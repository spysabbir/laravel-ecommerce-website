<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Childcategory;
use App\Models\Flashsale;
use App\Models\FlashsaleProduct;
use App\Models\Product;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FlashsaleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $flashsales = "";
            $query = Flashsale::select('flashsales.*');

            if($request->status){
                $query->where('flashsales.status', $request->status);
            }

            $flashsales = $query->get();

            return Datatables::of($flashsales)
                    ->addIndexColumn()
                    ->editColumn('flashsale_offer_banner_photo', function($row){
                        return '<img src="'.asset('uploads/flashsale_offer_banner_photo').'/'.$row->flashsale_offer_banner_photo.'" height="50" >';
                    })
                    ->editColumn('flashsale_offer_duration', function($row){
                        return'
                        <span class="badge bg-success">'.$row->flashsale_offer_start_date.'</span>
                        <span class="badge bg-success">'.$row->flashsale_offer_end_date.'</span>
                        ';
                    })
                    ->editColumn('status', function($row){
                        if($row->status == "Yes"){
                            return'
                            <span class="badge bg-success">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm flashsaleStatusBtn"><i class="fa fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm flashsaleStatusBtn"><i class="fa fa-check"></i></button>
                            ';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        <a href="'.route('flashsale.product.added', $row->id).'" class="btn btn-info btn-sm">Manage Product</a>
                        <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm editFlashsaleModelBtn" data-toggle="modal" data-target="#editFlashsaleModel"><i class="fa fa-pencil-square-o"></i></button>
                        <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteFlashsaleBtn"><i class="fa fa-trash"></i></button>
                            ';
                        return $btn;
                    })
                    ->rawColumns(['flashsale_offer_banner_photo', 'flashsale_offer_duration', 'status', 'action'])
                    ->make(true);
        }
        return view('admin.flashsale.index');
    }

    public function fetchTrashedFlashsale()
    {
        $send_trashed_flashsales_data = "";

        $trashed_flashsales = Flashsale::onlyTrashed()->get();

        foreach ($trashed_flashsales as $trashed_flashsale){
            $send_trashed_flashsales_data .= '
            <tr>
                <td>'.$trashed_flashsale->id.'</td>
                <td>'.$trashed_flashsale->flashsale_offer_name.'</td>
                <td>
                    <button type="button" id="'.$trashed_flashsale->id.'" class="btn btn-success btn-sm flashsaleRestoreBtn"><i class="fa fa-undo"></i></button>
                    <button type="button" id="'.$trashed_flashsale->id.'" class="btn btn-danger btn-sm flashsaleForceDeleteBtn"><i class="fa fa-times"></i></button>
                </td>
            </tr>
            ';
        }

        return response()->json([
            'trashed_flashsales' => $send_trashed_flashsales_data,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'flashsale_offer_name' => 'required|unique:flashsales',
            'flashsale_offer_banner_photo' => 'required|image|mimes:png,jpg,jpeg,webp',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $flashsale_offer_slug = Str::slug($request->flashsale_offer_name);
            // Offer Banner Photo Upload
            $flashsale_offer_banner_photo_name = "Offer-Banner-Photo-".Str::random(5).".". $request->file('flashsale_offer_banner_photo')->getClientOriginalExtension();
            $upload_link = base_path("public/uploads/flashsale_offer_banner_photo/").$flashsale_offer_banner_photo_name;
            Image::make($request->file('flashsale_offer_banner_photo'))->resize(640, 315)->save($upload_link);

            Flashsale::insert([
                'flashsale_offer_name' => $request->flashsale_offer_name,
                'flashsale_offer_slug' => $flashsale_offer_slug,
                'flashsale_offer_type' => $request->flashsale_offer_type,
                'flashsale_offer_amount' => $request->flashsale_offer_amount,
                'flashsale_offer_start_date' => $request->flashsale_offer_start_date,
                'flashsale_offer_end_date' => $request->flashsale_offer_end_date,
                'flashsale_offer_banner_photo' => $flashsale_offer_banner_photo_name,
                'created_by' => Auth::guard('admin')->user()->id,
                'created_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Flashsale create successfully',
            ]);
        }
    }

    public function edit($id)
    {
        $flashsale = Flashsale::where('id', $id)->first();
        return response()->json($flashsale);
    }

    public function update(Request $request, $id)
    {
        $flashsale = Flashsale::where('id', $id)->first();
        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'flashsale_offer_name' => 'required|unique:flashsales,flashsale_offer_name,'.$flashsale->id,
            'flashsale_offer_banner_photo' => 'nullable|image|mimes:png,jpg,jpeg,webp',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $flashsale_offer_slug = Str::slug($request->flashsale_offer_name);
            // Offer Banner Photo Upload
            if($request->hasFile('flashsale_offer_banner_photo')){
                unlink(base_path("public/uploads/flashsale_offer_banner_photo/").$flashsale->flashsale_offer_banner_photo);
                $flashsale_offer_banner_photo_name = "Offer-Banner-Photo-".Str::random(5).".". $request->file('flashsale_offer_banner_photo')->getClientOriginalExtension();
                $upload_link = base_path("public/uploads/flashsale_offer_banner_photo/").$flashsale_offer_banner_photo_name;
                Image::make($request->file('flashsale_offer_banner_photo'))->resize(640, 315)->save($upload_link);
                $flashsale->update([
                    'flashsale_offer_banner_photo' => $flashsale_offer_banner_photo_name,
                    'updated_by' => Auth::guard('admin')->user()->id,
                ]);
            }

            $flashsale->update([
                'flashsale_offer_name' => $request->flashsale_offer_name,
                'flashsale_offer_slug' => $flashsale_offer_slug,
                'flashsale_offer_type' => $request->flashsale_offer_type,
                'flashsale_offer_amount' => $request->flashsale_offer_amount,
                'flashsale_offer_start_date' => $request->flashsale_offer_start_date,
                'flashsale_offer_end_date' => $request->flashsale_offer_end_date,
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Flashsale update successfully',
            ]);
        }
    }

    public function destroy($id)
    {
        $flashsale = Flashsale::where('id', $id)->first();
        $flashsale->updated_by = Auth::guard('admin')->user()->id;
        $flashsale->deleted_by = Auth::guard('admin')->user()->id;
        $flashsale->save();
        $flashsale->delete();
        return response()->json([
            'message' => 'Flashsale destroy successfully',
        ]);
    }

    public function flashsaleRestore($id)
    {
        Flashsale::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Flashsale::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'message' => 'Flashsale restore successfully',
        ]);
    }

    public function flashsaleForceDelete($id)
    {
        unlink(base_path("public/uploads/flashsale_offer_banner_photo/").Flashsale::onlyTrashed()->where('id', $id)->first()->flashsale_offer_banner_photo);
        Flashsale::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Flashsale force delete successfully',
        ]);
    }

    public function flashsaleStatus($id){
        $flashsale = Flashsale::where('id', $id)->first();
        if($flashsale->status == "Yes"){
            $flashsale->update([
                'status' => "No",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Flashsale status inactive',
            ]);
        }else{
            $flashsale->update([
                'status' =>"Yes",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Flashsale status active',
            ]);
        }
    }

    public function flashsaleProductAdded($id){
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $childcategories = Childcategory::all();
        $brands = Brand::all();
        $flashsale = Flashsale::where('id', $id)->first();
        return view('admin.flashsale.product', compact('categories', 'subcategories', 'childcategories', 'brands', 'flashsale'));
    }

    public function flashsaleProductList(Request $request){
        if ($request->ajax()) {
            $products = "";
            $query = DB::table('products')
                ->leftJoin('categories', 'products.category_id', 'categories.id')
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
            if($request->flashsale_status){
                $query->where('products.flashsale_status', $request->flashsale_status);
            }

            $products = $query->select('products.*', 'categories.category_name', 'subcategories.subcategory_name', 'childcategories.childcategory_name', 'brands.brand_name')
            ->get();

            return Datatables::of($products->where('status', 'Yes'))
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
                    ->addColumn('action', function($row){
                        if($row->flashsale_status == "Yes"){
                            $btn = '
                            <span class="badge bg-success">'.$row->flashsale_status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm flashsaleProductAddedBtn"><i class="fa fa-ban"></i></button>
                            ';
                            return $btn;
                        }else{
                            $btn = '
                            <span class="badge bg-warning">'.$row->flashsale_status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm flashsaleProductAddedBtn"><i class="fa fa-check"></i></button>
                            ';
                            return $btn;
                        }
                    })
                    ->rawColumns(['product_thumbnail_photo', 'product_details', 'action'])
                    ->make(true);
        }
    }

    public function flashsaleProductUpdate(Request $request, $id)
    {
        $flashsaleProduct = FlashsaleProduct::where('flashsale_id', $request->flashsale_id)->where('product_id', $id);

        if($flashsaleProduct->exists()){
            $flashsaleProduct->delete();

            if(!FlashsaleProduct::where('product_id', $id)->exists()){
                Product::find($id)->update([
                    'flashsale_status' =>"No",
                    'updated_by' => Auth::guard('admin')->user()->id,
                ]);
            };

            return response()->json([
                'message' => 'Product remove',
            ]);
        }else{
            $flashsaleProduct->create([
                'flashsale_id' => $request->flashsale_id,
                'product_id' => $id,
            ]);

            Product::find($id)->update([
                'flashsale_status' =>"Yes",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);

            return response()->json([
                'message' => 'Product added',
            ]);
        }
    }

    public function flashsaleAllProductAdded($id)
    {
        $productIdsToAdd  = Product::where('flashsale_status', 'No')->pluck('id');
        Product::whereIn('id', $productIdsToAdd)->update(['flashsale_status' => 'Yes']);

        $flashSale = FlashSale::find($id);
        $flashSale->products()->attach($productIdsToAdd);


        $notification = array(
            'message' => 'All product added in flashsale.',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    public function flashsaleAllProductRemove($id)
    {
        $productIdsToAdd  = FlashsaleProduct::where('flashsale_id', $id)->pluck('product_id');
        Product::whereIn('id', $productIdsToAdd)->update(['flashsale_status' => 'No']);

        $flashSale = FlashSale::find($id);
        $flashSale->products()->detach();

        $notification = array(
            'message' => 'All product remove in flashsale.',
            'alert-type' => 'warning'
        );

        return back()->with($notification);
    }
}


