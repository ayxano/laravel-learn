<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePost;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
Use App\Http\Resources\Post as PostResource;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['store']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BlogPost $post, Request $request)
    {
        $perPage = (int)$request->input('per_page', 1);
        return PostResource::collection(
            $post::paginate($perPage)
            ->appends([
                'name' => 'aykhan'
            ]) // add parameters to pagination URLs
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogPost $post,StorePost $request)
    {
        $validated  =   $request->validated();
        $post       =   BlogPost::create($validated);
        $user       =   Auth::user();
        return new PostResource($post);
        return [
            'post' => $post,
            'user' => $user
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BlogPost $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogPost $post, StorePost $request)
    {
        $this->authorize('update');
        $validated  =   $request->validated();
        $post->fill($validated);
        $post->save();
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogPost $post)
    {
        $post->delete();
        return response()->noContent();
    }
}
