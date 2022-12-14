<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\GroupPermissionRequest;
use App\Http\Requests\API\UpdateGroupPermissionRequest;
use App\Services\API\GroupPermissionService;

class GroupPermissionController extends Controller
{
    protected $groupPermissionService;

    public function __construct()
    {
        $this->groupPermissionService = new GroupPermissionService;
    }

    public function index()
    {
        $groupPermissions = $this->groupPermissionService->getList();
        return sendResponse($groupPermissions,'Fetch Data Success');
    }

    public function store(GroupPermissionRequest $request)
    {
        $data = $request->all();
        $this->groupPermissionService->handleSaveGroupPermission($data);

        return sendResponse('','Add Group Permission Success');
    }

    public function update($id,UpdateGroupPermissionRequest $request)
    {
        $name = $request->name;
        $description = $request->description;

        $this->groupPermissionService->handleUpdateGroupPermission($id,$name,$description);
        return sendResponse([],'Update Group Permission Success');
    }

    public function show($id)
    {
        $result = $this->groupPermissionService->getId($id);
        return sendResponse($result,'Show Group Permission Success');
    }


    public function destroy($id)
    {
        $this->groupPermissionService->handleDeleteGroupPermission($id);
        return sendResponse([],'Delete Group Permission Success');
    }

}
