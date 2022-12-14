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

    public function store(MultipleImagePostRequest $request)
    {
        $images = $request->file('image');
        $post_id = $request->input('post_id');

        try {
            $result =  $this->postService->handleUploadMultipleImagePost($images, $post_id);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }
}
