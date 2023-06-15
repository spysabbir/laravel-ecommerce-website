<div class="col-xl-6">
    <div class="single-smblog mb-30">
        <div class="smblog-thum">
            <div class="blog-image w-img">
                <a href="{{route('blog.details', $blog->blog_slug)}}"><img width="400" height="180" src="{{asset('uploads/blog_thumbnail_photo')}}/{{$blog->blog_thumbnail_photo}}" alt=""></a>
            </div>
            <div class="blog-tag blog-tag-2">
                <a href="{{ route('category.wise.blog', $blog->relationtoblogcategory->blog_category_slug) }}">{{$blog->relationtoblogcategory->blog_category_name}}</a>
            </div>
        </div>
        <div class="smblog-content smblog-content-3">
            <h6><a href="{{route('blog.details', $blog->blog_slug)}}">{{$blog->blog_headline}}</a></h6>
            <span class="author mb-10">posted by <a href="#">{{App\Models\Admin::find($blog->created_by)->name}}</a></span>
            {!! Str::words($blog->blog_details, 30, '...') !!}
            <div class="smblog-foot pt-15">
                <div class="post-readmore">
                    <a href="{{route('blog.details', $blog->blog_slug)}}"> Read More <span class="icon"></span></a>
                </div>
                <div class="post-date">
                    <a href="#">
                        @if ($blog->updated_at)
                            {{$blog->updated_at->format('d-M-Y h:i:s A')}}
                        @else
                            {{$blog->created_at->format('d-M-Y h:i:s A')}}
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

