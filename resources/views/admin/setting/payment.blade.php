@extends('admin.layouts.admin_master')

@section('title_bar')
SSL Payment Setting
@endsection

@section('body_content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">SSL Payment Setting</h4>
                <p class="card-text">Body</p>
            </div>
            <div class="card-body">
                <form action="{{route('payment.setting.update', $payment_setting->id)}}" method="POST">
                    @csrf
                    <div class="m-3">
                        <label>Stor ID</label>
                        <input type="text" class="form-control" name="store_id" value="{{$payment_setting->store_id}}">
                        @error('store_id')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="m-3">
                        <label>Stor Password</label>
                        <input type="text" class="form-control" name="store_password" value="{{$payment_setting->store_password}}">
                        @error('store_password')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="m-3">
                        <button class="btn btn-info" type="submit">Update SSL Payment Setting</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_script')

@endsection
