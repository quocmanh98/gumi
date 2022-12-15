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
     * Summary of getList
     * @return mixed
     */
    public function getList()
    {
        return $this->groupPermissionRepository->getList();
    }

    /**
     * Summary of handleSaveGroupPermission
     * @param array $dataInput
     * @return mixed
     */
    public function handleSaveGroupPermission(array $dataInput)
    {
        return $this->groupPermissionRepository->saveGroupPermission($dataInput);
    }

    /**
     * Summary of handleUpdateGroupPermission
     * @param mixed $id
     * @param mixed $name
     * @param mixed $description
     * @return mixed
     */
    public function handleUpdateGroupPermission($id, $name, $description)
    {
        return $this->groupPermissionRepository->updateGroupPermissionInfo($id, $name, $description);
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
    public function handleDeleteGroupPermission(int $id)
    {
        return $this->groupPermissionRepository->deleteGroupPermissionInfo($id);
    }
}
