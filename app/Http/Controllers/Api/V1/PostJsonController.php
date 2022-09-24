<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;

class PostJsonController extends Controller
{
    public function index(Request $request)
    {
        return PostResource::collection(
            Post::query()->paginate(10)
        );
    }

    public function store(PostRequest $request)
    {
        return PostResource::make(
            Post::create($request->validated())
        );
    }

    public function show(Post $post)
    {
        return PostResource::make($post);
    }

    public function update(Post $post, PostRequest $request)
    {
        $post->update($request->validated());

        return PostResource::make($post);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json([
            'message' => __('Successfully delete post'),
        ]);
    }
}
