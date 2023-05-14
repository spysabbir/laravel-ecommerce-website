@extends('admin.layouts.admin_master')

@section('title_bar')
Page Setting
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Page Setting</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action">
                    <a class="btn btn-primary btn-sm" href="{{ route('page-setting.create') }}"><i class="fa fa-plus-square fa-2x"></i></a>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#deletePageModel">
                        <i class="fa fa-recycle fa-2x"></i>
                    </button>
                </div>
                <!-- deletePageModel -->
                <div class="modal fade" id="deletePageModel" tabindex="-1" aria-labelledby="deletePageModelLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="deletePageModelLabel">Deleted Page List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Page Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($trashed_page_settings as $trashed_page)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>{{ $trashed_page->page_name }}</td>
                                                <td>
                                                    <a href="{{ route('page-setting.restore', $trashed_page->id) }}" class="btn btn-info btn-sm"><i class="fa fa-undo"></i></a>
                                                    <a href="{{ route('page-setting.forcedelete', $trashed_page->id) }}" class="btn btn-info btn-sm"><i class="fa fa-times"></i></a>
                                                </td>
                                            </tr>
                                        @empty
                                        <tr>
                                            <td class="text-center" colspan="100">Page Not Found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-info">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Page Position</th>
                            <th>Page Name</th>
                            <th>Page Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($page_settings as $page)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>Line: {{ $page->page_position }}</td>
                            <td>{{ $page->page_name }}</td>
                            <td>
                                <span class="badge bg-{{ ($page->status == 'Yes') ? 'success' : 'danger'}}">{{ $page->status }}</span>
                                <a href="{{ route('page-setting.status', $page->id) }}" class="btn btn-info btn-sm"><i class="fa fa-{{ ($page->status == 'Yes') ? 'ban' : 'check'}}"></i></a>
                            </td>
                            <td class="d-flex">
                                <a href="{{ route('page-setting.show', $page->id) }}" class="btn btn-info btn-sm mr-3" ><i class="fa fa-eye"></i></a>
                                <a href="{{ route('page-setting.edit', $page->id) }}" class="btn btn-info btn-sm mr-3" ><i class="fa fa-pencil-square-o"></i></a>
                                <form action="{{route('page-setting.destroy', $page->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="100">Page Not Found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_script')
<script>

</script>
@endsection

