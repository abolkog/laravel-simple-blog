<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Post;
use App\Http\Resources\PostResource;

class PostsController extends Controller
{

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'DESC')->paginate(10);
        return PostResource::collection($posts);
    }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
        $request->validate([
            'title' => 'bail|required|min:3',
            'body' => 'required'
        ]);
    
        $post = new Post();
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $now = date('YmdHis');
        $post->slug = str_slug($post->title) . '-' . $now;
        $post->user_id = auth('api')->user()->id;
        
        $post->save();

        return new PostResource($post);

    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug',$slug)->firstOrFail();

        return new PostResource($post);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'bail|required|min:3',
            'body' => 'required'
        ]);

        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');

        $userId = auth('api')->user()->id;
        if ($post->user_id !== $userId ) {
            return response()->json(['error' => 'This is not your post'], 401);
        }
        $post->save();

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        
        $userId = auth('api')->user()->id;
        if ($post->user_id !== $userId ) {
            return response()->json(['error' => 'This is not your post'], 401);
        }

        $post->delete();

        return response()->json(null, 204);

    }
}
