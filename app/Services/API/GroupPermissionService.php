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

    public function getList()
    {
        return $this->groupPermissionRepository->getList();
    }

    public function handleSaveGroupPermission($data_input)
    {
        return $this->groupPermissionRepository->saveGroupPermission($data_input);
    }

    public function handleUpdateGroupPermission($id, $name, $description)
    {
        return $this->groupPermissionRepository->updateGroupPermissionInfo($id, $name, $description);
    }

    public function getId($id)
    {
        return $this->groupPermissionRepository->getId($id);
    }

    public function handleDeleteGroupPermission($id)
    {
        return $this->groupPermissionRepository->deleteGroupPermissionInfo($id);
    }
}
