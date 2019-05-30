<html lang="{{app()->getLocale()}}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{--csrf-token--}}
        <meta name="csrf-token" content="{{csrf_token()}}">
        <title>@yield('title', 'Larabbs')-Laravel 个人主页</title>
        <meta name="description" content="@yield('description', 'LaraBBS 社区')">

        {{--style--}}
        <link href="{{asset('css/app.css')}}" rel="stylesheet">
        @yield('styles')
    </head>

    <body>
        <div id="app" class="{{route_class()}}-page">
            @include('layouts._header')
            <div class="container">
                @include('layouts._message')
                @yield('content')
            </div>
            @include('layouts._footer')
        </div>

    {{--script--}}
    <script src="{{asset('js/app.js')}}"></script>
    @yield('scripts')
    </body>
</html>