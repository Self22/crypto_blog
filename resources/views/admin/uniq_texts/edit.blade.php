
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
                            <strong>Edit Uniq Text</strong>
                            <a href="{{ route('uniq_texts.index') }}" class="btn btn-success btn-sm" title="All Posts">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                            </a>
                        </div>

                        <form action="{{ route('uniq_texts.update',['id' => $post->id]) }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">
                            <div class="card-body">

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="title">Uniq Text anchor</label>
                                    <div class="col-md-9">
                                        <input type="text" id="anchor" name="anchor" class="form-control" value="{{ $post->anchor }}">
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="title">Uniq Text description</label>
                                    <div class="col-md-9">
                                        <input type="text" id="description" name="description" class="form-control" value="{{ $post->description }}">
                                    </div>
                                </div>
                                <br>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="content">Uniq Text Content</label>
                                    <div class="col-md-9">
                                        <textarea id="news_text" name="news_text" rows="9" class="form-control">{{ $post->news_text }}</textarea>
                                    </div>
                                </div>
                                <br>



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
