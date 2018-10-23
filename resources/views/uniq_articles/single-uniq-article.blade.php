<!-- Preview Image -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$article->anchor}}</li>
    </ol>
</nav>


<!-- Date/Time -->
<p>Posted on {{ $article->time }}, {{ $article->date }}</p>

<hr>
<!-- Post Content -->
<p class="lead">{!! $article->news_text !!}</p>
<!-- Tags -->
<div class="container">
    <div class="row">
        <ul class="list-group col-md-6">
            <li class="list-group-item"><b>Category:</b></li>
                <li class="list-group-item">{{ $category->name }}</li>
        </ul>
    </div>
</div>
<br>
@if(count($article->tags)>0)
    <div class="container">
        <div class="row">
            <ul class="list-group col-md-6">
                <li class="list-group-item"><b>Tags:</b></li>
                @foreach($article->tags as $tag)
                    <li class="list-group-item">{{ $tag->tag }}</li>
                @endforeach

            </ul>
        </div>
    </div>

@endif