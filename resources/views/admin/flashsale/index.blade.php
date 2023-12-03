@extends('admin.layouts.admin_master')

@section('title_bar')
Flashsale
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Flashsale</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createFlashsaleModel">
                        <i class="fa fa-plus-square fa-2x"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteFlashsaleModel">
                        <i class="fa fa-recycle fa-2x"></i>
                    </button>
                </div>
                <!-- createFlashsaleModel -->
                <div class="modal fade" id="createFlashsaleModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Flashsale</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="#" id="create_flashsale_form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="form-label">Flashsale Offer Name</label>
                                            <input type="text" name="flashsale_offer_name" class="form-control" placeholder="Flashsale Offer Name">
                                            <span class="text-danger error-text flashsale_offer_name_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Flashsale Offer Type</label>
                                            <select name="flashsale_offer_type" id="" class="form-control">
                                                <option value="">--Select Offer Type--</option>
                                                <option value="Flat">Flat</option>
                                                <option value="Percentage">Percentage</option>
                                            </select>
                                            <span class="text-danger error-text flashsale_offer_type_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Flashsale Offer Amount / Percentage</label>
                                            <input type="number" name="flashsale_offer_amount" class="form-control" placeholder="Flashsale Offer Amount / Percentage">
                                            <span class="text-danger error-text flashsale_offer_amount_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Flashsale Minimum Product Price</label>
                                            <input type="number" name="flashsale_minimum_product_price" class="form-control" placeholder="Flashsale Minimum Product Price">
                                            <span class="text-danger error-text flashsale_minimum_product_price_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Flashsale Offer Start Date</label>
                                            <input type="datetime-local" name="flashsale_offer_start_date" class="form-control">
                                            <span class="text-danger error-text flashsale_offer_start_date_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Flashsale Offer End Date</label>
                                            <input type="datetime-local" name="flashsale_offer_end_date" class="form-control">
                                            <span class="text-danger error-text flashsale_offer_end_date_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Flashsale Offer Photo</label>
                                            <input type="file" name="flashsale_offer_banner_photo" class="form-control">
                                            <span class="text-danger error-text flashsale_offer_banner_photo_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" id="create_flashsale_btn" class="btn btn-primary">Create Flashsale</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- deleteFlashsaleModel -->
                <div class="modal fade" id="deleteFlashsaleModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Deleted Flashsale List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Flashsale Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="all_trashed_flashsales">

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
                            <label class="form-label">Flashsale Status</label>
                            <select class="form-control filter_data" id="status">
                                <option value="">--Flashsale Status--</option>
                                <option value="Yes">Active</option>
                                <option value="No">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-info all_flashsale_table" >
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Flashsale Offer Banner Photo</th>
                                <th>Flashsale Name</th>
                                <th>Flashsale Offer Type</th>
                                <th>Flashsale Offer Amount</th>
                                <th>Flashsale Minimum Product Price</th>
                                <th>Flashsale Offer Duration</th>
                                <th>Flashsale Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- editFlashsaleModel -->
                            <div class="modal fade" id="editFlashsaleModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Flashsale</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <form action="#" id="edit_flashsale_form" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <input type="hidden" name="flashsale_id" id="flashsale_id">
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Flashsale Offer Name</label>
                                                        <input type="text" name="flashsale_offer_name" id="flashsale_offer_name" class="form-control" placeholder="Flashsale Offer Name">
                                                        <span class="text-danger error-text update_flashsale_offer_name_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Flashsale Offer Type</label>
                                                        <select name="flashsale_offer_type" class="form-control" id="flashsale_offer_type">
                                                            <option value="">--Select Offer Type--</option>
                                                            <option value="Flat">Flat</option>
                                                            <option value="Percentage">Percentage</option>
                                                        </select>
                                                        <span class="text-danger error-text update_flashsale_offer_type_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Flashsale Offer Amount</label>
                                                        <input type="number" name="flashsale_offer_amount" id="flashsale_offer_amount" class="form-control" placeholder="Flashsale Offer Amount">
                                                        <span class="text-danger error-text update_flashsale_offer_amount_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Flashsale Minimum Product Price</label>
                                                        <input type="number" name="flashsale_minimum_product_price" id="flashsale_minimum_product_price" class="form-control" placeholder="Flashsale Minimum Product Price">
                                                        <span class="text-danger error-text update_flashsale_minimum_product_price_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Flashsale Offer Start Date</label>
                                                        <input type="datetime-local" name="flashsale_offer_start_date" id="flashsale_offer_start_date" class="form-control">
                                                        <span class="text-danger error-text update_flashsale_offer_start_date_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Flashsale Offer End Date</label>
                                                        <input type="datetime-local" name="flashsale_offer_end_date" id="flashsale_offer_end_date" class="form-control">
                                                        <span class="text-danger error-text update_flashsale_offer_end_date_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Flashsale Offer Photo</label>
                                                        <input type="file" name="flashsale_offer_banner_photo" class="form-control">
                                                        <span class="text-danger error-text update_flashsale_offer_banner_photo_error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" id="edit_flashsale_btn" class="btn btn-primary">Edit Flashsale</button>
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
        fetchAllTrashedFlashsale();
        function fetchAllTrashedFlashsale(){
            $.ajax({
                url: '{{ route('fetch.trashed.flashsale') }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#all_trashed_flashsales').html(response.trashed_flashsales);
                }
            });
        }

        // Read Data
        table = $('.all_flashsale_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('flashsale.index') }}",
                "data":function(e){
                    e.status = $('#status').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'flashsale_offer_banner_photo', name: 'flashsale_offer_banner_photo'},
                {data: 'flashsale_offer_name', name: 'flashsale_offer_name'},
                {data: 'flashsale_offer_type', name: 'flashsale_offer_type'},
                {data: 'flashsale_offer_amount', name: 'flashsale_offer_amount'},
                {data: 'flashsale_minimum_product_price', name: 'flashsale_minimum_product_price'},
                {data: 'flashsale_offer_duration', name: 'flashsale_offer_duration'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });
        // Filter Data
        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('.all_flashsale_table').DataTable().ajax.reload()
        })

        // Store Data
        $("#create_flashsale_form").submit(function(e) {
            e.preventDefault();
            const form_data = new FormData(this);
            $("#create_flashsale_btn").text('Adding...');
            $.ajax({
                url: '{{ route('flashsale.store') }}',
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
                            toastr.error(response.message);
                        }else{
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                            $("#create_flashsale_btn").text('Add Flashsale');
                            $("#create_flashsale_form")[0].reset();
                            $("#createFlashsaleModel").modal('hide');
                        }
                    }
                }
            });
        });

        // Edit Form
        $(document).on('click', '.editFlashsaleModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('flashsale.edit', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#flashsale_offer_name").val(response.flashsale_offer_name);
                    $("#flashsale_offer_type").val(response.flashsale_offer_type);
                    $("#flashsale_offer_amount").val(response.flashsale_offer_amount);
                    $("#flashsale_minimum_product_price").val(response.flashsale_minimum_product_price);
                    $("#flashsale_offer_start_date").val(response.flashsale_offer_start_date);
                    $("#flashsale_offer_end_date").val(response.flashsale_offer_end_date);
                    $('#flashsale_offer_banner_photo').val(response.flashsale_offer_banner_photo)
                    $('#flashsale_id').val(response.id)
                }
            });
        })

        // Update Data
        $("#edit_flashsale_form").submit(function(e) {
            e.preventDefault();
            var id = $('#flashsale_id').val();
            var url = "{{ route('flashsale.update', ":id") }}";
            url = url.replace(':id', id)
            const form_data = new FormData(this);
            $("#edit_flashsale_btn").text('Updating...');
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
                            toastr.error(response.message);
                        }else{
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                            $("#edit_flashsale_btn").text('Updated Flashsale');
                            $("#edit_flashsale_form")[0].reset();
                            $("#editFlashsaleModel").modal('hide');
                        }
                    }
                }
            });
        });

        // Delete Data
        $(document).on('click', '.deleteFlashsaleBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('flashsale.destroy', ":id") }}";
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
                            fetchAllTrashedFlashsale();
                            table.ajax.reload(null, false);
                        }
                    });
                }
            })
        })

        // Restore Data
        $(document).on('click', '.flashsaleRestoreBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('flashsale.restore', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    toastr.success(response.message);
                    fetchAllTrashedFlashsale();
                    table.ajax.reload(null, false);
                    $("#deleteFlashsaleModel").modal('hide');
                }
            });
        })

        // Force Delete
        $(document).on('click', '.flashsaleForceDeleteBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('flashsale.forcedelete', ":id") }}";
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
                        fetchAllTrashedFlashsale();
                        $("#deleteFlashsaleModel").modal('hide');
                    }
                });
            }
            })
        })

        // Status Change
        $(document).on('click', '.flashsaleStatusBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('flashsale.status', ":id") }}";
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

