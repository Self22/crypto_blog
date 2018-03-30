<!-- Preview Image -->
<img class="img-fluid rounded" src="http://placehold.it/900x300" alt="">

<hr>

<!-- Date/Time -->
<p>Posted on {{ date('d F Y', strtotime($post->created_at)) }}</p>

<hr>
Category: <button type="button" class="btn btn-outline-success">{{ $post->category->name }}</button>
<!-- Post Content -->
<p class="lead">{{ $post->content }}</p>
<ul class="list-group">
    @foreach($post->tags as $tag)
        <li class="list-group-item">{{ $tag->tag }}</li>
    @endforeach

</ul>
