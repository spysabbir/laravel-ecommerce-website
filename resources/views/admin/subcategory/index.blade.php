@extends('admin.layouts.admin_master')

@section('title_bar')
Subcategory
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Subcategory</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createSubcategoryModel">
                        <i class="fa fa-plus-square fa-2x"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteSubcategoryModel">
                        <i class="fa fa-recycle fa-2x"></i>
                    </button>
                </div>
                <!-- createSubcategoryModel -->
                <div class="modal fade" id="createSubcategoryModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Subcategory</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="#" id="create_subcategory_form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="form-label">Category Name</label>
                                            <select class="form-control" name="category_id" >
                                                <option value="">-- Select Category --</option>
                                                @foreach ($categories as $category)
                                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text category_id_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Subcategory Name</label>
                                            <input type="text" name="subcategory_name" class="form-control" placeholder="Subcategory Name">
                                            <span class="text-danger error-text subcategory_name_error"></span>
                                            <span id="subcategory_exists_error" class="text-danger"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Subcategory Photo</label>
                                            <input type="file" name="subcategory_photo" class="form-control">
                                            <span class="text-danger error-text subcategory_photo_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" id="create_subcategory_btn" class="btn btn-primary">Create Subcategory</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- deleteSubcategoryModel -->
                <div class="modal fade" id="deleteSubcategoryModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Deleted Subcategory List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Subcategory Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="all_trashed_subcategories">

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
                            <label class="form-label">Category Name</label>
                            <select class="form-control filter_data" id="category_id" >
                                <option value="">--Select Category--</option>
                                @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Subcategory Status</label>
                            <select class="form-control filter_data" id="status">
                                <option value="">--Subcategory Status--</option>
                                <option value="Yes">Active</option>
                                <option value="No">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-info all_subcategory_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Category Name</th>
                                <th>Subcategory Photo</th>
                                <th>Subcategory Name</th>
                                <th>Subcategory Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- editSubcategoryModel -->
                            <div class="modal fade" id="editSubcategoryModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Subcategory</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <form action="#" id="edit_subcategory_form" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <input type="hidden" name="subcategory_id" id="subcategory_id">
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Category Name</label>
                                                        <select class="form-control category_id" name="category_id" id="category_id">
                                                            <option value=""></option>
                                                            @foreach ($categories as $category)
                                                            <option value="{{$category->id}}" >{{$category->category_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger error-text update_category_id_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Subcategory Name</label>
                                                        <input type="text" name="subcategory_name" id="subcategory_name" class="form-control">
                                                        <span class="text-danger error-text update_subcategory_name_error"></span>
                                                        <span id="update_subcategory_exists_error" class="text-danger"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Subcategory Photo</label>
                                                        <input type="file" name="subcategory_photo" class="form-control">
                                                        <span class="text-danger error-text update_subcategory_photo_error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" id="edit_subcategory_btn" class="btn btn-primary">Edit Subcategory</button>
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
        fetchAllTrashedSubcategory();
        function fetchAllTrashedSubcategory(){
            $.ajax({
                url: '{{ route('fetch.trashed.subcategory') }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#all_trashed_subcategories').html(response.trashed_subcategories);
                }
            });
        }

        // Read Data
        table = $('.all_subcategory_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('subcategory.index') }}",
                "data":function(e){
                    e.category_id = $('#category_id').val();
                    e.status = $('#status').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'category_name', name: 'category_name'},
                {data: 'subcategory_photo', name: 'subcategory_photo'},
                {data: 'subcategory_name', name: 'subcategory_name'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });
        // Filter Data
        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('.all_subcategory_table').DataTable().ajax.reload()
        })

        // Store Data
        $("#create_subcategory_form").submit(function(e) {
            e.preventDefault();
            const form_data = new FormData(this);
            $("#create_subcategory_btn").text('Adding...');
            $.ajax({
                url: '{{ route('subcategory.store') }}',
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
                        if (response.status == 401) {
                            $("#subcategory_exists_error").html('This subcategory already exists');
                        } else {
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                            $("#create_subcategory_btn").text('Add Subcategory');
                            $("#create_subcategory_form")[0].reset();
                            $("#createSubcategoryModel").modal('hide');
                        }
                    }
                }
            });
        });

        // Edit Form
        $(document).on('click', '.editSubcategoryModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('subcategory.edit', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $(".category_id").val(response.category_id);
                    $("#subcategory_name").val(response.subcategory_name);
                    $('#subcategory_photo').val(response.subcategory_photo)
                    $('#subcategory_id').val(response.id)
                }
            });
        })

        // Update Data
        $("#edit_subcategory_form").submit(function(e) {
            e.preventDefault();
            var id = $('#subcategory_id').val();
            var url = "{{ route('subcategory.update', ":id") }}";
            url = url.replace(':id', id)
            const form_data = new FormData(this);
            $("#edit_subcategory_btn").text('Updating...');
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
                        if (response.status == 401) {
                            $("#update_subcategory_exists_error").html('This subcategory already exists');
                        } else {
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                            $("#edit_subcategory_btn").text('Updated Subcategory');
                            $("#edit_subcategory_form")[0].reset();
                            $("#editSubcategoryModel").modal('hide');
                        }
                    }
                }
            });
        });

        // Delete Data
        $(document).on('click', '.deleteSubcategoryBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('subcategory.destroy', ":id") }}";
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
                            fetchAllTrashedSubcategory();
                        }
                    });
                }
            })
        })

        // Restore Data
        $(document).on('click', '.subcategoryRestoreBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('subcategory.restore', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    toastr.success(response.message);
                    fetchAllTrashedSubcategory();
                    table.ajax.reload(null, false);
                    $("#deleteSubcategoryModel").modal('hide');
                }
            });
        })

        // Force Delete
        $(document).on('click', '.subcategoryForceDeleteBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('subcategory.forcedelete', ":id") }}";
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
                        fetchAllTrashedSubcategory();
                        $("#deleteSubcategoryModel").modal('hide');
                    }
                });
            }
            })
        })

        // Status Change
        $(document).on('click', '.subcategoryStatusBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('subcategory.status', ":id") }}";
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

