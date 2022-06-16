@extends('layouts.app')

@section('title', 'Create a post')

@section('content')
<form action="{{ route('posts.store') }}" method="post">
    {{-- below adding csrf verification for security reasons --}}
    @csrf
    @include('posts.partials.form')
    <div><input type="submit" value="Create Post!"/></div>
</form>
@endsection