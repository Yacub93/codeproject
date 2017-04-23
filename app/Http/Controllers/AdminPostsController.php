<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Http\Requests\PostsCreateRequest;
use Illuminate\Support\Facades\Session;
use App\Post;
use App\Photo;
use App\Category;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        // $posts = Post::all();
        $posts = Post::paginate(2); //show the first 2 posts


       return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::lists('name','id')->all();

        return view('admin.posts.create', compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsCreateRequest $request)
    {
        //
        $input = $request->all();

        $user = Auth::user();// logged in user

        if ($file = $request->file('photo_id')) {
            
            $name = time(). $file->getClientOriginalName();

            $file->move('images', $name);

            $photo = Photo::create(['file'=>$name]);

            $input['photo_id'] = $photo->id;

            // return "Image file: " . $file;
        }


        $user->posts()->create($input);

        return redirect('/admin/posts');

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $post = Post::findOrFail($id);

        $categories = Category::lists('name', 'id');

        return view('admin.posts.edit', compact('post','categories'));
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
        $input = $request->all();

        //NOTE: code below should be in a method 
        //and then called through if condition
        if ($file = $request->file('photo_id')) {
            
            $name = time(). $file->getClientOriginalName();

            $file->move('images', $name);

            $photo = Photo::create(['file'=>$name]);

            $input['photo_id'] = $photo->id;

        }
        # Find first Post for user logged in 
        # and where id matches, then update
        Auth::user()->posts()->whereId($id)->first()->update($input);

        return redirect('/admin/posts');
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
        $post = Post::findOrFail($id);

        unlink(public_path() . $post->photo->file);

        $post->delete();

        Session::flash('Deleted Post', 'The post has been deleted!');

        return redirect('/admin/posts');
    }


    public function post($slug)
    {
        $post = Post::findBySlugOrFail($slug);

        $comments = $post->comments()->whereIsActive(1)->get();
                // return view('post', compact('post'));


        return view('post', compact('post', 'comments'));
      
    }
}
