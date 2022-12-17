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
     * Lấy danh sách user
     * kèm theo lọc theo các tiêu chí khác nhau
     * @param mixed $filters
     * @param mixed $search
     * @param mixed $sortArr
     * @param mixed $perPage
     * @return mixed
     */
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

    /**
     * lưu thông tin user vào db
     * @param array $data
     * @return mixed
     */
    public function saveUserData(array $data)
    {
        return $this->user->create($data)->id;
    }

    /**
     * lấy thông tin chi tiêt user
     * @param int $user
     * @return mixed
     */
    public function getById(int $user)
    {
        return $this->user->where('id', $user)->first();
    }

    /**
     * Cập nhật thông tin user vào db
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
     * Xóa tạm thời user vào db
     * @param mixed $user
     * @return mixed
     */
    public function deleteUser($user)
    {
        return $user = $this->user->find($user)
        ->delete();
    }

    /**
     * Lấy danh sách user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllData()
    {
        return $this->user->all();
    }

    /**
     * Xóa tạm thời user
     * @param mixed $listCheck
     * @return int
     */
    public function userDestroy($listCheck)
    {
        return $this->user->destroy($listCheck);
    }

    /**
     * Khôi phục dữ liệu user
     * @param mixed $listCheck
     * @return mixed
     */
    public function userRestoreTrashed($listCheck)
    {
        return $this->user->withTrashed()->whereIn('id', $listCheck)->restore();
    }

    /**
     *  Xóa vĩnh viễn user
     * @param mixed $listCheck
     * @return mixed
     */
    public function userForceDelete($listCheck)
    {
        return $this->user->withTrashed()->whereIn('id', $listCheck)->forceDelete();
    }


}
