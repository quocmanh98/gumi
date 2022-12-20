<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\API\PostService;
use App\Http\Requests\API\PostRequest;
use App\Http\Controllers\BaseController;
use App\Http\Requests\API\UpdatePostRequest;
use App\Http\Requests\API\MultipleImagePostRequest;

class PostController extends BaseController
{
    protected $postService;

    public function __construct()
    {
        $this->postService = new PostService;
    }

    /**
     * Danh sách post
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $this->authorize('viewAny',Post::class);
        try {
            $data = $this->postService->getPostAll();
            return $this->sendSuccess($data);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    /**
     * Thêm bài viết
     * @param PostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PostRequest $request)
    {
        $this->authorize('create',Post::class);
        $data = $request->all();
        $hasFile = $request->hasFile('thumbnail');
        $thumbnail = $request->file('thumbnail');

        try {
            $result = $this->postService->handleSavePostData($data, $hasFile, $thumbnail);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    /**
     * Thông tin chi tiết post
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Post $postId)
    {
        $this->authorize('view', $postId);
        try {
            $post = $this->postService->getById($postId->id);
            return $this->sendSuccess($post);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    /**
     * Cập nhật post
     * @param UpdatePostRequest $request
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePostRequest $request, Post $postId)
    {
        $this->authorize('update', $postId);
        $hasFile = $request->hasFile('thumbnail');
        $thumbnail = $request->file('thumbnail');
        $data = $request->all();

        try {
            $result = $this->postService->handleUpdatePost($data, $postId->id, $hasFile, $thumbnail);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    /**
     * Xóa post
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $postId)
    {
        $this->authorize('delete', $postId);
        try {
            $result = $this->postService->handleDeletePost($postId->id);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }


    /**
     * Upload nhiều ảnh của post
     * @param MultipleImagePostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(MultipleImagePostRequest $request)
    {
        $this->authorize('create',Post::class);
        $images = $request->file('image');
        $postId = $request->input('post_id');

        try {
            $result =  $this->postService->handleUploadMultipleImagePost($images, $postId);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    /**
     * Xóa tất cả hình ảnh của post
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAllImage(Request $request){
        $data = $request->all();
        try {
            $result =  $this->postService->handleDeleteImageAll($data);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }
}
