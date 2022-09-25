<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;

class PostJsonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index(Request $request)
    {
        return PostResource::collection(
            Post::query()->latest()->paginate($request->query('per_page', 16))
        );
    }

    public function store(PostRequest $request)
    {
        return PostResource::make(
            Post::create($request->getData())
        );
    }

    public function show(Post $post)
    {
        return PostResource::make($post);
    }

    public function update(Post $post, PostRequest $request)
    {
        $post->update($request->getData());

        return PostResource::make($post);
    }

    public function destroy(Post $post)
    {
        if (Storage::exists($post->thumbnail)) {
            Storage::delete($post->thumbnail);
        }

        $post->delete();

        return response()->json([
            'message' => __('Successfully delete post'),
        ]);
    }
}
