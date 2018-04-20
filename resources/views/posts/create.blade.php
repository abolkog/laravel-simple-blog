@extends('layouts.default')

@section('content')
<h1>Add New Post</h1>
<hr />

{!! Form::open(['action'=> 'PostsController@store', 'method'=>'POST', 'files'=>true ])  !!}
    
    <div class="form-group">
        {{ Form::label('Title') }}
        {{ Form::text('title', '', [ 'placeholder'=>'Enter Post Title', 'class'=>'form-control' ]) }}
    </div>

    <div class="form-group">
        {{ Form::label('Body') }}
        {{ Form::textarea('body', '', [ 'placeholder'=>'Enter Post Title', 'class'=>'form-control ckeditor' ]) }}
    </div>

    <div class="form-group">
        {{ Form::label('Tags') }}
        <select name="tags[]" class="form-control tags" multiple>
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}">{{  $tag->tag }} </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        {{ Form::label('Featured Image') }}
        {{ Form::file('photo', ['class'=>'form-control' ]) }}
    </div>

    <div class="form-group pull-right">
        {{ Form::submit('Save', ['class'=>'btn btn-primary']) }}
    </div>

{!! Form::close()  !!}

@endsection


@section('javascript')
<script type="text/javascript">
$(document).ready(function() {
    $('.tags').select2();
});
</script>
@endsection