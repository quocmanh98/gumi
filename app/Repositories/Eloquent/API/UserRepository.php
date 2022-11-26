<?php
namespace App\Repositories\Eloquent\API;

use App\Models\User;

class UserRepository extends BaseRepository
{

    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function getAllUser($filters = [], $search = null, $sortArr = null, $perPage = null)
    {
        $users = $this->user
            ->select('users.*', 'roles.name as role_name')
            ->join('roles', 'users.role_id', '=', 'roles.id');

        $orderBy = 'users.created_at';
        $orderType = 'desc';

        if (!empty($sortArr) && is_array($sortArr)) {
            if (!empty($sortArr['sortBy']) && !empty($sortArr['sortType'])) {
                $orderBy = trim($sortArr['sortBy']);
                $orderType = trim($sortArr['sortType']);
            }
        }

        $users = $users->orderBy($orderBy, $orderType);

        if (!empty($filters)) {
            $users = $users->where($filters);
        }

        if (!empty($search)) {
            $users = $users->where(function ($query) use ($search) {
                $query->orWhere('users.email', 'like', "%{$search}%")
                    ->orWhere('users.username', 'like', "%{$search}%");
            });
        }

        if (!empty($perPage)) {
            $users = $users->paginate($perPage);
        } else {
            $users = $users->get();
        }

        return $users;
    }

    public function saveUserData($data){
        return $this->user->create($data);
    }

    public function getById($user){
        return $this->user->where('id',$user)->first();
    }

    public function update($data,$user){
        return $user = $this->user->find($user)
        ->update($data);
    }

    public function delete($user){
        return $user = $this->user->find($user)
        ->delete();
    }

    public function getAllData(){
        return $this->user->all();
    }
}
