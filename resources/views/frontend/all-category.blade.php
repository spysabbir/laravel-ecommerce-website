@extends('frontend.layouts.frontend_master')

@section('title_bar')
All Category
@endsection

@section('body_content')
<!-- page-banner-area-start -->
<div class="page-banner-area page-banner-height-2" data-background="{{asset('frontend')}}/img/banner.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-banner-content text-center">
                    <h4 class="breadcrumb-title">All Category</h4>
                    <div class="breadcrumb-two">
                        <nav>
                            <nav class="breadcrumb-trail breadcrumbs">
                                <ul class="breadcrumb-menu">
                                    <li class="breadcrumb-trail">
                                        <a href="{{route('index')}}"><span>Home</span></a>
                                    </li>
                                    <li class="trail-item">
                                        <span>All Category</span>
                                    </li>
                                </ul>
                            </nav>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- page-banner-area-end -->

<!-- Category-area-start -->
<section class="brand-area brand-area-d pt-40">
    <div class="container">
        <div class="row pt-50 pb-45">
            <div class="col-lg-12">
                @forelse ($categories as $category)
                <div class="border p-2 m-2">
                    <div class="item p-1 m-1 d-flex justify-content-start">
                        <div class="category text-center border p-2">
                            <a href="{{ route('category.wise.product', $category->category_slug) }}">
                                <img width="150" height="150" src="{{ asset('uploads/category_photo') }}/{{ $category->category_photo }}" alt="Category Photo">
                                <br>
                                <span class="badge bg-success">{{ $category->category_name }}</span>
                            </a>
                        </div>
                        <div class="subcategory">
                            <div class="ml-10">
                                @forelse ($subcategories->where('category_id', $category->id) as $subcategory)
                                <div class="item p-1 m-1 border">
                                    <span class="badge bg-info">Subcategory: </span> <a href="{{ route('subcategory.wise.product', $subcategory->subcategory_slug) }}">" <span class="text-warning">{{ $subcategory->subcategory_name }}</span> "</a>
                                    <div class="ml-50">
                                        <span class="badge bg-primary">Childcategory: </span>
                                        @forelse ($childcategories->where('subcategory_id', $subcategory->id) as $childcategory)
                                        <span class="item p-1 m-1">
                                            <a href="{{ route('childcategory.wise.product', $childcategory->childcategory_slug) }}">" <span class="text-warning">{{ $childcategory->childcategory_name }}</span> "</a>
                                        </span>
                                        @empty
                                        <strong class="text-warning">Childcategory Item Not Found!</strong>
                                        @endforelse
                                    </div>
                                </div>
                                @empty
                                <strong class="text-warning">Subcategory Item Not Found!</strong>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="alert alert-warning text-center" role="alert">
                    <strong>Category Item Not Found!</strong>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
<!-- Category-area-end -->

@endsection

@section('custom_script')
<script>

</script>
@endsection
