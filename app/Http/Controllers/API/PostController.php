<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Requests\API\PostRequest;
use App\Http\Requests\API\UpdatePostRequest;
use App\Models\Post;
use App\Services\API\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends BaseController
{
    protected $postService;

    public function __construct()
    {
        $this->postService = new PostService;
    }

    public function index(Request $request){
        try {
            $data = $this->postService->getAll();
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
            $result = $this->postService->savePostData($data,$hasFile,$thumbnail);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    public function show(Post $post)
    {
        if (Auth::user()->can('view', $post)) {
            try {
                $post = $this->postService->getById($post->id);
                return $this->sendSuccess($post);
            } catch (\Exception$e) {
                return $this->sendError(null, $e->getMessage());
            }
        }
        return $this->sendError(null, 'Prohibited Access');
    }

    public function update(UpdatePostRequest $request,$id){
        $hasFile = $request->hasFile('thumbnail');
        $thumbnail = $request->file('thumbnail');
        $data = $request->all();
        try {
            $result = $this->postService->update($data,$id,$hasFile,$thumbnail);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $result = $this->postService->delete($id);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }
}
