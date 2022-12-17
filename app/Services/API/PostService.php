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

    /**
     * Summary of getAllPost
     * @throws \Exception
     * @return array
     */
    public function getAllPost()
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

    /**
     * Summary of handleSavePostData
     * @param mixed $data
     * @param mixed $hasFile
     * @param mixed $thumbnail
     * @throws \Exception
     * @return array<string>
     */
    public function handleSavePostData($data, $hasFile, $thumbnail)
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

    /**
     * Summary of getById
     * @param int $id
     * @throws \Exception
     * @return array
     */
    public function getById(int $id)
    {
        $result = $this->postRepository->getById($id);
        if ($result) {
            $success = [
                'message' => 'Fetch Data Post Success',
                'post' => new PostResource($result),
            ];
            return $success;
        }
        throw new \Exception('Error ! Fetch Data Post No Success', 1);
    }

    /**
     * Summary of handleUpdatePost
     * @param mixed $data
     * @param mixed $id
     * @param mixed $hasFile
     * @param mixed $thumbnail
     * @throws \Exception
     * @return array<string>
     */
    public function handleUpdatePost($data, $id, $hasFile, $thumbnail)
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

        if (!in_array($id, $dataId)) {
            throw new \Exception('Error ! No find Post', 1);
        }
        $post = $this->postRepository->getById($id);
        if (!empty($thumbnail)) {
            if($post->thumbnail){
                if (File::exists(public_path($post->thumbnail))) {
                    unlink($post->thumbnail);
                }
            }
        }

        $result = $this->postRepository->updatePost($data, $id);
        if ($result) {
            $success = [
                'message' => 'Update Data Post Success',
            ];
            return $success;
        }
        throw new \Exception('Error ! Update Data Post No Success', 1);

    }

    /**
     * Summary of handleDeletePost
     * @param mixed $id
     * @throws \Exception
     * @return array<string>
     */
    public function handleDeletePost($id)
    {
        $posts = $this->postRepository->getAllPost();
        $dataId = [];
        foreach ($posts as $post) {
            $dataId[] = $post->id;
        }

        if (in_array($id, $dataId)) {
            $result = $this->postRepository->deletePost($id);
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

    /**
     * Summary of handleUploadMultipleImagePost
     * @param mixed $images
     * @param mixed $postId
     * @throws \Exception
     * @return array<string>
     */
    public function handleUploadMultipleImagePost($images, $postId)
    {
        $imageErrors = [];
        try {
            foreach ($images as $image) {
                $name = time() . rand(1, 99) . '.' . $image->extension();
                $nameImage = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $image->move('image/multi/posts', $name);
                $pathImage = 'image/multi/posts' . $name;

                $data = [
                    'title' => $nameImage,
                    'path' => $pathImage,
                    'post_id' => $postId,
                ];

                $imageErrors[] = $pathImage;
                $this->postRepository->saveMultipleImagePost($data);
            }
        } catch (\Exception$e) {
            foreach ($imageErrors as $imageError) {
                if (File::exists(public_path($imageError))) {
                    unlink($imageError);
                }
            }
            throw new \Exception('Error !Upload Multiple Image Post No Success', 1);
        }

        $success = [
            'message' => 'Success ! Upload Multiple Image Post Success',
        ];
        return $success;
    }

}
