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

    /**
     * s
     * @param mixed $search
     * @return mixed
     */
    public function getSearchRole($search)
    {
        return $this->roleRepository->getSearchRole($search);
    }

    /**
     * Summary of handleSaveRole
     * @param mixed $name
     * @param mixed $description
     * @param mixed $permissionId
     * @throws \Exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleSaveRole($name, $description, $permissionId)
    {
        try {
            DB::beginTransaction();

            $dataRole = [
                'name' => $name,
                'description' => $description,
            ];
            $role = $this->roleRepository->addRole($dataRole);
            $role->permissions()->attach($permissionId);

            DB::commit();

            return sendResponse([], 'Add Role Success');
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Summary of getRoleInfo
     * @param mixed $role
     * @return mixed
     */
    public function getRoleInfo($role)
    {
        return $this->roleRepository->getRoleId($role);
    }

    /**
     * Summary of handleUpdateRole
     * @param mixed $role
     * @param mixed $name
     * @param mixed $description
     * @param mixed $permissionId
     * @throws \Exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleUpdateRole($role, $name, $description, $permissionId)
    {
        try {
            DB::beginTransaction();

            $this->roleRepository->updateRoleInfo($role, $name, $description);
            $role = $this->roleRepository->getRoleId($role);

            $role->permissions()->sync($permissionId);

            DB::commit();

            return sendResponse([], 'Update Role Success');
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Summary of handleDeleteRole
     * @param mixed $role
     * @return mixed
     */
    public function handleDeleteRole($role)
    {
        return $this->roleRepository->deleteRole($role);
    }
}

