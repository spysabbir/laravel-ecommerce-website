<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{ $newsletter->received_by }}</h4>
    </div>
    <div class="card-body">
        <h4>{{ $newsletter->newsletter_subject }}</h4>
        <p>{!! $newsletter->newsletter_body !!}</p>
    </div>
</div>
