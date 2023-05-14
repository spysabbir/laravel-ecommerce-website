<div class="card text-white">
    <div class="card-header d-flex justify-content-between text-white">
        <div>
            <img width="100" height="120" src="{{ asset('uploads/profile_photo') }}/{{ $customer_details->profile_photo }}" alt="">
        </div>
        <div>
            <p class="p-0 m-0"><strong>Name: </strong> {{ $customer_details->name }}</p>
            <p class="p-0 m-0"><strong>Email: </strong> {{ $customer_details->email }}</p>
            <p class="p-0 m-0"><strong>Phone: </strong> {{ $customer_details->phone_number }}</p>
            <p class="p-0 m-0"><strong>Gender: </strong> {{ $customer_details->gender }}</p>
            <p class="p-0 m-0"><strong>Date of Birth: </strong> {{ $customer_details->date_of_birth }}</p>
            <p class="p-0 m-0"><strong>Address: </strong> {{ $customer_details->address }}</p>
        </div>
        <div>
            <p class="p-0 m-0"><strong>Created At: </strong> <span class="badge badge-info">{{ $customer_details->created_at->format('d-M-Y h:m:s A') }}</span></p>
            <p class="p-0 m-0"><strong>Updated At: </strong> <span class="badge badge-info">{{ $customer_details->updated_at->format('d-M-Y h:m:s A') }}</span></p>
            <p class="p-0 m-0"><strong>Last Active: </strong> <span class="badge badge-info">{{ date('d-M-Y h:m:s A', strtotime($customer_details->last_active)) }}</span></p>
            <p class="p-0 m-0"><strong>Status: </strong>
                @if ($customer_details->status == "Yes")
                    <span class="badge badge-success">{{ $customer_details->status }}</span>
                @else
                    <span class="badge badge-warning">{{ $customer_details->status }}</span>
                @endif
            </p>
        </div>
    </div>
    <div class="card-body">
        @php
            $order_summery =  App\Models\Order_summery::where('user_id', $customer_details->id)->get();
        @endphp
        <p class="p-0 m-0"><strong>Total Order: </strong> {{ $order_summery->count() }}</p>
        <p class="p-0 m-0"><strong>Panding Order: </strong> {{ $order_summery->where('order_status', 'Panding')->count() }}</p>
        <p class="p-0 m-0"><strong>Received Order: </strong> {{ $order_summery->where('order_status', 'Received')->count() }}</p>
        <p class="p-0 m-0"><strong>On the way Order: </strong> {{ $order_summery->where('order_status', 'On the way')->count() }}</p>
        <p class="p-0 m-0"><strong>Delivered Order: </strong> {{ $order_summery->where('order_status', 'Delivered')->count() }}</p>
        <p class="p-0 m-0"><strong>Cancel Order: </strong> {{ $order_summery->where('order_status', 'Cancel')->count() }}</p>
    </div>
</div>
