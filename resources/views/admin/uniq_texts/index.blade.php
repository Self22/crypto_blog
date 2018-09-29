@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="animate fadeIn">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Uniq Texts</div>
                    <div class="panel-body">

                        <br/>
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

                        <br/>
                        <div class="table-responsive">

                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Posted On</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($posts as $post)
                                    <tr>
                                        <td>{{ $post->id }}</td>
                                        <td>{{ $post->anchor }}</td>
                                        <td>{{ date('d F Y', strtotime($post->created_at)) }}</td>
                                        <td>
                                            <a title="Edit article" href="{{ route('uniq_texts.edit', ['id'=> $post->id]) }}" class="btn btn-warning"><span class="fa fa-edit"></span></a>
                                            <button title="Delete post" type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete_post_{{ $post->id  }}"><span class="fa fa-trash-o"></span></button>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="delete_post_{{ $post->id  }}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                        <form class="" action="{{ route('posts.destroy', ['id' => $post->id]) }}" method="post">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-red">
                                                        <h4 class="modal-title" id="mySmallModalLabel">Delete post</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        Are you sure to delete post: <b>{{ $post->title }} </b>?
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


                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        <div class="pagination justify-content-center mb-4">
                            {{ $posts->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>



@endsection
