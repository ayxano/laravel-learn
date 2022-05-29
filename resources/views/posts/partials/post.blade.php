@if($loop->even)
<div>{{ $key }}.{{ $post['title'] }}</div>
@else
<div style="background-color: silver"><b>{{ $key }}.{{ $post['title'] }}</b></div>
@endif