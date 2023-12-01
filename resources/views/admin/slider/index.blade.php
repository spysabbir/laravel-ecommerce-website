@extends('admin.layouts.admin_master')

@section('title_bar')
Slider
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Slider</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createSliderModel">
                        <i class="fa fa-plus-square fa-2x"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteSliderModel">
                        <i class="fa fa-recycle fa-2x"></i>
                    </button>
                </div>
                <!-- createSliderModel -->
                <div class="modal fade" id="createSliderModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Slider</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="#" id="create_slider_form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="form-label">Slider Title</label>
                                            <input type="text" name="slider_title" class="form-control" placeholder="Slider Title">
                                            <span class="text-danger error-text slider_title_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Slider Subtitle</label>
                                            <input type="text" name="slider_subtitle" class="form-control" placeholder="Slider Subtitle">
                                            <span class="text-danger error-text slider_subtitle_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Slider Link</label>
                                            <select class="form-control" name="slider_link">
                                                <option value="">-- Select Flashsale --</option>
                                                @foreach (App\Models\Flashsale::where('status', 'Yes')->get() as $flashsale)
                                                <option value="{{$flashsale->flashsale_offer_slug}}">{{$flashsale->flashsale_offer_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text slider_link_error"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Slider Photo</label>
                                            <input type="file" name="slider_photo" class="form-control">
                                            <span class="text-danger error-text slider_photo_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" id="create_slider_btn" class="btn btn-primary">Create Slider</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- deleteSliderModel -->
                <div class="modal fade" id="deleteSliderModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Deleted Slider List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Slider Title</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="all_trashed_sliders">

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
                            <label class="form-label">Slider Status</label>
                            <select class="form-control filter_data" id="status">
                                <option value="">--Slider Status--</option>
                                <option value="Yes">Active</option>
                                <option value="No">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-info all_slider_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Slider Title</th>
                                <th>Slider Photo</th>
                                <th>Slider Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- editSliderModel -->
                            <div class="modal fade" id="editSliderModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Slider</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <form action="#" id="edit_slider_form" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <input type="hidden" name="slider_id" id="slider_id">
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Slider Title</label>
                                                        <input type="text" name="slider_title" id="slider_title" class="form-control">
                                                        <span class="text-danger error-text update_slider_title_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Slider Subtitle</label>
                                                        <input type="text" name="slider_subtitle" id="slider_subtitle" class="form-control">
                                                        <span class="text-danger error-text update_slider_subtitle_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Slider Link</label>
                                                        <select class="form-control" name="slider_link" id="slider_link">
                                                            <option value="">-- Select Flashsale --</option>
                                                            @foreach (App\Models\Flashsale::where('status', 'Yes')->get() as $flashsale)
                                                            <option value="{{$flashsale->flashsale_offer_slug}}">{{$flashsale->flashsale_offer_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger error-text update_slider_link_error"></span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Slider Photo</label>
                                                        <input type="file" name="slider_photo" class="form-control">
                                                        <span class="text-danger error-text update_slider_photo_error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" id="edit_slider_btn" class="btn btn-primary">Edit Slider</button>
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
        fetchAllTrashedSlider();
        function fetchAllTrashedSlider(){
            $.ajax({
                url: '{{ route('fetch.trashed.slider') }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#all_trashed_sliders').html(response.trashed_sliders);
                }
            });
        }

        // Read Data
        table = $('.all_slider_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('slider.index') }}",
                "data":function(e){
                    e.status = $('#status').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'slider_photo', name: 'slider_photo'},
                {data: 'slider_title', name: 'slider_title'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });

        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('.all_slider_table').DataTable().ajax.reload()
        })

        // Store Data
        $("#create_slider_form").submit(function(e) {
            e.preventDefault();
            const form_data = new FormData(this);
            $("#create_slider_btn").text('Adding...');
            $.ajax({
                url: '{{ route('slider.store') }}',
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
                        $("#create_slider_btn").text('Add Slider');
                        $("#create_slider_form")[0].reset();
                        $("#createSliderModel").modal('hide');
                    }
                }
            });
        });

        // Edit Form
        $(document).on('click', '.editSliderModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('slider.edit', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#slider_title").val(response.slider_title);
                    $("#slider_subtitle").val(response.slider_subtitle);
                    $("#slider_link").val(response.slider_link);
                    $('#slider_id').val(response.id)
                }
            });
        })

        // Update Data
        $("#edit_slider_form").submit(function(e) {
            e.preventDefault();
            var id = $('#slider_id').val();
            var url = "{{ route('slider.update', ":id") }}";
            url = url.replace(':id', id)
            const form_data = new FormData(this);
            $("#edit_slider_btn").text('Updating...');
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
                        $("#edit_slider_btn").text('Updated Slider');
                        $("#edit_slider_form")[0].reset();
                        $("#editSliderModel").modal('hide');
                    }
                }
            });
        });

        // Delete Data
        $(document).on('click', '.deleteSliderBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('slider.destroy', ":id") }}";
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
                            fetchAllTrashedSlider();
                        }
                    });
                }
            })
        })

        // Restore Data
        $(document).on('click', '.sliderRestoreBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('slider.restore', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    toastr.success(response.message);
                    table.ajax.reload(null, false);
                    fetchAllTrashedSlider();
                    $("#deleteSliderModel").modal('hide');
                }
            });
        })

        // Force Delete
        $(document).on('click', '.sliderForceDeleteBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('slider.forcedelete', ":id") }}";
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
                        fetchAllTrashedSlider();
                        $("#deleteSliderModel").modal('hide');
                    }
                });
            }
            })
        })

        // Status Change
        $(document).on('click', '.sliderStatusBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('slider.status', ":id") }}";
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

