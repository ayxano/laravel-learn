<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Jobs\NotifyMailPostAdded;
use App\Jobs\ThrottledMail;
use App\Mail\PostAdded;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
Use App\Http\Resources\Post as PostResource;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          return PostResource::collection(BlogPost::all());
    //    return view('posts.index', ['posts' => BlogPost::all()]);
    //    return view('posts.index', ['posts' => BlogPost::orderBy('created_at', 'desc')->take(2)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        $validated  =   $request->validated();
        $post       =   BlogPost::create($validated);
        /* Commented this block to make code more
        $post = new BlogPost();
        $post->title    = $validated['title'];
        $post->content  = $validated['content'];
        $post->save();
        */

        $when = now()->addMinutes(1);

        // Removed ShouldQueue implemention from PostAdded mail, 
        // let's decide if this should be queue or not from controller
        // Mail::to('ayxano@gmail.com')->queue(
        //     new PostAdded($post)
        // );

        ThrottledMail::dispatch(new PostAdded($post), $post); // custom rate limited job

        NotifyMailPostAdded::dispatch($post); // custom job



        $request->session()->flash('status', 'Created on DB!');

        return redirect()->route('posts.show', ['post' => $post->id ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // abort_if(!isset($this->posts[$id]), 404);
        return view('posts.show', [
            'post' => BlogPost::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('posts.edit', ['post' => BlogPost::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);
        $validated = $request->validated();
        $post->fill($validated);
        $post->save();

        $request->session()->flash('status', 'Blog post was updated!');
        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $post = BlogPost::findOrFail($id);
        $post->delete();
        $request->session()->flash('status', 'Deleted from DB!');
        return redirect()->route('posts.index');
    }
}
