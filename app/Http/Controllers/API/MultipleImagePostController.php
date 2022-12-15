<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Requests\API\MultipleImagePostRequest;
use App\Services\API\PostService;

class MultipleImagePostController extends BaseController
{
    protected $postService;

    public function __construct()
    {
        $this->postService = new PostService;
    }

    /**
     * Summary of store
     * @param MultipleImagePostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MultipleImagePostRequest $request)
    {
        $images = $request->file('image');
        $postId = $request->input('post_id');

        try {
            $result =  $this->postService->handleUploadMultipleImagePost($images, $postId);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }
}
