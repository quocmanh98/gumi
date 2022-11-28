<?php
namespace App\Repositories\Eloquent\API;

use App\Models\MultipleImagePost;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostRepository extends BaseRepository
{

    protected $post,$multipleImagePost;

    public function __construct()
    {
        $this->post = new Post();
        $this->multipleImagePost = new MultipleImagePost();
    }

    public function getAllPost(){
        return $this->post->all();
    }

    public function savePostData($data){
        return $this->post->create($data);
    }

    public function getById($id){
        return $this->post->where('id',$id)->first();
    }

    public function update($data,$user){
        return $this->post->find($user)
        ->update($data);
    }
    public function delete($user){
        return $user = $this->post->find($user)
        ->delete();
    }

    public function saveMultipleImagePost($data){
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
