@extends('frontend.layouts.frontend_master')

@section('title_bar')
Search Blog Result
@endsection

@section('body_content')
<!-- page-banner-area-start -->
<div class="page-banner-area page-banner-height-2" data-background="{{asset('frontend')}}/img/banner.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-banner-content text-center">
                    <h4 class="breadcrumb-title">Search Blog Result</h4>
                    <div class="breadcrumb-two">
                        <nav>
                            <nav class="breadcrumb-trail breadcrumbs">
                                <ul class="breadcrumb-menu">
                                    <li class="breadcrumb-trail">
                                        <a href="{{route('index')}}"><span>Home</span></a>
                                    </li>
                                    <li class="trail-item">
                                        <span>Search Blog Result</span>
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

<!-- News-detalis-area-start -->
<div class="blog-area mt-120 mb-75">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="row">
                    @forelse ($blogs as $blog)
                        @include('frontend.part.blog')
                    @empty
                    <div class="alert alert-warning text-center">
                        <strong>Blog Not Found........</strong>
                    </div>
                    @endforelse
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="basic-pagination text-center pt-30 pb-30">
                            {{ $blogs->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5">
                <div class="news-sidebar pl-10">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="widget">
                                <h6 class="sidebar-title">Search Here</h6>
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
                                <h6 class="sidebar-title">Blog Category</h6>
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
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Find Product
        $('#findBlog').keyup(function(){
            var searchData = $("#findBlog").val();
            if(searchData.length > 0){
                $.ajax({
                    type:'POST',
                    url: "{{route('find.blog')}}",
                    data: {search:searchData},

                    success: function(result){
                        $('#suggest_blogs').html(result)
                    }
                })
                // ajax end
            }
            if(searchData.length < 1) {
                $('#suggest_blogs').html("")
            }
        })
    });

    function showSearchResult(){
        $('#suggest_blogs').slideDown()
    }
    function hideSearchResult(){
        $('#suggest_blogs').slideUp()
    }
</script>
@endsection
