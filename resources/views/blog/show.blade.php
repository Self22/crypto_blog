@extends('layouts.blog')






@section('header')
    <a href="/" class="headerimg__cont">
        <img src="{{ asset('img\logo_hg.png') }}" alt="">
    </a>

    @isset($post)
        <h1 class="post_title mt-4 mb-3">{{ $post->title }}
    @endisset

    @isset($article)
                <h1 class="post_title mt-4 mb-3">{{ $article->anchor }}
    @endisset

</h1>

@endsection

@section('content')
<!-- Post Content Column -->
<div class="col-md-8 article__content">
    @isset($article)
        @includeIf('uniq_articles.single-uniq-article')
    @endisset


    @isset($post)
        @includeIf('blog.partials.single-post')
    @endisset


</div>

    @include('blog.partials.sidebar')

@endsection


