<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
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
            return $this->sendSuccess($userList, 'Fetch Data User Success');
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }

    }
}
