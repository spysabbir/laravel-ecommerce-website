@extends('frontend.layouts.frontend_master')

@section('title_bar')
FAQs
@endsection

@section('body_content')

<!-- page-banner-area-start -->
<div class="page-banner-area page-banner-height-2" data-background="{{asset('frontend')}}/img/banner.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-banner-content text-center">
                    <h4 class="breadcrumb-title">FAQs</h4>
                    <div class="breadcrumb-two">
                        <nav>
                            <nav class="breadcrumb-trail breadcrumbs">
                                <ul class="breadcrumb-menu">
                                    <li class="breadcrumb-trail">
                                        <a href="{{route('index')}}"><span>Home</span></a>
                                    </li>
                                    <li class="trail-item">
                                        <span>FAQs</span>
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

<!-- faq-area-start -->
<div class="faq-area mt-70 mb-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="single-faqs mb-40">
                    <div class="faq-title">
                        <h5>Order and Returns</h5>
                    </div>
                    <div class="faq-content mt-10">
                         <div class="accordion" id="accordionExample">
                            @forelse ($faqs->where('faq_position', 'Left') as $faq)
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="heading{{$faq->id}}">
                                <button class="accordion-button {{($loop->first != 1) ? 'collapsed' : ''}}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="{{($loop->first == 1) ? 'true' : 'false'}}" aria-controls="collapse{{$faq->id}}">
                                    {{$faq->faq_question}}
                                </button>
                              </h2>
                              <div id="collapse{{$faq->id}}" class="accordion-collapse collapse {{($loop->first == 1) ? 'show' : ''}}" aria-labelledby="heading{{$faq->id}}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                  <p>{{$faq->faq_answer}}</p>
                                </div>
                              </div>
                            </div>
                            @empty
                            <div class="alert alert-warning text-center" role="alert">
                                <strong>Faq Item Not Found!</strong>
                            </div>
                            @endforelse
                          </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="single-faqs mb-40">
                    <div class="faq-title">
                        <h5>Know Business</h5>
                    </div>
                    <div class="faq-content mt-10">
                        <div class="accordion" id="accordionExample2">
                            @forelse ($faqs->where('faq_position', 'Right') as $faq)
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="heading{{$faq->id}}">
                                <button class="accordion-button {{($loop->first != 1) ? 'collapsed' : ''}}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="{{($loop->first == 1) ? 'true' : 'false'}}" aria-controls="collapse{{$faq->id}}">
                                    {{$faq->faq_question}}
                                </button>
                              </h2>
                              <div id="collapse{{$faq->id}}" class="accordion-collapse collapse {{($loop->first == 1) ? 'show' : ''}}" aria-labelledby="heading{{$faq->id}}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                  <p>{{$faq->faq_answer}}</p>
                                </div>
                              </div>
                            </div>
                            @empty
                            <div class="alert alert-warning text-center" role="alert">
                                <strong>Faq Item Not Found!</strong>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- faq-area-end -->
@endsection

@section('custom_script')
<script>

</script>
@endsection
