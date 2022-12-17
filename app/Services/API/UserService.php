<?php
namespace App\Services\API;

use App\Http\Resources\API\UserResource;
use App\Repositories\Eloquent\API\AuthRepository;
use App\Repositories\Eloquent\API\UserRepository;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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
     * Summary of getAllUser
     * @param mixed $status
     * @param mixed $roleId
     * @param mixed $search
     * @param mixed $sortBy
     * @param mixed $sortType
     * @throws \Exception
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getAllUser($status, $search, $sortBy, $sortType)
    {
        $filters = [];

        if (!empty($status)) {
            if ($status == 'active') {
                $status = 1;
            } else {
                $status = 0;
            }

            $filters[] = ['users.status', '=', $status];
        }

        // if (!empty($roleId)) {
        //     $filters[] = ['users.role_id', '=', $roleId];
        // }

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

        $result = $this->userRepository->getAllUser($filters, $search, $sortArr, config('services.PER_PAGE'));
        if ($result->count() > 0) {
            return UserResource::collection($result);
        }
        throw new \Exception('Error ! Fetch Data User No Success', 1);
    }

    /**
     * Summary of handleCallbackGoogle
     * @throws \Exception
     * @return array
     */
    public function handleCallbackGoogle()
    {
        $user = Socialite::driver('google')->user();

        // Check Users Email If Already
        $is_user = $this->authRepository->verifyEmail($user->getEmail());

        if (!$is_user) {
            $saveUser = $this->authRepository->updateOrCreate($user);
        } else {
            $saveUser = $this->authRepository->updateGoogleId($user);
            $saveUser = $this->authRepository->verifyEmail($user->getEmail());
        }

        $result = Auth::loginUsingId($saveUser->id);

        if ($result) {
            $success = [
                'user' => new UserResource($saveUser),
                'message' => 'Login Google Success',
            ];
            return $success;
        }
        throw new \Exception('Error ! Fetch Data User No Success', 1);
    }

    /**
     * Summary of handleSaveUserData
     * @param mixed $data
     * @throws \Exception
     * @return array<string>
     */
    public function handleSaveUserData($data)
    {
        $result = $this->userRepository->saveUserData($data);
        if ($result) {
            $success = [
                'user_id' => $result,
                'message' => 'Create Data User Success',
            ];
            return $success;
        }
        throw new \Exception('Error ! Create Data User No Success', 1);
    }

    /**
     * Summary of getById
     * @param int $id
     * @throws \Exception
     * @return array
     */
    public function getById(int $id)
    {
        $users = $this->userRepository->getAllData();
        $dataId = [];
        foreach ($users as $user) {
            $dataId[] = $user->id;
        }

        if (in_array($id, $dataId)) {
            $result = $this->userRepository->getById($id);
            if ($result) {
                $success = [
                    'message' => 'Fetch Data User Success',
                    'user' => new UserResource($result),
                ];
                return $success;
            }
            throw new \Exception('Error ! Fetch Data User No Success', 1);
        }
        throw new \Exception('Error ! No find User', 1);
    }

    /**
     * Summary of handleUpdateUser
     * @param array $data
     * @param int $id
     * @throws \Exception
     * @return array<string>
     */
    public function handleUpdateUser(array $data,int $id)
    {
        $users = $this->userRepository->getAllData();
        $dataId = [];
        foreach ($users as $user) {
            $dataId[] = $user->id;
        }
        if (in_array($id, $dataId)) {
            $result = $this->userRepository->updateUser($data, $id);
            if ($result) {
                $success = [
                    'message' => 'Update Data User Success',
                ];
                return $success;
            }
            throw new \Exception('Error ! Update Data User No Success', 1);
        }
        throw new \Exception('Error ! No find User', 1);
    }

    /**
     * Summary of handleDeleteUser
     * @param int $id
     * @throws \Exception
     * @return array<string>
     */
    public function handleDeleteUser(int $id)
    {
        $users = $this->userRepository->getAllData();
        $dataId = [];
        foreach ($users as $user) {
            $dataId[] = $user->id;
        }
        if (in_array($id, $dataId)) {
            $result = $this->userRepository->deleteUser($id);
            if ($result) {
                $success = [
                    'message' => 'Success ! Delete Data User Success',
                ];
                return $success;
            }
            throw new \Exception('Error ! Delete Data User No Success', 1);
        }
        throw new \Exception('Error ! No find User', 1);
    }
}
