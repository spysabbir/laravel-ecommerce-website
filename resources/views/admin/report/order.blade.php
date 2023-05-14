@extends('admin.layouts.admin_master')

@section('title_bar')
All Order
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">All Order</h4>
                    <p class="card-text">List</p>
                </div>
            </div>
            <div class="card-body">
                <div class="filter">
                    <form action="{{ route('report.all.order.export') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-lg-2">
                                <label class="form-label">Payment Method</label>
                                <select class="form-control filter_data" name="payment_method" id="payment_method">
                                    <option value="">--Select--</option>
                                    <option value="COD">COD</option>
                                    <option value="Online">Online</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label class="form-label">Payment Status</label>
                                <select class="form-control filter_data" name="payment_status" id="payment_status">
                                    <option value="">--Select--</option>
                                    <option value="Paid">Paid</option>
                                    <option value="Unpaid">Unpaid</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label class="form-label">Order Status</label>
                                <select class="form-control filter_data" name="order_status" id="order_status">
                                    <option value="">--Select--</option>
                                    <option value="Panding">Panding</option>
                                    <option value="Received">Received</option>
                                    <option value="On the way">On the way</option>
                                    <option value="Delivered">Delivered</option>
                                    <option value="Cancel">Cancel</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label class="form-label">Order Start Date</label>
                                <input type="date" class="form-control filter_data" name="created_at_start" id="created_at_start">
                            </div>
                            <div class="col-lg-2">
                                <label class="form-label">Order End Date</label>
                                <input type="date" class="form-control filter_data" name="created_at_end" id="created_at_end">
                            </div>
                            <div class="col-lg-2">
                                <button type="submit" class="btn btn-success btn-sm mt-4">Export</button>
                                <button type="button" class="btn btn-info btn-sm mt-4 print">Print</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-info orders_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Order No</th>
                                <th>User Name</th>
                                <th>Grand Total</th>
                                <th>Payment Details</th>
                                <th>Order Status</th>
                                <th>Order Date</th>
                            </tr>
                        </thead>
                        <tbody>

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
        // Read Data
        table = $('.orders_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('report.all.order') }}",
                "data":function(e){
                    e.payment_method = $('#payment_method').val();
                    e.payment_status = $('#payment_status').val();
                    e.order_status = $('#order_status').val();
                    e.created_at_start = $('#created_at_start').val();
                    e.created_at_end = $('#created_at_end').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'grand_total', name: 'grand_total'},
                {data: 'payment_details', name: 'payment_details'},
                {data: 'order_status', name: 'order_status'},
                {data: 'created_at', name: 'created_at'},
            ],
        });

        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('.orders_table').DataTable().ajax.reload()
        })

        $('.print').on('click', function(e){
            e.preventDefault();
            $.ajax({
                url: "{{ route('report.all.order.print') }}",
                method: 'GET',
                data: {
                    payment_method : $('#payment_method').val(),
                    payment_status : $('#payment_status').val(),
                    order_status : $('#order_status').val(),
                    created_at_start : $('#created_at_start').val(),
                    created_at_end : $('#created_at_end').val(),
                    },
                success: function(data) {
                    $(data).printThis({
                        debug: false,
                        importCSS: true,
                        importStyle: true,
                        removeInline: false,
                        printDelay: 500,
                        header: null,
                        footer: null,
                    })
                }
            });
        })
    });
</script>
@endsection

