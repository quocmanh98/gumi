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


    public function getList()
    {
        return $this->permission->latest()->paginate(5);
    }

    public function savePermission($data_input)
    {
        return $this->permission->create($data_input);
    }

    public function updatePermission($id,$name,$description,$group_permission_id)
    {
        return $this->permission->findOrFail($id)->update([
            'name' => $name,
            'description' => $description,
            'group_permission_id' => $group_permission_id
        ]);
    }

    public function getId($id)
    {
        return $this->permission->findOrFail($id);
    }

    public function deletePermission($id)
    {
        return $this->permission->find($id)->delete();
    }
}
