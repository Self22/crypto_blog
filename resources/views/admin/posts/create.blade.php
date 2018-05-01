@extends('layouts.admin')

@section('content')

    <div class="container-fluid">
        <div class="animated fadeIn">

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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Add New</strong> Post
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <a href="{{ route('posts.index') }}" class="btn btn-success btn-sm" title="All Posts">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                            </a>
                        </div>

                        <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="card-body">

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="title">Post Title</label>
                                    <div class="col-md-9">
                                        <input type="text" id="title" name="title" class="form-control" placeholder="Post Title">
                                        <span class="help-block">Enter Post Title</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="title">Page Title (SEO)</label>
                                    <div class="col-md-9">
                                        <input type="text" id="title" name="seo_title" class="form-control" placeholder="Page Title (SEO)">
                                        <span class="help-block">Enter Page Title (SEO)</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="content">Post Content</label>
                                    <div class="col-md-9">
                                        <textarea id="content" name="content" rows="9" class="form-control" placeholder="Content.."></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="">Post Picture</label>
                                    <div class="col-md-9">
                                        <input type="file" name="image">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="category_id">Post Category</label>
                                    <div class="col-md-9">
                                        <select id="category_id" name="category_id" class="form-control">
                                            <option value="0">Please select</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Is Active</label>
                                    <div class="col-md-9">
                                        <label class="radio-inline" for="inline-radio1">
                                            <input type="radio" id="inline-radio1" name="is_active" value="1"> Yes
                                        </label>
                                        <label class="radio-inline" for="inline-radio2">
                                            <input type="radio" id="inline-radio2" name="is_active" value="0"> No
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Post Tags</label>
                                    <div class="col-md-9">
                                        <select class="form-control select2-multi" name="tags[]" multiple="multiple">
                                            @foreach($tags as $tag)
                                                <option value='{{ $tag->id }}'>{{ $tag->tag }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>
                                <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('.select2-multi').select2({
            placeholder: 'Choose A Tag',
            tags: true
        });
    </script>
@endsection