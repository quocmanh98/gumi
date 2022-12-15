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
     * Summary of getAll
     * @return mixed
     */
    public function getAll()
    {
        return $this->groupPermission->get();
    }

    /**
     * Summary of getList
     * @return mixed
     */
    public function getList()
    {
        return $this->groupPermission->latest()->paginate(5);
    }

    /**
     * Summary of saveGroupPermission
     * @param array $dataInput
     * @return mixed
     */
    public function saveGroupPermission(array $dataInput)
    {
        return $this->groupPermission->create($dataInput);
    }

    /**
     * Summary of updateGroupPermissionInfo
     * @param int $id
     * @param mixed $name
     * @param mixed $description
     * @return mixed
     */
    public function updateGroupPermissionInfo(int $id,$name,$description)
    {
        return $this->groupPermission->findOrFail($id)
            ->update(['name' => $name, 'description' => $description]);
    }

    /**
     * Summary of getId
     * @param int $id
     * @return mixed
     */
    public function getId(int $id)
    {
        return $this->groupPermission->findOrFail($id);
    }

    /**
     * Summary of deleteGroupPermissionInfo
     * @param mixed $id
     * @return mixed
     */
    public function deleteGroupPermissionInfo($id)
    {
        return $this->groupPermission->find($id)->delete();
    }
}
