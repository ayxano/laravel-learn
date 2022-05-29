@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
    {{-- forelse is used for to check if variable is not empty. if it is empty, then @empty section will be executed. If not, @forelse section will be executed. it makes you to not write if condition before foreach --}}
    @forelse ($posts as $key => $post)
        @include('posts.partials.post') {{-- Include function automaticly passes old variables from parent view. Also you can use $loop variable inside the included view --}}
    @empty
        <div>No posts</div>
    @endforelse

    {{-- Below I'm going to put simplified version of @include function for partial typed views. Unlink @include, @each doesn't passes old varriables from parent, and you can't use $loop variable inside the view --}}
    {{-- @each('posts.partials.post', $posts, 'post')  --}}
    <div><h2>Testing for loop</h2></div>

    
    @for ($i = 0; $i <= 10; $i++)
        <div>The current value inside for loop is {{ $i }}</div>
    @endfor

    <div><h2>Testing while</h2></div>

    @php
        $done = false;
    @endphp

    @while ($done === false)
        <div>I'm not done</div>
        @php
            if(random_int(0,1) === 1) $done = true
        @endphp
    @endwhile

@endsection