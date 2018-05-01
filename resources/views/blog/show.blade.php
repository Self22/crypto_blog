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
<h1 class="mt-4 mb-3">{{ $post->title }}

</h1>

@endsection

@section('content')
<!-- Post Content Column -->
<div class="col-md-8">
    @includeIf('blog.partials.single-post', ['post' => $post])


</div>
@endsection

@section('sidebar')
  @include('blog.partials.sidebar')
@endsection
