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

    /**
     * Summary of index
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $groupPermissions = $this->groupPermissionService->getList();
        return sendResponse($groupPermissions, 'Fetch Data Success');
    }

    /**
     * Summary of store
     * @param GroupPermissionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GroupPermissionRequest $request)
    {
        $data = $request->all();
        $this->groupPermissionService->handleSaveGroupPermission($data);

        return sendResponse('', 'Add Group Permission Success');
    }

    /**
      * Summary of update
      * @param mixed $id
      * @param UpdateGroupPermissionRequest $request
      * @return \Illuminate\Http\JsonResponse
      */
    public function update($id, UpdateGroupPermissionRequest $request)
    {
        $name = $request->name;
        $description = $request->description;

        $this->groupPermissionService->handleUpdateGroupPermission($id, $name, $description);
        return sendResponse([], 'Update Group Permission Success');
    }

    /**
     * Summary of show
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $result = $this->groupPermissionService->getId($id);
        return sendResponse($result, 'Show Group Permission Success');
    }

    /**
     * Summary of destroy
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $this->groupPermissionService->handleDeleteGroupPermission($id);
        return sendResponse([], 'Delete Group Permission Success');
    }

}
