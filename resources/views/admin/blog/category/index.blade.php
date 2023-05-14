@extends('admin.layouts.admin_master')

@section('title_bar')
Blog Category
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Blog Category</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createBlogCategoryModel">
                        <i class="fa fa-plus-square fa-2x"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteBlogCategoryModel">
                        <i class="fa fa-recycle fa-2x"></i>
                    </button>
                </div>
                <!-- createBlogCategoryModel -->
                <div class="modal fade" id="createBlogCategoryModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Blog Category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="#" id="create_blog_category_form" method="POST" >
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="form-label">Blog Category Name</label>
                                            <input type="text" name="blog_category_name" class="form-control" placeholder="Blog Category Name">
                                            <span class="text-danger error-text blog_category_name_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" id="create_blog_category_btn" class="btn btn-primary">Create Blog Category</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- deleteBlogCategoryModel -->
                <div class="modal fade" id="deleteBlogCategoryModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Deleted Blog Category List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Blog Category Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="all_trashed_blog_categories">

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
                <div class="table-responsive">
                    <table class="table table-bordered table-info all_blog_categories_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Blog Category Name</th>
                                <th>Blog Category Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- editBlogCategoryModel -->
                            <div class="modal fade" id="editBlogCategoryModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Blog Category</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <form action="#" id="edit_blog_category_form" method="POST" >
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <input type="hidden" name="blog_category_id" id="blog_category_id">
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Blog Category Name</label>
                                                        <input type="text" name="blog_category_name" id="blog_category_name" class="form-control">
                                                        <span class="text-danger error-text update_blog_category_name_error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" id="edit_blog_category_btn" class="btn btn-primary">Edit Blog Category</button>
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
        fetchTrashedBlogCategory();
        function fetchTrashedBlogCategory(){
            $.ajax({
                url: '{{ route('fetch.trashed.blog.category') }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#all_trashed_blog_categories').html(response.trashed_blog_categories);
                }
            });
        }

        // Read Data
        table = $('.all_blog_categories_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: "{{ route('blog_category.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'blog_category_name', name: 'blog_category_name'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });

        // Store Data
        $("#create_blog_category_form").submit(function(e) {
            e.preventDefault();
            const form_data = new FormData(this);
            $("#create_blog_category_btn").text('Adding...');
            $.ajax({
                url: '{{ route('blog_category.store') }}',
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
                        table.ajax.reload()
                        $("#create_blog_category_btn").text('Add Blog Category');
                        $("#create_blog_category_form")[0].reset();
                        $("#createBlogCategoryModel").modal('hide');
                    }
                }
            });
        });

        // Edit Form
        $(document).on('click', '.editBlogCategoryModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('blog_category.edit', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#blog_category_name").val(response.blog_category_name);
                    $('#blog_category_id').val(response.id)
                }
            });
        })

        // Update Data
        $("#edit_blog_category_form").submit(function(e) {
            e.preventDefault();
            var id = $('#blog_category_id').val();
            var url = "{{ route('blog_category.update', ":id") }}";
            url = url.replace(':id', id)
            const form_data = new FormData(this);
            $("#edit_blog_category_btn").text('Updating...');
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
                        table.ajax.reload()
                        $("#edit_blog_category_btn").text('Updated Blog Category');
                        $("#editBlogCategoryModel").modal('hide');
                    }
                }
            });
        });

        // Delete Data
        $(document).on('click', '.deleteBlogCategoryBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('blog_category.destroy', ":id") }}";
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
                            table.ajax.reload();
                            fetchTrashedBlogCategory();
                        }
                    });
                }
            })
        })

        // Restore Data
        $(document).on('click', '.blogCategoryRestoreBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('blog.category.restore', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    toastr.success(response.message);
                    table.ajax.reload();
                    fetchTrashedBlogCategory();
                    $("#deleteBlogCategoryModel").modal('hide');
                }
            });
        })

        // Force Delete
        $(document).on('click', '.blogCategoryForceDeleteBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('blog.category.forcedelete', ":id") }}";
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
                        table.ajax.reload();
                        fetchTrashedBlogCategory();
                        $("#deleteBlogCategoryModel").modal('hide');
                    }
                });
            }
            })
        })

        // Status Change
        $(document).on('click', '.blogCategoryStatusBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('blog.category.status', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    toastr.info(response.message);
                    table.ajax.reload()
                }
            });
        })
    });
</script>
@endsection

