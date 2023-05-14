<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Models\Childcategory;
use App\Models\Color;
use App\Models\Flashsale;
use App\Models\Product;
use App\Models\Product_featured_photo;
use App\Models\Product_inventory;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $products = "";
            $query = Product::leftJoin('categories', 'products.category_id', 'categories.id')
                ->leftJoin('subcategories', 'products.subcategory_id', 'subcategories.id')
                ->leftJoin('childcategories', 'products.childcategory_id', 'childcategories.id')
                ->leftJoin('brands', 'products.brand_id', 'brands.id');

            if($request->category_id){
                $query->where('products.category_id', $request->category_id);
            }
            if($request->subcategory_id){
                $query->where('products.subcategory_id', $request->subcategory_id);
            }
            if($request->childcategory_id){
                $query->where('products.childcategory_id', $request->childcategory_id);
            }
            if($request->brand_id){
                $query->where('products.brand_id', $request->brand_id);
            }
            if($request->today_deal_status){
                $query->where('products.today_deal_status', $request->today_deal_status);
            }
            if($request->status){
                $query->where('products.status', $request->status);
            }

            $products = $query->select('products.*', 'categories.category_name', 'subcategories.subcategory_name', 'childcategories.childcategory_name', 'brands.brand_name')
            ->get();

            return Datatables::of($products)
                    ->addIndexColumn()
                    ->editColumn('product_thumbnail_photo', function($row){
                        return '<img src="'.asset('uploads/product_thumbnail_photo').'/'.$row->product_thumbnail_photo.'" width="40" >';
                    })
                    ->editColumn('product_details', function($row){
                        return'
                        <span class="badge badge-dark">Product Name: <a href="" class="text-light">'.$row->product_name.'</a></span>
                        <br>
                        <span class="badge badge-info">Category Name: '.$row->category_name.' --> '.$row->subcategory_name.' --> '.$row->childcategory_name.'</span>
                        <br>
                        <span class="badge badge-primary">Brand: '.$row->brand_name.'</span>
                        ';
                    })
                    ->editColumn('today_deal_status', function($row){
                        if($row->today_deal_status == "Yes"){
                            return'
                            <span class="badge bg-success">'.$row->today_deal_status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm todayDealStatusBtn"><i class="fa fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->today_deal_status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm todayDealStatusBtn"><i class="fa fa-check"></i></button>
                            ';
                        }
                    })
                    ->editColumn('flashsale_status', function($row){
                        if($row->flashsale_status == "Yes"){
                            return'
                            <span class="badge bg-success">'.$row->flashsale_status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-info btn-sm editFlashsaleStatusModelBtn" data-toggle="modal" data-target="#editFlashsaleStatusModel"><i class="fa fa-pencil-square-o"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->flashsale_status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-info btn-sm editFlashsaleStatusModelBtn" data-toggle="modal" data-target="#editFlashsaleStatusModel"><i class="fa fa-pencil-square-o"></i></button>
                            ';
                        }
                    })
                    ->editColumn('status', function($row){
                        if($row->status == "Yes"){
                            return'
                            <span class="badge bg-success">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm productStatusBtn"><i class="fa fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm productStatusBtn"><i class="fa fa-check"></i></button>
                            ';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm editProductModelBtn" data-toggle="modal" data-target="#editProductModel"><i class="fa fa-pencil-square-o"></i></button>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm viewProductModelBtn" data-toggle="modal" data-target="#viewProductDetailsModel"><i class="fa fa-eye"></i></button>
                            <button type="button" id="'.$row->id.'" class="btn btn-primary btn-sm featuredPhotoModelBtn" data-toggle="modal" data-target="#featuredPhotoModel"><i class="fa fa-picture-o"></i></button>
                            <button type="button" id="'.$row->id.'" class="btn btn-info btn-sm inventoryModelBtn" data-toggle="modal" data-target="#inventoryModel"><i class="fa fa-database"></i></button>
                            <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteProductBtn"><i class="fa fa-trash"></i></button>
                            ';
                        return $btn;
                    })
                    ->rawColumns(['product_thumbnail_photo', 'product_details', 'flashsale_status', 'today_deal_status', 'status', 'action'])
                    ->make(true);
        }

        $categories = Category::all();
        $subcategories = Subcategory::all();
        $childcategories = Childcategory::all();
        $brands = Brand::all();
        $flashsales = Flashsale::all();
        $colors = Color::all();
        $sizes = Size::all();
        return view('admin.product.index', compact('categories', 'subcategories', 'childcategories', 'brands', 'flashsales', 'colors', 'sizes'));
    }

    public function fetchTrashedProduct()
    {
        $send_trashed_products_data = "";

        $trashed_products = Product::onlyTrashed()->get();

        foreach ($trashed_products as $trashed_product){
            $send_trashed_products_data .= '
            <tr>
                <td>'.$trashed_product->id.'</td>
                <td>'.$trashed_product->product_name.'</td>
                <td>
                    <button type="button" id="'.$trashed_product->id.'" class="btn btn-success btn-sm productRestoreBtn"><i class="fa fa-undo"></i></button>
                    <button type="button" id="'.$trashed_product->id.'" class="btn btn-danger btn-sm productForceDeleteBtn"><i class="fa fa-times"></i></button>
                </td>
            </tr>
            ';
        }

        return response()->json([
            'trashed_products' => $send_trashed_products_data,
        ]);
    }

    public function getSubcategories(Request $request){
        $send_data = "<option>--Select Subategory--</option>";
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();
        foreach ($subcategories as $subcategory) {
            $send_data .= "<option value='$subcategory->id'>$subcategory->subcategory_name</option>";
        }
        return response()->json($send_data);
    }

    public function getChildcategories(Request $request){
        $send_data = "<option>--Select Childcategory--</option>";
        $childcategories = Childcategory::where('subcategory_id', $request->subcategory_id)->get();
        foreach ($childcategories as $childcategory) {
            $send_data .= "<option value='$childcategory->id'>$childcategory->childcategory_name</option>";
        }
        return response()->json($send_data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'regular_price' => 'required',
            'short_description' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'childcategory_id' => 'required',
            'brand_id' => 'required',
            'long_description' => 'required',
            'product_thumbnail_photo' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=>$validator->errors()->toArray()
            ]);
        }else{
            if($request->discounted_price == NULL){
                $discounted_price = $request->regular_price;
            }else{
                $discounted_price = $request->discounted_price;
            }

            if($request->discounted_price > $request->regular_price){
                return response()->json([
                    'status' => 401,
                    'error' => 'Discounted price not more than regular price.',
                ]);
            }else{
                if ($request->flashsale_status == "Yes" && $request->flashsale_id == NULL) {
                    return response()->json([
                        'status' => 402,
                        'error' => 'Please select flashsale title.',
                    ]);
                } else {
                    $product_slug = Str::slug($request->product_name).'-'.Str::random(10);
                    $sku = Str::random(10);

                    $product_id = Product::insertGetId($request->except('_token', 'discounted_price')+[
                        'product_slug' => $product_slug,
                        'discounted_price' => $discounted_price,
                        'sku' => $sku,
                        'created_by' => Auth::guard('admin')->user()->id,
                        'created_at' => Carbon::now(),
                    ]);
                    // Product Thumbnail Photo Upload
                    if($request->hasFile('product_thumbnail_photo')){
                        $product_thumbnail_photo_name =  $product_id."-".$request->product_name."-Photo".".". $request->file('product_thumbnail_photo')->getClientOriginalExtension();
                        $upload_link = base_path("public/uploads/product_thumbnail_photo/").$product_thumbnail_photo_name;
                        Image::make($request->file('product_thumbnail_photo'))->resize(600, 600)->save($upload_link);
                        Product::find($product_id)->update([
                            'product_thumbnail_photo' => $product_thumbnail_photo_name,
                            'updated_by' => Auth::guard('admin')->user()->id
                        ]);
                    }
                    return response()->json([
                        'status' => 200,
                        'message' => 'Product create successfully',
                    ]);
                }
            }
        }
    }

    public function show($id)
    {
        $product = Product::where('id', $id)->first();
        return view('admin.product.details', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::where('id', $id)->first();
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            'product_name' => 'required|unique:products,product_name,'.$product->id,
            'regular_price' => 'required',
            'short_description' => 'required',
            'brand_id' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'childcategory_id' => 'required',
            'long_description' => 'required',
            'product_thumbnail_photo' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            if($request->discounted_price == NULL){
                $discounted_price = $request->regular_price;
            }else{
                $discounted_price = $request->discounted_price;
            }

            if($request->discounted_price > $request->regular_price){
                return response()->json([
                    'status' => 401,
                ]);
            }else{
                $product_slug = Str::slug($request->product_name).'-'.Str::random(10);
                $sku = Str::random(10);
                // Product Thumbnail Photo Upload
                if($request->hasFile('product_thumbnail_photo')){
                    if($product->product_thumbnail_photo != 'default_product_thumbnail_photo.jpg'){
                        unlink(base_path("public/uploads/product_thumbnail_photo/").$product->product_thumbnail_photo);
                    }
                    $product_thumbnail_photo_name =  $id."-".$request->product_name."-Photo".".". $request->file('product_thumbnail_photo')->getClientOriginalExtension();
                    $upload_link = base_path("public/uploads/product_thumbnail_photo/").$product_thumbnail_photo_name;
                    Image::make($request->file('product_thumbnail_photo'))->resize(600, 600)->save($upload_link);
                    $product->update([
                        'product_thumbnail_photo' => $product_thumbnail_photo_name,
                        'updated_by' => Auth::guard('admin')->user()->id,
                    ]);
                }

                $product->update([
                    'product_name' => $request->product_name,
                    'regular_price' => $request->regular_price,
                    'discounted_price' => $discounted_price,
                    'product_slug' => $product_slug,
                    'short_description' => $request->short_description,
                    'sku' => $sku,
                    'category_id' => $request->category_id,
                    'subcategory_id' => $request->subcategory_id,
                    'childcategory_id' => $request->childcategory_id,
                    'brand_id' => $request->brand_id,
                    'long_description' => $request->long_description,
                    'weight' => $request->weight,
                    'dimensions' => $request->dimensions,
                    'materials' => $request->materials,
                    'other_info' => $request->other_info,
                    'updated_by' => Auth::guard('admin')->user()->id,
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Product update successfully',
                ]);
            };
        }
    }

    public function destroy($id)
    {
        $product = Product::where('id', $id)->first();

        $product->updated_by = Auth::guard('admin')->user()->id;
        $product->deleted_by = Auth::guard('admin')->user()->id;
        $product->save();
        $product->delete();
        return response()->json([
            'message' => 'Product destroy successfully',
        ]);
    }

    public function productRestore($id)
    {
        Product::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);

        Product::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'message' => 'Product restore successfully',
        ]);
    }

    public function productForceDelete($id)
    {
        Product_inventory::where('product_id', $id)->forceDelete();
        foreach(Product_featured_photo::where('product_id', $id)->get() as $product_featured_photo){
            unlink(base_path("public/uploads/product_featured_photos/") . Product_featured_photo::find($product_featured_photo->id)->product_featured_photos);
        }
        Product_featured_photo::where('product_id', $id)->forceDelete();

        if(Product::onlyTrashed()->where('id', $id)->first()->product_thumbnail_photo != 'default_product_thumbnail_photo.jpg'){
            unlink(base_path("public/uploads/product_thumbnail_photo/").Product::onlyTrashed()->where('id', $id)->first()->product_thumbnail_photo);
        }
        Product::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Product force delete successfully',
        ]);
    }

    public function productTodayDealStatus($id){
        $product = Product::where('id', $id)->first();
        if($product->today_deal_status == "Yes"){
            $product->update([
                'today_deal_status' => "No",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Product today deal status inactive',
            ]);
        }else{
            $product->update([
                'today_deal_status' =>"Yes",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Product today deal status active',
            ]);
        }
    }

    public function productStatus($id){
        $product = Product::where('id', $id)->first();
        if($product->status == "Yes"){
            $product->update([
                'status' => "No",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Product status inactive',
            ]);
        }else{
            $product->update([
                'status' =>"Yes",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Product status inactive',
            ]);
        }
    }

    public function productFlashsaleStatusForm($id)
    {
        $product = Product::where('id', $id)->first();
        return response()->json($product);
    }

    public function productFlashsaleStatusUpdate(Request $request, $id){

        $product = Product::where('id', $id)->first();

        if($request->flashsale_status == "Yes" && $request->flashsale_id == NULL){
            return response()->json([
                'status' => 400,
            ]);
        }else{
            if($request->flashsale_status == NULL && $request->flashsale_id){
                return response()->json([
                    'status' => 401,
                ]);
            }else{
                if (!$request->flashsale_status) {
                    $flashsale_status = "No";
                } else {
                    $flashsale_status = $request->flashsale_status;
                }

                $product->update([
                    'flashsale_status' => $flashsale_status,
                    'flashsale_id' => $request->flashsale_id,
                    'updated_by' => Auth::guard('admin')->user()->id,
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Product flashsale status active',
                ]);
            }
        }
    }

    public function productFeaturedPhotoForm($id)
    {
        $product = Product::where('id', $id)->first();

        $send_product_featured_photos_data = "";

        $product_featured_photos = Product_featured_photo::where('product_id', $id)->get();

        foreach ($product_featured_photos as $product_featured_photo){
            $send_product_featured_photos_data .= '
            <div class="row border align-items-center">
                <div class="col-lg-6"><img src="'.asset('uploads/product_featured_photos').'/'.$product_featured_photo->product_featured_photos.'" width="60" ></div>
                <div class="col-lg-6">
                    <button type="button" id="'.$product_featured_photo->id.'" class="btn btn-danger btn-sm deleteProductFeaturedPhotoBtn">Delete</button>
                </div>
            </div>
            ';
        }

        return response()->json([
            'product' => $product,
            'send_product_featured_photos_data' => $send_product_featured_photos_data,
        ]);

    }

    public function productFeaturedPhotoStore(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'product_featured_photos' => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $status = true;
            foreach($request->file('product_featured_photos') as $product_featured_photo){
                if(!in_array($product_featured_photo->getClientOriginalExtension(), ['jpg', 'png', 'jpeg', 'webp', 'svg'])){
                    $status = false;
                }
            }
            if($status){
                foreach ($request->file('product_featured_photos') as $product_featured_photo) {
                    $new_name = $id."-Product-Featured-Photo-".Str::random(5).".".$product_featured_photo->getClientOriginalExtension();
                    $save_link = base_path("public/uploads/product_featured_photos/"). $new_name;
                    Image::make($product_featured_photo)->resize(600, 600)->save($save_link);

                    Product_featured_photo::insert([
                        'product_id' => $id,
                        'product_featured_photos' => $new_name,
                        'created_at'=> Carbon::now(),
                        'created_by' => Auth::guard('admin')->user()->id
                    ]);
                }
                return response()->json([
                    'status' => 200,
                    'message' => 'Product featured photos update successfully',
                ]);
            }
            else{
                return response()->json([
                    'status' => 401,
                    'error'=> 'Uploaded file must be this extension [ jpg, png, jpeg, webp ].'
                ]);
            }

        }
    }

    public function productFeaturedPhotoForceDelete($id)
    {
        unlink(base_path("public/uploads/product_featured_photos/") . Product_featured_photo::find($id)->product_featured_photos);
        Product_featured_photo::where('id', $id)->forceDelete();
    }

    public function productInventoryForm($id)
    {
        $product = Product::where('id', $id)->first();

        $send_product_inventories_data = "";

        $product_inventories = Product_inventory::where('product_id', $id)->get();

        foreach ($product_inventories as $product_inventory){
            $send_product_inventories_data .= '
            <div class="row border align-items-center">
                <div class="col-lg-2 border">'.Color::find($product_inventory->color_id)->color_name.'</div>
                <div class="col-lg-2 border">'.Size::find($product_inventory->size_id)->size_name.'</div>
                <div class="col-lg-2 border">'.$product_inventory->quantity.'</div>
                <div class="col-lg-3 border">'.$product_inventory->quantity * $product->discounted_price.'</div>
                <div class="col-lg-3 border">
                    <button type="button" id="'.$product_inventory->id.'" class="btn btn-danger btn-sm deleteProductInventoryBtn">Delete</button>
                </div>
            </div>
            ';
        }

        $product_inventories_quantity = $product_inventories->sum('quantity');
        $product_inventories_price = $product_inventories->sum('quantity') * $product->discounted_price;

        return response()->json([
            'product' => $product,
            'send_product_inventories_data' => $send_product_inventories_data,
            'product_inventories_quantity' => $product_inventories_quantity,
            'product_inventories_price' => $product_inventories_price,
        ]);
    }

    public function productInventoryStore(Request $request, $id){
        $validator = Validator::make($request->all(), [
            '*' => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $is_exists = Product_inventory::where([
                'product_id' => $id,
                'color_id' => $request->color_id,
                'size_id' => $request->size_id,
            ])->exists();
            if($is_exists){
                Product_inventory::where([
                    'product_id' => $id,
                    'color_id' => $request->color_id,
                    'size_id' => $request->size_id,
                ])->increment('quantity' , $request->quantity);
                return response()->json([
                    'status' => 201,
                ]);
            }
            else{
                Product_inventory::insert([
                    'product_id' => $id,
                    'color_id' => $request->color_id,
                    'size_id' => $request->size_id,
                    'quantity' => $request->quantity,
                    'created_at'=> Carbon::now(),
                    'created_by' => Auth::guard('admin')->user()->id
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Product inventory update successfully',
                ]);
            }
        }
    }

    public function productInventoryForceDelete($id)
    {
        Product_inventory::where('id', $id)->forceDelete();
    }
}

