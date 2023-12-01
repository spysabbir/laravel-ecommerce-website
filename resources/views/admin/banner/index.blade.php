@extends('admin.layouts.admin_master')
@section('title_bar')
Banner
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Banner</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createBannerModel">
                        <i class="fa fa-plus-square fa-2x"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteBannerModel">
                        <i class="fa fa-recycle fa-2x"></i>
                    </button>
                </div>
                <!-- createBannerModel -->
                <div class="modal fade" id="createBannerModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Banner</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="#" id="create_banner_form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="form-label">Banner Position</label>
                                            <select name="banner_position" class="form-control">
                                                <option value="">--Select Position--</option>
                                                <option value="Top">Top</option>
                                                <option value="Center">Center</option>
                                                <option value="Bottom">Bottom</option>
                                            </select>
                                            <span class="text-danger error-text banner_position_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Banner Title</label>
                                            <input type="text" name="banner_title" class="form-control" placeholder="Banner Title">
                                            <span class="text-danger error-text banner_title_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Banner Subtitle</label>
                                            <input type="text" name="banner_subtitle" class="form-control" placeholder="Banner Subtitle">
                                            <span class="text-danger error-text banner_subtitle_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Banner Link</label>
                                            <select class="form-control" name="banner_link">
                                                <option value="">-- Select Product --</option>
                                                @foreach (App\Models\Product::where('status', 'Yes')->get() as $product)
                                                <option value="{{$product->id}}">{{$product->product_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text banner_link_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Banner Photo</label>
                                            <input type="file" name="banner_photo" class="form-control">
                                            <span class="text-danger error-text banner_photo_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" id="create_banner_btn" class="btn btn-primary">Create Banner</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- deleteBannerModel -->
                <div class="modal fade" id="deleteBannerModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Deleted Banner List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Banner Title</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="all_trashed_banners">

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
                            <label class="form-label">Banner Status</label>
                            <select class="form-control filter_data" id="status">
                                <option value="">--Banner Status--</option>
                                <option value="Yes">Active</option>
                                <option value="No">Inactive</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Banner Position</label>
                            <select class="form-control filter_data" id="banner_position">
                                <option value="">--Banner Position--</option>
                                <option value="Top">Top</option>
                                <option value="Center">Center</option>
                                <option value="Bottom">Bottom</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-info all_banner_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Banner Position</th>
                                <th>Banner Title</th>
                                <th>Banner Photo</th>
                                <th>Banner Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- editBannerModel -->
                            <div class="modal fade" id="editBannerModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Banner</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <form action="#" id="edit_banner_form" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <input type="hidden" name="banner_id" id="banner_id">
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Banner Position</label>
                                                        <select name="banner_position" class="form-control banner_position" id="banner_position">
                                                            <option value="">--Select Position--</option>
                                                            <option value="Top">Top</option>
                                                            <option value="Center">Center</option>
                                                            <option value="Bottom">Bottom</option>
                                                        </select>
                                                        <span class="text-danger error-text update_banner_position_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Banner Title</label>
                                                        <input type="text" name="banner_title" id="banner_title" class="form-control">
                                                        <span class="text-danger error-text update_banner_title_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Banner Subtitle</label>
                                                        <input type="text" name="banner_subtitle" id="banner_subtitle" class="form-control">
                                                        <span class="text-danger error-text update_banner_subtitle_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Banner Link</label>
                                                        <select class="form-control" name="banner_link" id="banner_link">
                                                            <option value="">-- Select Product --</option>
                                                            @foreach (App\Models\Product::where('status', 'Yes')->get() as $product)
                                                            <option value="{{$product->id}}">{{$product->product_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger error-text update_banner_link_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Banner Photo</label>
                                                        <input type="file" name="banner_photo" class="form-control">
                                                        <span class="text-danger error-text update_banner_photo_error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" id="edit_banner_btn" class="btn btn-primary">Edit Banner</button>
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
        fetchAllTrashedBanner();
        function fetchAllTrashedBanner(){
            $.ajax({
                url: '{{ route('fetch.trashed.banner') }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#all_trashed_banners').html(response.trashed_banners);
                }
            });
        }

        // Read Data
        table = $('.all_banner_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('banner.index') }}",
                "data":function(e){
                    e.status = $('#status').val();
                    e.banner_position = $('#banner_position').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'banner_position', name: 'banner_position'},
                {data: 'banner_title', name: 'banner_title'},
                {data: 'banner_photo', name: 'banner_photo'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });

        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('.all_banner_table').DataTable().ajax.reload()
        })

        // Store Data
        $("#create_banner_form").submit(function(e) {
            e.preventDefault();
            const form_data = new FormData(this);
            $("#create_banner_btn").text('Adding...');
            $.ajax({
                url: '{{ route('banner.store') }}',
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
                        $("#create_banner_btn").text('Add Banner');
                        $("#create_banner_form")[0].reset();
                        $("#createBannerModel").modal('hide');
                    }
                }
            });
        });

        // Edit Form
        $(document).on('click', '.editBannerModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('banner.edit', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $(".banner_position").val(response.banner_position);
                    $("#banner_title").val(response.banner_title);
                    $("#banner_subtitle").val(response.banner_subtitle);
                    $("#banner_link").val(response.banner_link);
                    $('#banner_photo').val(response.banner_photo)
                    $('#banner_id').val(response.id)
                }
            });
        })

        // Update Data
        $("#edit_banner_form").submit(function(e) {
            e.preventDefault();
            var id = $('#banner_id').val();
            var url = "{{ route('banner.update', ":id") }}";
            url = url.replace(':id', id)
            const form_data = new FormData(this);
            $("#edit_banner_btn").text('Updating...');
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
                        $("#edit_banner_btn").text('Updated Banner');
                        $("#edit_banner_form")[0].reset();
                        $("#editBannerModel").modal('hide');
                    }
                }
            });
        });

        // Delete Data
        $(document).on('click', '.deleteBannerBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('banner.destroy', ":id") }}";
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
                            fetchAllTrashedBanner()
                            table.ajax.reload(null, false);
                        }
                    });
                }
            })
        })

        // Restore Data
        $(document).on('click', '.bannerRestoreBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('banner.restore', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    toastr.success(response.message);
                    fetchAllTrashedBanner();
                    table.ajax.reload(null, false);
                    $("#deleteBannerModel").modal('hide');
                }
            });
        })

        // Force Delete
        $(document).on('click', '.bannerForceDeleteBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('banner.forcedelete', ":id") }}";
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
                        fetchAllTrashedBanner();
                        $("#deleteBannerModel").modal('hide');
                    }
                });
            }
            })
        })

        // Status Change
        $(document).on('click', '.bannerStatusBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('banner.status', ":id") }}";
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

