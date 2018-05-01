<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @yield('head')
</head>
<body>
    <header class="main__header">
        @yield('header')
    </header>
    <div id="app">


        <div class="container">
            <div class="row">
            @yield('page')

            </div>
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
