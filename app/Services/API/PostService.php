<?php
namespace App\Services\API;

use App\Http\Resources\API\PostResource;
use App\Repositories\Eloquent\API\PostRepository;
use Illuminate\Support\Facades\File;

class PostService extends BaseService
{

    protected $postRepository;
    public function __construct()
    {
        $this->postRepository = new PostRepository;
    }

    public function getAll()
    {
        $result = $this->postRepository->getAllPost();
        if ($result) {
            $success = [
                'message' => 'Fetch Data Post Success',
                'posts' => PostResource::collection(($result)),
            ];
            return $success;
        }
        throw new \Exception('Error ! Fetch Data Post No Success', 1);
    }

    public function savePostData($data, $hasFile, $thumbnail)
    {

        if ($hasFile) {
            $imageName = $thumbnail->getClientOriginalName();

            $thumbnail->move('image/posts', $imageName);
            $image = 'image/posts/' . $imageName;
            $data['thumbnail'] = $image;
        }

        $result = $this->postRepository->savePostData($data);
        if ($result) {
            $success = [
                'message' => 'Create Data Post Success',
            ];
            return $success;
        }
        throw new \Exception('Error ! Create Data Post No Success', 1);
    }

    public function getById($id)
    {
        $posts = $this->postRepository->getAllPost();
        $dataId = [];
        foreach ($posts as $post) {
            $dataId[] = $post->id;
        }
        if (in_array($id, $dataId)) {
            $result = $this->postRepository->getById($id);
            if ($result) {
                $success = [
                    'message' => 'Fetch Data Post Success',
                    'user' => new PostResource($result),
                ];
                return $success;
            }
            throw new \Exception('Error ! Fetch Data Post No Success', 1);
        }
        throw new \Exception('Error ! No find Post', 1);

    }

    public function update($data, $id, $hasFile, $thumbnail)
    {

        if ($hasFile) {

            $imageName = $thumbnail->getClientOriginalName();

            $thumbnail->move('image/posts', $imageName);
            $image = 'image/posts/' . $imageName;
            $data['thumbnail'] = $image;

        }
        $posts = $this->postRepository->getAllPost();
        $dataId = [];
        foreach ($posts as $post) {
            $dataId[] = $post->id;
        }
        if (in_array($id, $dataId)) {
            $post = $this->postRepository->getById($id);
            if (!empty($thumbnail)) {
                if (File::exists(public_path($post->thumbnail))) {
                    unlink($post->thumbnail);
                }
            }
            $result = $this->postRepository->update($data, $id);
            if ($result) {
                $success = [
                    'message' => 'Update Data Post Success',
                ];
                return $success;
            }
            throw new \Exception('Error ! Update Data Post No Success', 1);
        }
        throw new \Exception('Error ! No find Post', 1);
    }

    public function delete($id)
    {
        $posts = $this->postRepository->getAllPost();
        $dataId = [];
        foreach ($posts as $post) {
            $dataId[] = $post->id;
        }
        if (in_array($id, $dataId)) {
            $result = $this->postRepository->delete($id);
            if ($result) {
                $success = [
                    'message' => 'Success ! Delete Data Post Success',
                ];
                return $success;
            }
            throw new \Exception('Error ! Delete Data Post No Success', 1);
        }
        throw new \Exception('Error ! No find Post', 1);
    }

}
