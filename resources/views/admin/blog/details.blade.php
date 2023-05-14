<div class="card">
    <div class="card-header d-flex justify-content-between text-white">
        <div>
            <img width="120" height="100" src="{{ asset('uploads/blog_thumbnail_photo') }}/{{ $blog->blog_thumbnail_photo }}" alt="">
        </div>
        <div>
            <img width="250" height="100" src="{{ asset('uploads/blog_cover_photo') }}/{{ $blog->blog_cover_photo }}" alt="">
        </div>
        <div>
            <p class="p-0 m-0"><strong>Total View: </strong> {{ $blog->view_count }}</p>
            <p class="p-0 m-0"><strong>Status: </strong>
                @if ($blog->status == "Yes")
                    <span class="badge badge-success">{{ $blog->status }}</span>
                @else
                    <span class="badge badge-warning">{{ $blog->status }}</span>
                @endif
            </p>
            <p class="p-0 m-0"><strong>Created By: </strong>{{ App\Models\Admin::find($blog->created_by)->name }}</p>
            <p class="p-0 m-0"><strong>Created At: </strong>{{ $blog->created_at }}</p>
            <p class="p-0 m-0"><strong>Updated By: </strong>{{ App\Models\Admin::find($blog->updated_by)->name }}</p>
            <p class="p-0 m-0"><strong>Updated At: </strong>{{ $blog->updated_at }}</p>
        </div>
    </div>
    <div class="card-body text-white">
        <p class="card-title"><strong>Blog Headline: </strong> {{ $blog->blog_headline }}</p>
        <p class="card-title"><strong>Blog Category:</strong> {{ $blog->relationtoblogcategory->blog_category_name }}</p>
        <p class="card-title"><strong>Blog Quota:</strong> {{ $blog->blog_quota }}</p>
        <p class="card-title"><strong>Blog Details: </strong> {!! $blog->blog_details !!}</p>
    </div>
</div>
