<div class="card text-white">
    <div class="card-header d-flex justify-content-between text-white">
        <div>
            <img width="100" height="120" src="{{ asset('uploads/profile_photo') }}/{{ $administration_details->profile_photo }}" alt="">
        </div>
        <div>
            <p class="p-0 m-0"><strong>Name: </strong> {{ $administration_details->name }}</p>
            <p class="p-0 m-0"><strong>Email: </strong> {{ $administration_details->email }}</p>
            <p class="p-0 m-0"><strong>Phone: </strong> {{ $administration_details->phone_number }}</p>
            <p class="p-0 m-0"><strong>Gender: </strong> {{ $administration_details->gender }}</p>
            <p class="p-0 m-0"><strong>Date of Birth: </strong> {{ $administration_details->date_of_birth }}</p>
            <p class="p-0 m-0"><strong>Address: </strong> {{ $administration_details->address }}</p>
        </div>
        <div>
            <p class="p-0 m-0"><strong>Created At: </strong> <span class="badge badge-info">{{ $administration_details->created_at->format('d-M-Y h:m:s A') }}</span></p>
            <p class="p-0 m-0"><strong>Updated At: </strong> <span class="badge badge-info">{{ $administration_details->updated_at->format('d-M-Y h:m:s A') }}</span></p>
            <p class="p-0 m-0"><strong>Status: </strong>
                @if ($administration_details->status == "Yes")
                    <span class="badge badge-success">{{ $administration_details->status }}</span>
                @else
                    <span class="badge badge-warning">{{ $administration_details->status }}</span>
                @endif
            </p>
            <p class="p-0 m-0"><strong>Role: </strong>
                @if ($administration_details->role == "Super Admin")
                    <span class="badge badge-success">{{ $administration_details->role }}</span>
                @elseif ($administration_details->role == "Admin")
                    <span class="badge badge-primary">{{ $administration_details->role }}</span>
                @else
                    <span class="badge badge-info">{{ $administration_details->role }}</span>
                    <span class="badge badge-primary">{{ $administration_details->relationtowarehouse->warehouse_name }}</span>
                @endif
            </p>
        </div>
    </div>
</div>
