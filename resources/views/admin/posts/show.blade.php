@extends('layouts.admin')

@section('content')
    <div class="container">

        @if (Session::get('message') != Null)
        <div class="row">
            <div class="col-md-9">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ Session::get('message') }}
                </div>
            </div>
        </div>
        @endif

        <div class="row">


            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit article</div>
                    <div class="panel-body">
                        <a href="{{ route('posts.index') }}" class="btn btn-success btn-sm" title="All Posts">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </a>
                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <div class="card">
                                <div class="card-header">
                                    <b><h5>Post title:</h5>{{$post->title}}</b>
                                </div>
                                <div class="card-header">
                                    <b><h5>Title SEO:</h5> {{$post->seo_title}}</b>
                                </div>
                                <div class="card-block">
                                    <h5>Post content:</h5>
                                    {!! $post->content !!}
                                </div>
                                <div class="card-block">
                                    <h5>Post img</h5>
                                    <img src="{{$post->picture_name}}" alt="">
                                </div>
                                <div class="card-block">
                                    <h5>Post category:</h5>
                                    {{$category}}
                                </div>
                                <div class="form-group">
                                    <div class="card-block">
                                        <h5>Post tags:</h5>
                                    @foreach($tags as $tag)
                                        <p>{{$tag->tag}}</p>

                                    @endforeach

                                </div>
                                <div class="card-footer text-muted">
                                    <div class="pull-right">
                                        <a title="Edit article" href="{{ url('/posts/'.$post->id.'/edit/') }}" class="btn btn-warning"><span class="fa fa-edit"></span></a>
                                        <button title="Delete article" type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete_article_{{ $post->id  }}"><span class="fa fa-trash-o"></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete_article_{{ $post->id  }}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <form class="" action="{{ route('posts.destroy', ['id' => $post->id]) }}" method="post">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <h4 class="modal-title" id="mySmallModalLabel">Delete article</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>


                    <div class="modal-body">
                        Are you sure to delete article: <b>{{ $post->title }} </b>?

                    </div>
                    <div class="modal-footer">
                        <a href="{{ url('/posts') }}">
                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                        </a>
                        <button type="submit" class="btn btn-outline" title="Delete" value="delete">Delete</button>
                    </div>
                </div>
            </div>
        </form>
    </div>


@endsection