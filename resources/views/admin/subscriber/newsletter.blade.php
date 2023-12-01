@extends('admin.layouts.admin_master')

@section('title_bar')
Newsletter
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Newsletter</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sendNewsletterModel">
                        <i class="fa fa-plus-square fa-2x"></i>
                    </button>
                </div>
                <!-- sendNewsletterModel -->
                <div class="modal fade" id="sendNewsletterModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Send Newsletter</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="#" id="send_newsletter_form" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <h5 class="text-info text-center">Please run cron job.</h5>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label class="form-label">Received By</label>
                                            <select name="received_by" class="form-control" >
                                                <option value="">--Select Type--</option>
                                                <option value="All User">All User</option>
                                                <option value="All Subscriber">All Subscriber</option>
                                            </select>
                                            <span class="text-danger error-text received_by_error"></span>
                                        </div>
                                        <div class="col-lg-12">
                                            <label class="form-label">Newsletter Subject</label>
                                            <textarea name="newsletter_subject" class="form-control" placeholder="Newsletter Subject"></textarea>
                                            <span class="text-danger error-text newsletter_subject_error"></span>
                                        </div>
                                        <div class="col-lg-12">
                                            <label class="form-label">Newsletter Body</label>
                                            <textarea name="newsletter_body" class="form-control" placeholder="Newsletter Body" rows="10"></textarea>
                                            <span class="text-danger error-text newsletter_body_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" id="send_newsletter_btn" class="btn btn-primary">Send Newsletter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-info all_newsletter_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Received By</th>
                                <th>Newsletter Subject</th>
                                <th>Send Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- View Newsletter Model -->
                            <div class="modal fade" id="viewNewsletterModel" tabindex="-1" aria-labelledby="viewNewsletterModelLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewNewsletterModelLabel">Newsletter Details</h5>
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
        table = $('.all_newsletter_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('all.newsletter') }}",
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'received_by', name: 'received_by'},
                {data: 'newsletter_subject', name: 'newsletter_subject'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });

        // Store Data
        $("#send_newsletter_form").submit(function(e) {
            e.preventDefault();
            const form_data = new FormData(this);
            $("#send_newsletter_btn").text('Sending...');
            $.ajax({
                url: '{{ route('send.newsletter') }}',
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
                        $("#send_newsletter_btn").text('Send Success');
                        $("#send_newsletter_form")[0].reset();
                        $("#sendNewsletterModel").modal('hide');
                    }
                }
            });
        });

        // View Details
        $(document).on('click', '.viewNewsletterModelBtn', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var url = "{{ route('view.newsletter', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url:  url,
                method: 'GET',
                success: function(response) {
                    $("#model_body").html(response);
                }
            });
        })

    });
</script>
@endsection

