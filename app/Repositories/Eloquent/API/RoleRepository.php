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

    public function getSearchRole($search)
    {
        return $this->role
            ->where('name', 'like', "%{$search}%")
            ->latest()->paginate(5);
    }

    public function addRole($data_role)
    {
        return $this->role->create($data_role);
    }

    public function getRoleId($role)
    {
        return $this->role->findOrFail($role);
    }

    public function updateRoleInfo($role, $name, $description)
    {
        return $this->role
            ->findOrFail($role)
            ->update(
                [
                    'name' => $name,
                    'description' => $description,
                ]
            );
    }

    public function deleteRole($role)
    {
        return $this->role->findOrFail($role)->delete();
    }

}
