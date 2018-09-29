<!-- Sidebar Widgets Column -->
<div class="col-md-4">



  <!-- Categories Widget -->
  @widget('categories')

  <!-- Tags Widget -->
    @widget('tags')

  <!-- Link to news -->

  @if (!strpos(url()->current(), 'news.index'))
  <div class="card my-4">
    <a href="{{route('blog')}}" class="widget-header">Expert Articles</a>

  </div>
    @endif

</div>