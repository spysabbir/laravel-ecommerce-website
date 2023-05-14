@extends('admin.layouts.admin_master')

@section('title_bar')
Contact Message
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Contact Message</h4>
                    <p class="card-text">List</p>
                </div>
            </div>
            <div class="card-body">
                <div class="filter">
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-label">Message Status</label>
                            <select class="form-control filter_data" id="status">
                                <option value="">--Select Message Status--</option>
                                <option value="Read">Read</option>
                                <option value="Unread">Unread</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Message Date</label>
                            <input type="date" class="form-control filter_data" name="created_at" id="created_at">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-info message_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- View Order Model -->
                            <div class="modal fade" id="viewContactMessageModel" tabindex="-1" aria-labelledby="viewContactMessageModelLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewContactMessageModelLabel">View Message Details</h5>
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
        table = $('.message_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('contact.message') }}",
                "data":function(e){
                    e.status = $('#status').val();
                    e.created_at = $('#created_at').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'full_name', name: 'full_name'},
                {data: 'email_address', name: 'email_address'},
                {data: 'status', name: 'status'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });

        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('.message_table').DataTable().ajax.reload()
        })

        // View Details
        $(document).on('click', '.viewContactMessageModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('contact.message.details', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    table.ajax.reload();
                    $("#model_body").html(response);
                }
            });
        })

        // Delete Data
        $(document).on('click', '.deleteContactMessageBtn', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('contact.message.destroy', ":id") }}";
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
                            toastr.error(response.message);
                            table.ajax.reload()
                        }
                    });
                }
            })
        })

    });
</script>
@endsection

