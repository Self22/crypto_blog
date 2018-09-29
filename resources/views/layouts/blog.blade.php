@extends('layouts.app')

@section('head')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @isset($description)
    <meta name="description" content="{{ $description }}">
    @endisset
    <link rel="icon" type="image/x-icon" href="{{url('/img/favicon.png')}}">

    <title>{{ $title }} | HG.IO</title>




    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.0/js/all.js"></script>
    <link href="/css/styles.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @endsection





    {{--Head--}}
    @section('header')
    @endsection
    
    @section('navigation')
       @include('shared.navigation')
    @endsection
    
    {{--Page--}}
    
    @section('page')


          @yield('content')
          @yield('sidebar')

    @endsection

@section('footer')
    @include('shared.footer')
@endsection

{{--Scripts--}}

    @section('scripts')
        <!-- Bootstrap core JavaScript -->
       <script src="{{ asset('js/vendor/jquery.min.js') }}"></script>

        <script src="{{ asset('js/vendor/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
    @endsection
