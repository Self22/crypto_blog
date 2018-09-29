<!-- Blog Post -->

<div class="card mb-4">
    <div class="card-img-top">
        @isset($post->picture_name)
            <img class="card-img-top" src="{{$post->picture_name}}" alt="">
        @endisset
    </div>


    <div class="card-body snippet-article_body">
        @isset($post->title)
            <h2 class="card-title">{{ $post->title }}</h2>
        @endisset

        @isset($post->anchor)
            <h2 class="card-title">{!! $post->anchor !!} </h2>

        @endisset
        @isset($post->img_preview)
            <div class="img__prev">
                <img src="{{$post->img_preview}}" alt="">
            </div>
        @endisset
        @isset($post->news_text)
            @php
                echo(strstr($post->news_text, '</p>', true)).'</p>';
            @endphp
        @endisset
        <a href="{{ route('blog.show', ['slug'=> $post->slug]) }}" class="btn btn-primary">Read More &rarr;</a>
    </div>

    <div class="card-footer text-muted">
        Posted on {{ date('d F Y', strtotime($post->created_at)) }}
    </div>
</div>
