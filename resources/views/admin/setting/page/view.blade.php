@extends('admin.layouts.admin_master')

@section('title_bar')
Page Details
@endsection

@section('body_content')
<div class="row phpclearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Page Setting</h4>
                    <p class="card-text">{{$page_setting->page_name}}</p>
                </div>
            </div>
            <div class="card-body">
                {!! $page_setting->page_content !!}
            </div>
            <div class="card-footer">
                <a href="{{url()->previous()}}"class="btn btn-info">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
