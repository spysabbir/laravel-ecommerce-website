@extends('admin.layouts.admin_master')

@section('title_bar')
Faq
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Faq</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createFaqModel">
                        <i class="fa fa-plus-square fa-2x"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteFaqModel">
                        <i class="fa fa-recycle fa-2x"></i>
                    </button>
                </div>
                <!-- createFaqModel -->
                <div class="modal fade" id="createFaqModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Faq</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="#" id="create_faq_form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-6 mb-3">
                                            <label>Faq Position</label>
                                            <select name="faq_position" class="form-control">
                                                <option value="">--Select Position--</option>
                                                <option value="Left">Left</option>
                                                <option value="Right">Right</option>
                                            </select>
                                            <span class="text-danger error-text faq_position_error"></span>
                                        </div>
                                        <div class="col-lg-12">
                                            <label class="form-label">Faq Question</label>
                                            <input type="text" name="faq_question" class="form-control" placeholder="Faq Question">
                                            <span class="text-danger error-text faq_question_error"></span>
                                        </div>
                                        <div class="col-lg-12">
                                            <label class="form-label">Faq Answer</label>
                                            <textarea name="faq_answer" class="form-control" placeholder="Faq Answer"></textarea>
                                            <span class="text-danger error-text faq_answer_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" id="create_faq_btn" class="btn btn-primary">Create Faq</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- deleteFaqModel -->
                <div class="modal fade" id="deleteFaqModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Deleted Faq List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Faq Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="all_trashed_faqs">

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
                            <label class="form-label">Faq Status</label>
                            <select class="form-control filter_data" id="status">
                                <option value="">--Faq Status--</option>
                                <option value="Yes">Active</option>
                                <option value="No">Inactive</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Faq Position</label>
                            <select class="form-control filter_data" id="faq_position">
                                <option value="">--Faq Position--</option>
                                <option value="Left">Left</option>
                                <option value="Right">Right</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-info all_faq_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Faq Position</th>
                                <th>Faq Question</th>
                                <th>Faq Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- editFaqModel -->
                            <div class="modal fade" id="editFaqModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Faq</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <form action="#" id="edit_faq_form" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <input type="hidden" name="faq_id" id="faq_id">
                                                    <div class="col-lg-6 mb-3">
                                                        <label>Faq Position</label>
                                                        <select name="faq_position" class="form-control faq_position" id="faq_position">
                                                            <option value="">--Select Position--</option>
                                                            <option value="Left">Left</option>
                                                            <option value="Right">Right</option>
                                                        </select>
                                                        <span class="text-danger error-text update_faq_position_error"></span>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <label class="form-label">Faq Name</label>
                                                        <input type="text" name="faq_question" id="faq_question" class="form-control">
                                                        <span class="text-danger error-text update_faq_question_error"></span>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <label class="form-label">Faq Name</label>
                                                        <textarea name="faq_answer" id="faq_answer" class="form-control"></textarea>
                                                        <span class="text-danger error-text update_faq_answer_error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" id="edit_faq_btn" class="btn btn-primary">Edit Faq</button>
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
        fetchAllTrashedFaq();
        function fetchAllTrashedFaq(){
            $.ajax({
                url: '{{ route('fetch.trashed.faq') }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#all_trashed_faqs').html(response.trashed_faqs);
                }
            });
        }

        // Read Data
        table = $('.all_faq_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('faq.index') }}",
                "data":function(e){
                    e.status = $('#status').val();
                    e.faq_position = $('#faq_position').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'faq_position', name: 'faq_position'},
                {data: 'faq_question', name: 'faq_question'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });

        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('.all_faq_table').DataTable().ajax.reload()
        })

        // Store Data
        $("#create_faq_form").submit(function(e) {
            e.preventDefault();
            const form_data = new FormData(this);
            $("#create_faq_btn").text('Adding...');
            $.ajax({
                url: '{{ route('faq.store') }}',
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
                        $("#create_faq_btn").text('Add Faq');
                        $("#create_faq_form")[0].reset();
                        $("#createFaqModel").modal('hide');
                    }
                }
            });
        });

        // Edit Form
        $(document).on('click', '.editFaqModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('faq.edit', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $(".faq_position").val(response.faq_position);
                    $("#faq_question").val(response.faq_question);
                    $('#faq_answer').html(response.faq_answer)
                    $('#faq_id').val(response.id)
                }
            });
        })

        // Update Data
        $("#edit_faq_form").submit(function(e) {
            e.preventDefault();
            var id = $('#faq_id').val();
            var url = "{{ route('faq.update', ":id") }}";
            url = url.replace(':id', id)
            const form_data = new FormData(this);
            $("#edit_faq_btn").text('Updating...');
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
                        $("#edit_faq_btn").text('Updated Faq');
                        $("#editFaqModel").modal('hide');
                    }
                }
            });
        });

        // Delete Data
        $(document).on('click', '.deleteFaqBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('faq.destroy', ":id") }}";
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
                            fetchAllTrashedFaq();
                        }
                    });
                }
            })
        })

        // Restore Data
        $(document).on('click', '.faqRestoreBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('faq.restore', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    toastr.success(response.message);
                    table.ajax.reload(null, false);
                    fetchAllTrashedFaq();
                    $("#deleteFaqModel").modal('hide');
                }
            });
        })

        // Force Delete
        $(document).on('click', '.faqForceDeleteBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('faq.forcedelete', ":id") }}";
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
                        fetchAllTrashedFaq();
                        $("#deleteFaqModel").modal('hide');
                    }
                });
            }
            })
        })

        // Status Change
        $(document).on('click', '.faqStatusBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('faq.status', ":id") }}";
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

