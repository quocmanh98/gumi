<?php
namespace App\Repositories\Eloquent\API;

use App\Models\GroupPermission;

class GroupPermissionRepository
{
    protected $groupPermission;

    public function __construct()
    {
        $this->groupPermission = new GroupPermission();
    }

    /**
     * Lấy tất cả bản ghi nhóm quyền
     * @return mixed
     */
    public function getAll()
    {
        return $this->groupPermission->get();
    }

    /**
     * Lấy tất cả bản ghi nhóm quyền có phân trang
     * @return mixed
     */
    public function getList()
    {
        return $this->groupPermission->latest()->paginate(5);
    }

    /**
     * Lưu thông tin nhóm quyền vào database
     * @param array $dataInput
     * @return mixed
     */
    public function saveGroupPermission(array $dataInput)
    {
        return $this->groupPermission->create($dataInput)->id;
    }

    /**
     * Cập nhật thông tin nhóm quyền vào database
     * @param int $id
     * @param mixed $name
     * @param mixed $description
     * @return mixed
     */
    public function updateGroupPermissionInfo($id, $name)
    {
        return $this->groupPermission->findOrFail($id)
            ->update(['name' => $name]);
    }

    /**
     * Lấy thông tin cụ thể của nhóm quyền
     * @param int $id
     * @return mixed
     */
    public function getId($id)
    {
        return $this->groupPermission->findOrFail($id);
    }

    /**
     * Xóa bản ghi cụ thể nhóm quyền
     * @param mixed $id
     * @return mixed
     */
    public function deleteGroupPermissionInfo($id)
    {
        return $this->groupPermission->findOrFail($id)->delete();
    }
}
