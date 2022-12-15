<?php
namespace App\Repositories\Eloquent\API;

use App\Models\MultipleImagePost;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostRepository extends BaseRepository
{

    protected $post;
    protected $multipleImagePost;

    public function __construct()
    {
        $this->post = new Post();
        $this->multipleImagePost = new MultipleImagePost();
    }

    /**
     * Summary of getAllPost
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllPost()
    {
        return $this->post->all();
    }

    /**
     * Summary of savePostData
     * @param mixed $data
     * @return mixed
     */
    public function savePostData($data)
    {
        return $this->post->create($data);
    }

    /**
     * Summary of getById
     * @param mixed $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->post->where('id',$id)->first();
    }

    /**
     * Summary of updatePost
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
     * Summary of deletePost
     * @param mixed $user
     * @return mixed
     */
    public function deletePost($user)
    {
        return $user = $this->post->find($user)
        ->delete();
    }

    /**
     * Summary of saveMultipleImagePost
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
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Update Data User Success');
        }
    }
}
