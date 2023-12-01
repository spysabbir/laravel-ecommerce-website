@extends('admin.layouts.admin_master')

@section('title_bar')
Return Orders
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Return Orders</h4>
                    <p class="card-text">List</p>
                </div>
            </div>
            <div class="card-body">
                <div class="filter">
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-label">Return Status</label>
                            <select class="form-control filter_data" id="return_status">
                                <option value="">--Select Return Status--</option>
                                <option value="Return Request">Return Request</option>
                                <option value="Return Done">Return Done</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Order Date</label>
                            <input type="date" class="form-control filter_data" name="created_at" id="created_at">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-info orders_table" id="orders_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Order No</th>
                                <th>Order Detail Id</th>
                                <th>Return Status</th>
                                <th>Return Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- View Order Model -->
                            <div class="modal fade" id="viewReturnDetailsModel" tabindex="-1" aria-labelledby="viewReturnDetailsModelLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewReturnDetailsModelLabel">View Order Details</h5>
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
                            <div class="modal fade" id="editReturnDetailsModel" tabindex="-1" aria-labelledby="editReturnDetailsModelLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editReturnDetailsModelLabel">Edit Return Status</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="#" id="edit_return_order_form" method="POST" >
                                                @csrf
                                                <div class="row">
                                                    <input type="hidden" name="return_id" id="return_id">
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Return Status</label>
                                                        <select class="form-control return_status" name="return_status" id="return_status">
                                                            <option value="Return Request">Return Request</option>
                                                            <option value="Return Done">Return Done</option>
                                                        </select>
                                                        <span class="text-danger error-text return_status_error"></span>
                                                    </div>
                                                </div>
                                                <button type="submit" id="edit_return_order_btn" class="btn btn-primary my-3">Edit Order</button>
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
        // Read Data
        table = $('.orders_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('return.orders') }}",
                "data":function(e){
                    e.return_status = $('#return_status').val();
                    e.created_at = $('#created_at').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'order_no', name: 'order_no'},
                {data: 'order_detail_id', name: 'order_detail_id'},
                {data: 'return_status', name: 'return_status'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });

        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('.orders_table').DataTable().ajax.reload()
        })

        // View Details
        $(document).on('click', '.viewReturnModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('return.order.details', ":id") }}";
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
        $(document).on('click', '.editReturnModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('return.order.status.edit', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $(".return_status").val(response.return_status);
                    $('#return_id').val(response.id)
                }
            });
        })

        // Update Order Status
        $("#edit_return_order_form").submit(function(e) {
            e.preventDefault();
            var id = $('#return_id').val();
            var url = "{{ route('return.order.status.update', ":id") }}";
            url = url.replace(':id', id)
            const form_data = new FormData(this);
            $("#edit_return_order_btn").text('Updating...');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: url,
                method: 'POST',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend:function(){
                    $(document).find('span.error-text').text('');
                },
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.error, function(prefix, val){
                            $('span.'+prefix+'_error').text(val[0]);
                        })
                    }
                    else{
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })
                        Toast.fire({
                            icon: 'success',
                            title: 'Order Return Status Updated Successfully'
                        })
                        table.ajax.reload(null, false)
                        $("#edit_return_order_btn").text('Updated Order Status');
                        $("#editReturnDetailsModel").modal('hide');
                    }
                }
            });
        });

    });
</script>
@endsection

