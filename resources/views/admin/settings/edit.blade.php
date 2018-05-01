@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="animate fadeIn">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading"><h2>General settings</h2></div>
                    <div class="panel-body">


                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <form action="{{ route('settings.update') }}" method="post">
                                <input type="hidden" name="_method" value="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">


                                <div class="card">
                                    <div class="card-block">
                                        <div class="form-group">
                                            <label for="title">Main Title</label>
                                            <input name="main_title" class="form-control" type="text" value="{{ $settings->main_title }}" required>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <div class="form-group">
                                            <label for="title">Main H1</label>
                                            <input name="main_h1" class="form-control" type="text" value="{{ $settings->main_h1 }}" required>
                                        </div>
                                    </div>
                                    <div class="card-footer text-muted">
                                        <div class="pull-right">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
