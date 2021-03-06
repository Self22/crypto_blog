<div class="sidebar">
  <nav class="sidebar-nav">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="/admin"><i class="icon-speedometer"></i> Dashboard </a>
      </li>

      <li class="nav-title">
        CMS
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('posts.index')}}"><i class="icon-calculator"></i> Posts</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('categories.index')}}"><i class="icon-calculator"></i> Categories</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('tags.index')}}"><i class="icon-calculator"></i> Tags</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('uniq_texts.index')}}"><i class="icon-calculator"></i> Uniq Texts</a>
      </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('settings')}}"><i class="icon-calculator"></i> Settings</a>
        </li>
    </ul>
  </nav>

  <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
