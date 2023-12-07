@extends('frontend.layouts.frontend_master')

@section('title_bar')
{{ $flashsale->flashsale_offer_name }} Product
@endsection

@section('body_content')
<!-- breadcrumb__area-start -->
<section class="breadcrumb__area box-plr-75">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12">
                <div class="breadcrumb__wrapper">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('all.flashsale')}}">All Flashsale</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $flashsale->flashsale_offer_name }} Product</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb__area-end -->

<!-- shop-area-start -->
<div class="shop-area mb-20">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <div class="product-widget mb-30">
                    <h5 class="pt-title">Choose Brand</h5>
                    <div class="widget-category-list mt-20" id="brandResult">
                        @forelse ($brands as $brand)
                        <div class="single-widget-category">
                            <input type="checkbox" class="select_brand" value="{{ $brand->brand_id }}" id="brand_item_{{ $brand->brand_id }}" name="brand-item">
                            <label for="brand_item_{{ $brand->brand_id }}">{{ App\Models\Brand::find($brand->brand_id)->brand_name }} <span>({{ $products->where('brand_id', $brand->brand_id)->count() }})</span></label>
                        </div>
                        @empty
                        <div class="alert alert-warning">
                            <strong>Brand Item Not Found........</strong>
                        </div>
                        @endforelse
                    </div>
                </div>
                <div class="product-widget mb-30">
                    <h5 class="pt-title">Top view product</h5>
                    <div class="price__slider mt-30">
                        <div class="n-sidebar-feed">
                            <ul>
                                @include('frontend.part.top-view-product')
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">
                <div class="shop-banner mb-30">
                    <div class="banner-image">
                        <img class="banner-l" width="479" height="185" src="{{ asset('uploads/flashsale_offer_banner_photo') }}/{{ $flashsale->flashsale_offer_banner_photo }}" alt="">
                        <div class="banner-content bg-dark text-center py-2 px-5">
                            <p class="m-0 p-0">Hurry Up!</p>
                            <p class="m-0 p-0"><strong>Offer Amount: </strong>{{ $flashsale->flashsale_offer_amount }} {{ ($flashsale->flashsale_offer_type == 'Percentage') ? '%' : '৳' }}</p>
                            <p class="m-0 p-0"><strong>Minimum Product Price: </strong>{{ $flashsale->flashsale_minimum_product_price }} ৳</p>
                            <p class="m-0 p-0"><strong>Start End: </strong>{{ date('d-M-Y H:i:s A', strtotime($flashsale->flashsale_offer_start_date)) }}</p>
                            <p class="m-0 p-0"><strong>Offer End: </strong>{{ date('d-M-Y H:i:s A', strtotime($flashsale->flashsale_offer_end_date)) }}</p>
                            <input type="hidden" value="{{ $flashsale->id }}" id="flashsale_id">
                        </div>
                    </div>
                </div>
                <div class="product-lists-top">
                    <div class="product__filter-wrap">
                        <div class="row align-items-center">
                            <div class="col-lg-3 col-md-6">
                                <div class="from-group">
                                    <select class="form-control filter_data" id="category_id" name="category_id">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->category_id }}">{{ App\Models\Category::find($category->category_id)->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="from-group">
                                    <select class="form-control filter_data" id="subcategory_id" name="subcategory_id">
                                        <option value="">Select Subcategory</option>
                                        @foreach ($subcategories as $subcategory)
                                        <option value="{{ $subcategory->subcategory_id }}">{{ App\Models\Subcategory::find($subcategory->subcategory_id)->subcategory_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="from-group">
                                    <select class="form-control filter_data" id="childcategory_id" name="childcategory_id">
                                        <option value="">Select Childcategory</option>
                                        @foreach ($childcategories as $childcategory)
                                        <option value="{{ $childcategory->childcategory_id }}">{{ App\Models\Childcategory::find($childcategory->childcategory_id)->childcategory_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="from-group">
                                    <select class="form-control filter_data" id="sort_by" name="sort_by">
                                        <option value="">Sort</option>
                                        <option value="Latest">Latest</option>
                                        <option value="Oldest">Oldest</option>
                                        <option value="Price-asc">Price low to high</option>
                                        <option value="Price-desc">Price high to low</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-list my-3">
                    <div class="tp-wrapper">
                        <div class="row g-0" id="filteringResult">
                            @include('frontend.part.flashsale-product-list')
                        </div>
                    </div>
                </div>
                <div class="tp-pagination text-center">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="basic-pagination pt-30 pb-30">
                                {{ $products->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- shop-area-end -->

@endsection

@section('custom_script')
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // Category Wise Product
    $(document).on('change', '.filter_data', function(e){
        e.preventDefault();
        var flashsale_id = $('#flashsale_id').val();
        var category_id = $('#category_id').val();
        var subcategory_id = $('#subcategory_id').val();
        var childcategory_id = $('#childcategory_id').val();
        var sort_by = $('#sort_by').val();
        // ajax start
        $.ajax({
            type: 'POST',
            url: "{{route('product.filtering')}}",
            data: {
                flashsale_id:flashsale_id,
                category_id:category_id,
                subcategory_id:subcategory_id,
                childcategory_id:childcategory_id,
                sort_by: sort_by,
            },
            success: function (data) {
                $('#filteringResult').html(data);
            }
        })
        // ajax end
    })
    // Brand
    $(document).on('change', '.filter_data', function(e){
        e.preventDefault();
        var flashsale_id = $('#flashsale_id').val();
        var category_id = $('#category_id').val();
        var subcategory_id = $('#subcategory_id').val();
        var childcategory_id = $('#childcategory_id').val();
        var sort_by = $('#sort_by').val();
        // ajax start
        $.ajax({
            type: 'POST',
            url: "{{route('product.filtering.brand')}}",
            data: {
                flashsale_id:flashsale_id,
                category_id:category_id,
                subcategory_id:subcategory_id,
                childcategory_id:childcategory_id
            },
            success: function (data) {
                $('#brandResult').html(data);
            }
        })
        // ajax end
    })
    // Brand Wise Product
    $(document).on('click', '.select_brand', function(){
        var flashsale_id = $('#flashsale_id').val();
        var category_id = $('#category_id').val();
        var subcategory_id = $('#subcategory_id').val();
        var childcategory_id = $('#childcategory_id').val();
        var brand_id = [];
        $('.select_brand').each(function(){
            if($(this).is(":checked")){
                brand_id.push($(this).val());
            }
        });
        var all_brand_id = brand_id.toString();
        // ajax start
        $.ajax({
            type: 'POST',
            url: "{{route('product.brand.wise.filtering')}}",
            data: {
                flashsale_id:flashsale_id,
                category_id:category_id,
                subcategory_id:subcategory_id,
                childcategory_id:childcategory_id,
                all_brand_id:all_brand_id
            },
            success: function (data) {
                $('#filteringResult').html(data);
            }
        })
        // ajax end
    })
})
</script>
@endsection
