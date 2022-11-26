<?php
namespace App\Services\API;

use App\Repositories\API\GroupPermissionRepository;
use App\Repositories\API\PermissionRepository;
use App\Repositories\API\RoleRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

class PermissionService{

    protected $permissionRepository;
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function getAll(){
        return $this->permissionRepository->getAll();
    }

    public function getList(){
        return $this->permissionRepository->getList();
    }

    public function handleAdd($dataInsert){
        return $this->permissionRepository->handleAdd($dataInsert);
    }

    public function update($id,$name,$description,$group_permission_id){
        return $this->permissionRepository->update($id,$name,$description,$group_permission_id);
    }

    public function getId($id){
        return $this->permissionRepository->getId($id);
    }

    public function delete($id){
        return $this->permissionRepository->delete($id);
    }

}

