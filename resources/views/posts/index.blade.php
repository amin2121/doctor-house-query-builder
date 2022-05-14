@extends('layouts.app', ['title' => $category->name ?? 'All Post'])

@section('content')

<div class="container">
	<div class="row mx-auto">
		<div class="col-md-12">
			<div class="d-flex justify-content-between">

				@isset($category)
				<h4>Post {{ $category->name }}</h4>
				@else
					@isset($tag)
					<h4>Tag : {{ $tag->name }}</h4>
					@else
					<h4>All Post</h4>
					@endisset
				@endisset


				<a href="/posts/create/" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Post</a>

			</div>
			<hr>

			@isset($categories)
				@foreach($categories as $c)
					@isset($category)
						<a href="/categories/{{ $c->slug }}" class="btn {{ $category->category == $c->category ? 'btn-primary' : 'btn-outline-primary' }} btn-sm mb-3">{{ $c->category }}</a>
					@else
						<a href="/categories/{{ $c->slug }}" class="btn btn-outline-primary btn-sm mb-3">{{ $c->category }}</a>
					@endisset
				@endforeach
			@else

			@endisset

			<a href="/posts" class="btn {{ ($category->category ?? null) == null ? 'btn-primary' : 'btn-outline-primary' }} btn-sm mb-3">All Post</a>
		</div>
		@forelse ($posts as $post)
		<div class="col-md-4 d-flex">
			<div class="card mb-3">
				{{-- <div class="card-header"><b>{{ $post->title }}</b></div> --}}
				<img class="card-img-top" style="height: 270px; object-fit: cover; object-position: center;" src="/storage/{{ $post->thumbnail }}">
				<div class="card-body">
					<div>
						<a href="{{ route('posts.show', $post->slug) }}" class=""><h5 class="text-bold">{{ $post->title }}</h5></a>
						<p class="text-secondary">{{ Str::limit($post->body, 200) }}</p>
						<a href="/posts/{{ $post->slug }}">Read More</a>
					</div>
				</div>
				<div class="card-footer text-muted d-flex justify-content-between">
					Posted on {{ $post->created_at->diffForHumans() }}
					<div>
						{{-- @if(auth()->user()->is($post->author)) --}}
						@can('update', $post)
							<a href="/posts/{{ $post->slug }}/edit" class="btn btn-warning btn-sm">Edit</a>
						@endcan

						@can('delete', $post)
							<button type="button" data-bs-toggle="modal" data-bs-target="#modal-hapus-post-{{ $post->id }}" class="btn btn-danger btn-sm">Hapus</button>
						@endcan
						{{-- @endif --}}

						<!-- Modal -->
						<div class="modal fade" id="modal-hapus-post-{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-hapus-post" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="modal-hapus-post">Hapus Post</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<form action="/posts/{{ $post->slug }}/delete" method="POST">
										@csrf
										@method('delete')
										<div class="modal-body">
											<div class="alert alert-warning">
												Apakah Anda Ingin Menghapus Post Ini?
											</div>
										</div>
										<div class="modal-footer">
											<button type="submit" class="btn btn-primary">Ya</button>
											<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@empty
		<div class="alert alert-info">
			There are no posts.
		</div>
		@endforelse
	</div>

	<div class="row">
		<div class="col-sm-12 mt-4">
			<div class=" d-flex justify-content-center">
				{{ $posts->links() }}
			</div>
		</div>
	</div>
</div>

@stop