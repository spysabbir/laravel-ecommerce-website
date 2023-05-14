@extends('admin.layouts.admin_master')

@section('title_bar')
Page Create
@endsection

@section('body_content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Page Create</h4>
                <p class="card-text">Body</p>
            </div>
            <div class="card-body">
                <form action="{{route('page-setting.store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label>Page Position</label>
                            <select name="page_position" class="form-control">
                                <option value="">--Select Position--</option>
                                <option value="1" @selected(old('page_position') == 1)>Line 1</option>
                                <option value="2" @selected(old('page_position') == 2)>Line 2</option>
                                <option value="3" @selected(old('page_position') == 3)>Line 3</option>
                                <option value="4" @selected(old('page_position') == 4)>Line 4</option>
                            </select>
                            @error('page_position')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label>Page Name</label>
                            <input type="text" class="form-control" name="page_name" placeholder="Page Name" value="{{ old('page_name') }}">
                            @error('page_name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label>Page Content</label>
                            <textarea class="form-control page_content_style" name="page_content" placeholder="Page Content">{{ old('page_content') }}</textarea>
                            @error('page_content')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-lg-6">
                            <button class="btn btn-info" type="submit">Create Page Setting</button>
                            <a href="{{url()->previous()}}"class="btn btn-info">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_script')
<script>
    $(document).ready(function() {
        $('.page_content_style').summernote();
    });
</script>
@endsection
