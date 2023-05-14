@php
$default_setting = App\Models\Default_setting::first();
@endphp

@extends('admin.layouts.admin_master')

@section('title_bar')
Administration Register
@endsection

@section('body_content')
<div class="row clearfix justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Create an account</h4>
                    <p class="card-text">Register</p>
                </div>
                @if (session('success'))
                <div class="alert alert-info" >
                    <span>{{ session('success') }}</span>
                </div>
                @endif
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('administration.register') }}" class="form-auth-small">
                    @csrf
                    <div class="form-group">
                        <select class="custom-select @error('role') is-invalid @enderror" name="role">
                            <option value="">Select Role</option>
                            <option value="Super Admin" @selected(old('role') == 'Super Admin')>Super Admin</option>
                            <option value="Admin" @selected(old('role') == 'Admin')>Admin</option>
                            <option value="Warehouse" @selected(old('role') == 'Warehouse')>Warehouse</option>
                        </select>
                        @error('role')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}" placeholder="Your name">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" placeholder="Your email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" placeholder="Password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            name="password_confirmation" placeholder="Confirm password">
                        @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_script')
<script>
    $(document).ready(function() {

    });
</script>
@endsection


