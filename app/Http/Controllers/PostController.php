<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditPostRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostsResource;
use App\Models\Post;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PostsResource::collection(
            Post::where('user_id', Auth::user()->id)->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();

        $post = Post::create($data);

        return new PostsResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return $this->isNotAuthorized($post) ? $this->isNotAuthorized($post) : new PostsResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(EditPostRequest $request, Post $post)
    {
        $post->update($request->validated());

        return new PostsResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if ($this->isNotAuthorized($post)) {
            return $this->isNotAuthorized($post);
        }
        $post->delete();
        return $this->success([], 'Record deleted successfully');
    }
}
