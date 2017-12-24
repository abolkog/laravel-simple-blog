@extends('layouts.default')

@section('content')
<h1>Edit {{ $post->title }}</h1>
<hr />

{!! Form::open(['action'=> ['PostsController@update', $post->id ], 'method'=>'POST' ])  !!}

    {{ Form::hidden('_method', 'PUT') }}
    
    <div class="form-group">
        {{ Form::label('Title') }}
        {{ Form::text('title', $post->title, [ 'placeholder'=>'Enter Post Title', 'class'=>'form-control' ]) }}
    </div>

    <div class="form-group">
        {{ Form::label('Body') }}
        {{ Form::textarea('body', $post->body , [ 'placeholder'=>'Enter Post Body', 'class'=>'form-control ckeditor' ]) }}
    </div>

    <div class="form-group pull-right">
        {{ Form::submit('Update', ['class'=>'btn btn-primary']) }}
    </div>

{!! Form::close()  !!}

@endsection