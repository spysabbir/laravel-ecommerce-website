@extends('admin.layouts.admin_master')
@section('title_bar')
Team
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Team</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createTeamModel">
                        <i class="fa fa-plus-square fa-2x"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteTeamModel">
                        <i class="fa fa-recycle fa-2x"></i>
                    </button>
                </div>
                <!-- createTeamModel -->
                <div class="modal fade" id="createTeamModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Team</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="#" id="create_team_form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="form-label">Team Member Name</label>
                                            <input type="text" name="team_member_name" class="form-control" placeholder="Team Member Name">
                                            <span class="text-danger error-text team_member_name_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Team Member Designation</label>
                                            <input type="text" name="team_member_designation" class="form-control" placeholder="Team Member Designation">
                                            <span class="text-danger error-text team_member_designation_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Team Member Photo</label>
                                            <input type="file" name="team_member_photo" class="form-control">
                                            <span class="text-danger error-text team_member_photo_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Team Member Facebook Link</label>
                                            <input type="text" name="team_member_facebook_link" class="form-control" placeholder="Team Member Facebook Link">
                                            <span class="text-danger error-text team_member_facebook_link_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Team Member Twitter Link</label>
                                            <input type="text" name="team_member_twitter_link" class="form-control" placeholder="Team Member Twitter Link">
                                            <span class="text-danger error-text team_member_twitter_link_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Team Member Instagram Link</label>
                                            <input type="text" name="team_member_instagram_link" class="form-control" placeholder="Team Member Instagram Link">
                                            <span class="text-danger error-text team_member_instagram_link_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Team Member Linkedin Link</label>
                                            <input type="text" name="team_member_linkedin_link" class="form-control" placeholder="Team Member Linkedin Link">
                                            <span class="text-danger error-text team_member_linkedin_link_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" id="create_team_btn" class="btn btn-primary">Create Team</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- deleteTeamModel -->
                <div class="modal fade" id="deleteTeamModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Deleted Team List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Sl No</th>
                                            <th>team_member_name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="all_trashed_teams">

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
                            <label class="form-label">Team Status</label>
                            <select class="form-control filter_data" id="status">
                                <option value="">--Team Status--</option>
                                <option value="Yes">Active</option>
                                <option value="No">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-info all_team_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>team_member_name</th>
                                <th>team_member_designation</th>
                                <th>team_member_photo</th>
                                <th>Team Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- editTeamModel -->
                            <div class="modal fade" id="editTeamModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Team</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <form action="#" id="edit_team_form" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <input type="hidden" name="team_id" id="team_id">
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Team Member Name</label>
                                                        <input type="text" name="team_member_name" id="team_member_name" class="form-control">
                                                        <span class="text-danger error-text update_team_member_name_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Team Member Designation</label>
                                                        <input type="text" name="team_member_designation" class="form-control" id="team_member_designation">
                                                        <span class="text-danger error-text update_team_member_designation_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Team Member Photo</label>
                                                        <input type="file" name="team_member_photo" class="form-control">
                                                        <span class="text-danger error-text update_team_member_photo_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Team Member Facebook Link</label>
                                                        <input type="text" name="team_member_facebook_link" class="form-control" id="team_member_facebook_link">
                                                        <span class="text-danger error-text update_team_member_facebook_link_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Team Member Twitter Link</label>
                                                        <input type="text" name="team_member_twitter_link" class="form-control" id="team_member_twitter_link">
                                                        <span class="text-danger error-text update_team_member_twitter_link_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Team Member Instagram Link</label>
                                                        <input type="text" name="team_member_instagram_link" class="form-control" id="team_member_instagram_link">
                                                        <span class="text-danger error-text update_team_member_instagram_link_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Team Member Linkedin Link</label>
                                                        <input type="text" name="team_member_linkedin_link" class="form-control" id="team_member_linkedin_link">
                                                        <span class="text-danger error-text update_team_member_linkedin_link_error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" id="edit_team_btn" class="btn btn-primary">Edit Team</button>
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
        // Read Data
        fetchAllTrashedTeam();
        function fetchAllTrashedTeam(){
            $.ajax({
                url: '{{ route('fetch.trashed.team') }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#all_trashed_teams').html(response.trashed_teams);
                }
            });
        }

         // Read Data
         table = $('.all_team_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('team.index') }}",
                "data":function(e){
                    e.status = $('#status').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'team_member_name', name: 'team_member_name'},
                {data: 'team_member_designation', name: 'team_member_designation'},
                {data: 'team_member_photo', name: 'team_member_photo'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });

        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('.all_team_table').DataTable().ajax.reload()
        })

        // Store Data
        $("#create_team_form").submit(function(e) {
            e.preventDefault();
            const form_data = new FormData(this);
            $("#create_team_btn").text('Adding...');
            $.ajax({
                url: '{{ route('team.store') }}',
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
                        $("#create_team_btn").text('Add Team Member');
                        $("#create_team_form")[0].reset();
                        $("#createTeamModel").modal('hide');
                    }
                }
            });
        });

        // Edit Form
        $(document).on('click', '.editTeamModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('team.edit', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#team_member_name").val(response.team_member_name);
                    $("#team_member_designation").val(response.team_member_designation);
                    $("#team_member_photo").val(response.team_member_photo);
                    $("#team_member_facebook_link").val(response.team_member_facebook_link);
                    $('#team_member_twitter_link').val(response.team_member_twitter_link)
                    $('#team_member_instagram_link').val(response.team_member_instagram_link)
                    $('#team_member_linkedin_link').val(response.team_member_linkedin_link)
                    $('#team_id').val(response.id)
                }
            });
        })

        // Update Data
        $("#edit_team_form").submit(function(e) {
            e.preventDefault();
            var id = $('#team_id').val();
            var url = "{{ route('team.update', ":id") }}";
            url = url.replace(':id', id)
            const form_data = new FormData(this);
            $("#edit_team_btn").text('Updating...');
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
                        $("#edit_team_btn").text('Updated Team Member');
                        $("#edit_team_form")[0].reset();
                        $("#editTeamModel").modal('hide');
                    }
                }
            });
        });

        // Delete Data
        $(document).on('click', '.deleteTeamBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('team.destroy', ":id") }}";
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
                            fetchAllTrashedTeam()
                            table.ajax.reload(null, false);
                        }
                    });
                }
            })
        })

        // Restore Data
        $(document).on('click', '.teamRestoreBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('team.restore', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    toastr.success(response.message);
                    fetchAllTrashedTeam();
                    table.ajax.reload(null, false);
                    $("#deleteTeamModel").modal('hide');
                }
            });
        })

        // Force Delete
        $(document).on('click', '.teamForceDeleteBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('team.forcedelete', ":id") }}";
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
                        fetchAllTrashedTeam();
                        $("#deleteTeamModel").modal('hide');
                    }
                });
            }
            })
        })

        // Status Change
        $(document).on('click', '.teamStatusBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('team.status', ":id") }}";
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

