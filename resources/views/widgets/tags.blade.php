<!-- Tags Widget -->
@if($data)
    <div class="card my-4">
        <p class="widget-header">Tags</p>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <ul class="list-unstyled mb-0">
                        @foreach($data as $item)
                            @if($loop->iteration  % 2 == 0)
                                <li>
                                    <a href="{{ route('tag.filter', ['id'=> $item->slug]) }}">{{ $item->tag }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>

                <div class="col-lg-6">
                    <ul class="list-unstyled mb-0">
                        @foreach($data as $item)
                            @if($loop->iteration  % 2 != 0)
                                <li>
                                    <a href="{{ route('tag.filter', ['id'=> $item->slug]) }}">{{ $item->tag }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif
