<p><b>Post title: {{ $post->title }}</b></p>
<p><i>Post content: {{ $post->content }}</i></p>

<img src="{{ $message->embed(public_path(DIRECTORY_SEPARATOR . 'dua lipa.jpg')) }}" />

<a href="{{ route('posts.show', ['post' => $post->id]) }}">View Post</a>