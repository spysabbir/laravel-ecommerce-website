<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Order_deliveredMail;
use App\Mail\Order_returnMail;
use App\Models\Order_detail;
use App\Models\Order_return;
use App\Models\Order_summery;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class Order_Controller extends Controller
{
    public function processingOrders(Request $request){
        if ($request->ajax()) {
            $processing_orders = "";

            if(Auth::guard('admin')->user()->role == 'Warehouse'){
                $query = Order_summery::where('warehouse_id', Auth::guard('admin')->user()->warehouse_id)
                    ->where('order_status', '!=', 'Panding')
                    ->where('order_status', '!=', 'Delivered')
                    ->where('order_status', '!=', 'Cancel')
                    ->leftJoin('users', 'order_summeries.user_id', 'users.id');
            }else{
                $query = Order_summery::where('order_status', '!=', 'Delivered')
                    ->where('order_status', '!=', 'Cancel')
                    ->leftJoin('users', 'order_summeries.user_id', 'users.id');
            }

            if($request->payment_method){
                $query->where('order_summeries.payment_method', $request->payment_method);
            }
            if($request->payment_status){
                $query->where('order_summeries.payment_status', $request->payment_status);
            }
            if($request->order_status){
                $query->where('order_summeries.order_status', $request->order_status);
            }
            if($request->created_at){
                $query->where('order_summeries.created_at', 'LIKE', '%'.$request->created_at.'%');
            }

            $processing_orders = $query->select('order_summeries.*', 'users.name')
            ->get();

            return Datatables::of($processing_orders)
                    ->addIndexColumn()
                    ->editColumn('shipping_address', function($row){
                        return'
                        <span>'.$row->shipping_city.'</span>
                        <br>
                        <span>'.$row->shipping_address.'</span>
                        ';
                    })
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
                    ->addColumn('action', function($row){
                        $btn = '
                        <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm editOrderModelBtn" data-toggle="modal" data-target="#editOrderDetailsModel"><i class="fa fa-pencil-square-o"></i></button>
                        <button type="button" id="'.$row->id.'" class="btn btn-info btn-sm viewOrderModelBtn" data-toggle="modal" data-target="#viewOrderDetailsModel"><i class="fa fa-eye"></i></button>
                        <a class="btn btn-success btn-sm" href="'.route('order.invoice.download', Crypt::encrypt($row->id)).'"><i class="fa fa-download"></i></a>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['shipping_address', 'payment_details', 'order_status', 'created_at', 'action'])
                    ->make(true);
        }
        return view('admin.order.processing');
    }

    public function deliveredOrders(Request $request){

        if ($request->ajax()) {
            $delivered_orders = "";
            if(Auth::guard('admin')->user()->role == 'Warehouse'){
                $query = Order_summery::where('warehouse_id', Auth::guard('admin')->user()->warehouse_id)
                    ->where('order_status', 'Delivered')
                    ->leftJoin('users', 'order_summeries.user_id', 'users.id');
            }else{
                $query = Order_summery::where('order_status', 'Delivered')
                    ->leftJoin('users', 'order_summeries.user_id', 'users.id');
            }

            if($request->payment_method){
                $query->where('order_summeries.payment_method', $request->payment_method);
            }
            if($request->created_at){
                $query->where('order_summeries.created_at', 'LIKE', '%'.$request->created_at.'%');
            }

            $delivered_orders = $query->select('order_summeries.*', 'users.name')
            ->get();

            return Datatables::of($delivered_orders)
                    ->addIndexColumn()
                    ->editColumn('shipping_address', function($row){
                        return'
                        <span>'.$row->shipping_city.'</span>
                        <br>
                        <span>'.$row->shipping_address.'</span>
                        ';
                    })
                    ->editColumn('payment_details', function($row){
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
                    })
                    ->editColumn('order_status', function($row){
                        return'
                        <span class="badge bg-success">'.$row->order_status.'</span>
                        ';
                    })
                    ->editColumn('created_at', function($row){
                        return'
                        <span class="badge bg-light">'.$row->created_at->format('d-M-Y h:m:s A').'</span>
                        ';
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        <button type="button" id="'.$row->id.'" class="btn btn-primary btn-sm editOrderModelBtn" data-toggle="modal" data-target="#editOrderDetailsModel"><i class="fa fa-pencil-square-o"></i></button>
                        <button type="button" id="'.$row->id.'" class="btn btn-info btn-sm viewOrderModelBtn" data-toggle="modal" data-target="#viewOrderDetailsModel"><i class="fa fa-eye"></i></button>
                        <a class="btn btn-success btn-sm" href="'.route('order.invoice.download', Crypt::encrypt($row->id)).'"><i class="fa fa-download"></i></a>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['shipping_address', 'payment_details', 'order_status', 'created_at', 'action'])
                    ->make(true);
        }
        return view('admin.order.delivered');
    }

    public function cancelOrders(Request $request){

        if ($request->ajax()) {
            $cancel_orders = "";
            $query = Order_summery::where('order_status', 'Cancel')
                ->leftJoin('users', 'order_summeries.user_id', 'users.id');

            if($request->created_at){
                $query->where('order_summeries.created_at', 'LIKE', '%'.$request->created_at.'%');
            }

            $cancel_orders = $query->select('order_summeries.*', 'users.name')
            ->get();

            return Datatables::of($cancel_orders)
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
                        return'
                        <span class="badge bg-danger">'.$row->order_status.'</span>
                        ';
                    })
                    ->editColumn('created_at', function($row){
                        return'
                        <span class="badge bg-light">'.$row->created_at->format('d-M-Y h:m:s A').'</span>
                        ';
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm editOrderModelBtn" data-toggle="modal" data-target="#editOrderDetailsModel"><i class="fa fa-pencil-square-o"></i></button>
                        <button type="button" id="'.$row->id.'" class="btn btn-info btn-sm viewOrderModelBtn" data-toggle="modal" data-target="#viewOrderDetailsModel"><i class="fa fa-eye"></i></button>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['name', 'payment_details', 'order_status', 'created_at', 'action'])
                    ->make(true);
        }
        return view('admin.order.cancel');
    }

    public function orderStatusEdit($id)
    {
        $order_summery = Order_summery::where('id', $id)->first();
        return response()->json($order_summery);
    }

    public function orderStatusUpdate(Request $request, $id)
    {
        $order_summery = Order_summery::where('id', $id)->first();

            if($request->warehouse_id == NULL && $request->order_status != 'Panding' && $request->order_status != 'Cancel'){
                return response()->json([
                    'status' => 400,
                ]);
            }else{
                if ($order_summery->payment_method == 'Online' && $order_summery->payment_status != 'Paid' && $request->order_status != 'Panding' && $request->order_status != 'Cancel') {
                    return response()->json([
                        'status' => 401,
                        'message' => 'This order payment incomplete!',
                    ]);
                } else {
                    if($order_summery->payment_method == 'Online' && $order_summery->payment_status == 'Paid' && $request->order_status == 'Cancel'){
                        return response()->json([
                            'status' => 402,
                            'message' => 'This order already payment successfully!',
                        ]);
                    }else{
                        if($request->order_status == 'Panding' || $request->order_status == 'Cancel'){
                            $warehouse_id = null;
                        }else{
                            $warehouse_id = $request->warehouse_id;
                        }

                        if($order_summery->payment_method == 'COD' && $request->order_status != 'Delivered'){
                            $payment_status = 'Unpaid';
                        }else{
                            if ($order_summery->payment_method == 'COD' && $request->order_status == 'Delivered') {
                                $payment_status = 'Paid';
                            } else {
                                $payment_status = $order_summery->payment_status;
                            }
                        }

                        $order_summery->update([
                            'warehouse_id' => $warehouse_id,
                            'order_status' => $request->order_status,
                            'payment_status' => $payment_status,
                        ]);

                        return response()->json([
                            'status' => 200,
                            'message' => 'Order status updated successfully',
                        ]);

                        if($request->order_status == 'Delivered'){
                            $order_summery = Order_summery::find($id);
                            Mail::to($order_summery->billing_email)
                                ->cc($order_summery->shipping_email)
                                ->send(new Order_deliveredMail($order_summery));
                        }
                    }
                }
            }
    }

    public function orderInvoiceDownload ($id)
    {
        $id = Crypt::decrypt($id);
        $order_summery = Order_summery::where('id', $id)->first();
        $order_details = Order_detail::where('order_no', $id)->get();
        $pdf = Pdf::loadView('admin.order.invoice', compact('order_summery', 'order_details'));
        return $pdf->download(Carbon::now()->format('d-M-Y').'-INVOICE-ID-'.$order_summery->id.'.pdf');
    }

    public function orderDetails($id)
    {
        $order_summery = Order_summery::where('id', $id)->first();
        $order_details = Order_detail::where('order_no', $id)->get();
        return view('admin.order.order-details', compact('order_summery', 'order_details'));
    }

    public function returnOrders(Request $request){

        if ($request->ajax()) {
            $return_orders = "";
            $query = Order_return::leftJoin('order_details', 'order_returns.order_detail_id', 'order_details.id');

            if($request->return_status){
                $query->where('order_returns.return_status', $request->return_status);
            }

            if($request->created_at){
                $query->where('order_returns.created_at', 'LIKE', '%'.$request->created_at.'%');
            }

            $return_orders = $query->select('order_returns.*', 'order_details.product_current_price')
            ->get();

            return Datatables::of($return_orders)
                    ->addIndexColumn()
                    ->editColumn('return_status', function($row){
                        if ($row->return_status == 'Return Done') {
                            return'
                            <span class="badge bg-success">'.$row->return_status.'</span>
                            ';
                        } else {
                            return'
                            <span class="badge bg-danger">'.$row->return_status.'</span>
                            ';
                        }
                    })
                    ->editColumn('created_at', function($row){
                        return'
                        <span class="badge bg-light">'.$row->created_at->format('d-M-Y h:m:s A').'</span>
                        ';
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm editReturnModelBtn" data-toggle="modal" data-target="#editReturnDetailsModel"><i class="fa fa-pencil-square-o"></i></button>
                        <button type="button" id="'.$row->id.'" class="btn btn-info btn-sm viewReturnModelBtn" data-toggle="modal" data-target="#viewReturnDetailsModel"><i class="fa fa-eye"></i></button>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['return_status', 'created_at', 'action'])
                    ->make(true);
        }
        return view('admin.order.return');
    }

    public function returnOrderDetails($id)
    {
        $return_details = Order_return::where('id', $id)->first();
        $order_summery = Order_summery::where('id', $return_details->order_no)->first();
        $order_details = Order_detail::where('id', $return_details->order_detail_id)->first();
        return view('admin.order.return-details', compact('return_details', 'order_summery', 'order_details'));
    }

    public function returnOrderStatusEdit($id)
    {
        $return_details = Order_return::where('id', $id)->first();
        return response()->json($return_details);
    }

    public function returnOrderStatusUpdate(Request $request, $id)
    {
        $return_details = Order_return::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            'return_status' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $return_details->return_status = $request->return_status;
            $return_details->save();

            return response()->json([
                'status' => 200,
            ]);

            if($request->order_status == 'Return Done'){
                $order_summery = Order_summery::find($return_details->order_no);
                Mail::to($order_summery->billing_email)
                    ->cc($order_summery->shipping_email)
                    ->send(new Order_returnMail($order_summery));
            }
        }
    }

}
