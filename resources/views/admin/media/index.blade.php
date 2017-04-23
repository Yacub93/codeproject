@extends('layouts.admin')

@section('content')

{{--     @if(Session::has('Deleted Post'))
            
        <p class="bg-danger">{{session('Deleted Post')}}</p>

    @endif --}}

<h1>Media</h1>

      @if($photos)
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Photo Name</th>
              <th>Created</th>
            </tr>
          </thead>
          <tbody>
            @foreach($photos as $photo)

            <tr>
              <td>{{$photo->id}}</td>
              <td><img height="100px" src="{{$photo->file}}"></td>
              <td>{{$photo->created_at ? $photo->created_at->diffForHumans() : 'No Date Available'}}</td>
              <td>
                

              {!! Form::open(['method' => 'DELETE','action'=>['AdminMediasController@destroy',$photo->id]]) !!}


            <div class="form-group">
    
            {!! Form::submit('Delete Photo', ['class'=>'btn btn-danger']) !!}

            </div>

  

                {!! Form::close() !!}


              </td>
            </tr>

            @endforeach()
          </tbody>
        </table>
      @endif


@endsection


