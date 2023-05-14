<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{ env('APP_NAME') }}</h4>
        <p class="card-text">Category Name: {{ ($category_name) ? $category_name : "All" }}</p>
        <p class="card-text">Subcategory Name: {{ ($subcategory_name) ? $subcategory_name : "All" }}</p>
        <p class="card-text">Childcategory Name: {{ ($childcategory_name) ? $childcategory_name : "All" }}</p>
        <p class="card-text">Brand Name: {{ ($brand_name) ? $brand_name : "All" }}</p>
        <p class="card-text">Product Name: {{ ($product_name) ? $product_name : "All" }}</p>
        <p class="card-text">Color Name: {{ ($color_name) ? $color_name : "All" }}</p>
        <p class="card-text">Size Name: {{ ($size_name) ? $size_name : "All" }}</p>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-primary">
                <thead>
                    <tr>
                        <th>Sl No</th>
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
