@extends('admin.layouts.admin_master')

@section('title_bar')
Brand
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Brand</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createBrandModel">
                        <i class="fa fa-plus-square fa-2x"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteBrandModel">
                        <i class="fa fa-recycle fa-2x"></i>
                    </button>
                </div>
                <!-- createBrandModel -->
                <div class="modal fade" id="createBrandModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Brand</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="#" id="create_brand_form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="form-label">Brand Name</label>
                                            <input type="text" name="brand_name" class="form-control" placeholder="Brand Name">
                                            <span class="text-danger error-text brand_name_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Brand Photo</label>
                                            <input type="file" name="brand_photo" class="form-control">
                                            <span class="text-danger error-text brand_photo_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" id="create_brand_btn" class="btn btn-primary">Create Brand</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- deleteBrandModel -->
                <div class="modal fade" id="deleteBrandModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Deleted Brand List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Brand Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="all_trashed_brands">

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
                            <label class="form-label">Brand Status</label>
                            <select class="form-control filter_data" id="status">
                                <option value="">--Brand Status--</option>
                                <option value="Yes">Active</option>
                                <option value="No">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-info all_brand_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Brand Name</th>
                                <th>Brand Photo</th>
                                <th>Brand Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- editBrandModel -->
                            <div class="modal fade" id="editBrandModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Brand</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <form action="#" id="edit_brand_form" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <input type="hidden" name="brand_id" id="brand_id">
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Brand Name</label>
                                                        <input type="text" name="brand_name" id="brand_name" class="form-control">
                                                        <span class="text-danger error-text update_brand_name_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Brand Photo</label>
                                                        <input type="file" name="brand_photo" class="form-control">
                                                        <span class="text-danger error-text update_brand_photo_error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" id="edit_brand_btn" class="btn btn-primary">Edit Brand</button>
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
        fetchAllTrashedBrand();
        function fetchAllTrashedBrand(){
            $.ajax({
                url: '{{ route('fetch.trashed.brand') }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#all_trashed_brands').html(response.trashed_brands);
                }
            });
        }

        // Read Data
        table = $('.all_brand_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('brand.index') }}",
                "data":function(e){
                    e.status = $('#status').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'brand_photo', name: 'brand_photo'},
                {data: 'brand_name', name: 'brand_name'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });
        // Filter Data
        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('.all_brand_table').DataTable().ajax.reload()
        })

        // Store Data
        $("#create_brand_form").submit(function(e) {
            e.preventDefault();
            const form_data = new FormData(this);
            $("#create_brand_btn").text('Adding...');
            $.ajax({
                url: '{{ route('brand.store') }}',
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
                        $("#create_brand_btn").text('Add Brand');
                        $("#create_brand_form")[0].reset();
                        $("#createBrandModel").modal('hide');
                    }
                }
            });
        });

        // Edit Form
        $(document).on('click', '.editBrandModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('brand.edit', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#brand_name").val(response.brand_name);
                    $('#brand_photo').val(response.brand_photo)
                    $('#brand_id').val(response.id)
                }
            });
        })

        // Update Data
        $("#edit_brand_form").submit(function(e) {
            e.preventDefault();
            var id = $('#brand_id').val();
            var url = "{{ route('brand.update', ":id") }}";
            url = url.replace(':id', id)
            const form_data = new FormData(this);
            $("#edit_brand_btn").text('Updating...');
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
                        $("#edit_brand_btn").text('Updated Brand');
                        $("#edit_brand_form")[0].reset();
                        $("#editBrandModel").modal('hide');
                    }
                }
            });
        });

        // Delete Data
        $(document).on('click', '.deleteBrandBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('brand.destroy', ":id") }}";
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
                            fetchAllTrashedBrand();
                        }
                    });
                }
            })
        })

        // Restore Data
        $(document).on('click', '.brandRestoreBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('brand.restore', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    toastr.success(response.message);
                    table.ajax.reload(null, false);
                    fetchAllTrashedBrand();
                    $("#deleteBrandModel").modal('hide');
                }
            });
        })

        // Force Delete
        $(document).on('click', '.brandForceDeleteBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('brand.forcedelete', ":id") }}";
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
                        fetchAllTrashedBrand();
                        $("#deleteBrandModel").modal('hide');
                    }
                });
            }
            })
        })

        // Status Change
        $(document).on('click', '.brandStatusBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('brand.status', ":id") }}";
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

