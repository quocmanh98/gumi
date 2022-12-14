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

    public function getAll()
    {
        return $this->groupPermission->get();
    }

    public function getList()
    {
        return $this->groupPermission->latest()->paginate(5);
    }

    public function saveGroupPermission($dataInsert)
    {
        return $this->groupPermission->create($dataInsert);
    }

    public function updateGroupPermissionInfo($id,$name,$description)
    {
        return $this->groupPermission->findOrFail($id)->update([
            'name' => $name,
            'description' => $description,
        ]);
    }

    public function getId($id)
    {
        return $this->groupPermission->findOrFail($id);
    }

    public function deleteGroupPermissionInfo($id)
    {
        return $this->groupPermission->find($id)->delete();
    }
}
