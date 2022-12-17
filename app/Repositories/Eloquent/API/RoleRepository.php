<?php
namespace App\Repositories\Eloquent\API;

use App\Models\Role;

class RoleRepository
{
    protected $role;

    public function __construct()
    {
        $this->role = new Role();
    }

    /**
     * Summary of getSearchRole
     * @param mixed $search
     * @return mixed
     */
    public function getSearchRole($search)
    {
        return $this->role
            ->where('name', 'like', "%{$search}%")
            ->latest()->paginate(5);
    }

    /**
     * Summary of addRole
     * @param mixed $dataRole
     * @return mixed
     */
    public function addRole($dataRole)
    {
        return $this->role->create($dataRole);
    }

    /**
     * Summary of getRoleId
     * @param int $role
     * @return mixed
     */
    public function getRoleId($role)
    {
        return $this->role->findOrFail($role);
    }

    /**
     * Summary of updateRoleInfo
     * @param mixed $role
     * @param mixed $name
     * @param mixed $description
     * @return mixed
     */
    public function updateRoleInfo($role, $name, $description)
    {
        return $this->role
            ->findOrFail($role)
            ->update(['name' => $name, 'description' => $description]);
    }

    /**
     * Summary of deleteRole
     * @param mixed $role
     * @return mixed
     */
    public function deleteRole($role)
    {
        return $this->role->findOrFail($role)->delete();
    }

}
