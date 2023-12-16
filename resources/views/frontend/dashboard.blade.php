@extends('frontend.layouts.frontend_master')

@section('title_bar')
Dashboard
@endsection

@section('body_content')

<!-- page-banner-area-start -->
<div class="page-banner-area page-banner-height-2" data-background="{{asset('frontend')}}/img/banner.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-banner-content text-center">
                    <h4 class="breadcrumb-title">My account</h4>
                    <div class="breadcrumb-two">
                        <nav>
                            <nav class="breadcrumb-trail breadcrumbs">
                                <ul class="breadcrumb-menu">
                                    <li class="breadcrumb-trail">
                                        <a href="{{route('index')}}"><span>Home</span></a>
                                    </li>
                                    <li class="trail-item">
                                        <span>My account</span>
                                    </li>
                                </ul>
                            </nav>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- page-banner-area-end -->

<!-- account-area-start -->
<div class="account-area mt-70 mb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="text-center m-2">
                    <img width="100" height="80" src="{{ asset('uploads/profile_photo') }}/{{ auth()->user()->profile_photo }}" alt="">
                </div>
                <h3 class="text-center">{{ auth()->user()->name }}</h3>
                <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Home</button>
                    <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</button>
                    <button class="nav-link" id="v-pills-orders-tab" data-bs-toggle="pill" data-bs-target="#v-pills-orders" type="button" role="tab" aria-controls="v-pills-orders" aria-selected="false">Orders</button>
                    <button type="button" id="logout_btn" class="my-3 btn btn-danger">Logout</button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
            <div class="col-lg-9">
                @if (session('success'))
                <div class="alert alert-success" role="alert">
                    <strong>{{ session('success') }}</strong>
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    <strong>{{ session('error') }}</strong>
                </div>
                @endif
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <div class="card text-start">
                            <div class="card-header bg-info">
                                <h4 class="card-title">Dashboard</h4>
                                <p class="card-text text-white">{{ auth()->user()->name }}</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 mb-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Wishlist Item</h4>
                                            </div>
                                            <div class="card-body">
                                                {{ App\Models\Wishlist::where('user_id', auth()->user()->id)->count() }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Cart Item</h4>
                                            </div>
                                            <div class="card-body">
                                                {{ App\Models\Cart::where('user_id', auth()->user()->id)->count() }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">All Order</h4>
                                            </div>
                                            <div class="card-body">
                                                {{ $order_summeries->count() }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Order Panding</h4>
                                            </div>
                                            <div class="card-body">
                                                {{ $order_summeries->where('order_status', 'Panding')->count() }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Order Received</h4>
                                            </div>
                                            <div class="card-body">
                                                {{ $order_summeries->where('order_status', 'Received')->count() }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Order On the way</h4>
                                            </div>
                                            <div class="card-body">
                                                {{ $order_summeries->where('order_status', 'On the way')->count() }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Order Delivered</h4>
                                            </div>
                                            <div class="card-body">
                                                {{ $order_summeries->where('order_status', 'Delivered')->count() }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Order Cancel</h4>
                                            </div>
                                            <div class="card-body">
                                                {{ $order_summeries->where('order_status', 'Cancel')->count() }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Order Return</h4>
                                            </div>
                                            <div class="card-body">
                                                {{ App\Models\Order_return::where('user_id', Auth::user()->id)->count() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h4 class="card-title">Edit Profile</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('change.profile')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="m-3">
                                        <label>Profile Photo</label>
                                        <input type="file" class="form-control" name="profile_photo">
                                        @error('profile_photo')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="m-3">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control" name="name" value="{{auth()->user()->name}}">
                                        @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="m-3">
                                        <label>Email</label>
                                        <input type="text" class="form-control"  value="{{auth()->user()->email}}" disabled>
                                    </div>
                                    <div class="m-3">
                                        <label>Phone Number</label>
                                        <input type="text" class="form-control" name="phone_number" placeholder="Phone Number"
                                            value="{{auth()->user()->phone_number}}">
                                        @error('phone_number')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="m-3">
                                        <div class="country-select">
                                            <label>Gender</label>
                                            <select name="gender">
                                                <option value="">Select Gender</option>
                                                <option value="Male" {{(auth()->user()->gender == 'Male') ? 'selected' : ''}}>Male</option>
                                                <option value="Female" {{(auth()->user()->gender == 'Female') ? 'selected' : ''}}>Female
                                                </option>
                                                <option value="Other" {{(auth()->user()->gender == 'Other') ? 'selected' : ''}}>Other
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="m-3">
                                        <label>Date of Birth</label>
                                        <input type="date" class="form-control" name="date_of_birth" value="{{auth()->user()->date_of_birth}}">
                                        @error('date_of_birth')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="m-3">
                                        <div class="country-select">
                                            <label>Division</label>
                                            <select name="division_id" id="profile_division_select">
                                                <option value="">Select Division</option>
                                                @foreach ($divisions as $division)
                                                <option value="{{$division->id}}" @selected($division->id == auth()->user()->division_id)>{{$division->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('division_id')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="m-3">
                                        <div class="country-select">
                                            <label>District</label>
                                            <select name="district_id" id="profile_all_district_list">
                                                <option value="">Select District</option>
                                                @foreach ($districts as $district)
                                                <option value="{{$district->id}}" @selected($district->id == auth()->user()->district_id)>{{$district->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('district_id')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="m-3">
                                        <label>Address</label>
                                        <textarea name="address" class="form-control"
                                            placeholder="Address">{{auth()->user()->address}}</textarea>
                                    </div>
                                    <div class="m-3">
                                        <button class="btn btn-info" type="submit">Edit Profile</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Change Password</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('change.password')}}" method="POST">
                                    @csrf
                                    <div class="m-3">
                                        <label>Old Password</label>
                                        <input type="password" class="form-control" name="old_password" placeholder="Old Password">
                                        @error('password_error')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                        @error('old_password')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="m-3">
                                        <label>New Password</label>
                                        <input type="password" class="form-control" name="password" placeholder="New Password" value="">
                                        @error('password')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="m-3">
                                        <label>Confirm Password</label>
                                        <input type="password" class="form-control" name="password_confirmation"
                                            placeholder="Confirm Password" value="">
                                        @error('password_confirmation')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="m-3">
                                        <button class="btn btn-info" type="submit">Change Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-orders" role="tabpanel" aria-labelledby="v-pills-orders-tab">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">All Order</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-primary" id="orderTable">
                                        <thead>
                                            <tr>
                                                <th>Sl No</th>
                                                <th>Order No</th>
                                                <th>Grand Total</th>
                                                <th>Payment Details</th>
                                                <th>Order Status</th>
                                                <th>Order Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order_summeries as $order_summery)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>{{ $order_summery->id }}</td>
                                                <td>
                                                    <span>৳ {{ $order_summery->grand_total }}</span>
                                                </td>
                                                <td>
                                                    @if ($order_summery->payment_method == "COD")
                                                    <span class="badge bg-info">{{ $order_summery->payment_method }}</span>
                                                    @else
                                                    <span class="badge bg-primary">{{ $order_summery->payment_method }}</span>
                                                    @endif
                                                    @if ($order_summery->payment_status == "Unpaid")
                                                    <span class="badge bg-warning">{{ $order_summery->payment_status }}</span>
                                                    @else
                                                    <span class="badge bg-success">{{ $order_summery->payment_status }}</span>
                                                    @endif
                                                    @if ($order_summery->payment_method == "Online" && $order_summery->payment_status == "Unpaid")
                                                    <a class="btn btn-warning btn-sm" href="{{ url('later/pay')}}/{{ $order_summery->grand_total }}/{{ $order_summery->id }}"><i class="fa fa-credit-card"></i></a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($order_summery->order_status == "Panding")
                                                    <span class="badge bg-dark">{{ $order_summery->order_status }}</span>
                                                    @elseif ($order_summery->order_status == "Received")
                                                    <span class="badge bg-info">{{ $order_summery->order_status }}</span>
                                                    @elseif ($order_summery->order_status == "On the way")
                                                    <span class="badge bg-primary">{{ $order_summery->order_status }}</span>
                                                    @elseif ($order_summery->order_status == "Delivered")
                                                    <span class="badge bg-success">{{ $order_summery->order_status }}</span>
                                                    @else
                                                    <span class="badge bg-danger">{{ $order_summery->order_status }}</span>
                                                    @endif

                                                    @if ($order_summery->order_status == "Delivered")
                                                    <a class="btn btn-warning btn-sm" href="{{ route('order.review', Crypt::encrypt($order_summery->id))}}"><i class="fa fa-star"></i></a>
                                                    @endif

                                                    @if ($order_summery->order_status == "Delivered")
                                                    <a class="btn btn-danger btn-sm" href="{{ route('return.request', Crypt::encrypt($order_summery->id))}}"><i class="fa fa-reply"></i></a>
                                                    @endif

                                                    @if ($order_summery->order_status == "Panding" && $order_summery->payment_status == "Unpaid")
                                                    <a class="btn btn-danger btn-sm" href="{{ route('cancel.order', $order_summery->id)}}"><i class="fa fa-times"></i></a>
                                                    @endif

                                                    @php
                                                    $return_status = App\Models\Order_return::where('order_no', $order_summery->id)->first();
                                                    @endphp
                                                    <br>
                                                    @if ($return_status)
                                                    <span class="badge bg-info">{{ $return_status->return_status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $order_summery->created_at->format('d-M-Y') }}
                                                    <br>
                                                    {{ $order_summery->created_at->format('h:i:s A') }}
                                                </td>
                                                <td>
                                                    <a class="btn btn-info btn-sm" href="{{route('view.invoice', Crypt::encrypt($order_summery->id))}}"><i class="fa fa-eye"></i></a>
                                                    <a class="btn btn-success btn-sm" href="{{route('download.invoice', Crypt::encrypt($order_summery->id))}}"><i class="fa fa-download"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- account-area-end -->
@endsection

@section('custom_script')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

         // Select Division
         $('#profile_division_select').change(function(){
            var division_id = $(this).val();
            // ajax start
            $.ajax({
                type:'POST',
                url: "{{route('profile.get.district.list')}}",
                data:{division_id:division_id},
                success: function(response){
                    $('#profile_all_district_list').html(response);
                }
            })
            // ajax end
        })

        // Log out
        $(document).on('click', '#logout_btn', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You Log out!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Log out'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#logout-form').submit();
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-center',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave',  Swal.resumeTimer)
                        }
                    })
                    Toast.fire({
                        icon: 'warning',
                        title: 'Log out successfully'
                    })
                }
            })
        })

        // Order Datatable
        $('#orderTable').DataTable({
            order: [[6, 'desc']],
        });
    });
</script>
@endsection
