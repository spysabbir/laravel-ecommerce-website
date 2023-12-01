@extends('admin.layouts.admin_master')

@section('title_bar')
Category
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Category</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createCategoryModel">
                        <i class="fa fa-plus-square fa-2x"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteCategoryModel">
                        <i class="fa fa-recycle fa-2x"></i>
                    </button>
                </div>
                <!-- createCategoryModel -->
                <div class="modal fade" id="createCategoryModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="#" id="create_category_form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="form-label">Category Name</label>
                                            <input type="text" name="category_name" class="form-control" placeholder="Category Name">
                                            <span class="text-danger error-text category_name_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Category Photo</label>
                                            <input type="file" name="category_photo" class="form-control">
                                            <span class="text-danger error-text category_photo_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" id="create_category_btn" class="btn btn-primary">Create Category</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- deleteCategoryModel -->
                <div class="modal fade" id="deleteCategoryModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Deleted Category List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Category Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="all_trashed_categories">

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
                            <label class="form-label">Category Status</label>
                            <select class="form-control filter_data" id="status">
                                <option value="">--Category Status--</option>
                                <option value="Yes">Active</option>
                                <option value="No">Inactive</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Show Home Screen Status</label>
                            <select class="form-control filter_data" id="show_home_screen">
                                <option value="">--Show Home Screen Status--</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-info all_category_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Category Photo</th>
                                <th>Category Name</th>
                                <th>Show Home Screen</th>
                                <th>Category Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- editCategoryModel -->
                            <div class="modal fade" id="editCategoryModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <form action="#" id="edit_category_form" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <input type="hidden" name="category_id" id="category_id">
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Category Name</label>
                                                        <input type="text" value="" name="category_name" id="category_name" class="form-control">
                                                        <span class="text-danger error-text update_category_name_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Category Photo</label>
                                                        <input type="file" name="category_photo" class="form-control">
                                                        <span class="text-danger error-text update_category_photo_error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" id="edit_category_btn" class="btn btn-primary">Edit Category</button>
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
        fetchAllTrashedCategory();
        function fetchAllTrashedCategory(){
            $.ajax({
                url: '{{ route('fetch.trashed.category') }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#all_trashed_categories').html(response.trashed_categories);
                }
            });
        }

        // Read Data
        table = $('.all_category_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('category.index') }}",
                "data":function(e){
                    e.status = $('#status').val();
                    e.show_home_screen = $('#show_home_screen').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'category_photo', name: 'category_photo'},
                {data: 'category_name', name: 'category_name'},
                {data: 'show_home_screen', name: 'show_home_screen'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });
        // Filter Data
        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('.all_category_table').DataTable().ajax.reload()
        })

        // Store Data
        $("#create_category_form").submit(function(e) {
            e.preventDefault();
            const form_data = new FormData(this);
            $("#create_category_btn").text('Adding...');
            $.ajax({
                url: '{{ route('category.store') }}',
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
                        table.ajax.reload(null, false)
                        $("#create_category_btn").text('Add Category');
                        $("#create_category_form")[0].reset();
                        $("#createCategoryModel").modal('hide');
                    }
                }
            });
        });

        // Edit Form
        $(document).on('click', '.editCategoryModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('category.edit', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#category_name").val(response.category_name);
                    $('#category_photo').val(response.category_photo)
                    $('#category_id').val(response.id)
                }
            });
        })

        // Update Data
        $("#edit_category_form").submit(function(e) {
            e.preventDefault();
            var id = $('#category_id').val();
            var url = "{{ route('category.update', ":id") }}";
            url = url.replace(':id', id)
            const form_data = new FormData(this);
            $("#edit_category_btn").text('Updating...');
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
                        table.ajax.reload(null, false)
                        $("#edit_category_btn").text('Updated Category');
                        $("#edit_category_form")[0].reset();
                        $("#editCategoryModel").modal('hide');
                    }
                }
            });
        });

        // Delete Data
        $(document).on('click', '.deleteCategoryBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('category.destroy', ":id") }}";
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
                            fetchAllTrashedCategory();
                        }
                    });
                }
            })
        })

        // Restore Data
        $(document).on('click', '.categoryRestoreBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('category.restore', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    toastr.success(response.message);
                    table.ajax.reload(null, false)
                    fetchAllTrashedCategory();
                    $("#deleteCategoryModel").modal('hide');
                }
            });
        })

        // Force Delete
        $(document).on('click', '.categoryForceDeleteBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('category.forcedelete', ":id") }}";
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
                        fetchAllTrashedCategory();
                        $("#deleteCategoryModel").modal('hide');
                    }
                });
            }
            })
        })

        // Status Change
        $(document).on('click', '.categoryStatusBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('category.status', ":id") }}";
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

        // Show Home Screen
        $(document).on('click', '.categoryShowHomeScreenBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('category.show.home.screen', ":id") }}";
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

