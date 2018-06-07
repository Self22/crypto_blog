<!-- Preview Image -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$post->title}}</li>
    </ol>
</nav>

<img class="img-fluid rounded" src="../{{$post->picture_name}}" alt="">

<hr>

<!-- Date/Time -->
<p>Posted on {{ date('d F Y', strtotime($post->created_at)) }}</p>

<hr>
Category: <a href="{{ route('category.filter', ['id'=> $post->category->id]) }}">{{ $post->category->name }}</a>
<!-- Post Content -->
<p class="lead">{!! $post->content !!}</p>
<ul class="list-group">
    @foreach($post->tags as $tag)
        <li class="list-group-item">{{ $tag->tag }}</li>
    @endforeach

</ul>
