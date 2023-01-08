<?php
namespace App\Repositories\Eloquent\API;

use App\Models\Role;

class RoleRepository
{
    protected $role;

    public function __construct()
    {
        $this->role = new Role();
    }

    /**
     * Tìm kiếm vai trò có phân trang
     * @param mixed $search
     * @return mixed
     */
    public function getSearchRole($search)
    {
        return $this->role
            ->where('name', 'like', "%{$search}%")
            ->latest()->paginate(5);
    }

    /**
     * Thêm vai trò
     * @param mixed $dataRole
     * @return mixed
     */
    public function addRole($dataRole)
    {
        return $this->role->create($dataRole)->id;
    }

    /**
     * Lấy thông tin chi tiêt vai trò
     * @param int $role
     * @return mixed
     */
    public function getRoleId($role)
    {
        $result = $this->role->where('id', $role)->exists();
        if($result){
            return $this->role->findOrFail($role)->first();
        }
        throw new \Exception('Find role fail');
    }

    /**
     * Cập nhật thông tin vai trò
     * @param mixed $role
     * @param mixed $name
     * @param mixed $description
     * @return mixed
     */
    public function updateRoleInfo($role, $name, $description)
    {
        return $this->role
            ->findOrFail($role)
            ->update(['name' => $name, 'description' => $description]);
    }

    /**
     * Xóa vai trò
     * @param mixed $role
     * @return mixed
     */
    public function deleteRole($role)
    {
        return $this->role->findOrFail($role)->delete();
    }

}
