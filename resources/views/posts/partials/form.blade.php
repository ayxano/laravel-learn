<div class="form-group">
    <label for="title">Title</label>
    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $post->title ?? null) }}" />
</div>
{{-- checking only error input based  --}}
@error('title')
    <div>{{ $message }}</div>
@enderror
<div class="form-group">
    <label for="content">Content</label>
    <textarea name="content" id="content" class="form-control">{{ old('content', $post->content ?? null) }}</textarea>
</div>
@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif