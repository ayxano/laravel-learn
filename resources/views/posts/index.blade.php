@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
    {{-- forelse is used for to check if variable is not empty. if it is empty, then @empty section will be executed. If not, @forelse section will be executed. it makes you to not write if condition before foreach --}}
    @forelse ($posts as $key => $post)
        @include('posts.partials.post')
    @empty
        <div>No posts</div>
    @endforelse

    <div><h2>Testing for loop</h2></div>
    
    @for ($i = 0; $i <= 10; $i++)
        <div>The current value is {{ $i }}</div>
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