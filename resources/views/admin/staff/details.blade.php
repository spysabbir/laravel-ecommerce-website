<div class="card text-white">
    <div class="card-header d-flex justify-content-between text-white">
        <div>
            <img width="100" height="120" src="{{ asset('uploads/profile_photo') }}/{{ $staff_details->profile_photo }}" alt="">
        </div>
        <div>
            <p class="p-0 m-0"><strong>Name: </strong> {{ $staff_details->name }}</p>
            <p class="p-0 m-0"><strong>Email: </strong> {{ $staff_details->email }}</p>
            <p class="p-0 m-0"><strong>Phone: </strong> {{ $staff_details->phone_number }}</p>
            <p class="p-0 m-0"><strong>Gender: </strong> {{ $staff_details->gender }}</p>
            <p class="p-0 m-0"><strong>Date of Birth: </strong> {{ $staff_details->date_of_birth }}</p>
            <p class="p-0 m-0"><strong>Address: </strong> {{ $staff_details->address }}</p>
        </div>
        <div>
            <p class="p-0 m-0"><strong>Created At: </strong> <span class="badge badge-info">{{ $staff_details->created_at->format('d-M-Y h:m:s A') }}</span></p>
            <p class="p-0 m-0"><strong>Updated At: </strong> <span class="badge badge-info">{{ ($staff_details->updated_at) ? $staff_details->updated_at->format('d-M-Y h:m:s A') : 'N/A' }}</span></p>
            <p class="p-0 m-0"><strong>Status: </strong>
                @if ($staff_details->status == "Yes")
                    <span class="badge badge-success">{{ $staff_details->status }}</span>
                @else
                    <span class="badge badge-warning">{{ $staff_details->status }}</span>
                @endif
            </p>
            <p class="p-0 m-0"><strong>Role: </strong>
                <span class="badge badge-info">{{ $staff_details->role }}</span>
                <span class="badge badge-primary">{{ ($staff_details->warehouse_id) ? $staff_details->relationtowarehouse->warehouse_name : "N/A" }}</span>
            </p>
        </div>
    </div>
</div>
