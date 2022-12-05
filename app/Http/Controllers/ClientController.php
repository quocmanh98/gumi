<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ClientController extends Controller
{

    public function __construct()
    {
        // $this->middleware(['role:admin','permission:edit book'])->only('index','show');;
    }

    public function impersonate($id){
        $user = User::find($id);
        if($user){
            Session::put('impersonate', $user->id);
        }
        return redirect('/');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Role::create(['name' => 'writer','guard_name' => 'web']);
        // Permission::create(['name' => 'add post','guard_name' => 'web']);
        // $role = Role::findOrFail(3);
        // $permission = Permission::findOrFail(4);
        // $role->givePermissionTo($permission);
        // $permission->assignRole($role);
        // $role->revokePermissionTo($permission);
        // Auth()->user()->assignRole(['admin','writer']);
        // Auth()->user()->syncRoles(['admin']);
        // $user = User::findOrFail(2);
        // $user->assignRole('writer');

        // $user = Auth::user();
        // $user = User::findOrFail(2);
        // $user->givePermissionTo(['edit book', 'add book']);
        // if($user->hasRole('writer')){
        //     echo 'User có vai trò writer';
        // }else{
        //     echo 'User không có vai trò writer';

        // }
        // if($user->hasAnyDirectPermission(Permission::all())){
        //     echo 'User có quyền';
        // }else{
        //     echo 'User không có quyền';

        // }

        // return $user->getPermissionsViaRoles();
        // bảng role_has_permission


        $users = User::with('roles','permissions')->orderBy('id', 'desc')->get();
        return view('admin.client.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function roleAssignment($id){
        $user = User::findOrFail($id);
        $role = Role::orderBy('id', 'desc')->get();
        $all_column_roles = $user->roles->first();
        $permission = Permission::orderBy('id', 'desc')->get();
        // lấy bảng: model_has_roles
        return view('admin.client.role_assignment',compact('user','role','all_column_roles','permission'));
    }

    public function decentralizate($id){
        $user = User::findOrFail($id);
        $permission = Permission::orderBy('id', 'desc')->get();

        $name_roles = $user->roles->first()->name;

        // lấy bảng: model_has_roles
        $get_permission_via_role = $user->getPermissionsViaRoles();
        return view('admin.client.decentralizate',compact('user','permission','name_roles','get_permission_via_role'));
    }

    public function insertRoles(Request $request,$id){
        $data = $request->all();
        $user = User::findOrFail($id);
        $user->syncRoles($data['role']);

        return redirect()->route('client.index')->with('status', 'Thêm quyền cho User thành công');
    }

    public function insertPermission(Request $request,$id){
        $data = $request->all();
        $user = User::findOrFail($id);
        $role_id = $user->roles->first()->id;

        $role = Role::findOrFail($role_id);
        $role->syncPermissions($data['permission']);
        return  redirect()->route('client.index')->with('status', 'Thêm vai trò cho User thành công');
    }

    public function insertPerPermission(Request $request){
        $data = $request->all();
        Permission::create(['name' => $data['permission'],'guard_name' => 'web']);
        return  redirect()->route('client.index')->with('status', 'Thêm quyền thành công');
    }
}
