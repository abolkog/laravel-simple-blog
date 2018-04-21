@extends('layouts.default')

@section('content')
    
    <h2>Posts Tagged {{ $tag->tag }}</h2>

    <div class="row">    
        <!-- S:Main -->
        <div class="col-md-8 posts">
            @foreach($tag->posts as $post)
            <!-- Blog Post -->
            <div class="card mb-4">
                <img class="img-responsive" src="{{ asset('images/posts/'.$post->photo) }}" alt="Card image cap">
                <div class="card-body">
                    <h2 class="card-title"> <a href="/posts/{{$post->slug}}">{{ $post->title }}</a></h2>
                    <div class="meta">
                        <span class="label label-info"><i class='fas fa-calendar'></i> {{ $post->created_at->format('d M, Y') }}</span>
                        &nbsp
                        <span class="label label-primary"><i class='fas fa-user'></i> {{ $post->user->name }}</span>
                    </div>
                    <div class="card-text">
                        {{str_limit(strip_tags($post->body), 500 )  }}
                    </div>
                    <a class="btn btn-primary btn-xs" href="/posts/{{$post->slug}}">Read More</a>
                </div>
            </div>
            @endforeach
        </div>
        <!-- E:Main -->

        <!-- S:Sidebar -->
        <div class="col-md-4">TODO:Side bar</div>
        <!-- E:Sidebar -->
    </div>



@endsection