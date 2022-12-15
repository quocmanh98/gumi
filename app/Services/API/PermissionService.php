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

    /**
     * Summary of getList
     * @return mixed
     */
    public function getList()
    {
        return $this->permissionRepository->getList();
    }

    /**
     * Summary of savePermission
     * @param mixed $dataInput
     * @return mixed
     */
    public function savePermission($dataInput)
    {
        return $this->permissionRepository->savePermission($dataInput);
    }

    /**
     * Summary of updatePermission
     * @param mixed $id
     * @param mixed $name
     * @param mixed $description
     * @param mixed $groupPermissionId
     * @return mixed
     */
    public function updatePermission($id, $name, $description, $groupPermissionId)
    {
        return $this->permissionRepository
            ->updatePermission($id, $name, $description, $groupPermissionId);
    }


    /**
     * Summary of getId
     * @param int $id
     * @return mixed
     */
    public function getId(int $id)
    {
        return $this->permissionRepository->getId($id);
    }

    /**
     * Summary of deletePermission
     * @param int $id
     * @return mixed
     */
    public function deletePermission(int $id)
    {
        return $this->permissionRepository->deletePermission($id);
    }
}

