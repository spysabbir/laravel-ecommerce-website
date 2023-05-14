@extends('admin.layouts.admin_master')

@section('title_bar')
Default Setting
@endsection

@section('body_content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Default Setting</h4>
                <p class="card-text">Body</p>
            </div>
            <div class="card-body">
                <form action="{{route('default.setting.update', $default_setting->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label>Logo Photo</label>
                            <input type="file" class="form-control" name="logo_photo" id="logo_photo">
                            @error('logo_photo')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <img width="180" height="180" src="{{asset('uploads/profile_photo')}}/{{$default_setting->app_name}}" class="rounded-circle" alt="{{Auth::guard('admin')->user()->name}}" id="profilePhotoPreview">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label>Favicon</label>
                            <input type="file" class="form-control" name="favicon" id="favicon">
                            @error('favicon')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <img width="180" height="180" src="{{asset('uploads/profile_photo')}}/{{$default_setting->app_name}}" class="rounded-circle" alt="{{Auth::guard('admin')->user()->name}}" id="profilePhotoPreview">
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label>App Name</label>
                            <input type="text" class="form-control" name="app_name" value="{{$default_setting->app_name}}">
                            @error('app_name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label>App Url</label>
                            <input type="text" class="form-control" name="app_url" value="{{$default_setting->app_url}}">
                            @error('app_url')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label>Time Zone</label>
                            <select class="form-control" name="time_zone">
                                <option value="UTC" @selected($default_setting->time_zone == 'UTC')>UTC</option>
                                <option value="Asia/Dhaka" @selected($default_setting->time_zone == 'Asia/Dhaka')>Asia/Dhaka</option>
                                <option value="America/New_York" @selected($default_setting->time_zone == 'America/New_York')>America/New_York</option>
                            </select>
                            @error('time_zone')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label>Main Phone Number</label>
                            <input type="text" class="form-control" name="main_phone" value="{{$default_setting->main_phone}}">
                            @error('main_phone')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label>Support Phone Number</label>
                            <input type="text" class="form-control" name="support_phone" value="{{$default_setting->support_phone}}">
                            @error('support_phone')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label>Main Email Address</label>
                            <input type="text" class="form-control" name="main_email" value="{{$default_setting->main_email}}">
                            @error('main_email')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label>Support Email Address</label>
                            <input type="text" class="form-control" name="support_email" value="{{$default_setting->support_email}}">
                            @error('support_email')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label>Address</label>
                            <textarea name="address" class="form-control" placeholder="address">{{$default_setting->address}}</textarea>
                            @error('address')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label>Google Map Link</label>
                            <textarea name="google_map_link" class="form-control" placeholder="google_map_link">{{$default_setting->google_map_link}}</textarea>
                            @error('google_map_link')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 mb-3">
                            <label>Facebook Link</label>
                            <input type="text" class="form-control" name="facebook_link" value="{{$default_setting->facebook_link}}">
                            @error('facebook_link')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label>Twitter Link</label>
                            <input type="text" class="form-control" name="twitter_link" value="{{$default_setting->twitter_link}}">
                            @error('twitter_link')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label>Instagram Link</label>
                            <input type="text" class="form-control" name="instagram_link" value="{{$default_setting->instagram_link}}">
                            @error('instagram_link')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label>Linkedin Link</label>
                            <input type="text" class="form-control" name="linkedin_link" value="{{$default_setting->linkedin_link}}">
                            @error('linkedin_link')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label>Youtube Link</label>
                            <input type="text" class="form-control" name="youtube_link" value="{{$default_setting->youtube_link}}">
                            @error('youtube_link')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-lg-4 mb-3">
                            <button class="btn btn-info my-4" type="submit">Update Default Setting</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_script')

@endsection
