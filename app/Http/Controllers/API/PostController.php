<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Requests\API\PostRequest;
use App\Http\Requests\API\UpdatePostRequest;
use App\Models\Post;
use App\Services\API\PostService;

class PostController extends BaseController
{
    protected $postService;

    public function __construct()
    {
        $this->postService = new PostService;
    }

    public function index()
    {
        try {
            $data = $this->postService->getAllPost();
            return $this->sendSuccess($data);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    public function store(PostRequest $request)
    {
        $data = $request->all();
        $hasFile = $request->hasFile('thumbnail');
        $thumbnail = $request->file('thumbnail');

        try {
            $result = $this->postService->handleSavePostData($data,$hasFile,$thumbnail);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    public function show(Post $post)
    {
        $this->authorize('view',$post);
        try {
            $post = $this->postService->getById($post->id);
            return $this->sendSuccess($post);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    public function update(UpdatePostRequest $request,Post $post)
    {
        $this->authorize('update',$post);
        $hasFile = $request->hasFile('thumbnail');
        $thumbnail = $request->file('thumbnail');
        $data = $request->all();

        try {
            $result = $this->postService->handleUpdatePost($data,$post->id,$hasFile,$thumbnail);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete',$post);
        try {
            $result = $this->postService->handleDeletePost($post->id);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }
}
