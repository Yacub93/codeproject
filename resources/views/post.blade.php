@extends('layouts.blog-post')

@section('content')


		        <!-- Blog Post -->

                <!-- Title -->
                <h1>{{$post->title}}</h1>

                <!-- Author -->
                <p class="lead">
                    by <a href="#">{{$post->user->name}}</a>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted: {{$post->created_at->diffForHumans()}}</p>

                <hr>

                <!-- Preview Image -->
                <img class="img-responsive" src="{{$post->photo->file}}" alt="">

                <hr>

                <!-- Post Content -->
                <p class="lead">{{$post->body}}</p>

                <hr>

                @if(Session::has('Comment Message'))

                <p class="bg-success">{{session('Comment Message')}}</p>

                @endif

                <!-- Blog Comments -->

    @if(Auth::check()) <!-- if user is logged in -->




                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>


            {!! Form::open(['method' => 'POST', 'action'=>'PostCommentsController@store']) !!}
            
            <div class="form-group">

            <input type="hidden" name="post_id" value="{{$post->id}}">
                
            {!! Form::label('body', 'Body:') !!}
            {!! Form::textarea('body', null, ['class'=>'form-control', 'rows'=>3]) !!}

            <div class="form-group">
                
            {!! Form::submit('Post Comment', ['class'=>'btn btn-primary']) !!}

            </div>


            {!! Form::close() !!}

            </div>



                </div>
    @endif


                <hr>

                <!-- Posted Comments -->

        @if(count($comments) > 0)


          

            @foreach($comments as $comment)


                

                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img height="64" class="media-object" src="{{Auth::user()->gravatar}}" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">{{$comment->author}}
                            <small>{{$comment->created_at->diffForHumans()}}</small>
                        </h4>
                        <p>{{$comment->body}}</p>
   

                @if(count($comment->replies) > 0)

                        @foreach($comment->replies as $reply)

                        @if($reply->is_active == 1)

                        <!-- Nested Comment -->
                        <div class="media" style="margin-top: 60px">
                            <a class="pull-left" href="#">
                                <img height="64" class="media-object" src="{{$reply->photo}}" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">{{$reply->author}}
                                <small>{{$reply->created_at->diffForHumans()}}</small>
                                </h4>
                                {{$reply->body}}
                            </div>

     
                 <div class="comment-reply-container">

                    <button class="toggle-reply btn btn-primary pull-right">Reply</button>
                    
                    <div class="comment-reply col-sm-8" style="display: none;">

    {!! Form::open(['method' => 'POST', 'action'=>['CommentRepliesController@createReply']]) !!}

                <div class="form-group">

                <input type="hidden" name="comment_id" value="{{$comment->id}}">

        
                {!! Form::label('body', 'Reply') !!}
                {!! Form::textarea('body', null, ['class'=>'form-control','rows'=>3]) !!}

                </div>

                <div class="form-group">
                    
                    {!! Form::submit('Post', ['class'=>'btn btn-primary']) !!}

                </div>
    {!! Form::close() !!}
                    
                      </div> 
                        <!-- End Nested Comment -->

                        </div>
                        <!-- comment-reply container -->

            </div><!-- div comment/media margin container -->

                    @endif <!-- reply Approved/UnApproved-->


                @endforeach <!-- Replies foreach -->
            @endif    <!-- Replies if condition -->






                    </div>
                </div>
            @endforeach
        @endif



@endsection

@section('scripts')

    <script>
        $(".comment-reply-container .toggle-reply").click(function(){

                $(this).next().slideToggle("slow");


        });

    </script>



@endsection