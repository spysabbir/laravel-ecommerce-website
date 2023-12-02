<div class="card">
    <div class="card-header d-flex justify-content-between text-white">
        <div>
            <img width="140" height="150" src="{{ asset('uploads/product_thumbnail_photo') }}/{{ $product->product_thumbnail_photo }}" alt="">
        </div>
        <div>
            <p class="p-0 m-0"><strong>Product Name: </strong> {{ $product->product_name }}</p>
            <p class="p-0 m-0"><strong>Total View: </strong> {{ $product->view_count }}</p>
            <p class="p-0 m-0"><strong>Status: </strong>
                @if ($product->status == "Yes")
                    <span class="badge badge-success">{{ $product->status }}</span>
                @else
                    <span class="badge badge-warning">{{ $product->status }}</span>
                @endif
            </p>
            <p class="p-0 m-0"><strong>Created By: </strong>{{ App\Models\Admin::find($product->created_by)->name }}</p>
            <p class="p-0 m-0"><strong>Created At: </strong>{{ $product->created_at }}</p>
            <p class="p-0 m-0"><strong>Updated By: </strong>{{ App\Models\Admin::find($product->updated_by)->name }}</p>
            <p class="p-0 m-0"><strong>Updated At: </strong>{{ $product->updated_at }}</p>
        </div>
    </div>
    <div class="card-body text-white">
        <p class="card-title"><strong>Regular Price:</strong> {{ $product->regular_price }}</p>
        <p class="card-title"><strong>Discounted Price:</strong> {{ $product->discounted_price }}</p>
        <p class="card-title"><strong>Short Description:</strong> {{ $product->short_description }}</p>
        <p class="card-title"><strong>Category Name: </strong> {{ $product->relationtocategory->category_name }}</p>
        <p class="card-title"><strong>Subcategory Name: </strong> {{ $product->relationtosubcategory->subcategory_name }}</p>
        <p class="card-title"><strong>Childcategory Name: </strong> {{ $product->relationtochildcategory->childcategory_name }}</p>
        <p class="card-title"><strong>Brand Name: </strong> {{ $product->relationtobrand->brand_name }}</p>
        <p class="card-title"><strong>Flashsale Status: </strong> {{ $product->flashsale_status }}</p>
        <p class="card-title"><strong>Today Deal Status:</strong> {{ $product->today_deal_status }}</p>
        <p class="card-title"><strong>Long Description:</strong> {{  $product->long_description  }}</p>
        <p class="card-title"><strong>Weight:</strong> {{ $product->weight }}</p>
        <p class="card-title"><strong>Dimensions:</strong> {{ $product->dimensions }}</p>
        <p class="card-title"><strong>Materials:</strong> {{ $product->materials }}</p>
        <p class="card-title"><strong>Other Info:</strong> {{ $product->other_info }}</p>
    </div>
</div>
