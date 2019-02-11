@extends('layouts.blog')



@section('header')
    <a href="/" class="headerimg__cont">
        <img src="{{ asset('img\logo_hg.png') }}" alt="">
    </a>

        
@endsection



@section('content')
        <!-- Blog Entries Column -->
    @isset($h1)
    <div class="col-md-12">
    <h1 class="main__h1">{{$h1}}</h1>
        </div>
    @endisset
<div class="col-md-8">

    @isset($name)
    <p>All posts with tag: {{($name)}}</p>
    @endisset
    @isset($category)
    <p>All posts in category: {{($category)}}</p>
    @endisset
    @each('blog.partials.post', $posts, 'post', 'blog.partials.post-none')

            <!-- Pagination -->
    @if(is_object($posts))
    <div class="pagination justify-content-center mb-4">
         {{ $posts->links() }}
    </div>
    @endif

</div>
@include('blog.partials.sidebar')
@endsection
