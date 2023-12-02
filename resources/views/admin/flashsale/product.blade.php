@extends('admin.layouts.admin_master')

@section('title_bar')
Flashsale Product
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">{{ $flashsale->flashsale_offer_name }}</h4>
                    <input type="hidden" name="flashsale_id" id="flashsale_id" value="{{ $flashsale->id }}">
                    <p class="card-text">Product List</p>
                </div>
                <div class="action">
                    <a href="javascript:history.go(-1)" class="btn btn-info btn-block"><i class="fa fa-arrow-left"></i> <span>Go Back</span></a>
                </div>
            </div>
            <div class="card-body">
                <div class="filter">
                    <div class="row mb-3">
                        <div class="col-lg-2">
                            <label class="form-label">Category Name</label>
                            <select class="form-control filter_data" id="category_id">
                                <option value="">--Select Category--</option>
                                @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label">Subcategory Name</label>
                            <select class="form-control filter_data" id="subcategory_id">
                                <option value="">--Select Subcategory--</option>
                                @foreach ($subcategories as $subcategory)
                                <option value="{{$subcategory->id}}">{{$subcategory->subcategory_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label">Childcategory Name</label>
                            <select class="form-control filter_data" id="childcategory_id">
                                <option value="">--Select Childcategory--</option>
                                @foreach ($childcategories as $childcategory)
                                <option value="{{$childcategory->id}}">{{$childcategory->childcategory_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label">Brand Name</label>
                            <select class="form-control filter_data" id="brand_id">
                                <option value="">--Select Brand--</option>
                                @foreach ($brands as $brand)
                                <option value="{{$brand->id}}">{{$brand->brand_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label">Flashsale Status</label>
                            <select class="form-control filter_data" id="flashsale_status">
                                <option value="">--Flashsale Status--</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <a href="{{ route('flashsale.all-product.added', $flashsale->id) }}" class="btn btn-success btn-sm mb-2">Added All Product</a>
                            <a href="{{ route('flashsale.all-product.remove', $flashsale->id) }}" class="btn btn-warning btn-sm">Remove All Product</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-info all_products_table" id="all_products_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Product Code</th>
                                <th>Product Photo</th>
                                <th>Product Details</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="all_products">

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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Read Data
        let id =  $('#flashsale_id').val();
        var url = "{{ route('flashsale.manage.product.list', ":id") }}";
        url = url.replace(':id', id);
        
        table = $('.all_products_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: url,
                "data":function(e){
                    e.category_id = $('#category_id').val();
                    e.subcategory_id = $('#subcategory_id').val();
                    e.childcategory_id = $('#childcategory_id').val();
                    e.brand_id = $('#brand_id').val();
                    e.flashsale_status = $('#flashsale_status').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'sku', name: 'sku'},
                {data: 'product_thumbnail_photo', name: 'product_thumbnail_photo'},
                {data: 'product_details', name: 'product_details'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });
        // Filter Data
        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('.all_products_table').DataTable().ajax.reload()
        })

        // Status Change
        $(document).on('click', '.flashsaleProductAddedBtn', function(e){
            e.preventDefault();
            var flashsale_id = $('#flashsale_id').val();
            let id = $(this).attr('id');
            var url = "{{ route('flashsale.product.update', ":id") }}";
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                method: 'POST',
                data: {flashsale_id:flashsale_id},
                success: function(response) {
                    toastr.info(response.message);
                    table.ajax.reload(null, false);
                }
            });
        })

    });
</script>
@endsection

