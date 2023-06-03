<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{ env('APP_NAME') }}</h4>
        <p class="card-text">Category Name: {{ $category_name }}</p>
        <p class="card-text">Subcategory Name: {{ $subcategory_name }}</p>
        <p class="card-text">Childcategory Name: {{ $childcategory_name }}</p>
        <p class="card-text">Brand Name: {{ $brand_name }}</p>
        <p class="card-text">Product Name: {{ $product_name }}</p>
        <p class="card-text">Color Name: {{ $color_name }}</p>
        <p class="card-text">Size Name: {{ $size_name }}</p>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-primary">
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
                    @forelse ($product_inventories as $product_inventory)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $product_inventory->relationtocategory->category_name }}</td>
                        <td>{{ $product_inventory->relationtosubcategory->subcategory_name }}</td>
                        <td>{{ $product_inventory->relationtochildcategory->childcategory_name }}</td>
                        <td>{{ $product_inventory->relationtobrand->brand_name }}</td>
                        <td>{{ $product_inventory->product_name }}</td>
                        <td>{{ $product_inventory->color_name }}</td>
                        <td>{{ $product_inventory->size_name }}</td>
                        <td>{{ $product_inventory->quantity }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="50">Product Inventory Not Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <p class="card-text">Report Print Date : {{ date('d M Y') }}</p>
    </div>
</div>
