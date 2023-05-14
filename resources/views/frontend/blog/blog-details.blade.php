@extends('frontend.layouts.frontend_master')

@section('title_bar')
{{$blog->blog_headline}}
@endsection

@section('body_content')
<!-- page-banner-area-start -->
<div class="page-banner-area page-banner-height-2" data-background="{{asset('frontend')}}/img/banner.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-banner-content text-center">
                    <h4 class="breadcrumb-title">Blog Details</h4>
                    <div class="breadcrumb-two">
                        <nav>
                            <nav class="breadcrumb-trail breadcrumbs">
                                <ul class="breadcrumb-menu">
                                    <li class="breadcrumb-trail">
                                        <a href="{{route('index')}}"><span>Home</span></a>
                                    </li>
                                    <li class="breadcrumb-trail">
                                        <a href="{{route('all.blog')}}"><span>All Blog</span></a>
                                    </li>
                                    <li class="breadcrumb-trail">
                                        <a href="{{ route('category.wise.blog', $blog->relationtoblogcategory->blog_category_slug) }}"><span>{{$blog->relationtoblogcategory->blog_category_name}}</span></a>
                                    </li>
                                    <li class="trail-item">
                                        <span>{{$blog->blog_headline}}</span>
                                    </li>
                                </ul>
                            </nav>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- page-banner-area-end -->

