<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\API\UserService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\API\UserRequest;
use App\Http\Controllers\BaseController;
use App\Http\Requests\API\UpdateUserRequest;

class UserController extends BaseController
{
    protected $userService;

    public function __construct()
    {
        $this->userService = new UserService;
    }

    /**
     * Danh sách user
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
     * Thêm người dùng
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($request->input('password'));
        $data['user_created'] = Auth::user()->name;
        $hasFile = $request->hasFile('thumbnail');
        $thumbnail = $request->thumbnail;

        try {
            $result = $this->userService->handleSaveUserData($data,$thumbnail,$hasFile);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    /**
     * Xem chi tiết user
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
     * Cập nhật thông tin user
     * @param UpdateUserRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, $id){
        $data = $request->all();
        $data['password'] = bcrypt($request->input('password'));
        $data['user_updated'] = Auth::user()->name;
        $hasFile = $request->hasFile('thumbnail');
        $thumbnail = $request->thumbnail;

        try {
            $result = $this->userService->handleUpdateUser($data, $id, $hasFile, $thumbnail);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    /**
     * Xóa User
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $result = $this->userService->handleDeleteUser($id);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    /**
     * Chức năng xóa tạm thời, khôi phục, xóa vĩnh viến user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function action(Request $request)
    {
        $listCheck = $request->input('list_check');
        $action = $request->input('action');

        try {
            $result = $this->userService->handleUserAction($listCheck, $action);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }
}
