<?php
namespace App\Services\API;

use App\Repositories\Eloquent\API\GroupPermissionRepository;

class GroupPermissionService
{
    protected $groupPermissionRepository;

    public function __construct()
    {
        $this->groupPermissionRepository = new GroupPermissionRepository;
    }

    /**
     * Xử lý lấy danh sách nhóm quyền
     * @return mixed
     */
    public function getList()
    {
        return $this->groupPermissionRepository->getList();
    }

    /**
     * Xử lý thêm nhóm quyền
     * @param array $dataInput
     * @return mixed
     */
    public function handleSaveGroupPermission(array $dataInput)
    {
        $id = $this->groupPermissionRepository->saveGroupPermission($dataInput);
        $success = [
            'group_permission_id' => $id,
            'message' => 'Save Success',
        ];
        return $success;
    }

    /**
     * Summary of handleUpdateGroupPermission
     * @param mixed $id
     * @param mixed $name
     * @param mixed $description
     * @return mixed
     */
    public function handleUpdateGroupPermission($id, $name)
    {
        return $this->groupPermissionRepository->updateGroupPermissionInfo($id, $name);
    }

    /**
     * Summary of getId
     * @param mixed $id
     * @return mixed
     */
    public function getId($id)
    {
        return $this->groupPermissionRepository->getId($id);
    }

    /**
     * Summary of handleDeleteGroupPermission
     * @param int $id
     * @return mixed
     */
    public function handleDeleteGroupPermission($id)
    {
        return $this->groupPermissionRepository->deleteGroupPermissionInfo($id);
    }
}
