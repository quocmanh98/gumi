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

    /**
     * Summary of getAllUser
     * @param mixed $filters
     * @param mixed $search
     * @param mixed $sortArr
     * @param mixed $perPage
     * @return mixed
     */
    public function getAllUser($filters = [], $search = null, $sortArr = null, $perPage = null)
    {
        $users = $this->user
            ->select('users.*');
            // ->join('roles', 'users.role_id', '=', 'roles.id');

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

    /**
     * Summary of saveUserData
     * @param array $data
     * @return mixed
     */
    public function saveUserData(array $data)
    {
        return $this->user->insertGetId($data);
    }

    /**
     * Summary of getById
     * @param int $user
     * @return mixed
     */
    public function getById(int $user)
    {
        return $this->user->where('id', $user)->first();
    }

    /**
     * Summary of updateUser
     * @param mixed $data
     * @param mixed $user
     * @return mixed
     */
    public function updateUser($data, $user)
    {
        return $user = $this->user->find($user)
        ->update($data);
    }

    /**
     * Summary of deleteUser
     * @param mixed $user
     * @return mixed
     */
    public function deleteUser($user)
    {
        return $user = $this->user->find($user)
        ->delete();
    }

    /**
     * Summary of getAllData
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllData()
    {
        return $this->user->all();
    }

    
}
