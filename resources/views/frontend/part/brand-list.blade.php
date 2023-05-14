@forelse ($brands_result as $brand)
<div class="single-widget-category">
    <input type="checkbox" class="select_brand" value="{{ $brand->brand_id }}" id="brand_item_{{ $brand->brand_id }}" name="brand_id">
    <label for="brand_item_{{ $brand->brand_id }}">{{ App\Models\Brand::find($brand->brand_id)->brand_name }} <span> ({{ App\Models\Product::where('brand_id', $brand->brand_id)->count() }})</span></label>
</div>
@empty
<div class="alert alert-warning">
    <strong>Brand Item Not Found........</strong>
</div>
@endforelse
