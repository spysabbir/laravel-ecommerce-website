@extends('admin.layouts.admin_master')

@section('title_bar')
Profile
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-lg-4 col-md-12">
        <div class="card profile-header">
            <div class="body text-center">
                <div class="profile-image mb-3">
                    <img width="180" height="180" src="{{asset('uploads/profile_photo')}}/{{Auth::guard('admin')->user()->profile_photo}}" class="rounded-circle" alt="{{Auth::guard('admin')->user()->name}}" id="profilePhotoPreview">
                </div>
                <div>
                    <h4 class="mb-0"><strong>{{Auth::guard('admin')->user()->name}}</strong></h4>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="header">
                <h2 class="pb-3">Info</h2>
                <span class="badge badge-info">Join: {{ Auth::guard('admin')->user()->created_at->format('D d-M,Y h:m:s A') }}</span>
                <br>
                <br>
                <span class="badge badge-info">Last Active: {{ date('D d-M,Y h:m:s A', strtotime(Auth::guard('admin')->user()->last_active)) }}</span>
            </div>
            <div class="body">
                <small class="text-muted">Email address: </small>
                <p>{{Auth::guard('admin')->user()->email}}</p>
                <hr>
                <small class="text-muted">Phone Number: </small>
                <p>{{Auth::guard('admin')->user()->phone_number}}</p>
                <hr>
                <small class="text-muted">Date of Birth: </small>
                <p class="m-b-0">{{Auth::guard('admin')->user()->date_of_birth}}</p>
                <hr>
                <small class="text-muted">Gender: </small>
                <p class="m-b-0">{{Auth::guard('admin')->user()->gender}}</p>
                <hr>
                <small class="text-muted">Address: </small>
                <p>{{Auth::guard('admin')->user()->address}}</p>
                <hr>
            </div>
        </div>
    </div>

    <div class="col-lg-8 col-md-12">
        <div class="card">
            <div class="header bline">
                <h2>Basic Information</h2>
            </div>
            <div class="body">
                <form action="{{route('admin.change.profile')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <input type="file" class="form-control" name="profile_photo" id="profilePhoto">
                                @error('profile_photo')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" value="{{Auth::guard('admin')->user()->name}}">
                                @error('name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control" name="phone_number" value="{{Auth::guard('admin')->user()->phone_number}}" placeholder="Enter phone number">
                                @error('phone_number')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <input type="date" class="form-control" name="date_of_birth" value="{{Auth::guard('admin')->user()->date_of_birth}}">
                                @error('date_of_birth')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <div>
                                    <label class="fancy-radio">
                                        <input name="gender" value="Male" type="radio" {{(Auth::guard('admin')->user()->gender == 'Male') ? 'checked' : ''}}>
                                        <span><i></i>Male</span>
                                    </label>
                                    <label class="fancy-radio">
                                        <input name="gender" value="Female" type="radio" {{(Auth::guard('admin')->user()->gender == 'Female') ? 'checked' : ''}}>
                                        <span><i></i>Female</span>
                                    </label>
                                    <label class="fancy-radio">
                                        <input name="gender" value="other" type="radio" {{(Auth::guard('admin')->user()->gender == 'Other') ? 'checked' : ''}}>
                                        <span><i></i>Other</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <textarea name="address" class="form-control" placeholder="Enter address">{{Auth::guard('admin')->user()->address}}</textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button> &nbsp;&nbsp;
                </form>
            </div>
        </div>

        <div class="card">
            <div class="header bline">
                <h2>Change Password</h2>
            </div>
            <div class="body">
                <form action="{{route('admin.change.password')}}" method="POST">
                    @csrf
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <input type="password" class="form-control" name="old_password" placeholder="Old Password">
                                @error('password_error')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                                @error('old_password')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="New Password">
                                @error('password')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" >
                                @error('password_confirmation')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button> &nbsp;&nbsp;
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_script')
<script>
    $(document).ready(function(){
        // Profile Photo Preview
        $('#profilePhoto').change(function(){
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#profilePhotoPreview').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(this.files[0]);
        });
    })
</script>
@endsection
