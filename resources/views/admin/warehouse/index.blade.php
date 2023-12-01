@extends('admin.layouts.admin_master')

@section('title_bar')
Warehouse
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Warehouse</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createWarehouseModel">
                        <i class="fa fa-plus-square fa-2x"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteWarehouseModel">
                        <i class="fa fa-recycle fa-2x"></i>
                    </button>
                </div>
                <!-- createWarehouseModel -->
                <div class="modal fade" id="createWarehouseModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Warehouse</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="#" id="create_warehouse_form" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="form-label">Warehouse Name</label>
                                            <input type="text" name="warehouse_name" class="form-control" placeholder="Warehouse Name">
                                            <span class="text-danger error-text warehouse_name_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Warehouse Email</label>
                                            <input type="text" name="warehouse_email" class="form-control" placeholder="Warehouse Email">
                                            <span class="text-danger error-text warehouse_email_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Warehouse Phone Number</label>
                                            <input type="text" name="warehouse_phone_number" class="form-control" placeholder="Warehouse Phone Number">
                                            <span class="text-danger error-text warehouse_phone_number_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Warehouse Address</label>
                                            <input type="text" name="warehouse_address" class="form-control" placeholder="Warehouse Address">
                                            <span class="text-danger error-text warehouse_address_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" id="create_warehouse_btn" class="btn btn-primary">Create Warehouse</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- deleteWarehouseModel -->
                <div class="modal fade" id="deleteWarehouseModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Deleted Warehouse List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Warehouse Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="all_trashed_warehouses">

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
                            <label class="form-label">Warehouse Status</label>
                            <select class="form-control filter_data" id="status">
                                <option value="">--Warehouse Status--</option>
                                <option value="Yes">Active</option>
                                <option value="No">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-info all_warehouse_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Warehouse Name</th>
                                <th>Warehouse Email</th>
                                <th>Warehouse Phone Number</th>
                                <th>Warehouse Address</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- editWarehouseModel -->
                            <div class="modal fade" id="editWarehouseModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Warehouse</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <form action="#" id="edit_warehouse_form" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <input type="hidden" name="warehouse_id" id="warehouse_id">
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Warehouse Name</label>
                                                        <input type="text" name="warehouse_name" id="warehouse_name" class="form-control" placeholder="Warehouse Name">
                                                        <span class="text-danger error-text update_warehouse_name_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Warehouse Email</label>
                                                        <input type="text" name="warehouse_email" id="warehouse_email" class="form-control" placeholder="Warehouse Email">
                                                        <span class="text-danger error-text update_warehouse_email_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Warehouse Phone Number</label>
                                                        <input type="text" name="warehouse_phone_number" id="warehouse_phone_number" class="form-control" placeholder="Warehouse Phone Number">
                                                        <span class="text-danger error-text update_warehouse_phone_number_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Warehouse Address</label>
                                                        <input type="text" name="warehouse_address" id="warehouse_address" class="form-control" placeholder="Warehouse Address">
                                                        <span class="text-danger error-text update_warehouse_address_error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" id="edit_warehouse_btn" class="btn btn-primary">Edit Warehouse</button>
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
        fetchAllTrashedWarehouse();
        function fetchAllTrashedWarehouse(){
            $.ajax({
                url: '{{ route('fetch.trashed.warehouse') }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#all_trashed_warehouses').html(response.trashed_warehouses);
                }
            });
        }

        // Read Data
        table = $('.all_warehouse_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('warehouse.index') }}",
                "data":function(e){
                    e.status = $('#status').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'warehouse_name', name: 'warehouse_name'},
                {data: 'warehouse_email', name: 'warehouse_email'},
                {data: 'warehouse_phone_number', name: 'warehouse_phone_number'},
                {data: 'warehouse_address', name: 'warehouse_address'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });
        // Filter Data
        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('.all_warehouse_table').DataTable().ajax.reload()
        })

        // Store Data
        $("#create_warehouse_form").submit(function(e) {
            e.preventDefault();
            const form_data = new FormData(this);
            $("#create_warehouse_btn").text('Adding...');
            $.ajax({
                url: '{{ route('warehouse.store') }}',
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
                        $("#create_warehouse_btn").text('Add Warehouse');
                        $("#create_warehouse_form")[0].reset();
                        $("#createWarehouseModel").modal('hide');
                    }
                }
            });
        });

        // Edit Form
        $(document).on('click', '.editWarehouseModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('warehouse.edit', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#warehouse_name").val(response.warehouse_name);
                    $("#warehouse_email").val(response.warehouse_email);
                    $("#warehouse_phone_number").val(response.warehouse_phone_number);
                    $('#warehouse_address').val(response.warehouse_address)
                    $('#warehouse_id').val(response.id)
                }
            });
        })

        // Update Data
        $("#edit_warehouse_form").submit(function(e) {
            e.preventDefault();
            var id = $('#warehouse_id').val();
            var url = "{{ route('warehouse.update', ":id") }}";
            url = url.replace(':id', id)
            const form_data = new FormData(this);
            $("#edit_warehouse_btn").text('Updating...');
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
                        $("#edit_warehouse_btn").text('Updated Warehouse');
                        $("#edit_warehouse_form")[0].reset();
                        $("#editWarehouseModel").modal('hide');
                    }
                }
            });
        });

        // Delete Data
        $(document).on('click', '.deleteWarehouseBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('warehouse.destroy', ":id") }}";
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
                            fetchAllTrashedWarehouse();
                        }
                    });
                }
            })
        })

        // Restore Data
        $(document).on('click', '.warehouseRestoreBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('warehouse.restore', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    toastr.success(response.message);
                    table.ajax.reload(null, false);
                    fetchAllTrashedWarehouse();
                    $("#deleteWarehouseModel").modal('hide');
                }
            });
        })

        // Force Delete
        $(document).on('click', '.warehouseForceDeleteBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('warehouse.forcedelete', ":id") }}";
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
                        fetchAllTrashedWarehouse();
                        $("#deleteWarehouseModel").modal('hide');
                    }
                });
            }
            })
        })

        // Status Change
        $(document).on('click', '.warehouseStatusBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('warehouse.status', ":id") }}";
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

