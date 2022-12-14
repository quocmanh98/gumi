<?php
namespace App\Services\API;

use App\Repositories\Eloquent\API\PermissionRepository;

class PermissionService
{
    protected $permissionRepository;

    public function __construct()
    {
        $this->permissionRepository = new PermissionRepository();
    }

    public function getList()
    {
        return $this->permissionRepository->getList();
    }

    public function savePermission($data_input)
    {
        return $this->permissionRepository->savePermission($data_input);
    }

    public function updatePermission($id, $name, $description, $group_permission_id)
    {
        return $this->permissionRepository
            ->updatePermission($id, $name, $description, $group_permission_id);
    }

    public function getId($id)
    {
        return $this->permissionRepository->getId($id);
    }

    public function deletePermission($id)
    {
        return $this->permissionRepository->deletePermission($id);
    }
}

