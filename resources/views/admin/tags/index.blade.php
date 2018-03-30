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
                    <div class="panel-heading">Tags</div>
                    <div class="panel-body">
                        <a href="{{ url('/tags/create') }}" class="btn btn-success btn-sm" title="Add New Tag">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        <br/>
                        <br/>
                        <div class="table-responsive">
                  
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Posted On</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tags as $tag)
                                    <tr>
                                        <td>{{ $tag->tag }}</td>
                                        <td>{{ date('d F Y', strtotime($tag->created_at)) }}</td>
                                        <td>
                                            <a title="Read tag" href="{{ route('tags.show', ['id'=> $tag->id]) }}" class="btn btn-primary"><span class="fa fa-newspaper-o"></span></a>
                                            <a title="Edit tag" href="{{ route('tags.edit', ['id'=> $tag->id]) }}" class="btn btn-warning"><span class="fa fa-edit"></span></a>
                                            <button title="Delete tag" type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete_tag_{{ $tag->id  }}"><span class="fa fa-trash-o"></span></button>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @foreach($tags as $tag)
        <div class="modal fade" id="delete_tag_{{ $tag->id  }}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <form class="" action="{{ route('tags.destroy', ['id' => $tag->id]) }}" method="post">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-red">
                            <h4 class="modal-title" id="mySmallModalLabel">Delete tag</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>


                        <div class="modal-body">
                            Are you sure to delete tag: <b>{{ $tag->name }} </b>?

                        </div>
                        <div class="modal-footer">
                            <a href="{{ url('/') }}">
                                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                            </a>
                            <button type="submit" class="btn btn-outline" title="Delete" value="delete">Delete</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endforeach

@endsection