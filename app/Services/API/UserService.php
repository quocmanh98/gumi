<?php
namespace App\Services\API;

use App\Http\Resources\API\UserResource;
use App\Repositories\Eloquent\API\AuthRepository;
use App\Repositories\Eloquent\API\UserRepository;
use Illuminate\Support\Facades\Auth;
use Laravolt\Avatar\Avatar;

class UserService extends BaseService
{
    protected $userRepository;
    protected $authRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository;
        $this->authRepository = new AuthRepository;
    }

    /**
     * Xử lý Lấy danh sách người dùng
     * @param mixed $status
     * @param mixed $roleId
     * @param mixed $search
     * @param mixed $sortBy
     * @param mixed $sortType
     * @throws \Exception
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getUserAll($status, $roleId, $search, $sortBy, $sortType)
    {
        // Lọc trạng thái tài khoản
        $filters = [];
        if (!empty($status)) {
            if ($status == 'active') {
                $status = 1;
            } else {
                $status = 0;
            }
            $filters[] = ['users.status', '=', $status];
        }

        // Lọc vai trò
        if (!empty($roleId)) {
            $filters[] = ['users.role_id', '=', $roleId];
        }

        // Sắp xếp các cột theo thứ tự desc,asc
        $allowSort = ['asc', 'desc'];
        if (!empty($sortType) && in_array($sortType, $allowSort)) {
            if ($sortType == 'desc') {
                $sortType = 'asc';
            } else {
                $sortType = 'desc';
            }
        } else {
            $sortType = 'asc';
        }
        $sortArr = [
            'sortBy' => $sortBy,
            'sortType' => $sortType,
        ];

        $result = $this->userRepository->getUserAll($filters, $search, $sortArr, config('services.PER_PAGE'));
        if (!$result->count()) {
            throw new \Exception('Error ! Fetch Data User No Success', 1);
        }
        return UserResource::collection($result);
    }

    /**
     * Xử lý chức thêm năng người dùng
     * @param mixed $data
     * @throws \Exception
     * @return array<string>
     */
    public function handleSaveUserData($data, $thumbnail, $hasFile)
    {
        if (!$hasFile) {
            $avatar = new Avatar();
            $data['thumbnail'] = $avatar->create($data['name'])->toBase64();
        } else {
            $imageName = $thumbnail->getClientOriginalName();
            $thumbnail->move('image/users', $imageName);
            $image = 'image/users/' . $imageName;
            $data['thumbnail'] = $image;
        }

        $result = $this->userRepository->saveUserData($data);
        if (!$result) {
            throw new \Exception('Error ! Create Data User No Success', 1);
        }
        $success = [
            'user_id' => $result,
            'message' => 'Create Data User Success',
        ];
        return $success;
    }

    /**
     * Xử lý lấy chi tiết user
     * @param int $id
     * @throws \Exception
     * @return array
     */
    public function getById($id)
    {
        $users = $this->userRepository->getUsers();
        $dataId = [];
        foreach ($users as $user) {
            $dataId[] = $user->id;
        }

        if (!in_array($id, $dataId)) {
            throw new \Exception('Error ! No find User', 1);
        }

        $result = $this->userRepository->getById($id);
        if (!$result) {
            throw new \Exception('Error ! Fetch Data User No Success', 1);
        }

        $success = [
            'message' => 'Fetch Data User Success',
            'user' => new UserResource($result),
        ];
        return $success;
    }

    /**
     * Xử lý cập nhật thông tin user
     * @param array $data
     * @param int $id
     * @throws \Exception
     * @return array<string>
     */
    public function handleUpdateUser($data, $id, $hasFile, $thumbnail)
    {
        $users = $this->userRepository->getUsers();

        $dataId = [];
        foreach ($users as $user) {
            $dataId[] = $user->id;
        }

        if (!in_array($id, $dataId)) {
            throw new \Exception('Error ! No find User', 1);
        }

        if ($hasFile) {
            $imageName = $thumbnail->getClientOriginalName();
            $thumbnail->move('image/users', $imageName);
            $image = 'image/users/' . $imageName;
            $data['thumbnail'] = $image;
        }

        $result = $this->userRepository->updateUser($data, $id);
        if (!$result) {
            throw new \Exception('Error ! Update Data User No Success', 1);
        }

        $success = [
            'message' => 'Update Data User Success',
        ];
        return $success;
    }

    /**
     * Xử lý xóa user
     * @param int $id
     * @throws \Exception
     * @return array<string>
     */
    public function handleDeleteUser($id)
    {
        $users = $this->userRepository->getUsers();

        $dataId = [];
        foreach ($users as $user) {
            $dataId[] = $user->id;
        }

        if (!in_array($id, $dataId)) {
            throw new \Exception('Error ! No find User', 1);
        }

        $result = $this->userRepository->deleteUser($id);
        if (!$result) {
            throw new \Exception('Error ! Delete Data User No Success', 1);
        }

        $success = [
            'message' => 'Success ! Delete Data User Success',
        ];
        return $success;

    }

    /**
     * Xử lý hành động xóa tạm thời, khôi phục, xóa vĩnh viến hàng loạt user
     * @param mixed $listCheck
     * @param mixed $action
     * @throws \Exception
     * @return array<string>
     */
    public function handleUserAction($listCheck, $action)
    {

        if (!$listCheck) {
            throw new \Exception('Error ! You need to select the element to execute', 1);
        }

        foreach ($listCheck as $k => $v) {
            if (Auth::id() == $v) {
                unset($listCheck[$k]);
            }
        }

        if (!empty($listCheck)) {

            if ($action == 'delete') {
                $this->userRepository->userDestroy($listCheck);
                return [
                    'message' => 'You have successfully deleted the temporary',
                ];
            }

            if ($action == 'restore') {
                $this->userRepository->userRestoreTrashed($listCheck);
                return [
                    'message' => 'You have successfully recovered',
                ];
            }

            if ($action == 'forceDelete') {
                $this->userRepository->userForceDelete($listCheck);
                return [
                    'message' => 'You have successfully permanently deleted',
                ];
            }
        }

        throw new \Exception('Error ! You cannot operate on your account', 1);
    }

}
