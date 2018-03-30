@extends('layouts.admin')

@section('content')
<div class="container-fluid">
  <div class="animate fadeIn">
    <div class="col-md-9">
      <div class="panel panel-default">
        <div class="panel-heading"><h2>Categories</h2></div>
          <div class="panel-body">
            <a href="{{ url('/categories/create') }}" class="btn btn-success btn-sm pull-right" title="Add New Category">
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
                  @foreach($categories as $category)
                    <tr>
                      <td>{{ $category->name }}</td>
                      <td>{{ date('d F Y', strtotime($category->created_at)) }}</td>
                      <td>
                        <a title="Read category" href="{{ route('categories.show', ['id'=> $category->id]) }}" class="btn btn-primary"><span class="fa fa-newspaper-o"></span></a>
                        <a title="Edit category" href="{{ route('categories.edit', ['id'=> $category->id]) }}" class="btn btn-warning"><span class="fa fa-edit"></span></a>
                        <button title="Delete category" type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete_category_{{ $category->id  }}"><span class="fa fa-trash-o"></span></button>
                      </td>
                    </tr>

                    <div class="modal fade" id="delete_category_{{ $category->id  }}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                      <form class="" action="{{ route('categories.destroy', ['id' => $category->id]) }}" method="post">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                            <div class="modal-header bg-red">
                              <h4 class="modal-title" id="mySmallModalLabel">Delete category</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>

                            <div class="modal-body">
                              Are you sure to delete category: <b>{{ $category->name }} </b>?
                            </div>
                            <div class="modal-footer">
                              <a href="{{ url('/categories') }}">
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
          </div>
        </div>
      </div>
    </div>    
  </div>
</div>

@endsection