@extends('layouts.default')

@section('content')
<h1>Add New Tag</h1>
<hr />

{!! Form::open(['action' => 'TagsController@store', 'method' => 'POST']) !!}
    <div class="form-group">
        {{ Form::label('Tag') }}
        {{ Form::text('tag', '', ['class' => 'form-control', 'placeholder' => 'Enter Tag Name']) }}
    </div>
    <div class="form-group">
        {{ Form::submit('Save', ['class' => 'btn btn-primary float-right']) }}
    </div>
{!! Form::close () !!}
@endsection
