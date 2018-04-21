@extends('layouts.default')

@section('content')
    <h1>{{ $post->title }} </h1>

    <div class="row">
        <div class="col-md-8 posts">
            <div style="margin-bottom: 20px">
                <img src="{{ asset('images/posts/'.$post->photo) }}" class="img-responsive" />
            </div>
            {!! $post->body !!}

            @foreach($post->tags as $tag)
                <a href="{{ route('tags.show', $tag->id) }}">
                    <span class="label label-info">
                        <i class="fa fa-tag"></i> {{ $tag->tag }}
                    </span>
                </a>
                &nbsp;
            @endforeach

            <hr />

            <h4>Comments: {{ $post->comments->count() }}</h4>

            <!-- Comments List -->
            <ul class="comments">

                @foreach($post->comments as $comment)
                <li class="comment">
                    <div class="clearfix">
                        <h4 class="pull-left">{{ $comment->user->name }}</h4>
                        <p class="pull-right">{{ $comment->created_at->format('d M Y') }}</p>
                    </div>

                    <p>{{ $comment->body }}</p>
                </li>
                @endforeach
            </ul>
            <!-- Comments List -->
            
            <!-- Comments Form -->
            <div class="panel panel-default">
                <div class="panel-heading">Add Your Comment</div>
                <div class="panel-body">

                    @guest
                        <div class="alert alert-info">Please login to comment</div>
                    @else
                    <form action="{{ route('comments.store', $post->slug) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="Comment">Comment</label>
                            <textarea name="body" class="form-control" placeholder="Enter your comment" cols="30" rows="10"></textarea>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">Add Comment</button>
                        </div>
                    </form>
                    @endguest

                </div>
            </div>
            <!-- Comments Form -->
            
        </div>

        <div class="col-md-4">
            
            @if(!Auth::guest() && (Auth::user()->id  == $post->user_id) )
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-cog"></i> Manage</h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <a href="{{ route('posts.edit', $post->id) }}">
                                <i class="fa fa-edit"></i>Edit Post
                            </a>
                        </li>
                        <li class="list-group-item">
                             {!! Form::open(['action'=>['PostsController@destroy', $post->id], 'method'=>'POST', 'onsubmit' => "return confirm('Are you sure you want to delete this post?')"]) !!}
                                {{ Form::hidden('_method', 'DELETE') }}
                                <button type="submit">
                                    <i class="fas fa-trash"></i> Delete Post
                                </button>
                            {!! Form::close() !!}
                        </li>
                    </ul>
                </div>
            </div>
            @endif

        </div>
    </div><!-- Row -->

    
@endsection