@extends('admin.layouts.admin_master')

@section('title_bar')
Processing Orders
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Processing Orders</h4>
                    <p class="card-text">List</p>
                </div>
            </div>
            <div class="card-body">
                <div class="filter">
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-label">Payment Method</label>
                            <select class="form-control filter_data" id="payment_method">
                                <option value="">--Select Payment Method--</option>
                                <option value="COD">COD</option>
                                <option value="Online">Online</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Payment Status</label>
                            <select class="form-control filter_data" id="payment_status">
                                <option value="">--Select Payment Status--</option>
                                <option value="Paid">Paid</option>
                                <option value="Unpaid">Unpaid</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Order Status</label>
                            <select class="form-control filter_data" id="order_status">
                                <option value="">--Select Order Status--</option>
                                <option value="Panding">Panding</option>
                                <option value="Received">Received</option>
                                <option value="On the way">On the way</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Order Date</label>
                            <input type="date" class="form-control filter_data" id="created_at">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-info orders_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Order No</th>
                                <th>User Name</th>
                                <th>Shipping Address</th>
                                <th>Grand Total</th>
                                <th>Payment Details</th>
                                <th>Order Status</th>
                                <th>Order Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- View Order Model -->
                            <div class="modal fade" id="viewOrderDetailsModel" tabindex="-1" aria-labelledby="viewOrderDetailsModelLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewOrderDetailsModelLabel">View Order Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" id="model_body">

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Edit Order Model -->
                            <div class="modal fade" id="editOrderDetailsModel" tabindex="-1" aria-labelledby="editOrderDetailsModelLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editOrderDetailsModelLabel">Edit Order</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="#" id="edit_order_form" method="POST" >
                                                @csrf
                                                <div class="row">
                                                    <input type="hidden" name="order_id" id="order_id">
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Order Status</label>
                                                        <select class="form-control order_status" name="order_status" id="order_status">
                                                            <option value="Panding">Panding</option>
                                                            <option value="Received">Received</option>
                                                            <option value="On the way">On the way</option>
                                                            <option value="Delivered">Delivered</option>
                                                            <option value="Cancel">Cancel</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6 warehouse d-none">
                                                        <label class="form-label">Warehouse</label>
                                                        <select class="form-control warehouse_id" name="warehouse_id" id="warehouse_id">
                                                            <option value="">--Select--</option>
                                                            @foreach (App\Models\Warehouse::where('status', 'Yes')->get() as $warehouse)
                                                            <option value="{{ $warehouse->id }}">{{ $warehouse->warehouse_name }} ({{ $warehouse->warehouse_address }})</option>
                                                            @endforeach
                                                        </select>
                                                        <span id="warehouse_id_error" class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <button type="submit" id="edit_order_btn" class="btn btn-primary my-3">Edit Order</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Read Data
        table = $('.orders_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('processing.orders') }}",
                "data":function(e){
                    e.payment_method = $('#payment_method').val();
                    e.payment_status = $('#payment_status').val();
                    e.order_status = $('#order_status').val();
                    e.created_at = $('#created_at').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'shipping_address', name: 'shipping_address'},
                {data: 'grand_total', name: 'grand_total'},
                {data: 'payment_details', name: 'payment_details'},
                {data: 'order_status', name: 'order_status'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });

        // Filter Data
        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('.orders_table').DataTable().ajax.reload()
        })

        // View Details
        $(document).on('click', '.viewOrderModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('order.details', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#model_body").html(response);
                }
            });
        })

        // Edit Order Status
        $(document).on('click', '.editOrderModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('order.status.edit', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $(".order_status").val(response.order_status);
                    $(".warehouse_id").val(response.warehouse_id);
                    $('#order_id').val(response.id)

                    if (response.warehouse_id != null) {
                        $('.warehouse').removeClass('d-none')
                    }else{
                        $('.warehouse').addClass('d-none')
                    }
                }
            });
        })

        //Show warehouse
        $(document).on('change', '.order_status', function(e){
            e.preventDefault();
            if ($('.order_status').val() == 'Panding' || $('.order_status').val() == 'Cancel') {
                $('.warehouse').addClass('d-none')
                $('.warehouse_id').val('')
            }else{
                $('.warehouse').removeClass('d-none')
            }
        })

        // Update Order Status
        $("#edit_order_form").submit(function(e) {
            e.preventDefault();
            var id = $('#order_id').val();
            var url = "{{ route('order.status.update', ":id") }}";
            url = url.replace(':id', id)
            const form_data = new FormData(this);
            $("#editOrderModelBtn").text('Updating...');
            $.ajax({
                url: url,
                method: 'POST',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend:function(){
                    $('#warehouse_id_error').html('');
                },
                success: function(response) {
                    if (response.status == 400) {
                        $('#warehouse_id_error').html("Please Select Warehouse.");
                    }
                    else{
                        if (response.status == 401) {
                            toastr.warning(response.message);
                        } else {
                            if(response.status == 402){
                                toastr.warning(response.message);
                            }else{
                                toastr.success(response.message);
                                table.ajax.reload(null, false)
                                $("#editOrderModelBtn").text('Updated Order');
                                $("#editOrderDetailsModel").modal('hide');
                            }
                        }
                    }
                }
            });
        });

    });
</script>
@endsection

