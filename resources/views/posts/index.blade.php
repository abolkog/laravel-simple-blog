@extends('layouts.default')

@section('content')
    @if($posts->count() > 0 )
        @foreach($posts as $post)
            <div class="panel">
                <div class="panel-heading">
                    <h3>{{ $post->title }}</h3>
                </div>

                <div class="panel-body">
                    {{ $post->body }}
                </div>
            </div>
        @endforeach
        {{ $posts->links() }}
    @else
        <div class="alert alert-info">
            <strong>Ops</strong> No Posts
        </div>
    @endif

@endsection