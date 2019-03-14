@extends('layouts.master')

@section('content')

@include('includes.message-block')
	<section class="row new-post">
		<div class="col-md-6 col-md-offset-3">
			<header><h3>What do you have to say?</h3></header>
			<form action="{{ route('post.create') }}" method="post">
				<div class="form-group">
					<textarea class="form-control" name="body" id="new-post" rows="5" placeholder="say something"></textarea>
				</div>
				<button type="submit" class="btn btn-primary">Create Post</button>
				<input type="hidden" value="{{ Session::token() }}" name="_token">
			</form>
		</div>
	</section>
	<section class="row posts">
		<div class="col-md-6 col-md-offset-3">
			<header><h3>What other people say....</h3></header>
			
			@foreach($posts as $index => $post)
			<article class="post" data-postid = "{{ $post->id }}">
				<p>{{$post->body}}</p>
				<span class="hidden">{{$post->id}}</span>
				<div class="info">
					Posted by {{$post->user->first_name}} on {{$post->created_at}}
				</div>
				<div class="interaction">
					<a href="#">Like</a>
					<a href="#">Dislike</a>
					@if(Auth::user() == $post->user)
						<a href="#" data-toggle="modal" data-target="#myModal" onclick="myFunction()">Edit</a>
						<a href="{{route('post.delete', ['post_id'=> $post->id])}}">Delete</a>
					@endif
				</div>
			</article>

			@endforeach
		</div>
	</section>

	
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          	<form class="">
          		<div class="form-group">
          			<label for="post-body">Edit the Post</label>
          			<input class="form-control" type="textarea" name="post-body" rows="5" value="{{$post->body}}" id="edit-input">
          			<input class="hidden" id="hidden-input" value=""></input>
          		</div>
          	</form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success" data-dismiss="modal" onclick="myFunction1()">save</button>
        </div>
      </div>
      
    </div>
  </div>

  <script type="text/javascript">
  	var token = '{{ Session::token() }}';
  	var url = '{{ route('edit')}}';
  </script>
  

@endsection