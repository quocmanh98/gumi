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

    /**
     * Summary of index
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Summary of store
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Summary of show
     * @param int $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $user)
    {
        try {
            $result = $this->userService->getById($user);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    /**
     * Summary of update
     * @param UpdateUserRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request,int $id){
        $data = $request->all();
        $data['password'] = bcrypt($request->input('password'));
        try {
            $result = $this->userService->handleUpdateUser($data,$id);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    /**
     * Summary of destroy
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        try {
            $result = $this->userService->handleDeleteUser($id);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }
}
