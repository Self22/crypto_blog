<!-- Categories Widget -->
@if($data)
<div class="card my-4">
  <p class="widget-header">Categories</p>
    <div class="card-body">
      <div class="row">
        <div class="col-lg-12">
          <ul class="list-unstyled mb-0">
            @foreach($data as $item)

                <li>
                    <a href="{{ route('category.filter', ['id'=> $item->slug]) }}">{{ $item->name }}</a>
                </li>

            @endforeach
          </ul>
        </div>


      </div>
    </div>
  </div>
@endif
