@extends('admin.layouts.admin_master')

@section('title_bar')
Seo Setting
@endsection

@section('body_content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Seo Setting</h4>
                <p class="card-text">Body</p>
            </div>
            <div class="card-body">
                <form action="{{route('seo.setting.update', $seo_setting->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="m-3">
                        <label>Seo Image</label>
                        <input type="file" class="form-control" name="seo_image">
                        @error('seo_image')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="m-3">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" value="{{$seo_setting->title}}">
                        @error('title')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="m-3">
                        <label>Keywords</label>
                        <input type="text" class="form-control" name="keywords" value="{{$seo_setting->keywords}}">
                        @error('keywords')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="m-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control">{{$seo_setting->description}}</textarea>
                        @error('description')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="m-3">
                        <button class="btn btn-info" type="submit">Update Seo Setting</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_script')

@endsection
