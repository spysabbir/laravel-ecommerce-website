@extends('admin.layouts.admin_master')

@section('title_bar')
Product Inventory
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Product Inventory</h4>
                    <p class="card-text">List</p>
                </div>
            </div>
            <div class="card-body">
                @php
                    $categories = App\Models\CategorY::where('status', 'Yes')->get();
                    $subcategories = App\Models\SubcategorY::where('status', 'Yes')->get();
                    $childcategories = App\Models\ChildcategorY::where('status', 'Yes')->get();
                    $brands = App\Models\Brand::where('status', 'Yes')->get();
                    $products = App\Models\Product::where('status', 'Yes')->get();
                    $colors = App\Models\Color::where('status', 'Yes')->get();
                    $sizes = App\Models\Size::where('status', 'Yes')->get();
                @endphp
                <div class="filter">
                    <form action="{{ route('report.product.inventory.export') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-lg-2">
                                <label class="form-label">Select Category</label>
                                <select class="form-control filter_data" name="category_id" id="category_id">
                                    <option value="">All Category</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label class="form-label">Select Subcategory</label>
                                <select class="form-control filter_data" name="subcategory_id" id="subcategory_id">
                                    <option value="">All Subcategory</option>
                                    @foreach ($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}">{{ $subcategory->subcategory_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label class="form-label">Select Childcategory</label>
                                <select class="form-control filter_data" name="childcategory_id" id="childcategory_id">
                                    <option value="">All Childcategory</option>
                                    @foreach ($childcategories as $childcategory)
                                    <option value="{{ $childcategory->id }}">{{ $childcategory->childcategory_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label class="form-label">Select Brand</label>
                                <select class="form-control filter_data" name="brand_id" id="brand_id">
                                    <option value="">All Brand</option>
                                    @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label class="form-label">Select Product</label>
                                <select class="form-control filter_data" name="product_id" id="product_id">
                                    <option value="">All Product</option>
                                    @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label class="form-label">Select Color</label>
                                <select class="form-control filter_data" name="color_id" id="color_id">
                                    <option value="">All Color</option>
                                    @foreach ($colors as $color)
                                    <option value="{{ $color->id }}">{{ $color->color_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label class="form-label">Select Size</label>
                                <select class="form-control filter_data" name="size_id" id="size_id">
                                    <option value="">All Size</option>
                                    @foreach ($sizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->size_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <button type="submit" class="btn btn-success btn-sm mt-4">Export</button>
                                <button type="button" class="btn btn-info btn-sm mt-4 print">Print</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-info inventory_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Category Name</th>
                                <th>Subcategory Name</th>
                                <th>Childcategory Name</th>
                                <th>Brand Name</th>
                                <th>Product Name</th>
                                <th>Color Name</th>
                                <th>Size Name</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_script')
<script>
    $(document).ready(function() {
        // Read Data
        table = $('.inventory_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('report.product.inventory') }}",
                "data":function(e){
                    e.category_id = $('#category_id').val();
                    e.subcategory_id = $('#subcategory_id').val();
                    e.childcategory_id = $('#childcategory_id').val();
                    e.brand_id = $('#brand_id').val();
                    e.product_id = $('#product_id').val();
                    e.color_id = $('#color_id').val();
                    e.size_id = $('#size_id').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'category_name', name: 'category_name'},
                {data: 'subcategory_name', name: 'subcategory_name'},
                {data: 'childcategory_name', name: 'childcategory_name'},
                {data: 'brand_name', name: 'brand_name'},
                {data: 'product_name', name: 'product_name'},
                {data: 'color_name', name: 'color_name'},
                {data: 'size_name', name: 'size_name'},
                {data: 'quantity', name: 'quantity'},
            ],
        });

        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('.inventory_table').DataTable().ajax.reload()
        })

        $('.print').on('click', function(e){
            e.preventDefault();
            $.ajax({
                url: "{{ route('report.product.inventory.print') }}",
                method: 'GET',
                data: {
                    category_id: $('#category_id').val(),
                    subcategory_id: $('#subcategory_id').val(),
                    childcategory_id: $('#childcategory_id').val(),
                    brand_id: $('#brand_id').val(),
                    product_id: $('#product_id').val(),
                    color_id: $('#color_id').val(),
                    size_id: $('#size_id').val(),
                    },
                success: function(data) {
                    // $(data).printThis({
                    //     debug: false,
                    //     importCSS: true,
                    //     importStyle: true,
                    //     removeInline: false,
                    //     printDelay: 500,
                    //     header: null,
                    //     footer: null,
                    // })
                    console.log(data);
                }
            });
        })
    });
</script>
@endsection

