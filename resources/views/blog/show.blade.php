@extends('layouts.blog')






@section('header')
<h1 class="post_title mt-4 mb-3">{{ $post->title }}

</h1>

@endsection

@section('content')
<!-- Post Content Column -->
<div class="col-md-8">
    @includeIf('blog.partials.single-post')


</div>

    @include('blog.partials.sidebar')

@endsection


