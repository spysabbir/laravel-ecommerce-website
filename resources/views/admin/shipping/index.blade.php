@extends('admin.layouts.admin_master')

@section('title_bar')
Shipping
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Shipping</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createShippingModel">
                        <i class="fa fa-plus-square fa-2x"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteShippingModel">
                        <i class="fa fa-recycle fa-2x"></i>
                    </button>
                </div>
                <!-- createShippingModel -->
                <div class="modal fade" id="createShippingModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Shipping</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="#" id="create_shipping_form" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="form-label">Division Name</label>
                                            <select name="division_id" class="form-control select_division">
                                                <option value="">--Select Division--</option>
                                                @foreach ($divisions as $division)
                                                <option value="{{$division->id}}">{{$division->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text division_id_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">District Name</label>
                                            <select name="district_id" class="form-control all_district">
                                                <option value="">--Select Division First--</option>
                                            </select>
                                            <span class="text-danger error-text district_id_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Shipping Charge</label>
                                            <input type="text" name="shipping_charge" class="form-control" placeholder="Shipping Charge">
                                            <span class="text-danger error-text shipping_charge_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" id="create_shipping_btn" class="btn btn-primary">Create Shipping</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- deleteShippingModel -->
                <div class="modal fade" id="deleteShippingModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Deleted Shipping List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Division Name</th>
                                            <th>District Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="all_trashed_shippings">

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
                            <label class="form-label">Division Name</label>
                            <select class="form-control filter_data" id="filter_division_id">
                                <option value="">--Division Name--</option>
                                @foreach ($divisions as $division)
                                <option value="{{ $division->id }}">{{ $division->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Shipping Status</label>
                            <select class="form-control filter_data" id="filter_status">
                                <option value="">--Shipping Status--</option>
                                <option value="Yes">Active</option>
                                <option value="No">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-info all_shipping_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Division Name</th>
                                <th>District Name</th>
                                <th>Shipping Charge</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- editShippingModel -->
                            <div class="modal fade" id="editShippingModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Shipping</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <form action="#" id="edit_shipping_form" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <input type="hidden" name="shipping_id" id="shipping_id">
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Division Name</label>
                                                        <select name="division_id" class="form-control select_division" id="division_id">
                                                            <option value="">--Select Division--</option>
                                                            @foreach ($divisions as $division)
                                                            <option value="{{$division->id}}">{{$division->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger error-text update_division_id_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">District Name</label>
                                                        <select name="district_id" class="form-control all_district" id="district_id">
                                                            <option value="">--Select Division First--</option>
                                                            @foreach ($districts as $district)
                                                            <option value="{{$district->id}}">{{$district->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger error-text update_district_id_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Shipping Charge</label>
                                                        <input type="text" name="shipping_charge" id="shipping_charge" class="form-control" placeholder="Shipping Charge">
                                                        <span class="text-danger error-text update_shipping_charge_error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" id="edit_shipping_btn" class="btn btn-primary">Edit Shipping</button>
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
        fetchAllTrashedShipping();
        function fetchAllTrashedShipping(){
            $.ajax({
                url: '{{ route('fetch.trashed.shipping') }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#all_trashed_shippings').html(response.trashed_shippings);
                }
            });
        }

        // Read Data
        table = $('.all_shipping_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('shipping.index') }}",
                "data":function(e){
                    e.division_id = $('#filter_division_id').val();
                    e.status = $('#filter_status').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'division_name', name: 'division_name'},
                {data: 'district_name', name: 'district_name'},
                {data: 'shipping_charge', name: 'shipping_charge'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });
        // Filter Data
        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('.all_shipping_table').DataTable().ajax.reload()
        })

        // Division Data
        $(document).on('change', '.select_division', function(e){
            e.preventDefault();
            var division_id = $(this).val();
            $.ajax({
                url: '{{ route('get.districts') }}',
                method: 'POST',
                data: {division_id:division_id},
                success: function(response) {
                    $('.all_district').html(response);
                }
            });
        })

        // Store Data
        $("#create_shipping_form").submit(function(e) {
            e.preventDefault();
            const form_data = new FormData(this);
            $("#create_shipping_btn").text('Adding...');
            $.ajax({
                url: '{{ route('shipping.store') }}',
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
                        if(response.status == 401){
                            toastr.error(response.error);
                        }else{
                            table.ajax.reload(null, false);
                            $("#create_shipping_btn").text('Add Shipping');
                            $("#create_shipping_form")[0].reset();
                            $("#createShippingModel").modal('hide');
                        }
                    }
                }
            });
        });

        // Edit Form
        $(document).on('click', '.editShippingModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('shipping.edit', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#division_id").val(response.division_id);
                    $("#district_id").val(response.district_id);
                    $("#shipping_charge").val(response.shipping_charge);
                    $('#shipping_id').val(response.id)
                }
            });
        })

        // Update Data
        $("#edit_shipping_form").submit(function(e) {
            e.preventDefault();
            var id = $('#shipping_id').val();
            var url = "{{ route('shipping.update', ":id") }}";
            url = url.replace(':id', id)
            const form_data = new FormData(this);
            $("#edit_shipping_btn").text('Updating...');
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
                        if(response.status == 401){
                            toastr.error(response.error);
                        }else{
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                            $("#edit_shipping_btn").text('Updated Shipping');
                            $("#edit_shipping_form")[0].reset();
                            $("#editShippingModel").modal('hide');
                        }
                    }
                }
            });
        });

        // Delete Data
        $(document).on('click', '.deleteShippingBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('shipping.destroy', ":id") }}";
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
                            fetchAllTrashedShipping();
                        }
                    });
                }
            })
        })

        // Restore Data
        $(document).on('click', '.shippingRestoreBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('shipping.restore', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    toastr.success(response.message);
                    table.ajax.reload(null, false);
                    fetchAllTrashedShipping();
                    $("#deleteShippingModel").modal('hide');
                }
            });
        })

        // Force Delete
        $(document).on('click', '.shippingForceDeleteBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('shipping.forcedelete', ":id") }}";
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
                        fetchAllTrashedShipping();
                        $("#deleteShippingModel").modal('hide');
                    }
                });
            }
            })
        })

        // Status Change
        $(document).on('click', '.shippingStatusBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('shipping.status', ":id") }}";
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

