<?php
namespace App\Repositories\Eloquent\API;

use App\Models\Post;

class PostRepository extends BaseRepository
{

    protected $post;

    public function __construct()
    {
        $this->post = new Post();
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
        return $post = $this->post->find($user)
        ->update($data);
    }
    public function delete($user){
        return $user = $this->post->find($user)
        ->delete();
    }

}
