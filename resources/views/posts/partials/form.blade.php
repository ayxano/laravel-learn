<div><input type="text" name="title" value="{{ old('title', $post->title ?? null) }}" /></div>
{{-- checking only error input based  --}}
@error('title')
    <div>{{ $message }}</div>
@enderror
<div><textarea name="content">{{ old('content', $post->content ?? null) }}</textarea></div>
@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif