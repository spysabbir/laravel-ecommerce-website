@extends('admin.layouts.admin_master')

@section('title_bar')
Mail Setting
@endsection

@section('body_content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Mail Setting</h4>
                <p class="card-text">Body</p>
            </div>
            <div class="card-body">
                <form action="{{route('mail.setting.update', $mail_setting->id)}}" method="POST">
                    @csrf
                    <div class="m-3">
                        <label>Mailer Name</label>
                        <input type="text" class="form-control" name="mailer" value="{{$mail_setting->mailer}}">
                        @error('mailer')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="m-3">
                        <label>Host Name</label>
                        <input type="text" class="form-control" name="host" value="{{$mail_setting->host}}">
                        @error('host')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="m-3">
                        <label>Port Name</label>
                        <input type="text" class="form-control" name="port" value="{{$mail_setting->port}}">
                        @error('port')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="m-3">
                        <label>Username </label>
                        <input type="text" class="form-control" name="username" value="{{$mail_setting->username}}">
                        @error('username')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="m-3">
                        <label>password </label>
                        <input type="text" class="form-control" name="password" value="{{$mail_setting->password}}">
                        @error('password')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="m-3">
                        <label>encryption </label>
                        <input type="text" class="form-control" name="encryption" value="{{$mail_setting->encryption}}">
                        @error('encryption')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="m-3">
                        <label>from_address </label>
                        <input type="text" class="form-control" name="from_address" value="{{$mail_setting->from_address}}">
                        @error('from_address')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="m-3">
                        <button class="btn btn-info" type="submit">Update Mail Setting</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_script')

@endsection
