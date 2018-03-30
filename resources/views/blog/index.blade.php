@extends('layouts.blog')

@section('meta')
@endsection

@section('title')
@endsection

        {{--<!-- Page Heading/Breadcrumbs -->--}}






<div class="container-fluid header__logo">
    <h1 class="title__logo">CryptoBlog</h1>
</div>


@section('content')
        <!-- Blog Entries Column -->

<div class="col-md-8">
    @isset($name)
    <p>All posts with tag: {{($name)}}</p>
    @endisset
    @isset($category)
    <p>All posts in category: {{($category)}}</p>
    @endisset
    @each('blog.partials.post', $posts, 'post', 'blog.partials.post-none')

            <!-- Pagination -->
    <div class="pagination justify-content-center mb-4">
         {{ $posts->links() }}
    </div>

</div>
@include('blog.partials.sidebar')
@endsection
