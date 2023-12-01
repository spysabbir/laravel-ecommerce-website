@extends('admin.layouts.admin_master')

@section('title_bar')
Feature
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Feature</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createFeatureModel">
                        <i class="fa fa-plus-square fa-2x"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteFeatureModel">
                        <i class="fa fa-recycle fa-2x"></i>
                    </button>
                </div>
                <!-- createFeatureModel -->
                <div class="modal fade" id="createFeatureModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Feature</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="#" id="create_feature_form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="form-label">Feature Title</label>
                                            <input type="text" name="feature_title" class="form-control" placeholder="Feature Title">
                                            <span class="text-danger error-text feature_title_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Feature Subtitle</label>
                                            <input type="text" name="feature_subtitle" class="form-control" placeholder="Feature Subtitle">
                                            <span class="text-danger error-text feature_subtitle_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Feature Photo</label>
                                            <input type="file" name="feature_photo" class="form-control">
                                            <span class="text-danger error-text feature_photo_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" id="create_feature_btn" class="btn btn-primary">Create Feature</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- deleteFeatureModel -->
                <div class="modal fade" id="deleteFeatureModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Deleted Feature List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Feature Title</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="all_trashed_features">

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
                            <label class="form-label">Feature Status</label>
                            <select class="form-control filter_data" id="status">
                                <option value="">--Feature Status--</option>
                                <option value="Yes">Active</option>
                                <option value="No">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-info all_feature_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Feature Title</th>
                                <th>Feature Photo</th>
                                <th>Feature Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- editFeatureModel -->
                            <div class="modal fade" id="editFeatureModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Feature</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <form action="#" id="edit_feature_form" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <input type="hidden" name="feature_id" id="feature_id">
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Feature Title</label>
                                                        <input type="text" name="feature_title" id="feature_title" class="form-control">
                                                        <span class="text-danger error-text update_feature_title_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Feature Subtitle</label>
                                                        <input type="text" name="feature_subtitle" id="feature_subtitle" class="form-control">
                                                        <span class="text-danger error-text update_feature_subtitle_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Feature Photo</label>
                                                        <input type="file" name="feature_photo" class="form-control">
                                                        <span class="text-danger error-text update_feature_photo_error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" id="edit_feature_btn" class="btn btn-primary">Edit Feature</button>
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
        fetchAllTrashedFeature();
        function fetchAllTrashedFeature(){
            $.ajax({
                url: '{{ route('fetch.trashed.feature') }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#all_trashed_features').html(response.trashed_features);
                }
            });
        }

         // Read Data
         table = $('.all_feature_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('feature.index') }}",
                "data":function(e){
                    e.status = $('#status').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'feature_photo', name: 'feature_photo'},
                {data: 'feature_title', name: 'feature_title'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });

        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('.all_feature_table').DataTable().ajax.reload()
        })

        // Store Data
        $("#create_feature_form").submit(function(e) {
            e.preventDefault();
            const form_data = new FormData(this);
            $("#create_feature_btn").text('Adding...');
            $.ajax({
                url: '{{ route('feature.store') }}',
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
                        $("#create_feature_btn").text('Add Feature');
                        $("#create_feature_form")[0].reset();
                        $("#createFeatureModel").modal('hide');
                    }
                }
            });
        });

        // Edit Form
        $(document).on('click', '.editFeatureModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('feature.edit', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#feature_title").val(response.feature_title);
                    $("#feature_subtitle").val(response.feature_subtitle);
                    $('#feature_photo').val(response.feature_photo)
                    $('#feature_id').val(response.id)
                }
            });
        })

        // Update Data
        $("#edit_feature_form").submit(function(e) {
            e.preventDefault();
            var id = $('#feature_id').val();
            var url = "{{ route('feature.update', ":id") }}";
            url = url.replace(':id', id)
            const form_data = new FormData(this);
            $("#edit_feature_btn").text('Updating...');
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
                        $("#edit_feature_btn").text('Updated Feature');
                        $("#edit_feature_form")[0].reset();
                        $("#editFeatureModel").modal('hide');
                    }
                }
            });
        });

        // Delete Data
        $(document).on('click', '.deleteFeatureBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('feature.destroy', ":id") }}";
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
                            fetchAllTrashedFeature();
                        }
                    });
                }
            })
        })

        // Restore Data
        $(document).on('click', '.featureRestoreBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('feature.restore', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    toastr.success(response.message);
                    fetchAllTrashedFeature();
                    table.ajax.reload(null, false);
                    $("#deleteFeatureModel").modal('hide');
                }
            });
        })

        // Force Delete
        $(document).on('click', '.featureForceDeleteBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('feature.forcedelete', ":id") }}";
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
                        fetchAllTrashedFeature();
                        $("#deleteFeatureModel").modal('hide');
                    }
                });
            }
            })
        })

        // Status Change
        $(document).on('click', '.featureStatusBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('feature.status', ":id") }}";
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

