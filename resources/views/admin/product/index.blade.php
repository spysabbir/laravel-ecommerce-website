@extends('admin.layouts.admin_master')

@section('title_bar')
Product
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Product</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createProductModel">
                        <i class="fa fa-plus-square"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteProductModel">
                        <i class="fa fa-recycle"></i>
                    </button>
                </div>
                <!-- createProductModel -->
                <div class="modal fade" id="createProductModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Product</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="#" id="create_product_form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-12 mb-2">
                                            <label class="form-label">Product Name</label>
                                            <input type="text" name="product_name"class="form-control" placeholder="Product Name">
                                            <span class="text-danger error-text product_name_error"></span>
                                        </div>
                                        <div class="col-lg-6 mb-2">
                                            <label class="form-label">Regular Price</label>
                                            <input type="number" name="regular_price" class="form-control" placeholder="Regular Price">
                                            <span class="text-danger error-text regular_price_error"></span>
                                        </div>
                                        <div class="col-lg-6 mb-2">
                                            <label class="form-label">Discounted Price</label>
                                            <input type="number" name="discounted_price" class="form-control" placeholder="Discounted Price">
                                            <span class="text-danger" id="discounted_price_error"></span>
                                        </div>
                                        <div class="col-lg-12 mb-2">
                                            <label class="form-label">Short Description</label>
                                            <textarea name="short_description" placeholder="Short Description" class="form-control"></textarea>
                                            <span class="text-danger error-text short_description_error"></span>
                                        </div>
                                        <div class="col-lg-4 mb-2">
                                            <label class="form-label">Category Name</label>
                                            <select class="form-control select_category" name="category_id" id="select_category">
                                                <option value="">--Select Category--</option>
                                                @foreach ($categories as $category)
                                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text category_id_error"></span>
                                        </div>
                                        <div class="col-lg-4 mb-2">
                                            <label class="form-label">Subcategory Name</label>
                                            <select id="all_subcategories" class="form-control select_subcategory" name="subcategory_id" >
                                                <option value="">--Select Category First--</option>
                                            </select>
                                            <span class="text-danger error-text subcategory_id_error"></span>
                                        </div>
                                        <div class="col-lg-4 mb-2">
                                            <label class="form-label">Childcategory Name</label>
                                            <select id="all_childcategories" class="form-control" name="childcategory_id" >
                                                <option value="">--Select Subcategory First--</option>
                                            </select>
                                            <span class="text-danger error-text childcategory_id_error"></span>
                                        </div>
                                        <div class="col-lg-4 mb-2">
                                            <label class="form-label">Brand Name</label>
                                            <select class="form-control" name="brand_id" id="brand_dropdown">
                                                <option value="">--Select Brand--</option>
                                                @foreach ($brands as $brand)
                                                <option value="{{$brand->id}}">{{$brand->brand_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text brand_id_error"></span>
                                        </div>
                                        <div class="col-lg-12 mb-2">
                                            <label class="form-label">Long Description</label>
                                            <textarea name="long_description" placeholder="Long Description" class="form-control long_description_style"></textarea>
                                            <span class="text-danger error-text long_description_error"></span>
                                        </div>
                                        <div class="col-lg-4 mb-2">
                                            <label class="form-label">Weight</label>
                                            <input type="text" name="weight" class="form-control" placeholder="Weight">
                                        </div>
                                        <div class="col-lg-4 mb-2">
                                            <label class="form-label">Dimensions</label>
                                            <input type="text" name="dimensions" class="form-control" placeholder="Dimensions">
                                        </div>
                                        <div class="col-lg-4 mb-2">
                                            <label class="form-label">Materials</label>
                                            <input type="text" name="materials" class="form-control" placeholder="Materials">
                                        </div>
                                        <div class="col-lg-12 mb-2">
                                            <label class="form-label">Other Info</label>
                                            <textarea name="other_info" placeholder="Other Info" class="form-control"></textarea>
                                        </div>
                                        <div class="col-lg-6 mb-2">
                                            <label class="form-label">Product Thumbnail Photo</label>
                                            <input type="file" name="product_thumbnail_photo" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-lg-6">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="today_deal_status"
                                                    value="Yes" id="checkTodayDeal">
                                                <label class="form-check-label" for="checkTodayDeal">Today Deal Status</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="flashsale_status"
                                                    value="Yes" id="checkFlashsale" >
                                                <label class="form-check-label" for="checkFlashsale">Flashsale Status</label>
                                            </div>
                                            <label class="form-label">Flashsale Title</label>
                                            <select class="form-control" name="flashsale_id">
                                                <option value="">--Select Flashsale--</option>
                                                @foreach ($flashsales as $flashsale)
                                                <option value="{{$flashsale->id}}">{{$flashsale->flashsale_offer_name}}</option>
                                                @endforeach
                                            </select>
                                            <span id="flashsale_id_error" class="text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" id="create_product_btn" class="btn btn-primary">Create Product</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- deleteProductModel -->
                <div class="modal fade" id="deleteProductModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Deleted Product List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Product Photo</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="all_trashed_products">

                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="filter">
                    <div class="row mb-3">
                        <div class="col-lg-2">
                            <label class="form-label">Category Name</label>
                            <select class="form-control filter_data" id="category_id">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label">Subcategory Name</label>
                            <select class="form-control filter_data" id="subcategory_id">
                                <option value="">Select Subcategory</option>
                                @foreach ($subcategories as $subcategory)
                                <option value="{{$subcategory->id}}">{{$subcategory->subcategory_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label">Childcategory Name</label>
                            <select class="form-control filter_data" id="childcategory_id">
                                <option value="">Select Childcategory</option>
                                @foreach ($childcategories as $childcategory)
                                <option value="{{$childcategory->id}}">{{$childcategory->childcategory_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label">Brand Name</label>
                            <select class="form-control filter_data" id="brand_id">
                                <option value="">Select Brand</option>
                                @foreach ($brands as $brand)
                                <option value="{{$brand->id}}">{{$brand->brand_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label">Today Deal Status</label>
                            <select class="form-control filter_data" id="today_deal_status">
                                <option value="">Today Deal Status</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label">Status</label>
                            <select class="form-control filter_data" id="status">
                                <option value="">Active Status</option>
                                <option value="Yes">Active</option>
                                <option value="No">Inactive</option>
                            </select>
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
                                <th>Today Deal Status</th>
                                <th>Flashsale Status</th>
                                <th>Product Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="all_products">
                            <!-- editFlashsaleStatusModel -->
                            <div class="modal fade" id="editFlashsaleStatusModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Flashsale Status</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <form action="#" id="edit_flashsale_status_form" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="row">
                                                    <input type="hidden" name="product_id" id="product_id">
                                                    <div class="col-lg-12 mb-3" >
                                                        <div class="form-check mb-3">
                                                            <input type="checkbox" class="form-check-input flashsale_status" value="Yes" name="flashsale_status" id="check_flashsale">
                                                            <label class="form-check-label" for="check_flashsale">Flashsale Status</label>
                                                        </div>
                                                        <span id="update_flashsale_status_error" class="text-danger"></span>
                                                    </div>
                                                    <div class="col-lg-6 mb-3" >
                                                        <label class="form-label">Flashsale Title</label>
                                                        <select class="form-control" name="flashsale_id" id="flashsale_id">
                                                            <option value="">--Select Flashsale--</option>
                                                            @foreach ($flashsales as $flashsale)
                                                            <option value="{{$flashsale->id}}" >{{$flashsale->flashsale_offer_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span id="update_flashsale_id_error" class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" id="edit_flashsale_status_btn" class="btn btn-primary">Update Flashsale Status</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- View Product Details Model -->
                            <div class="modal fade" id="viewProductDetailsModel" tabindex="-1" aria-labelledby="viewProductDetailsModelLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewProductDetailsModelLabel">View Product Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" id="model_body">

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- editProductModel -->
                            <div class="modal fade" id="editProductModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <form action="#" id="edit_product_form" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <input type="hidden" name="product_id" id="product_id">
                                                    <div class="col-lg-12 mb-3">
                                                        <label class="form-label">Product Name</label>
                                                        <input type="text" name="product_name" id="product_name" class="form-control" value="">
                                                        <span class="text-danger error-text update_product_name_error"></span>
                                                    </div>
                                                    <div class="col-lg-6 mb-3">
                                                        <label class="form-label">Regular Price</label>
                                                        <input type="text" name="regular_price" id="regular_price" class="form-control" value="">
                                                        <span class="text-danger error-text update_regular_price_error"></span>
                                                    </div>
                                                    <div class="col-lg-6 mb-3">
                                                        <label class="form-label">Discounted Price</label>
                                                        <input type="text" name="discounted_price" id="discounted_price" class="form-control" value="">
                                                        <span class="text-danger" id="update_discounted_price_error"></span>
                                                    </div>
                                                    <div class="col-lg-12 mb-3">
                                                        <label class="form-label">Short Description</label>
                                                        <textarea name="short_description" id="short_description" class="form-control"></textarea>
                                                        <span class="text-danger error-text update_short_description_error"></span>
                                                    </div>
                                                    <div class="col-lg-4 mb-3">
                                                        <label class="form-label">Category Name</label>
                                                        <select class="form-control select_category category_id" name="category_id" id="category_id">
                                                            <option value="">--Select Category--</option>
                                                            @foreach ($categories as $category)
                                                            <option value="{{$category->id}}" >{{$category->category_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger error-text update_category_id_error"></span>
                                                    </div>
                                                    <div class="col-lg-4 mb-3">
                                                        <label class="form-label">Subcategory Name</label>
                                                        <select name="subcategory_id" class="form-control subcategory_id" id="subcategory_id">
                                                            <option value="">--Select Subcategory--</option>
                                                            @foreach ($subcategories as $subcategory)
                                                            <option value="{{$subcategory->id}}" >{{$subcategory->subcategory_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger error-text update_subcategory_id_error"></span>
                                                    </div>
                                                    <div class="col-lg-4 mb-3">
                                                        <label class="form-label">Childcategory Name</label>
                                                        <select name="childcategory_id" class="form-control childcategory_id" id="childcategory_id">
                                                            <option value="">--Select Childcategory--</option>
                                                            @foreach ($childcategories as $childcategory)
                                                            <option value="{{$childcategory->id}}" >{{$childcategory->childcategory_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger error-text update_childcategory_id_error"></span>
                                                    </div>
                                                    <div class="col-lg-4 mb-3">
                                                        <label class="form-label">Brand Name</label>
                                                        <select class="form-control brand_id" name="brand_id" id="brand_id">
                                                            <option value="">--Select Brand--</option>
                                                            @foreach ($brands as $brand)
                                                            <option value="{{$brand->id}}" >{{$brand->brand_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger error-text update_brand_id_error"></span>
                                                    </div>
                                                    <div class="col-lg-12 mb-3">
                                                        <label class="form-label">Long Description</label>
                                                        <textarea id="long_description" name="long_description" class="form-control"></textarea>
                                                        <span class="text-danger error-text update_long_description_error"></span>
                                                    </div>
                                                    <div class="col-lg-4 mb-3">
                                                        <label class="form-label">Weight</label>
                                                        <input type="text" name="weight" id="weight" class="form-control" value="">
                                                    </div>
                                                    <div class="col-lg-4 mb-3">
                                                        <label class="form-label">Dimensions</label>
                                                        <input type="text" name="dimensions" id="dimensions" class="form-control" value="">
                                                    </div>
                                                    <div class="col-lg-4 mb-3">
                                                        <label class="form-label">Materials</label>
                                                        <input type="text" name="materials" id="materials" class="form-control" value="">
                                                    </div>
                                                    <div class="col-lg-12 mb-3">
                                                        <label class="form-label">Other Info</label>
                                                        <textarea name="other_info" id="other_info" class="form-control"></textarea>
                                                    </div>
                                                    <div class="col-lg-6 mb-3">
                                                        <label class="form-label">Product Thumbnail Photo</label>
                                                        <input type="file" name="product_thumbnail_photo" class="form-control">
                                                        <span class="text-danger error-text update_product_thumbnail_photo_error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" id="edit_product_btn" class="btn btn-primary">Edit Product</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- featuredPhotoModel -->
                            <div class="modal fade" id="featuredPhotoModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add Product Featured Photo</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="#" id="featured_photo_form" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <input type="hidden" name="product_id" id="featured_photo_product_id">
                                                    <div class="col-lg-9">
                                                        <label class="form-label">Product Featured Photo</label>
                                                        <input type="file" name="product_featured_photos[]" class="form-control" multiple >
                                                        <small>Input file accept extension (jpg, png, jpeg, webp)</small>
                                                        <span class="text-danger error-text product_featured_photos_error"></span>
                                                        <span class="text-danger" id="featured_photo_extension_error"></span>
                                                    </div>
                                                    <div class="col-lg-3 mt-4">
                                                        <button type="submit" id="add_featured_photo_btn" class="btn btn-primary mt-2">Add Featured Photo</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">List Product Featured Photo</h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-2 text-center">
                                                <div class="col-lg-6">Featured Photo</div>
                                                <div class="col-lg-6">Action</div>
                                            </div>
                                            <div class="text-center border" id="all_product_featured_photos">

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- inventoryModel -->
                            <div class="modal fade" id="inventoryModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add Product Inventory</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="#" id="inventory_form" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <input type="hidden" name="product_id" id="inventory_product_id">
                                                    <div class="col-lg-3">
                                                        <label class="form-label">Color</label>
                                                        <select name="color_id" class="form-control" id="">
                                                            <option value="">--Select Color--</option>
                                                            @foreach ($colors as $color)
                                                            <option value="{{$color->id}}">{{$color->color_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger error-text color_id_error"></span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label class="form-label">Size</label>
                                                        <select name="size_id" class="form-control" id="">
                                                            <option value="">--Select Size--</option>
                                                            @foreach ($sizes as $size)
                                                            <option value="{{$size->id}}">{{$size->size_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger error-text size_id_error"></span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label class="form-label">Quantity</label>
                                                        <input type="text" name="quantity" class="form-control" placeholder="Quantity">
                                                        <span class="text-danger error-text quantity_error"></span>
                                                    </div>
                                                    <div class="col-lg-3 mt-4">
                                                        <button type="submit" id="add_inventory_btn" class="btn btn-primary mt-1">Add Inventory</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">List Product Inventory</h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row border mb-2 text-center">
                                                <div class="col-lg-2 border">Color Name</div>
                                                <div class="col-lg-2 border">Size Name</div>
                                                <div class="col-lg-2 border">Quantity</div>
                                                <div class="col-lg-3 border">Total Price</div>
                                                <div class="col-lg-3 border">Action</div>
                                            </div>
                                            <div class="text-center border mb-2" id="all_product_inventories">

                                            </div>
                                            <div class="row align-items-center border text-center">
                                                <div class="col-lg-6 border">
                                                    <h4 class="mt-2">Total QTY: <strong id="product_inventories_quantity"></strong></h4>
                                                </div>
                                                <div class="col-lg-6 border">
                                                    <h4 class="mt-2">Total Price: <strong id="product_inventories_price"></strong></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
        // Summernote
        $('.long_description_style').summernote();

        // Read Trashed Data
        fetchAllTrashedProduct();
        function fetchAllTrashedProduct(){
            $.ajax({
                url: '{{ route('fetch.trashed.product') }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#all_trashed_products').html(response.trashed_products);
                }
            });
        }

        // Read Data
        table = $('.all_products_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('product.index') }}",
                "data":function(e){
                    e.category_id = $('#category_id').val();
                    e.subcategory_id = $('#subcategory_id').val();
                    e.childcategory_id = $('#childcategory_id').val();
                    e.brand_id = $('#brand_id').val();
                    e.today_deal_status = $('#today_deal_status').val();
                    e.status = $('#status').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'sku', name: 'sku'},
                {data: 'product_thumbnail_photo', name: 'product_thumbnail_photo'},
                {data: 'product_details', name: 'product_details'},
                {data: 'today_deal_status', name: 'today_deal_status'},
                {data: 'flashsale_status', name: 'flashsale_status'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });
        // Filter Data
        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('.all_products_table').DataTable().ajax.reload()
        })

        // Subcategory Data
        $(document).on('change', '.select_category', function(e){
            e.preventDefault();
            var category_id = $(this).val();
            $.ajax({
                url: '{{ route('get.subcategories') }}',
                method: 'POST',
                data: {category_id:category_id},
                success: function(response) {
                    $('#all_subcategories').html(response);
                }
            });
        })

        // Childcategory Data
        $(document).on('change', '.select_subcategory', function(e){
            e.preventDefault();
            var subcategory_id = $(this).val();
            $.ajax({
                url: '{{ route('get.childcategories') }}',
                method: 'POST',
                data: {subcategory_id:subcategory_id},
                success: function(response) {
                    $('#all_childcategories').html(response);
                }
            });
        })

        // Store Data
        $("#create_product_form").submit(function(e) {
            e.preventDefault();
            const form_data = new FormData(this);
            $("#create_product_btn").text('Adding...');
            $.ajax({
                url: '{{ route('product.store') }}',
                method: 'POST',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend:function(){
                    $(document).find('span.error-text').text('');
                    $('#discounted_price_error').html('');
                    $('#flashsale_id_error').html('');
                },
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.error, function(prefix, val){
                            $('span.'+prefix+'_error').text(val[0]);
                        })
                    }
                    else{
                        if(response.status == 401){
                            $('#discounted_price_error').html(response.error);
                        }
                        else{
                            if (response.status == 402) {
                                $('#flashsale_id_error').html(response.error);
                            } else {
                                toastr.success(response.message);
                                table.ajax.reload(null, false);
                                $("#create_product_btn").text('Add Product');
                                $("#create_product_form")[0].reset();
                                $("#createProductModel").modal('hide');
                            }
                        }
                    }
                }
            });
        });

        // View Details
        $(document).on('click', '.viewProductModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('product.show', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#model_body").html(response);
                }
            });
        })

        // Edit Form
        $(document).on('click', '.editProductModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('product.edit', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#product_name").val(response.product_name);
                    $("#regular_price").val(response.regular_price);
                    $("#discounted_price").val(response.discounted_price);
                    $("#short_description").val(response.short_description);
                    $(".category_id").val(response.category_id);
                    $(".subcategory_id").val(response.subcategory_id);
                    $(".childcategory_id").val(response.childcategory_id);
                    $(".brand_id").val(response.brand_id);
                    $("#long_description").val(response.long_description);
                    $("#weight").val(response.weight);
                    $("#dimensions").val(response.dimensions);
                    $("#materials").val(response.materials);
                    $("#other_info").val(response.other_info);
                    $('#product_id').val(response.id)
                }
            });
        })

        // Update Data
        $("#edit_product_form").submit(function(e) {
            e.preventDefault();
            var id = $('#product_id').val();
            var url = "{{ route('product.update', ":id") }}";
            url = url.replace(':id', id)
            const form_data = new FormData(this);
            $("#edit_product_btn").text('Updating...');
            $.ajax({
                url: url,
                method: 'POST',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend:function(){
                    $(document).find('span.error-text').text('');
                    $("#update_discounted_price_error").html('');
                },
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.error, function(prefix, val){
                            $('span.update_'+prefix+'_error').text(val[0]);
                        })
                    }
                    else{
                        if(response.status == 401){
                            $("#update_discounted_price_error").html('Discounted price not more than regular price.');
                        }else{
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                            $("#edit_product_btn").text('Updated Product');
                            $("#editProductModel").modal('hide');
                        }
                    }
                }
            });
        });

        // Delete Data
        $(document).on('click', '.deleteProductBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('product.destroy', ":id") }}";
            url = url.replace(':id', id)
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: 'DELETE',
                        success: function(response) {
                            toastr.warning(response.message);
                            table.ajax.reload(null, false);
                            fetchAllTrashedProduct();
                        }
                    });
                }
            })
        })

        // Restore Data
        $(document).on('click', '.productRestoreBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('product.restore', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    toastr.success(response.message);
                    table.ajax.reload(null, false)
                    fetchAllTrashedProduct();
                    $("#deleteProductModel").modal('hide');
                }
            });
        })

        // Force Delete
        $(document).on('click', '.productForceDeleteBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('product.forcedelete', ":id") }}";
            url = url.replace(':id', id)
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        toastr.error(response.message);
                        fetchAllTrashedProduct();
                        $("#deleteProductModel").modal('hide');
                    }
                });
            }
            })
        })

        // Today Deal Status Change
        $(document).on('click', '.todayDealStatusBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('product.today.deal.status', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    toastr.info(response.message);
                    table.ajax.reload(null, false)
                }
            });
        })

        // Active Status Change
        $(document).on('click', '.productStatusBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('product.status', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    toastr.info(response.message);
                    table.ajax.reload(null, false);
                }
            });
        })

        // Edit Flashsale Status Form
        $(document).on('click', '.editFlashsaleStatusModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('product.flashsale.status.form', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#flashsale_id").val(response.flashsale_id);
                    $('#product_id').val(response.id)
                    if (response.flashsale_status == "Yes") {
                        $(".flashsale_status").prop( "checked", true );
                    } else {
                        $(".flashsale_status").prop( "checked", false );
                    }
                }
            });
        })

        // Remove Flashsale Id
        $(document).on('click', '.flashsale_status', function(e){
            $('#flashsale_id').val('')
        })

        // Update Flashsale Status Data
        $("#edit_flashsale_status_form").submit(function(e) {
            e.preventDefault();
            var id = $('#product_id').val();
            var url = "{{ route('product.flashsale.status.update', ":id") }}";
            url = url.replace(':id', id)
            const form_data = new FormData(this);
            $("#edit_flashsale_status_btn").text('Updating...');
            $.ajax({
                url: url,
                method: 'POST',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend:function(){
                    $('#update_flashsale_id_error').html('');
                },
                success: function(response) {
                    if (response.status == 400) {
                        $('#update_flashsale_id_error').html('Please select flashsale title.');
                    }
                    else{
                        if(response.status == 401){
                            $('#update_flashsale_status_error').html('Please check flashsale status.');
                        }else{
                            toastr.info(response.message);
                            table.ajax.reload(null, false);
                            $("#edit_flashsale_status_btn").text('Updated Status');
                            $("#editFlashsaleStatusModel").modal('hide');
                        }
                    }
                }
            });
        });

        // Featured Photo Form
        $(document).on('click', '.featuredPhotoModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('product.featured.photo.form', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $('#featured_photo_product_id').val(response.product.id)
                    $('#all_product_featured_photos').html(response.send_product_featured_photos_data);
                }
            });
        })

        // Featured Photo Store
        $("#featured_photo_form").submit(function(e) {
            e.preventDefault();
            var id = $('#featured_photo_product_id').val();
            var url = "{{ route('product.featured.photo.store', ":id") }}";
            url = url.replace(':id', id)
            const form_data = new FormData(this);
            $("#add_featured_photo_btn").text('Adding...');
            $.ajax({
                url: url,
                method: 'POST',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend:function(){
                    $(document).find('span.error-text').text('');
                    $('#featured_photo_extension_error').html('')
                },
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.error, function(prefix, val){
                            $('span.'+prefix+'_error').text(val[0]);
                        })
                    }else{
                        if(response.status == 401){
                            $('#featured_photo_extension_error').html(response.error)
                        }else{
                            toastr.success(response.message);
                            table.ajax.reload(null, false)
                            $("#add_featured_photo_btn").text('Add Product');
                            $("#featured_photo_form")[0].reset();
                            $("#featuredPhotoModel").modal('hide');
                        }
                    }
                }
            });
        });

        // Product Featured Photo Force Delete
        $(document).on('click', '.deleteProductFeaturedPhotoBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('product.featured.photo.forcedelete', ":id") }}";
            url = url.replace(':id', id)
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        toastr.error(response.message);
                        $("#featuredPhotoModel").modal('hide');
                    }
                });
            }
            })
        })

        // Inventory Form
        $(document).on('click', '.inventoryModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('product.inventory.form', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $('#inventory_product_id').val(response.product.id)
                    $('#all_product_inventories').html(response.send_product_inventories_data);
                    $('#product_inventories_quantity').html(response.product_inventories_quantity);
                    $('#product_inventories_price').html(response.product_inventories_price);
                }
            });
        })

        // Inventory Store
        $("#inventory_form").submit(function(e) {
            e.preventDefault();
            var id = $('#inventory_product_id').val();
            var url = "{{ route('product.inventory.store', ":id") }}";
            url = url.replace(':id', id)
            const form_data = new FormData(this);
            $("#add_inventory_btn").text('Adding...');
            $.ajax({
                url: url,
                method: 'POST',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend:function(){
                    $(document).find('span.error-text').text('');
                },
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.error, function(prefix, val){
                            $('span.'+prefix+'_error').text(val[0]);
                        })
                    }else{
                        if (response.status == 201) {
                            toastr.info(response.message);
                            table.ajax.reload(null, false)
                            $("#add_inventory_btn").text('Increment inventory');
                            $("#inventory_form")[0].reset();
                            $("#inventoryModel").modal('hide');
                        } else {
                            toastr.success(response.message);
                            table.ajax.reload(null, false)
                            $("#add_inventory_btn").text('Added inventory');
                            $("#inventory_form")[0].reset();
                            $("#inventoryModel").modal('hide');
                        }
                    }
                }
            });
        });

        // Product Inventory Force Delete
        $(document).on('click', '.deleteProductInventoryBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('product.inventory.forcedelete', ":id") }}";
            url = url.replace(':id', id)
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        toastr.error(response.message);
                        $("#inventoryModel").modal('hide');
                    }
                });
            }
            })
        })
    });
</script>
@endsection

