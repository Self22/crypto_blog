<!-- Blog Post -->

<div class="card mb-4">
        <img class="card-img-top" src="{{$post->picture_name}}" alt="Card image cap">
        
        <div class="card-body">
            <h2 class="card-title">{{ $post->title }}</h2>  

            
            <a href="{{ route('blog.show', ['slug'=> $post->slug]) }}" class="btn btn-primary">Read More &rarr;</a>
        </div>

        <div class="card-footer text-muted">
            Posted on {{ date('d F Y', strtotime($post->created_at)) }} by &nbsp;
            <a href="#">  Janus Nic</a>
        </div>
</div>  
