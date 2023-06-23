
@extends('admin.layouts.admin_master')

@section('title_bar')
Dashboard
@endsection

@section('body_content')
@if (session('success'))
<div class="alert alert-success" role="alert">
    <strong>{{ session('success') }}</strong>
</div>
@endif
@if (session('error'))
<div class="alert alert-warning" role="alert">
    <strong>{{ session('error') }}</strong>
</div>
@endif

@if (Auth::guard('admin')->user()->role == 'Super Admin' || Auth::guard('admin')->user()->role == 'Admin')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card top_summary">
            <div class="header">
                <h2>Summary</h2>
            </div>
            <div class="body">
                <div class="row clearfix mb-3">
                    <div class="col-lg-4 col-md-3">
                        <div id="Summary1" class="carousel vert slide" data-ride="carousel" data-interval="1700">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="p-10">
                                        <h2 class="font700 float-left mr-2">
                                            {{ $users }}
                                        </h2>
                                        <small><i class="fa fa-level-up text-success"></i><br>
                                            Total Customer
                                        </small>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="p-10">
                                        <h2 class="font700 float-left mr-2">
                                            {{ App\Models\User::where('created_at', '>', Carbon\Carbon::now()->subDays(7))->count() }}
                                        </h2>
                                        <small><i class="fa fa-level-up text-success"></i><br>New Customer </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-3">
                        <div id="Summary2" class="carousel vert slide" data-ride="carousel" data-interval="1200">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="p-10">
                                        <h2 class="font700 float-left mr-2">{{ $visitors }}</h2>
                                        <small><i class="fa fa-level-down text-danger"></i><br>All Visiter</small>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="p-10">
                                        <h2 class="font700 float-left mr-2">
                                            {{ App\Models\Visitor::where('visit_time', '>', Carbon\Carbon::now()->subDays(7))->count() }}
                                        </h2>
                                        <small><i class="fa fa-level-up text-success"></i><br>New Visiter</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-3">
                        <div id="Summary2" class="carousel vert slide" data-ride="carousel" data-interval="1200">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="p-10">
                                        <h2 class="font700 float-left mr-2">{{ $order_summeries->count() }}</h2>
                                        <small><i class="fa fa-level-down text-danger"></i><br>Total Order</small>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="p-10">
                                        <h2 class="font700 float-left mr-2">
                                            {{ $order_summeries->where('created_at', '>', Carbon\Carbon::now()->subDays(7))->count() }}
                                        </h2>
                                        <small><i class="fa fa-level-up text-success"></i><br>New Order</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix mb-3">
                    <div class="col-lg-4 col-md-3">
                        <div id="Summary3" class="carousel vert slide" data-ride="carousel" data-interval="1000">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="p-10">
                                        <h2 class="font700 float-left mr-2">
                                            {{ $order_summeries->where('order_status', 'Panding')->count() }}</h2>
                                        <small><i class="fa fa-level-up text-success"></i><br>
                                            Panding Orders</small>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="p-10">
                                        <h2 class="font700 float-left mr-2">
                                            {{ $order_summeries->where('order_status', 'Received')->count() }}</h2>
                                        <small><i class="fa fa-level-up text-success"></i><br>
                                            Received Orders</small>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="p-10">
                                        <h2 class="font700 float-left mr-2">
                                            {{ $order_summeries->where('order_status', 'On the way')->count() }}</h2>
                                        <small><i class="fa fa-level-up text-success"></i><br>
                                            On the way Orders</small>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="p-10">
                                        <h2 class="font700 float-left mr-2">
                                            {{ $order_summeries->where('order_status', 'Delivered')->count() }}</h2>
                                        <small><i class="fa fa-level-up text-success"></i><br>
                                            Delivered Orders</small>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="p-10">
                                        <h2 class="font700 float-left mr-2">
                                            {{ $order_summeries->where('order_status', 'Cancel')->count() }}</h2>
                                        <small><i class="fa fa-level-up text-success"></i><br>
                                            Cancel Orders</small>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="p-10">
                                        <h2 class="font700 float-left mr-2">
                                            {{ $order_summeries->where('order_status', 'Return')->count() }}</h2>
                                        <small><i class="fa fa-level-up text-success"></i><br>
                                            Return Orders</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-3">
                        <div id="Summary3" class="carousel vert slide" data-ride="carousel" data-interval="1000">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="p-10">
                                        <h2 class="font700 float-left mr-2">
                                            {{ $categories }}</h2>
                                        <small><i class="fa fa-level-up text-success"></i><br>
                                            All Categories</small>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="p-10">
                                        <h2 class="font700 float-left mr-2">
                                            {{ $subcategories }}</h2>
                                        <small><i class="fa fa-level-up text-success"></i><br>
                                            All Subcategories</small>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="p-10">
                                        <h2 class="font700 float-left mr-2">
                                            {{ $childcategories }}</h2>
                                        <small><i class="fa fa-level-up text-success"></i><br>
                                            All Childcategories</small>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="p-10">
                                        <h2 class="font700 float-left mr-2">
                                            {{ $brands }}</h2>
                                        <small><i class="fa fa-level-up text-success"></i><br>
                                            All Brands</small>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="p-10">
                                        <h2 class="font700 float-left mr-2">
                                            {{ $products }}</h2>
                                        <small><i class="fa fa-level-up text-success"></i><br>
                                            All Products</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if (Auth::guard('admin')->user()->role == 'Super Admin' || Auth::guard('admin')->user()->role == 'Admin')
