@extends('layouts.blog')


@section('breadcrumb')
<!-- Page Heading/Breadcrumbs -->
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="/">Home</a>
  </li>
  <li class="breadcrumb-item">
    <a href="/blog">Blog</a>
  </li>
  <li class="breadcrumb-item active">{{ $post->title }}</li>
</ol>

@endsection

@section('header')
<h2 class="mt-4 mb-3">{{ $post->title }}
  <small>by
    <a href="#">Janus Nic</a>
  </small>
</h2>

@endsection

@section('content')
<!-- Post Content Column -->
<div class="col-lg-8">
    @includeIf('blog.partials.single-post', ['post' => $post])
    <hr>
    @includeIf('blog.partials.quote', ['some' => 'data'])

</div>
@endsection

@section('sidebar')
  @include('blog.partials.sidebar')
@endsection
