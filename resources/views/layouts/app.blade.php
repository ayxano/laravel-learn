<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
    <title>Laravel App - @yield('title')</title>
</head>
<body>
    <div class="f-flex flex-column flex-md-row align-items-center p-3 px-md-4 ">
        <h5>Laravel App</h5>
        <nav>
            <a href="{{ route('home.index') }}">Home</a>
            <a href="{{ route('home.contact') }}">Contact</a>
            <a href="{{ route('posts.index') }}">Posts</a>
            <a href="{{ route('posts.create') }}">Add post</a>
        </nav>
    </div>
    <div class="container">
        @if(session('status'))
            <div style="background: red; color:white">{{ session('status') }}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>