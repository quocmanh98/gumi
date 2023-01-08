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
     * Xử lý lấy danh sách post
     * @throws \Exception
     * @return array
     */
    public function getPostAll()
    {
        $result = $this->postRepository->getPostAll();
        if (!$result) {
            throw new \Exception('Error ! Fetch Data Post No Success', 1);
        }

        $success = [
            'message' => 'Fetch Data Post Success',
            'posts' => PostResource::collection(($result)),
        ];
        return $success;
    }

    /**
     * Xử lý thêm bài viết
     * @param mixed $data
     * @param mixed $hasFile
     * @param mixed $thumbnail
     * @throws \Exception
     * @return array<string>
     */
    public function handleSavePostData($data, $hasFile, $thumbnail)
    {
        if ($hasFile) {
            $imageName = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move('image/posts', $imageName);
            $image = 'image/posts/' . $imageName;
            $data['thumbnail'] = $image;
        }

        $result = $this->postRepository->savePostData($data);
        if (!$result) {
            throw new \Exception('Error ! Create Data Post No Success', 1);
        }
        $success = [
            'post_id' => $result,
            'message' => 'Create Data Post Success',
        ];
        return $success;
    }

    /**
     * Xử lý lây chi tiêt post
     * @param int $id
     * @throws \Exception
     * @return array
     */
    public function getById($id)
    {
        $result = $this->postRepository->getById($id);
        if (!$result) {
            throw new \Exception('Error ! Fetch Data Post No Success', 1);
        }

        $success = [
            'message' => 'Fetch Data Post Success',
            'post' => new PostResource($result),
        ];
        return $success;
    }

    /**
     * Xử lý cập nhật thông tin post
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

        $post = $this->postRepository->getById($id);
        if (!empty($thumbnail)) {
            if ($post->thumbnail) {
                if (File::exists(public_path($post->thumbnail))) {
                    unlink($post->thumbnail);
                }
            }
        }

        $result = $this->postRepository->updatePost($data, $id);
        if (!$result) {
            throw new \Exception('Error ! Update Data Post No Success', 1);
        }
        $success = [
            'message' => 'Update Data Post Success',
        ];
        return $success;
    }

    /**
     * Xử lý xóa thông tin bài post
     * @param mixed $id
     * @throws \Exception
     * @return array<string>
     */
    public function handleDeletePost($id)
    {
        $posts = $this->postRepository->getPostAll();
        $dataId = [];
        foreach ($posts as $post) {
            $dataId[] = $post->id;
        }

        if (!in_array($id, $dataId)) {
            throw new \Exception('Error ! No find Post', 1);
        }

        $result = $this->postRepository->deletePost($id);
        if (!$result) {
            throw new \Exception('Error ! Delete Data Post No Success', 1);
        }

        $success = [
            'message' => 'Success ! Delete Data Post Success',
        ];
        return $success;

    }

    /**
     * Xử lý upload nhiều ảnh bài post
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
                $name = time() . rand(1, 99) . '.' . $image->getClientOriginalExtension();
                $image->move('image/multi/posts', $name);
                $pathImage = 'image/multi/posts/' . $name;

                $data = [
                    'name' => $name,
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
            throw new \Exception('Error ! Upload Multiple Image Post No Success', 1);

        }

        $success = [
            'message' => 'Success ! Upload Multiple Image Post Success',
        ];
        return $success;
    }

    /**
     * Xóa nhiều hình ảnh của post
     * @param mixed $data
     * @throws \Exception
     * @return array<string>
     */
    public function handleDeleteImageAll($data)
    {
        $postData = $this->postRepository->verifyPostId($data['post_id']);
        if ($postData->count() <= 0) {
            throw new \Exception('Error ! No find ', 1);
        }

        foreach ($postData as $v) {
            if (File::exists(public_path($v->path))) {
                unlink($v->path);
            }
        }

        $this->postRepository->deleteImageAll($data['post_id']);
        $success = [
            'message' => 'Success ! Delete Images Post Success',
        ];
        return $success;
    }

}
