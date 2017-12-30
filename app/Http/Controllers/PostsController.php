<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Post;

class PostsController extends Controller
{

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Every request need to be authneticated
        // $this->middleware('auth');

        //Only
        // $this->middleware('auth',[ 'only'=> ['show'] ]);

        //Except
         $this->middleware('auth',[ 'except'=> ['index','show'] ]);

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $posts = Post::orderBy('created_at', 'DESC')->get();

        $posts = Post::orderBy('created_at', 'DESC')->paginate(10);

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Access request data
        // $postTitle = $request->input('title');
        // return $postTitle;

        //Simple Validation
        $request->validate([
            'title' => 'bail|required|min:3',
            'body' => 'required'
        ]);

        //Current User
        $user = Auth::user();
        

        $post = new Post();
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $now = date('YmdHis');
        $post->slug = str_replace(' ', '-', strtolower($post->title)).'-'.$now;
        $post->user_id = $user->id;
        $post->save();

        return redirect('/posts')->with('success','Post Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        //
        $post = Post::where('slug',$slug)->first();

        return view('posts.show', compact('post'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = Post::find($id);

        //Current User Id
        $userId = Auth::id();
        if ($post->user_id !== $userId ) {
            return redirect('/posts')->with('error', 'That is not your post yaaaad!!!!');
        }

        return view('posts.edit', compact('post'));
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
        //
        $request->validate([
            'title' => 'bail|required|min:3',
            'body' => 'required'
        ]);

        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');

        //Current User Id
        $userId = Auth::id();
        if ($post->user_id !== $userId ) {
            return redirect('/posts')->with('error', 'That is not your post yaaaad!!!!');
        }

        $post->save();

        return redirect('/posts/'.$post->slug)->with('success','Post Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Post::find($id);
        
        //Current User Id
        $userId = Auth::id();
        if ($post->user_id !== $userId ) {
            return redirect('/posts')->with('error', 'That is not your post yaaaad!!!!');
        }


        $post->delete();

        return redirect('/posts')->with('success','Post Deleted Successfully');

    }
}
