<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Post;
use App\Tag;
use Image;

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
        $tags = Tag::all();
        return view('posts.index', compact('posts','tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $tags = Tag::all();
        return view('posts.create',compact('tags'));
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
            'body' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        //Current User
        $user = Auth::user();
        

        $post = new Post();
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $now = date('YmdHis');
        $post->slug = str_slug($post->title) . '-' . $now;
        $post->user_id = $user->id;

        //Upload the featured image if any
        if ($request->hasFile('photo')) {
            $photo = $request->photo;
            $filename = time() .'-'. $photo->getClientOriginalName();
            $location = public_path('images/posts/'.$filename);

            Image::make($photo)->resize(800, 400)->save($location);
            
            $post->photo = $filename;
        }
        
        
        $post->save();

        $post->tags()->sync($request->tags);

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

        $tags = Tag::all();
        return view('posts.edit', compact('post', 'tags'));
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
            'body' => 'required',
             'photo' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');

        //Current User Id
        $userId = Auth::id();
        if ($post->user_id !== $userId ) {
            return redirect('/posts')->with('error', 'That is not your post yaaaad!!!!');
        }
         
        //Upload the featured image if any
        if ($request->hasFile('photo')) {
            $photo = $request->photo;
            $filename = time() .'-'. $photo->getClientOriginalName();
            $location = public_path('images/posts/'.$filename);

            Image::make($photo)->resize(800, 400)->save($location);
            
            $post->photo = $filename;
        }

        $post->save();

        $post->tags()->sync($request->tags);

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
