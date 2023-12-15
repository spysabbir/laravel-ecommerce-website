@extends('admin.layouts.admin_master')

@section('title_bar')
Childcategory
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Childcategory</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createChildcategoryModel">
                        <i class="fa fa-plus-square fa-2x"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteChildcategoryModel">
                        <i class="fa fa-recycle fa-2x"></i>
                    </button>
                </div>
                <!-- createChildcategoryModel -->
                <div class="modal fade" id="createChildcategoryModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Childcategory</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="#" id="create_childcategory_form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="form-label">Category Name</label>
                                            <select class="form-control select_category" name="category_id" id="">
                                                <option value="">-- Select Category --</option>
                                                @foreach ($categories as $category)
                                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text category_id_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Subcategory Name</label>
                                            <select class="form-control all_subcategories" name="subcategory_id" id="">
                                                <option value="">-- Select Category First --</option>
                                            </select>
                                            <span class="text-danger error-text subcategory_id_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Childcategory Name</label>
                                            <input type="text" name="childcategory_name" class="form-control" placeholder="Childcategory Name">
                                            <span class="text-danger error-text childcategory_name_error"></span>
                                            <span id="childcategory_exists_error" class="text-danger"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Childcategory Photo</label>
                                            <input type="file" name="childcategory_photo" class="form-control">
                                            <span class="text-danger error-text childcategory_photo_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" id="create_childcategory_btn" class="btn btn-primary">Create Childcategory</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- deleteChildcategoryModel -->
                <div class="modal fade" id="deleteChildcategoryModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Deleted Childcategory List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Childcategory Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="all_trashed_childcategories">

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
                            <select class="form-control filter_data" id="filter_category_id">
                                <option value="">--Select Category--</option>
                                @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Subcategory Name</label>
                            <select class="form-control filter_data" id="filter_subcategory_id">
                                <option value="">--Select Subcategory--</option>
                                @foreach ($subcategories as $subcategory)
                                <option value="{{$subcategory->id}}">{{$subcategory->subcategory_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Childcategory Status</label>
                            <select class="form-control filter_data" id="filter_status">
                                <option value="">--Select Childcategory Status--</option>
                                <option value="Yes">Active</option>
                                <option value="No">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-info all_childcategories_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Childcategory Photo</th>
                                <th>Category Name</th>
                                <th>Subcategory Name</th>
                                <th>Childcategory Name</th>
                                <th>Childcategory Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- editChildcategoryModel -->
                            <div class="modal fade" id="editChildcategoryModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Childcategory</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <form action="#" id="edit_childcategory_form" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <input type="hidden" name="childcategory_id" id="childcategory_id">
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Category Name</label>
                                                        <select class="form-control select_category" name="category_id" id="category_id">
                                                            @foreach ($categories as $category)
                                                            <option value="{{$category->id}}" >{{$category->category_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger error-text update_category_id_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Subcategory Name</label>
                                                        <select class="form-control all_subcategories" name="subcategory_id" id="subcategory_id">
                                                            @foreach ($subcategories as $subcategory)
                                                            <option value="{{$subcategory->id}}" >{{$subcategory->subcategory_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger error-text update_subcategory_id_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Childcategory Name</label>
                                                        <input type="text" name="childcategory_name" id="childcategory_name" class="form-control">
                                                        <span class="text-danger error-text update_childcategory_name_error"></span>
                                                        <span id="update_childcategory_exists_error" class="text-danger"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Childcategory Photo</label>
                                                        <input type="file" name="childcategory_photo" class="form-control">
                                                        <span class="text-danger error-text update_childcategory_photo_error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" id="edit_childcategory_btn" class="btn btn-primary">Edit Childcategory</button>
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
        fetchAllTrashedChildcategory();
        function fetchAllTrashedChildcategory(){
            $.ajax({
                url: '{{ route('fetch.trashed.childcategory') }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#all_trashed_childcategories').html(response.trashed_childcategories);
                }
            });
        }

        // Read Data
        table = $('.all_childcategories_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('childcategory.index') }}",
                "data":function(e){
                    e.category_id = $('#filter_category_id').val();
                    e.subcategory_id = $('#filter_subcategory_id').val();
                    e.status = $('#filter_status').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'category_name', name: 'category_name'},
                {data: 'subcategory_name', name: 'subcategory_name'},
                {data: 'childcategory_photo', name: 'childcategory_photo'},
                {data: 'childcategory_name', name: 'childcategory_name'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });
        // Filter Data
        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('.all_childcategories_table').DataTable().ajax.reload()
        })

        // Subcategory Data
        $(document).on('change', '.select_category', function(e){
            e.preventDefault();
            var category_id = $(this).val();
            $.ajax({
                url: '{{ route('get.subcategories') }}',
                method: 'POST',
                data: {category_id:category_id},
                success: function(response) {
                    $('.all_subcategories').html(response);
                }
            });
        })

        // Store Data
        $("#create_childcategory_form").submit(function(e) {
            e.preventDefault();
            const form_data = new FormData(this);
            $("#create_childcategory_btn").text('Adding...');
            $.ajax({
                url: '{{ route('childcategory.store') }}',
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
                            $("#childcategory_exists_error").html('This childcategory already exists');
                        } else {
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                            $("#create_childcategory_btn").text('Add Childcategory');
                            $("#create_childcategory_form")[0].reset();
                            $("#createChildcategoryModel").modal('hide');
                        }
                    }
                }
            });
        });

        // Edit Form
        $(document).on('click', '.editChildcategoryModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('childcategory.edit', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#category_id").val(response.category_id);
                    $("#subcategory_id").val(response.subcategory_id);
                    $("#childcategory_name").val(response.childcategory_name);
                    $('#childcategory_photo').val(response.childcategory_photo)
                    $('#childcategory_id').val(response.id)
                }
            });
        })

        // Update Data
        $("#edit_childcategory_form").submit(function(e) {
            e.preventDefault();
            var id = $('#childcategory_id').val();
            var url = "{{ route('childcategory.update', ":id") }}";
            url = url.replace(':id', id)
            const form_data = new FormData(this);
            $("#edit_childcategory_btn").text('Updating...');
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
                            $("#update_childcategory_exists_error").html('This childcategory already exists');
                        } else {
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                            $("#edit_childcategory_btn").text('Updated Childcategory');
                            $("#edit_childcategory_form")[0].reset();
                            $("#editChildcategoryModel").modal('hide');
                        }
                    }
                }
            });
        });

        // Delete Data
        $(document).on('click', '.deleteChildcategoryBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('childcategory.destroy', ":id") }}";
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
                            fetchAllTrashedChildcategory();
                        }
                    });
                }
            })
        })

        // Restore Data
        $(document).on('click', '.childcategoryRestoreBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('childcategory.restore', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    toastr.success(response.message);
                    table.ajax.reload(null, false);
                    fetchAllTrashedChildcategory();
                    $("#deleteChildcategoryModel").modal('hide');
                }
            });
        })

        // Force Delete
        $(document).on('click', '.childcategoryForceDeleteBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('childcategory.forcedelete', ":id") }}";
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
                        fetchAllTrashedChildcategory();
                        $("#deleteChildcategoryModel").modal('hide');
                    }
                });
            }
            })
        })

        // Status Change
        $(document).on('click', '.childcategoryStatusBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('childcategory.status', ":id") }}";
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

