<?php
namespace App\Services\API;

use App\Repositories\Eloquent\API\PermissionRepository;

class PermissionService
{
    protected $permissionRepository;

    public function __construct()
    {
        $this->permissionRepository = new PermissionRepository;
    }

    /**
     * Lấy danh sách quyền
     * @return mixed
     */
    public function getList()
    {
        return $this->permissionRepository->getList();
    }

    /**
     * lưu quyền
     * @param mixed $dataInput
     * @return mixed
     */
    public function savePermission($dataInput)
    {
        $id = $this->permissionRepository->savePermission($dataInput);
        $success = [
            'permission_id' => $id,
            'message' => 'Save Permission Success !',
        ];
        return $success;
    }

    /**
     * Cập nhật quyền vào database
     * @param mixed $id
     * @param mixed $name
     * @param mixed $description
     * @param mixed $groupPermissionId
     * @return mixed
     */
    public function updatePermission($id, $name, $groupPermissionId)
    {
        return $this->permissionRepository
            ->updatePermission($id, $name, $groupPermissionId);
    }


    /**
     * Lấy bản ghi cụ thể của quyền
     * @param int $id
     * @return mixed
     */
    public function getId($id)
    {
        return $this->permissionRepository->getId($id);
    }

    /**
     * Xóa quyền.
     * @param int $id
     * @return mixed
     */
    public function deletePermission($id)
    {
        return $this->permissionRepository->deletePermission($id);
    }
}