<div class="row clearfix">
    <div class="col-md-3 col-sm-12">
        <div class="card">
            <div class="body">
                <div class="row clearfix">
                    <div class="col-8">
                        <h5 class="mb-0">Subscribers</h5>
                        <small class="info">All</small>
                    </div>
                    <div class="col-4 text-right">
                        <h2 class="m-b-0">{{ $subscribers }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-12">
        <div class="card">
            <div class="body">
                <div class="row clearfix">
                    <div class="col-8">
                        <h5 class="mb-0">Messages</h5>
                        <small class="info">All</small>
                    </div>
                    <div class="col-4 text-right">
                        <h2 class="m-b-0">{{ $contact_messages }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-12">
        <div class="card">
            <div class="body">
                <div class="row clearfix">
                    <div class="col-8">
                        <h5 class="mb-0">Warehouse Staff</h5>
                        <small class="info">All</small>
                    </div>
                    <div class="col-4 text-right">
                        <h2 class="m-b-0">{{ App\Models\Admin::where('role', 'Manager')->count() }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-12">
        <div class="card">
            <div class="body">
                <div class="row clearfix">
                    <div class="col-8">
                        <h5 class="mb-0">Customer</h5>
                        <small class="info">All</small>
                    </div>
                    <div class="col-4 text-right">
                        <h2 class="m-b-0">{{ $users }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row clearfix">
    <div class="col-md-3 col-sm-12">
        <div class="card">
            <div class="body">
                <div class="row clearfix">
                    <div class="col-8">
                        <h5 class="mb-0">All</h5>
                        <small class="info">Orders</small>
                    </div>
                    <div class="col-4 text-right">
                        <h2 class="m-b-0">{{ $order_summeries->where('warehouse_id', Auth::guard('admin')->user()->warehouse_id)->count() }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-12">
        <div class="card">
            <div class="body">
                <div class="row clearfix">
                    <div class="col-8">
                        <h5 class="mb-0">Received</h5>
                        <small class="info">Orders</small>
                    </div>
                    <div class="col-4 text-right">
                        <h2 class="m-b-0">{{ $order_summeries->where('warehouse_id', Auth::guard('admin')->user()->warehouse_id)->where('order_status', 'Received')->count() }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-12">
        <div class="card">
            <div class="body">
                <div class="row clearfix">
                    <div class="col-8">
                        <h5 class="mb-0">On the way</h5>
                        <small class="info">Orders</small>
                    </div>
                    <div class="col-4 text-right">
                        <h2 class="m-b-0">{{ $order_summeries->where('warehouse_id', Auth::guard('admin')->user()->warehouse_id)->where('order_status', 'On the way')->count() }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-12">
        <div class="card">
            <div class="body">
                <div class="row clearfix">
                    <div class="col-8">
                        <h5 class="mb-0">Delivered</h5>
                        <small class="info">Orders</small>
                    </div>
                    <div class="col-4 text-right">
                        <h2 class="m-b-0">{{ $order_summeries->where('warehouse_id', Auth::guard('admin')->user()->warehouse_id)->where('order_status', 'Delivered')->count() }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if (Auth::guard('admin')->user()->role == 'Super Admin' || Auth::guard('admin')->user()->role == 'Admin')
<div class="row clearfix">
    <div class="col-lg-3">
        <div class="card bg-info">
            <div class="body">
                <div class="row clearfix">
                    <div class="col-8">
                        <h5 class="mb-0">All</h5>
                        <small class="info">Orders</small>
                    </div>
                    <div class="col-4 text-right">
                        <h2 class="m-b-0">{{ $order_summeries->count() }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="card bg-dark">
            <div class="body">
                <div class="row clearfix">
                    <div class="col-8">
                        <h5 class="mb-0">Panding</h5>
                        <small class="info">Orders</small>
                    </div>
                    <div class="col-4 text-right">
                        <h2 class="m-b-0">{{ $order_summeries->Where('order_status', 'Panding')->count() }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="card bg-primary">
            <div class="body">
                <div class="row clearfix">
                    <div class="col-8">
                        <h5 class="mb-0">Received</h5>
                        <small class="info">Orders</small>
                    </div>
                    <div class="col-4 text-right">
                        <h2 class="m-b-0">{{ $order_summeries->Where('order_status', 'Received')->count() }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="card bg-info">
            <div class="body">
                <div class="row clearfix">
                    <div class="col-8">
                        <h5 class="mb-0">On the way</h5>
                        <small class="info">Orders</small>
                    </div>
                    <div class="col-4 text-right">
                        <h2 class="m-b-0">{{ $order_summeries->Where('order_status', 'On the way')->count() }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="card bg-success">
            <div class="body">
                <div class="row clearfix">
                    <div class="col-8">
                        <h5 class="mb-0">Delivered</h5>
                        <small class="info">Orders</small>
                    </div>
                    <div class="col-4 text-right">
                        <h2 class="m-b-0">{{ $order_summeries->Where('order_status', 'Delivered')->count() }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="card">
            <div class="header">
                <h2>Recent Order</h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table m-b-0 " id="recentOrderTable">
                        <thead class="text-light">
                            <tr>
                                <th>Order No</th>
                                <th>Order By</th>
                                <th>Grand Total</th>
                                <th>Payment Method</th>
                                <th>Order Status</th>
                                <th>Order Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($order_summeries->Where('order_status', 'Panding') as $order)
                            <tr>
                                <td>
                                    <strong>#{{ $order->id }}</strong>
                                </td>
                                <td>
                                    <h6 class="mb-0">{{ $order->relationtouser->name }}</h6>
                                    <span>{{ $order->relationtouser->email }}</span>
                                </td>
                                <td>{{ $order->grand_total }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $order->payment_method }}</span>
                                    <span class="badge badge-primary">{{ $order->payment_status }}</span>
                                </td>
                                <td><span class="badge badge-success">{{ $order->order_status }}</span></td>
                                <td><strong>{{ $order->created_at }}</strong></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="50" class="text-center">
                                    <span class="text-info">Recent Order Not Found..........</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@else
@php
    $order_summeries = App\Models\Order_summery::where('warehouse_id', Auth::guard('admin')->user()->warehouse_id)->Where('order_status', 'Received')->get();
@endphp
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>Recent Order</h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table m-b-0 " id="recentOrderTable">
                        <thead class="text-light">
                            <tr>
                                <th>Order No</th>
                                <th>Order By</th>
                                <th>Grand Total</th>
                                <th>Payment Method</th>
                                <th>Order Status</th>
                                <th>Order Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($order_summeries as $order)
                            <tr>
                                <td>
                                    <strong>#{{ $order->id }}</strong>
                                </td>
                                <td>
                                    <h6 class="mb-0">{{ $order->relationtouser->name }}</h6>
                                    <span>{{ $order->relationtouser->email }}</span>
                                </td>
                                <td>{{ $order->grand_total }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $order->payment_method }}</span>
                                    <span class="badge badge-primary">{{ $order->payment_status }}</span>
                                </td>
                                <td><span class="badge badge-success">{{ $order->order_status }}</span></td>
                                <td><strong>{{ $order->created_at }}</strong></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="50" class="text-center">
                                    <span class="text-info">Recent Order Not Found..........</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('custom_script')
<script>
$(document).ready( function () {
    $('#recentOrderTable').DataTable({
        order: [[0, 'desc']],
    });
} );
</script>
@endsection
