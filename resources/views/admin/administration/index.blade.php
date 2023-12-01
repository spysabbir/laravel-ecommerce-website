@extends('admin.layouts.admin_master')

@section('title_bar')
Administration
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Administration</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createAdministrationModel">
                        <i class="fa fa-plus-square"></i>
                    </button>
                </div>
                <!-- createAdministrationModel -->
                <div class="modal fade" id="createAdministrationModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Administration</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="#" id="create_administration_form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-2">
                                        <label class="form-label">Role</label>
                                        <select name="role" class="form-control">
                                            <option value="">--Select Role--</option>
                                            <option value="Super Admin">Super Admin</option>
                                            <option value="Admin">Admin</option>
                                        </select>
                                        <span class="text-danger error-text role_error"></span>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Your name">
                                        <span class="text-danger error-text name_error"></span>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" placeholder="Your email">
                                        <span class="text-danger error-text email_error"></span>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Your password">
                                        <span class="text-danger error-text password_error"></span>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Your confirm password">
                                        <span class="text-danger error-text password_confirmation_error"></span>
                                    </div>
                                    <input type="hidden" name="warehouse_id" value="NULL">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" id="create_administration_btn" class="btn btn-primary">Create Administration</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="filter">
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-label">Administration Status</label>
                            <select class="form-control filter_data" id="status">
                                <option value="">--Status--</option>
                                <option value="Yes">Active</option>
                                <option value="No">Inactive</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Administration Role</label>
                            <select class="form-control filter_data" id="role">
                                <option value="">--Role--</option>
                                <option value="Super Admin">Super Admin</option>
                                <option value="Admin">Admin</option>
                                <option value="Manager">Manager</option>
                            </select>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-info all_administration_table">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Administration Photo</th>
                            <th>Administration Name</th>
                            <th>Administration Email</th>
                            <th>Administration Role</th>
                            <th>Created Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- View Administrations Model -->
                        <div class="modal fade" id="viewAdministrationModel" tabindex="-1" aria-labelledby="viewAdministrationModelLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewAdministrationModelLabel">View Administration Details</h5>
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
                        <!-- editAdministrationModel -->
                        <div class="modal fade" id="editAdministrationModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Administration</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <form action="#" id="edit_administration_form" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="row">
                                                <input type="hidden" name="administration_id" id="administration_id">
                                                <div class="col-lg-6">
                                                    <label class="form-label">Role</label>
                                                    <select name="role" class="form-control role" id="role">
                                                        <option value="">--Select Role--</option>
                                                        <option value="Super Admin">Super Admin</option>
                                                        <option value="Admin">Admin</option>
                                                        <option value="Manager">Manager</option>
                                                    </select>
                                                    <span class="text-danger error-text update_role_error"></span>
                                                </div>
                                                <div class="col-lg-6 d-none warehouse">
                                                    <label class="form-label">Warehouse Name</label>
                                                    <select name="warehouse_id" class="form-control warehouse_id" id="warehouse_id">
                                                        <option value="">--Select Warehouse--</option>
                                                        @foreach ($warehouses as $warehouse)
                                                        <option value="{{ $warehouse->id }}">{{ $warehouse->warehouse_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger" id="warehouse_id_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" id="edit_administration_btn" class="btn btn-primary">Edit Administration</button>
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
        table = $('.all_administration_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('all.administration') }}",
                "data":function(e){
                    e.status = $('#status').val();
                    e.role = $('#role').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'profile_photo', name: 'profile_photo'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'role', name: 'role'},
                {data: 'created_at', name: 'created_at'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });

        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('.all_administration_table').DataTable().ajax.reload()
        })

        // Store Data
        $("#create_administration_form").submit(function(e) {
            e.preventDefault();
            const form_data = new FormData(this);
            $("#create_administration_btn").text('Adding...');
            $.ajax({
                url: "{{ route('auth.register') }}",
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
                        toastr.success(response.message);
                        table.ajax.reload(null, false);
                        $("#create_administration_btn").text('Add Auth');
                        $("#create_administration_form")[0].reset();
                        $("#createAdministrationModel").modal('hide');
                    }
                }
            });
        });

        // View Details
        $(document).on('click', '.viewAdministrationModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('administration.details', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#model_body").html(response);
                }
            });
        })

        // Edit Form
        $(document).on('click', '.editAdministrationModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('administration.edit', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $('.role').val(response.role)
                    $('.warehouse_id').val(response.warehouse_id)
                    $('#administration_id').val(response.id)
                    if (response.role == 'Manager') {
                        $('.warehouse').removeClass('d-none')
                    }else{
                        $('.warehouse').addClass('d-none')
                    }
                }
            });
        })

        //Show warehouse
        $(document).on('change', '.role', function(e){
            e.preventDefault();
            if ($('.role').val() == 'Manager') {
                $('.warehouse').removeClass('d-none')
            }else{
                $('.warehouse').addClass('d-none')
            }
        })

        // Update Data
        $("#edit_administration_form").submit(function(e) {
            e.preventDefault();
            var id = $('#administration_id').val();
            var url = "{{ route('administration.update', ":id") }}";
            url = url.replace(':id', id)
            const form_data = new FormData(this);
            $("#edit_administration_btn").text('Updating...');
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
                    $("#warehouse_id_error").html('');
                },
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.error, function(prefix, val){
                            $('span.update_'+prefix+'_error').text(val[0]);
                        })
                    }
                    else{
                        if(response.status == 401){
                            $("#warehouse_id_error").html(response.message);
                        }else{
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                            $("#edit_administration_btn").text('Updated Administration');
                            $("#edit_administration_form")[0].reset();
                            $("#editAdministrationModel").modal('hide');
                        }
                    }
                }
            });
        });

        // Status Change
        $(document).on('click', '.administrationStatusBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('administration.status', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    toastr.info(response.message);
                    table.ajax.reload(null, false)
                }
            });
        })
    });
</script>
@endsection

