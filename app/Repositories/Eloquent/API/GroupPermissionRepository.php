<?php
namespace App\Repositories\Eloquent\API;

use App\Models\GroupPermission;
use Illuminate\Support\Facades\Hash;

class GroupPermissionRepository
{
    protected $groupPermission;
    public function __construct()
    {
        $this->groupPermission = new GroupPermission();
    }

    public function getAll(){
        return $this->groupPermission->get();
    }

    public function getList(){
        return $this->groupPermission->latest()->paginate(5);
    }

    public function handleAdd($dataInsert){
        return $this->groupPermission->create($dataInsert);
    }

    public function update($id,$name,$description){
        return $this->groupPermission->findOrFail($id)->update([
            'name' => $name,
            'description' => $description,
        ]);
    }

    public function getId($id){
        return $this->groupPermission->findOrFail($id);
    }

    public function delete($id){
        return $this->groupPermission->find($id)->delete();
    }
}
