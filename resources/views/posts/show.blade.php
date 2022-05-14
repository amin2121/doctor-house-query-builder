@extends('layouts.app', ['title' => $post->title])

@section('content')
<div class="container">
	<h3 style="font-weight: bold;">{{ $post->title }}</h3>
	<a href="/categories/{{ $post->category->slug }}">{{ $post->category->name }}</a> 
	<span class="text-muted">&middot; {{ $post->created_at->format('d F, Y') }}</span>
	<span class="text-muted">&middot;</span>
	
	@isset($post->tags)
		@foreach ($post->tags as $tag)
			<a href="/tags/{{ $tag->slug }}" style="text-decoration: none !important;">{{ $tag->name }}</a>
		@endforeach
	@else

	@endisset

	<br>
	<p class="mt-3">{{ $post->body }}</p>
	<div class="text-secondary">
		Wrote by : {{ $post->author->name }}
	</div>
</div>
@endsection