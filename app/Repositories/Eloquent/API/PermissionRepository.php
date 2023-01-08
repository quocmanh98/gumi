<?php
namespace App\Repositories\Eloquent\API;

use App\Models\Permission;

class PermissionRepository
{
    protected $permission;

    public function __construct()
    {
        $this->permission = new Permission;
    }

    /**
     * Lấy tất cả bản ghi quyền có phân trang
     * @return mixed
     */
    public function getList()
    {
        return $this->permission->latest()->paginate(5);
    }

    /**
     * Lưu thông tin quyền vào database
     * @param array $dataInput
     * @return mixed
     */
    public function savePermission(array $dataInput)
    {
        return $this->permission->create($dataInput)->id;
    }

    /**
     * Cập nhật thông tin quyền vào database
     * @param mixed $id
     * @param mixed $name
     * @param mixed $description
     * @param mixed $groupPermissionId
     * @return mixed
     */
    public function updatePermission($id, $name, $groupPermissionId)
    {
        return $this->permission->findOrFail($id)
        ->update(['name' => $name, 'group_permission_id' => $groupPermissionId]);
    }

    /**
     * Lấy bản ghi cụ thể của quyền
     * @param mixed $id
     * @return mixed
     */
    public function getId($id)
    {
        return $this->permission->findOrFail($id);
    }

    /**
     * Xóa quyền vào database
     * @param mixed $id
     * @return mixed
     */
    public function deletePermission($id)
    {
        return $this->permission->findOrFail($id)->delete();
    }
}
