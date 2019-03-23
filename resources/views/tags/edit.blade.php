@extends('layouts.default')

@section('content')
<h1>Edit {{ $tag->tag }}</h1>
<hr />

{!! Form::open(['action' => ['TagsController@update', $tag->id], 'method' => 'POST']) !!}
    {{ Form::hidden('_method', 'PUT') }}
    <div class="form-group">
        {{ Form::label('Tag') }}
        {{ Form::text('tag', $tag->tag, ['class' => 'form-control', 'placeholder' => 'Enter Tag Name']) }}
    </div>
    
    <div class="form-group">
        {{ Form::submit('Update', ['class' => 'btn btn-primary float-right']) }}
    </div>
{!! Form::close () !!}
@endsection
