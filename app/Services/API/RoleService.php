<?php
namespace App\Services\API;

use App\Repositories\Eloquent\API\RoleRepository;
use Illuminate\Support\Facades\DB;

class RoleService
{
    protected $roleRepository;

    public function __construct()
    {
        $this->roleRepository = new RoleRepository;
    }

    public function getSearchRole($search)
    {
        return $this->roleRepository->getSearchRole($search);
    }

    public function handleSaveRole($name, $description, $permission_id)
    {
        try {
            DB::beginTransaction();

            $dataRole = [
                'name' => $name,
                'description' => $description,
            ];
            $role = $this->roleRepository->addRole($dataRole);
            $role->permissions()->attach($permission_id);

            DB::commit();

            return sendResponse([],'Add Role Success');
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function getRoleInfo($role)
    {
        return $this->roleRepository->getRoleId($role);
    }

    public function handleUpdateRole($role,$name,$description,$permission_id)
    {
        try {
            DB::beginTransaction();

            $this->roleRepository->updateRoleInfo($role,$name,$description);
            $role = $this->roleRepository->getRoleId($role);

            $role->permissions()->sync($permission_id);

            DB::commit();

            return sendResponse([],'Update Role Success');
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function handleDeleteRole($role)
    {
        return $this->roleRepository->deleteRole($role);
    }
}

