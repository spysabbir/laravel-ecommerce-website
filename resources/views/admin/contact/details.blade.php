<div class="card">
    <div class="card-header d-flex justify-content-between text-white">
        <div>
            <p class="p-0 m-0"><strong>Name: </strong>{{ $message_details->full_name }}</p>
            <p class="p-0 m-0"><strong>Email: </strong>{{ $message_details->email_address }}</p>
            <p class="p-0 m-0"><strong>Phone: </strong>{{ $message_details->phone_number }}</p>
        </div>
        <div>
            <span class="mb-2">Send Date:</span>
            <p class="p-0 m-0">{{ $message_details->created_at->format('d-M-Y') }}</p>
            <p class="p-0 m-0">{{ $message_details->created_at->format('h:m:s A') }}</p>
        </div>
    </div>
    <div class="card-body">
        <div class="card text-white">
            <div class="card-header">
                Subject: {{ $message_details->subject }}
            </div>
            <div class="card-body">
                Message: {{ $message_details->message }}
            </div>
        </div>
    </div>
</div>
