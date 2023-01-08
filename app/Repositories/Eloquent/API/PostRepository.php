<?php
namespace App\Repositories\Eloquent\API;

use App\Models\ImagePost;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostRepository extends BaseRepository
{

    protected $post;
    protected $multipleImagePost;

    public function __construct()
    {
        $this->post = new Post();
        $this->multipleImagePost = new ImagePost();
    }

    /**
     * Lấy danh sách post từ db
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPostAll()
    {
        return $this->post->all();
    }

    /**
     * Lưu thông tin post
     * @param mixed $data
     * @return mixed
     */
    public function savePostData($data)
    {
        return $this->post->create($data)->id;
    }

    /**
     * Lấy thông tin chi tiết post từ db
     * @param mixed $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->post->where('id', $id)->first();
    }

    /**
     * Cập nhật Post từ đb
     * @param mixed $data
     * @param mixed $user
     * @return mixed
     */
    public function updatePost($data, $user)
    {
        return $this->post->find($user)
            ->update($data);
    }

    /**
     * Xóa bài post
     * @param mixed $user
     * @return mixed
     */
    public function deletePost($user)
    {
        return $user = $this->post->find($user)
            ->delete();
    }

    /**
     * Lưu nhiều hình ảnh của post
     * @param mixed $data
     * @throws \Exception
     * @return void
     */
    public function saveMultipleImagePost($data)
    {
        DB::beginTransaction();

        try {
            $this->multipleImagePost->create($data);
            DB::commit();
        } catch (\Exception$e) {
            DB::rollBack();
            throw new \Exception('Update Data User Success');
        }
    }

    /**
     * Kiểm tra nhiều ảnh có thuôc 1 bài post
     * @param mixed $postId
     * @return mixed
     */
    public function verifyPostId($postId)
    {
        return $this->multipleImagePost->where('post_id', $postId)->get();
    }

    /**
     * Xóa nhiều ảnh của bài post
     * @param mixed $postId
     * @return mixed
     */
    public function deleteImageAll($postId)
    {
        return $this->multipleImagePost->where('post_id', $postId)->delete();
    }
}