<!-- news-detalis-area-start -->
<div class="news-detalis-area mt-120 mb-70">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-8">
                <div class="news-detalis-content mb-50">
                    <ul class="blog-meta mb-20">
                        <li><i class="fal fa-eye"></i> {{$blog->view_count}} Views</li>
                        <li><i class="fal fa-comments"></i> {{ $comments->count() }} Comments</li>
                        <li>
                            <i class="fal fa-calendar-alt"></i>
                            @if ($blog->updated_at)
                                {{$blog->updated_at->format('d-M-Y h:i:s A')}}
                            @else
                                {{$blog->created_at->format('d-M-Y h:i:s A')}}
                            @endif
                        </li>
                    </ul>
                    <h4 class="news-title news-title-2 pt-55">{{$blog->blog_headline}}</h4>
                    <div class="news-thumb mt-40">
                        <img src="{{asset('uploads/blog_cover_photo')}}/{{$blog->blog_cover_photo}}" alt="blog" class="img-fluid">
                    </div>
                    <p class="mt-25 mb-50">{!! $blog->blog_details !!}</p>
                    <div class="news-quote-area mt-55 text-center">
                        <i class="fas fa-quote-left"></i><br>
                        <strong>{{$blog->blog_quota}}</strong>
                    </div>
                    {{-- <div class="blog-inner mt-10">
                        <img class="w-100" src="{{asset('uploads/blog_thumbnail_photo')}}/{{$blog->blog_thumbnail_photo}}" alt="" class="img-fluid">

                    </div> --}}
                    <div class="news-info d-sm-flex align-items-center justify-content-between mt-50 mb-50">
                        <div class="news-tag">
                            <h6 class="tag-title mb-25">Category</h6>
                            <a href="{{ route('category.wise.blog', $blog->relationtoblogcategory->blog_category_slug) }}"> {{$blog->relationtoblogcategory->blog_category_name}}</a>
                        </div>
                        <div class="news-share">
                            <h6 class="tag-title mb-25">Social Share</h6>
                            <a target="_blank" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a target="_blank" href="#"><i class="fab fa-twitter"></i></a>
                            <a target="_blank" href="#"><i class="fab fa-typo3"></i></a>
                            <a target="_blank" href="#"><i class="fab fa-tumblr"></i></a>
                            <a target="_blank" href="#"><i class="fal fa-share-alt"></i></a>
                        </div>
                    </div>
                    <div class="news-author mt-60">
                        <img src="{{asset('uploads/profile_photo')}}/{{App\Models\Admin::find($blog->created_by)->profile_photo}}" alt="" class="img-fluid">
                        <div class="news-author-info">
                            <span>Written by</span>
                            <h6 class="author-title">{{App\Models\Admin::find($blog->created_by)->name}}</h6>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation is enougn for today. quis nostrud exercitation is enougn for.</p>
                        </div>
                    </div>
                    <div class="post-comments mt-60">
                        <h6 class="post-comment-title mb-40">{{ $comments->count() }} Comments</h6>
                        <div class="latest-comments">
                            <ul>
                                @foreach ($comments as $comment)
                                <li>
                                    <div class="comments-box">
                                        <div class="comments-avatar">
                                            <img src="{{asset('frontend')}}/img/b-author-1.jpg" alt="">
                                        </div>
                                        <div class="comments-text">
                                            <div class="avatar">
                                                <h6 class="avatar-name">{{ $comment->name }}</h6>
                                                {{-- <a href="#" class="comment-reply"><i class="fal fa-share"></i>Reply</a> --}}
                                            </div>
                                            <span class="post-meta"><i class="fal fa-calendar-alt"></i>
                                                {{$comment->created_at->format('d-M-Y h:i:s A')}}
                                            </span>
                                            <p>{!! $comment->comment !!}</p>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                                {{-- <li class="children">
                                    <div class="comments-box">
                                        <div class="comments-avatar">
                                            <img src="{{asset('frontend')}}/img/blog/p-author-2.jpg" alt="">
                                        </div>
                                        <div class="comments-text">
                                            <div class="avatar">
                                                <h6 class="avatar-name">Iqbal Hossain</h6>
                                                <a href="#" class="comment-reply"><i class="fal fa-share"></i>Reply</a>
                                            </div>
                                            <span class="post-meta"><i class="fal fa-calendar-alt"></i> October 26,
                                                2020</span>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                                tempor incid idunt ut labore et dolore magna aliqua. Ut enim ad minim
                                                veniam, quis nostrud exercitation ullamco..</p>
                                        </div>
                                    </div>
                                </li> --}}
                            </ul>
                        </div>
                    </div>
                    <div class="post-comment-form mt-20">
                        <h4 class="post-comment-form-title mb-40">Post Comment</h4>
                        <form action="{{ route('blog.comment.post', $blog->id) }}" method="POST">
                            @csrf
                            <div class="input-field">
                                <i class="fal fa-pencil-alt"></i>
                                <textarea name="comment" name="comment" placeholder="Type your comments...."></textarea>
                                @error('comment')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-field">
                                <i class="fal fa-user"></i>
                                <input type="text" name="name" placeholder="Type your name....">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-field">
                                <i class="fal fa-envelope"></i>
                                <input type="text" name="email" placeholder="Type your email....">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button class="post-comment shutter-btn" type="submit"><i class="fal fa-comments"></i>Post
                                Comment</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4">
                <div class="news-sidebar pl-10">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="widget">
                                <h6 class="sidebar-title"> Search Here</h6>
                                <div class="n-sidebar-search">
                                    <div class="blog_search_box">
                                        <form action="{{route('search.blogs')}}" method="GET">
                                            <input class="search-input" name="blog_headline" id="findBlog" onfocus="showSearchResult()" onblur="hideSearchResult()" type="text" placeholder="Search your keyword..." value="{{request('blog_headline')}}">
                                            <button class="button" type="submit"><i class="far fa-search"></i></button>
                                        </form>
                                    </div>
                                    <div class="search_result_blog">
                                        <ul id="suggest_blogs">

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="widget">
                                <h6 class="sidebar-title">Popular Feeds</h6>
                                <div class="n-sidebar-feed">
                                    <ul>
                                        @forelse ($top_view_blog as $blog)
                                        <li>
                                            <div class="feed-number">
                                                <a href="{{route('blog.details', $blog->blog_slug)}}"><img src="{{asset('uploads/blog_thumbnail_photo')}}/{{$blog->blog_thumbnail_photo}}" alt=""></a>
                                            </div>
                                            <div class="feed-content">
                                                <h6><a href="{{route('blog.details', $blog->blog_slug)}}">{{$blog->blog_headline}}</a></h6>
                                                <span class="feed-date">
                                                    <i class="fal fa-calendar-alt"></i>
                                                    @if ($blog->updated_at)
                                                        {{$blog->updated_at->format('d-M-Y')}}
                                                    @else
                                                        {{$blog->created_at->format('d-M-Y')}}
                                                    @endif
                                                </span>
                                            </div>
                                        </li>
                                        @empty
                                        <div class="alert alert-warning">
                                            <strong>Blog Not Found........</strong>
                                        </div>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-6">
                            <div class="widget">
                                <h6 class="sidebar-title">Categories</h6>
                                <ul class="n-sidebar-categories">
                                    @forelse ($blog_categories as $blog_category)
                                    <li>
                                        <a href="{{ route('category.wise.blog', $blog_category->blog_category_slug) }}">
                                            <div class="single-category p-relative mb-10">
                                                {{$blog_category->blog_category_name}}
                                                <span class="category-number">{{ App\Models\Blog::where('blog_category_id', $blog_category->id)->count() }}</span>
                                            </div>
                                        </a>
                                    </li>
                                    @empty
                                    <div class="alert alert-warning">
                                        <strong>Category Not Found!</strong>
                                    </div>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- news-detalis-area-end  -->
@endsection

@section('custom_script')
<script>

</script>
@endsection
