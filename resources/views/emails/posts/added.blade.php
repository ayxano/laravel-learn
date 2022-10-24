<p><b>Post title: {{ $post->title }}</b></p>
<p><i>Post content: {{ $post->content }}</i></p>

<a href="{{ route('posts.show', ['post' => $post->id]) }}">View Post</a>