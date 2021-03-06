@extends('layouts.admin')

@section('content')

    @if(Session::has('Deleted Post'))
            
        <p class="bg-danger">{{session('Deleted Post')}}</p>

    @endif

<h1>Posts</h1>



  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Photo</th>
        <th>Owner</th>
        <th>Category</th>
        <th>Title</th>
        <th>Body</th>
        <th>Post</th>
        <th>Comment</th>
        <th>Created</th>
        <th>Updated</th>
      </tr>
    </thead>
    <tbody>

    @if($posts)
		@foreach($posts as $post)
	      <tr>
	        <td>{{$post->id}}</td>
          <td><img height="100px" src="{{$post->photo ? $post->photo->file : '/images/not-available.png'}}"></td>
	     <td><a href="{{route('admin.posts.edit',$post->id)}}">{{$post->user->name}}</a></td>
	        <td>{{$post->category ? $post->category->name : 'Uncategorized'}}</td>
	        <td>{{$post->title}}</td>
	        <td>{{str_limit($post->body, 30)}}</td>
          <td><a href="{{route('home.post', $post->slug)}}">View Post</a></td>
          <td><a href="{{route('admin.comments.show', $post->id)}}">View Comments</a></td>
	        <td>{{$post->created_at->diffForHumans()}}</td>
	        <td>{{$post->updated_at->diffForHumans()}}</td>
	      </tr>
		@endforeach
	@endif
    </tbody>
  </table>

  <div class="row">
    <div class="col-sm-6 col-sm-offset-5">
      
      {{$posts->render()}}

    </div>
  </div>


@endsection


