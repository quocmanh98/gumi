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
     * Tìm kiếm bản ghi
     * @param mixed $search
     * @return mixed
     */
    public function getSearchRole($search)
    {
        return $this->roleRepository->getSearchRole($search);
    }

    /**
     * Xử lý thêm vai trò
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
            // $role->permissions()->attach($permissionId);
            $success = [
                'role_id' => $role,
            ];

            DB::commit();
            return $success;
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * lấy thông tin chi tiêt vai trò
     * @param mixed $role
     * @return mixed
     */
    public function getRoleInfo($role)
    {
        return $this->roleRepository->getRoleId($role);
    }

    /**
     * Xử lý cập nhật vai trò
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
            // $role->permissions()->sync($permissionId);

            DB::commit();

            return sendResponse([], 'Update Role Success');
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception('Fail ! Role no find');
        }
    }

    /**
     * Xử lý xóa vai trò
     * @param mixed $role
     * @return mixed
     */
    public function handleDeleteRole($role)
    {
        return $this->roleRepository->deleteRole($role);
    }
}

