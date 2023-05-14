<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrderExport;
use App\Exports\OrdersExport;
use App\Exports\Product_inventoriesExport;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Childcategory;
use App\Models\Color;
use App\Models\Order_summery;
use App\Models\Product;
use App\Models\Product_inventory;
use App\Models\Size;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function reportAllOrder(Request $request)
    {
        if ($request->ajax()) {
            $all_order = "";
            $query = Order_summery::leftJoin('users', 'order_summeries.user_id', 'users.id');

            if($request->payment_method){
                $query->where('order_summeries.payment_method', $request->payment_method);
            }
            if($request->payment_status){
                $query->where('order_summeries.payment_status', $request->payment_status);
            }
            if($request->order_status){
                $query->where('order_summeries.order_status', $request->order_status);
            }

            if($request->created_at_start){
                $query->whereDate('order_summeries.created_at', '>=', $request->created_at_start);
            }
            if($request->created_at_end){
                $query->whereDate('order_summeries.created_at', '<=', $request->created_at_end);
            }

            $all_order = $query->select('order_summeries.*', 'users.name')->get();

            return Datatables::of($all_order)
                    ->addIndexColumn()
                    ->editColumn('payment_details', function($row){
                        if ($row->payment_status == 'Paid') {
                            if ($row->payment_method == 'COD') {
                                return'
                                <span class="badge bg-primary">'.$row->payment_method.'</span>
                                <span class="badge bg-success">'.$row->payment_status.'</span>
                                ';
                            } else {
                                return'
                                <span class="badge bg-info">'.$row->payment_method.'</span>
                                <span class="badge bg-success">'.$row->payment_status.'</span>
                                ';
                            }
                        } else {
                            if ($row->payment_method == 'COD') {
                                return'
                                <span class="badge bg-primary">'.$row->payment_method.'</span>
                                <span class="badge bg-warning">'.$row->payment_status.'</span>
                                ';
                            } else {
                                return'
                                <span class="badge bg-info">'.$row->payment_method.'</span>
                                <span class="badge bg-warning">'.$row->payment_status.'</span>
                                ';
                            }
                        };
                    })
                    ->editColumn('order_status', function($row){
                        if ($row->order_status == 'Panding') {
                            return'
                            <span class="badge bg-warning">'.$row->order_status.'</span>
                            ';
                        }elseif($row->order_status == 'Received'){
                            return'
                            <span class="badge bg-info">'.$row->order_status.'</span>
                            ';
                        }elseif($row->order_status == 'On the way'){
                            return'
                            <span class="badge bg-primary">'.$row->order_status.'</span>
                            ';
                        }elseif($row->order_status == 'Delivered'){
                            return'
                            <span class="badge bg-success">'.$row->order_status.'</span>
                            ';
                        }else {
                            return'
                            <span class="badge bg-danger">'.$row->order_status.'</span>
                            ';
                        }
                    })
                    ->editColumn('created_at', function($row){
                        return'
                        <span class="badge bg-light">'.$row->created_at->format('d-M-Y h:m:s A').'</span>
                        ';
                    })
                    ->rawColumns(['name', 'payment_details', 'order_status', 'created_at'])
                    ->make(true);
        }
        return view('admin.report.order');
    }

    public function reportAllOrderPrint(Request $request)
    {
        if ($request->ajax()) {
            $all_order = "";
            $query = Order_summery::leftJoin('users', 'order_summeries.user_id', 'users.id');

            $payment_method = $request->payment_method;
            if($request->payment_method){
                $query->where('order_summeries.payment_method', $request->payment_method);
            }

            $payment_status = $request->payment_status;
            if($request->payment_status){
                $query->where('order_summeries.payment_status', $request->payment_status);
            }

            $order_status = $request->order_status;
            if($request->order_status){
                $query->where('order_summeries.order_status', $request->order_status);
            }

            $created_at_start = $request->created_at_start;
            if($request->created_at_start){
                $query->whereDate('order_summeries.created_at', '>=', $request->created_at_start);
            }

            $created_at_end = $request->created_at_end;
            if($request->created_at_end){
                $query->whereDate('order_summeries.created_at', '<=', $request->created_at_end);
            }

            $all_order = $query->select('order_summeries.*', 'users.name')->get();
        }
        return view('admin.report.order-print', compact('all_order', 'payment_method', 'payment_status', 'order_status', 'created_at_start', 'created_at_end'));
    }

    public function reportAllOrderExport(Request $request)
    {
        $all_order = "";
        $query = Order_summery::leftJoin('users', 'order_summeries.user_id', 'users.id');

        if($request->payment_method){
            $query->where('order_summeries.payment_method', $request->payment_method);
        }

        if($request->payment_status){
            $query->where('order_summeries.payment_status', $request->payment_status);
        }

        if($request->order_status){
            $query->where('order_summeries.order_status', $request->order_status);
        }

        if($request->created_at_start){
            $query->whereDate('order_summeries.created_at', '>=', $request->created_at_start);
        }

        if($request->created_at_end){
            $query->whereDate('order_summeries.created_at', '<=', $request->created_at_end);
        }

        $all_order = $query->select('order_summeries.*', 'users.name')->get();

        return Excel::download(new OrdersExport($all_order), 'all-order.xlsx');
    }

    public function reportProductInventory(Request $request)
    {
        if ($request->ajax()) {
            $product_inventories = "";
            $query = Product_inventory::leftJoin('products', 'product_inventories.product_id', 'products.id')
                            ->leftJoin('colors', 'product_inventories.color_id', 'colors.id')
                            ->leftJoin('sizes', 'product_inventories.size_id', 'sizes.id');

            if($request->product_id){
                $query->where('product_inventories.product_id', $request->product_id);
            }
            if($request->color_id){
                $query->where('product_inventories.color_id', $request->color_id);
            }
            if($request->size_id){
                $query->where('product_inventories.size_id', $request->size_id);
            }

            $all_product_inventories = $query->select('product_inventories.*', 'products.product_name', 'products.category_id', 'products.subcategory_id', 'products.childcategory_id', 'products.brand_id', 'colors.color_name', 'sizes.size_name');

            if($request->category_id){
                $all_product_inventories->where('category_id', $request->category_id);
            }
            if($request->subcategory_id){
                $all_product_inventories->where('subcategory_id', $request->subcategory_id);
            }
            if($request->childcategory_id){
                $all_product_inventories->where('childcategory_id', $request->childcategory_id);
            }

            if($request->brand_id){
                $all_product_inventories->where('brand_id', $request->brand_id);
            }

            $product_inventories = $all_product_inventories->get();

            return Datatables::of($product_inventories)
                    ->addIndexColumn()
                    ->editColumn('category_name', function($row){
                        return'
                        <span class="badge bg-info">'.$row->relationtocategory->category_name.'</span>
                        ';
                    })
                    ->editColumn('subcategory_name', function($row){
                        return'
                        <span class="badge bg-info">'.$row->relationtosubcategory->subcategory_name.'</span>
                        ';
                    })
                    ->editColumn('childcategory_name', function($row){
                        return'
                        <span class="badge bg-info">'.$row->relationtochildcategory->childcategory_name.'</span>
                        ';
                    })
                    ->editColumn('brand_name', function($row){
                        return'
                        <span class="badge bg-info">'.$row->relationtobrand->brand_name.'</span>
                        ';
                    })
                    ->rawColumns(['category_name', 'subcategory_name', 'childcategory_name', 'brand_name'])
                    ->make(true);
        }
        return view('admin.report.product-inventory');
    }

    public function reportProductInventoryPrint(Request $request)
    {
        if ($request->ajax()) {
            $product_inventories = "";
            $query = Product_inventory::leftJoin('products', 'product_inventories.product_id', 'products.id')
                            ->leftJoin('colors', 'product_inventories.color_id', 'colors.id')
                            ->leftJoin('sizes', 'product_inventories.size_id', 'sizes.id');

            $product_name = Product::find($request->product_id)->product_name;
            if($request->product_id){
                $query->where('product_inventories.product_id', $request->product_id);
            }

            $color_name = Color::find($request->color_id)->color_name;
            if($request->color_id){
                $query->where('product_inventories.color_id', $request->color_id);
            }

            $size_name = Size::find($request->size_id)->size_name;
            if($request->size_id){
                $query->where('product_inventories.size_id', $request->size_id);
            }

            $all_product_inventories = $query->select('product_inventories.*', 'products.product_name', 'products.category_id', 'products.subcategory_id', 'products.childcategory_id', 'products.brand_id', 'colors.color_name', 'sizes.size_name');

            $category_name = Category::find($request->category_id)->category_name;
            if($request->category_id){
                $all_product_inventories->where('category_id', $request->category_id);
            }

            $subcategory_name = Subcategory::find($request->subcategory_id)->subcategory_name;
            if($request->subcategory_id){
                $all_product_inventories->where('subcategory_id', $request->subcategory_id);
            }

            $childcategory_name = Childcategory::find($request->childcategory_id)->childcategory_name;
            if($request->childcategory_id){
                $all_product_inventories->where('childcategory_id', $request->childcategory_id);
            }

            $brand_name = Brand::find($request->brand_id)->brand_name;
            if($request->brand_id){
                $all_product_inventories->where('brand_id', $request->brand_id);
            }

            $product_inventories = $all_product_inventories->get();
        }

        return response()->json($product_inventories);

        // return view('admin.report.product-inventory-print', compact('product_inventories', 'category_name', 'subcategory_name', 'childcategory_name', 'brand_name', 'product_name', 'color_name', 'size_name'));
    }

    public function reportProductInventoryExport(Request $request)
    {
        $product_inventories = "";
        $query = Product_inventory::leftJoin('products', 'product_inventories.product_id', 'products.id')
                        ->leftJoin('colors', 'product_inventories.color_id', 'colors.id')
                        ->leftJoin('sizes', 'product_inventories.size_id', 'sizes.id');

        if($request->product_id){
            $query->where('product_inventories.product_id', $request->product_id);
        }
        if($request->color_id){
            $query->where('product_inventories.color_id', $request->color_id);
        }
        if($request->size_id){
            $query->where('product_inventories.size_id', $request->size_id);
        }

        $all_product_inventories = $query->select('product_inventories.*', 'products.product_name', 'products.category_id', 'products.subcategory_id', 'products.childcategory_id', 'products.brand_id', 'colors.color_name', 'sizes.size_name');

        if($request->category_id){
            $all_product_inventories->where('category_id', $request->category_id);
        }
        if($request->subcategory_id){
            $all_product_inventories->where('subcategory_id', $request->subcategory_id);
        }
        if($request->childcategory_id){
            $all_product_inventories->where('childcategory_id', $request->childcategory_id);
        }

        if($request->brand_id){
            $all_product_inventories->where('brand_id', $request->brand_id);
        }

        $product_inventories = $all_product_inventories->get();

        return Excel::download(new Product_inventoriesExport($product_inventories), 'product-inventories.xlsx');
    }
}
