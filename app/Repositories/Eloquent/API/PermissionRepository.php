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
     * Summary of getList
     * @return mixed
     */
    public function getList()
    {
        return $this->permission->latest()->paginate(5);
    }

    /**
     * Summary of savePermission
     * @param array $dataInput
     * @return mixed
     */
    public function savePermission(array $dataInput)
    {
        return $this->permission->create($dataInput);
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
        return $this->permission->findOrFail($id)
        ->update(['name' => $name, 'description' => $description, 'group_permission_id' => $groupPermissionId]);
    }

    /**
     * Summary of getId
     * @param mixed $id
     * @return mixed
     */
    public function getId($id)
    {
        return $this->permission->findOrFail($id);
    }

    /**
     * Summary of deletePermission
     * @param mixed $id
     * @return mixed
     */
    public function deletePermission($id)
    {
        return $this->permission->find($id)->delete();
    }
}
