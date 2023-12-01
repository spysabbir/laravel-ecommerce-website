@extends('admin.layouts.admin_master')

@section('title_bar')
Blog
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Blog</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createBlogModel">
                        <i class="fa fa-plus-square fa-2x"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteBlogModel">
                        <i class="fa fa-recycle fa-2x"></i>
                    </button>
                </div>
                <!-- createBlogModel -->
                <div class="modal fade" id="createBlogModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Blog</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="#" id="create_blog_form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label class="form-label">Blog Headline</label>
                                            <input type="text" name="blog_headline" class="form-control" placeholder="Blog Headline">
                                            <span class="text-danger error-text blog_headline_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Blog Category</label>
                                            <select class="form-control" name="blog_category_id">
                                                <option value="">--Select Category--</option>
                                                @foreach ($blog_categories as $blog_category)
                                                <option value="{{$blog_category->id}}">{{$blog_category->blog_category_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text blog_category_id_error"></span>
                                        </div>
                                        <div class="col-lg-12">
                                            <label class="form-label">Blog Quota</label>
                                            <textarea name="blog_quota" class="form-control" placeholder="Blog Quota"></textarea>
                                            <span class="text-danger error-text blog_quota_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Blog Thumbnail Photo</label>
                                            <input type="file" name="blog_thumbnail_photo" class="form-control">
                                            <span class="text-danger error-text blog_thumbnail_photo_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Blog Cover Photo</label>
                                            <input type="file" name="blog_cover_photo" class="form-control">
                                            <span class="text-danger error-text blog_blog_cover_photo_error"></span>
                                        </div>
                                        <div class="col-lg-12">
                                            <label class="form-label">Blog Details</label>
                                            <textarea name="blog_details" class="form-control blog_details_style" placeholder="Blog Details"></textarea>
                                            <span class="text-danger error-text blog_details_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" id="create_blog_btn" class="btn btn-primary">Create Blog</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- deleteBlogModel -->
                <div class="modal fade" id="deleteBlogModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Deleted Blog List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Blog Headline</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="all_trashed_blogs">

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
                            <label class="form-label">Blog Category Name</label>
                            <select class="form-control filter_data" id="blog_category_id" >
                                <option value="">--Select Blog Category--</option>
                                @foreach ($blog_categories as $blog_category)
                                <option value="{{$blog_category->id}}">{{$blog_category->blog_category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Blog Status</label>
                            <select class="form-control filter_data" id="status">
                                <option value="">--Blog Status--</option>
                                <option value="Yes">Active</option>
                                <option value="No">Inactive</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Post Date</label>
                            <input type="date" class="form-control filter_data" name="created_at" id="created_at">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-info all_blogs_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Blog Photo</th>
                                <th>Blog Headline</th>
                                <th>Blog Category</th>
                                <th>Blog Status</th>
                                <th>Post Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="all_blogs">

                            <!-- View Blog Details Model -->
                            <div class="modal fade" id="viewBlogDetailsModel" tabindex="-1" aria-labelledby="viewBlogDetailsModelLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewBlogDetailsModelLabel">View Blog Details</h5>
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
                            <!-- editBlogModel -->
                            <div class="modal fade" id="editBlogModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Blog</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <form action="#" id="edit_blog_form" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <input type="hidden" name="blog_id" id="blog_id">
                                                    <div class="col-lg-12">
                                                        <label class="form-label">Blog Headline</label>
                                                        <input type="text" name="blog_headline" id="blog_headline" class="form-control" placeholder="Blog Headline">
                                                        <span class="text-danger error-text update_blog_headline_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Blog Category</label>
                                                        <select class="form-control blog_category_id" name="blog_category_id" id="blog_category_id">
                                                            <option value="">--Select Category--</option>
                                                            @foreach ($blog_categories as $blog_category)
                                                            <option value="{{$blog_category->id}}">{{$blog_category->blog_category_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger error-text update_blog_category_id_error"></span>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <label class="form-label">Blog Quota</label>
                                                        <input type="text" name="blog_quota" id="blog_quota" class="form-control" placeholder="Blog Quota">
                                                        <span class="text-danger error-text update_blog_quota_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Blog Thumbnail Photo</label>
                                                        <input type="file" name="blog_thumbnail_photo" class="form-control">
                                                        <span class="text-danger error-text update_blog_thumbnail_photo_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Blog Cover Photo</label>
                                                        <input type="file" name="blog_cover_photo" class="form-control">
                                                        <span class="text-danger error-text update_blog_cover_photo_error"></span>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <label class="form-label">Blog Details</label>
                                                        <textarea name="blog_details" class="form-control" id="blog_details" placeholder="Blog Details"></textarea>
                                                        <span class="text-danger error-text update_blog_details_error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" id="edit_blog_btn" class="btn btn-primary">Edit Blog</button>
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

        // Summernote
        $('.blog_details_style').summernote();

        // Read Trashed Data
        fetchTrashedBlog();
        function fetchTrashedBlog(){
            $.ajax({
                url: '{{ route('fetch.trashed.blog') }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#all_trashed_blogs').html(response.trashed_blogs);
                }
            });
        }

        // Read Data
        table = $('.all_blogs_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('blog.index') }}",
                "data":function(e){
                    e.blog_category_id = $('#blog_category_id').val();
                    e.status = $('#status').val();
                    e.created_at = $('#created_at').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'thumbnail_photo', name: 'thumbnail_photo'},
                {data: 'blog_headline', name: 'blog_headline'},
                {data: 'blog_category_name', name: 'blog_category_name'},
                {data: 'status', name: 'status'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });
        // Filter Data
        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('.all_blogs_table').DataTable().ajax.reload()
        })

        // Store Data
        $("#create_blog_form").submit(function(e) {
            e.preventDefault();
            const form_data = new FormData(this);
            $("#create_blog_btn").text('Adding...');
            $.ajax({
                url: '{{ route('blog.store') }}',
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
                        $("#create_blog_btn").text('Add Blog');
                        $("#create_blog_form")[0].reset();
                        $("#createBlogModel").modal('hide');
                    }
                }
            });
        });

        // View Details
        $(document).on('click', '.viewBlogModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('blog.show', ":id") }}";
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
        $(document).on('click', '.editBlogModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('blog.edit', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#blog_headline").val(response.blog_headline);
                    $(".blog_category_id").val(response.blog_category_id);
                    $("#blog_quota").val(response.blog_quota);
                    $("#blog_thumbnail_photo").val(response.blog_thumbnail_photo);
                    $("#blog_cover_photo").val(response.blog_cover_photo);
                    $('#blog_details').html(response.blog_details)
                    $('#blog_id').val(response.id)
                }
            });
        })

        // Update Data
        $("#edit_blog_form").submit(function(e) {
            e.preventDefault();
            var id = $('#blog_id').val();
            var url = "{{ route('blog.update', ":id") }}";
            url = url.replace(':id', id)
            const form_data = new FormData(this);
            $("#edit_blog_btn").text('Updating...');
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
                        $("#edit_blog_btn").text('Updated Blog');
                        $("#editBlogModel").modal('hide');
                    }
                }
            });
        });

        // Delete Data
        $(document).on('click', '.deleteBlogBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('blog.destroy', ":id") }}";
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
                            fetchTrashedBlog();
                        }
                    });
                }
            })
        })

        // Restore Data
        $(document).on('click', '.blogRestoreBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('blog.restore', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    toastr.success(response.message);
                    table.ajax.reload(null, false);
                    fetchTrashedBlog();
                    $("#deleteBlogModel").modal('hide');
                }
            });
        })

        // Force Delete
        $(document).on('click', '.blogForceDeleteBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('blog.forcedelete', ":id") }}";
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
                        table.ajax.reload(null, false);
                        fetchTrashedBlog();
                        $("#deleteBlogModel").modal('hide');
                    }
                });
            }
            })
        })

        // Status Change
        $(document).on('click', '.blogStatusBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('blog.status', ":id") }}";
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
