@extends('layouts.default')

@section('content')
    <h1>{{ $post->title }} </h1>
  
    @if(!Auth::guest() && (Auth::user()->id  == $post->user_id) )
    <div class="clearfix">
        <a href="/posts/{{ $post->id }}/edit" class="btn btn-default">
            <i class='fas fa-edit'></i> Edit Post
        </a>

        <div class="pull-right">
            {!! Form::open(['action'=>['PostsController@destroy', $post->id], 'method'=>'POST' ]) !!}
                {{ Form::hidden('_method', 'DELETE') }}
                <button class="btn btn-danger" type="submit">
                    <i class="fas fa-trash"></i> Delete Post
                </button>

            {!! Form::close() !!}
        </div>
    </div>
    @endif

    <hr />
    <div>
        {!! $post->body !!}
    </div>
@endsection