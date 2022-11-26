<?php
namespace App\Repositories\Eloquent\API;

use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleRepository
{
    protected $role;
    public function __construct()
    {
        $this->role = new Role();
    }

    public function searchRole($search){
        return $this->role->where('name', 'like', "%{$search}%")->latest()->paginate(5);
    }

    public function addRole($dataRole){
        return $this->role->create($dataRole);
    }

    public function getId($role){
        return $this->role->findOrFail($role);
    }

    public function updateRole($role,$name,$description){
        return $this->role->findOrFail($role)->update([
            'name' => $name,
            'description' => $description,
        ]);
    }

    public function delete($role){
        return $this->role->findOrFail($role)->delete();
    }

    public function getIdRole($role){
        return $this->role->select('id')->whereIn('id',$role)->pluck('id')->toArray();
    }
}
