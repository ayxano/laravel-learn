@extends('layouts.app')

@section('title', 'Edit a post')

@section('content')
<form action="{{ route('posts.update', ['post' => $post->id ]) }}" method="post">
    {{-- below adding csrf verification for security reasons --}}
    @csrf
    @method('PUT')
    @include('posts.partials.form')
    <div><input type="submit" value="Update Post!"/></div>
</form>
@endsection