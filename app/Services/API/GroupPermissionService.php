<?php
namespace App\Services\API;

use App\Repositories\API\GroupPermissionRepository;
use App\Repositories\API\RoleRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

class GroupPermissionService{

    protected $groupPermissionRepository;

    public function __construct()
    {
        $this->groupPermissionRepository = new GroupPermissionRepository();
    }

    public function getAll(){
        return $this->groupPermissionRepository->getAll();
    }

    public function getList(){
        return $this->groupPermissionRepository->getList();
    }

    public function handleAdd($dataInsert){
        return $this->groupPermissionRepository->handleAdd($dataInsert);
    }

    public function update($id,$name,$description){
        return $this->groupPermissionRepository->update($id,$name,$description);
    }

    public function getId($id){
        return $this->groupPermissionRepository->getId($id);
    }

    public function delete($id){
        return $this->groupPermissionRepository->delete($id);
    }

}

