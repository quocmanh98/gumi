<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Requests\API\UpdateUserRequest;
use App\Http\Requests\API\UserRequest;
use App\Services\API\UserService;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    protected $userService;

    public function __construct()
    {
        $this->userService = new UserService;
    }

    public function index(Request $request)
    {
        $search = null;
        $status = $request->status;
        $roleId = $request->role_id;

        if (!empty($request->search)) {
            $search = $request->search;
        }
        $sortBy = $request->input('sort-by');
        $sortType = $request->input('sort-type');

        try {
            $userList = $this->userService->getAllUser($status, $roleId, $search, $sortBy, $sortType);
            return $this->sendSuccess($userList);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    public function store(UserRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($request->input('password'));
        try {
            $result = $this->userService->handleSaveUserData($data);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    public function show($user)
    {
        try {
            $result = $this->userService->getById($user);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }


    public function update(UpdateUserRequest $request,$id){
        $data = $request->all();
        $data['password'] = bcrypt($request->input('password'));
        try {
            $result = $this->userService->handleUpdateUser($data,$id);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $result = $this->userService->handleDeleteUser($id);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }
}
