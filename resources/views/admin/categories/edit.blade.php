@extends('layouts.admin')

@section('content')

{{--     @if(Session::has('Deleted Post'))
            
        <p class="bg-danger">{{session('Deleted Post')}}</p>

    @endif --}}

<h1>Edit Categories</h1>


    <div class="col-sm-6">
      
      {!! Form::model($category,['method' => 'PATCH','action'=>['AdminCategoriesController@update',$category->id]]) !!}
    
      {{-- {{csrf_field()}} --}}

      <div class="form-group">
        
      {!! Form::label('name', 'Category Name:') !!}
      {!! Form::text('name', null, ['class'=>'form-control']) !!}

      </div>

      <div class="form-group">
    
      {!! Form::submit('Update Category', ['class'=>'btn btn-primary col-sm-5']) !!}

      </div>

      {!! Form::close() !!}



     {!! Form::open(['method' => 'DELETE','action'=>['AdminCategoriesController@destroy',$category->id]]) !!}
    
      <div class="form-group">
    
      {!! Form::submit('Delete Category', ['class'=>'btn btn-danger col-sm-5']) !!}

      </div>

      {!! Form::close() !!}

    </div>

    <div class="col-sm-6">


    </div>


@endsection


