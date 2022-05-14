@extends('layouts.app', ['title', 'Edit Post'])

@section('content')
	
	<div class="container">
		<div class="row mx-auto">
			<div class="col-md-6 mx-auto">
				<div class="card">
					<div class="card-header">
						<h5>Edit Post</h5>
					</div>
					<div class="card-body">
						<form action="/posts/{{ $post->slug }}/edit" method="POST" enctype="multipart/form-data">
							@method('patch')
							@csrf
							@include('posts/partial/form-control')
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@stop