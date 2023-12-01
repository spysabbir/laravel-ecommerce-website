@extends('admin.layouts.admin_master')

@section('title_bar')
Coupon
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Coupon</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createCouponModel">
                        <i class="fa fa-plus-square fa-2x"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteCouponModel">
                        <i class="fa fa-recycle fa-2x"></i>
                    </button>
                </div>
                <!-- createCouponModel -->
                <div class="modal fade" id="createCouponModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Coupon</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="#" id="create_coupon_form" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="form-label">Coupon Name</label>
                                            <input type="text" name="coupon_name" class="form-control" placeholder="Coupon Name">
                                            <span class="text-danger error-text coupon_name_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Coupon Type</label>
                                            <select class="form-control" name="coupon_offer_type" id="">
                                                <option value="">-- Select One --</option>
                                                <option value="flat">Flat Discount</option>
                                                <option value="percentage">Percentage Discount</option>
                                            </select>
                                            <span class="text-danger error-text coupon_offer_type_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Coupon Amount</label>
                                            <input type="number" name="coupon_offer_amount" class="form-control" placeholder="Coupon Amount">
                                            <span class="text-danger error-text coupon_offer_amount_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Minimum Order</label>
                                            <input type="number" name="coupon_minimum_order" class="form-control" placeholder="minimum_order">
                                            <span class="text-danger error-text coupon_minimum_order_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Coupon Validity Date</label>
                                            <input type="date" name="coupon_validity_date" class="form-control">
                                            <span class="text-danger error-text coupon_validity_date_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Coupon Limit</label>
                                            <input type="number" name="coupon_user_limit" class="form-control" placeholder="coupon_limit">
                                            <span class="text-danger error-text coupon_user_limit_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" id="create_coupon_btn" class="btn btn-primary">Create Coupon</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- deleteCouponModel -->
                <div class="modal fade" id="deleteCouponModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Deleted Coupon List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Coupon Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="all_trashed_coupons">

                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="filter">
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-label">Coupon Status</label>
                            <select class="form-control filter_data" id="status">
                                <option value="">--Coupon Status--</option>
                                <option value="Yes">Active</option>
                                <option value="No">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-info all_coupon_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Coupon Name</th>
                                <th>Coupon Type</th>
                                <th>Coupon Amount</th>
                                <th>Coupon Validity Date</th>
                                <th>Coupon Limit</th>
                                <th>Minimum Order</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- editCouponModel -->
                            <div class="modal fade" id="editCouponModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Coupon</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <form action="#" id="edit_coupon_form" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <input type="hidden" name="coupon_id" id="coupon_id">
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Coupon Name</label>
                                                        <input type="text" name="coupon_name" id="coupon_name" class="form-control" placeholder="Coupon Name">
                                                        <span class="text-danger error-text update_coupon_name_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Coupon Type</label>
                                                        <select class="form-control" name="coupon_offer_type" id="coupon_offer_type">
                                                            <option value="">-- Select One --</option>
                                                            <option value="flat">Flat Discount</option>
                                                            <option value="percentage">Percentage Discount</option>
                                                        </select>
                                                        <span class="text-danger error-text update_coupon_offer_type_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Coupon Amount</label>
                                                        <input type="number" name="coupon_offer_amount" id="coupon_offer_amount" class="form-control" placeholder="Coupon Amount">
                                                        <span class="text-danger error-text update_coupon_offer_amount_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Minimum Order</label>
                                                        <input type="number" name="coupon_minimum_order" id="coupon_minimum_order" class="form-control" placeholder="minimum_order">
                                                        <span class="text-danger error-text update_coupon_minimum_order_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Coupon Validity Date</label>
                                                        <input type="date" name="coupon_validity_date" id="coupon_validity_date" class="form-control">
                                                        <span class="text-danger error-text update_coupon_validity_date_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Coupon Limit</label>
                                                        <input type="number" name="coupon_user_limit" id="coupon_user_limit" class="form-control" placeholder="coupon_limit">
                                                        <span class="text-danger error-text update_coupon_user_limit_error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" id="edit_coupon_btn" class="btn btn-primary">Edit Coupon</button>
                                            </div>
                                        </form>
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
        // Read Trashed Data
        fetchAllTrashedCoupon();
        function fetchAllTrashedCoupon(){
            $.ajax({
                url: '{{ route('fetch.trashed.coupon') }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#all_trashed_coupons').html(response.trashed_coupons);
                }
            });
        }

        // Read Data
        table = $('.all_coupon_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('coupon.index') }}",
                "data":function(e){
                    e.status = $('#status').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'coupon_name', name: 'coupon_name'},
                {data: 'coupon_offer_type', name: 'coupon_offer_type'},
                {data: 'coupon_offer_amount', name: 'coupon_offer_amount'},
                {data: 'coupon_validity_date', name: 'coupon_validity_date'},
                {data: 'coupon_user_limit', name: 'coupon_user_limit'},
                {data: 'coupon_minimum_order', name: 'coupon_minimum_order'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });

        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('.all_coupon_table').DataTable().ajax.reload()
        })

        // Store Data
        $("#create_coupon_form").submit(function(e) {
            e.preventDefault();
            const form_data = new FormData(this);
            $("#create_coupon_btn").text('Adding...');
            $.ajax({
                url: '{{ route('coupon.store') }}',
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
                    }else{
                        toastr.success(response.message);
                        table.ajax.reload(null, false);
                        $("#create_coupon_btn").text('Add Coupon');
                        $("#create_coupon_form")[0].reset();
                        $("#createCouponModel").modal('hide');
                    }
                }
            });
        });

        // Edit Form
        $(document).on('click', '.editCouponModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('coupon.edit', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#coupon_name").val(response.coupon_name);
                    $('#coupon_offer_type').val(response.coupon_offer_type)
                    $('#coupon_offer_amount').val(response.coupon_offer_amount)
                    $('#coupon_minimum_order').val(response.coupon_minimum_order)
                    $('#coupon_validity_date').val(response.coupon_validity_date)
                    $('#coupon_user_limit').val(response.coupon_user_limit)
                    $('#coupon_id').val(response.id)
                }
            });
        })

        // Update Data
        $("#edit_coupon_form").submit(function(e) {
            e.preventDefault();
            var id = $('#coupon_id').val();
            var url = "{{ route('coupon.update', ":id") }}";
            url = url.replace(':id', id)
            const form_data = new FormData(this);
            $("#edit_coupon_btn").text('Updating...');
            $.ajax({
                url: url,
                method: 'POST',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.error, function(prefix, val){
                            $('span.update_'+prefix+'_error').text(val[0]);
                        })
                    }
                    else{
                        toastr.success(response.message);
                        table.ajax.reload(null, false);
                        $("#edit_coupon_btn").text('Updated Coupon');
                        $("#edit_coupon_form")[0].reset();
                        $("#editCouponModel").modal('hide');
                    }
                }
            });
        });

        // Delete Data
        $(document).on('click', '.deleteCouponBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('coupon.destroy', ":id") }}";
            url = url.replace(':id', id)
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: 'DELETE',
                        success: function(response) {
                            toastr.warning(response.message);
                            table.ajax.reload(null, false);
                            fetchAllTrashedCoupon();
                        }
                    });
                }
            })
        })

        // Restore Data
        $(document).on('click', '.couponRestoreBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('coupon.restore', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    toastr.success(response.message);
                    table.ajax.reload(null, false);
                    fetchAllTrashedCoupon();
                    $("#deleteCouponModel").modal('hide');
                }
            });
        })

        // Force Delete
        $(document).on('click', '.couponForceDeleteBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('coupon.forcedelete', ":id") }}";
            url = url.replace(':id', id)
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        toastr.error(response.message);
                        fetchAllTrashedCoupon();
                        $("#deleteCouponModel").modal('hide');
                    }
                });
            }
            })
        })

        // Status Change
        $(document).on('click', '.couponStatusBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('coupon.status', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    toastr.info(response.message);
                    table.ajax.reload(null, false);
                }
            });
        })
    });
</script>
@endsection

