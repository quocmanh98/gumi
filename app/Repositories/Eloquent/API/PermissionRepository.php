<?php
namespace App\Repositories\Eloquent\API;

use App\Models\Permission;
use Illuminate\Support\Facades\Hash;

class PermissionRepository
{
    protected $permission;
    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function getAll(){
        return $this->permission->get();
    }

    public function getList(){
        return $this->permission->latest()->paginate(5);
    }

    public function handleAdd($dataInsert){
        return $this->permission->create($dataInsert);
    }

    public function update($id,$name,$description,$group_permission_id){
        return $this->permission->findOrFail($id)->update([
            'name' => $name,
            'description' => $description,
            'group_permission_id' => $group_permission_id
        ]);
    }

    public function getId($id){
        return $this->permission->findOrFail($id);
    }

    public function delete($id){
        return $this->permission->find($id)->delete();
    }
}
