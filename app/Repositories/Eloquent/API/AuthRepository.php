<?php
namespace App\Repositories\Eloquent\API;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthRepository extends BaseRepository
{
    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * Thêm người dùng
     * @param mixed $data
     * @return mixed
     */
    public function createUser($data)
    {
        return $this->user->create($data);
    }

    /**
     *  Lấy thông tin chi tiêt user thông qua uuid của user đó
     * @param mixed $uuid
     * @return mixed
     */
    public function verifyUuid($uuid)
    {
        $result = $this->user->select('activation_date', 'uuid', 'status')
            ->where('uuid', $uuid)
            ->first();
        return $result;
    }

    /**
     * Kiểm tra tồn tại uuid của user đó
     * @param mixed $uuid
     * @return mixed
     */
    public function checkUuidExist($uuid)
    {
        $result = $this->user->where('uuid', $uuid)->exists();
        return $result;
    }

    /**
     * Cập nhật trạng thái user
     * @param mixed $uuid
     * @return mixed
     */
    public function updateUserStatus($uuid)
    {
        $result = $this->user
            ->where('uuid', $uuid)
            ->update(['status' => 1]);
        return $result;
    }

    /**
     * Kiểm tra tồn tại email user đó
     * @param mixed $email
     * @return mixed
     */
    public function verifyEmail($email)
    {
        $result = $this->user->select('*')
            ->where('email', $email)
            ->first();
        return $result;
    }

    /**
     * Kiểm tra tồn tại phone đó
     * @param int $phone
     * @return mixed
     */
    public function verifyPhone($phone)
    {
        $result = $this->user->select('*')
            ->where('phone', $phone)
            ->first();
        return $result;
    }

    /**
     * Lấy thông tin chi tiết user
     * @param int $userId
     * @return mixed
     */
    public function getUserId($userId)
    {
        $result = $this->user->whereId($userId)->first();
        return $result;
    }

    /**
     * Thay đổi mật khẩu qua uuid của user
     * @param mixed $passwordNew
     * @param mixed $uuid
     * @return mixed
     */
    public function updatePassword($passwordNew, $uuid)
    {
        return $this->user->where('uuid', $uuid)
            ->update(['password' => $passwordNew]);
    }

    /**
     * Cập nhật mật khẩu user qua email của user
     * @param mixed $passwordNewHash
     * @param mixed $email
     * @return mixed
     */
    public function updatePasswordByEmail($passwordNewHash, $email)
    {
        return $this->user->where('email', $email)
            ->update(['password' => $passwordNewHash, 'status' => 1]);
    }

    /**
     * Cập nhật nếu tồn tại user
     * Tạo mới user nếu ko tồn tại user
     * @param mixed $user
     * @return mixed
     */
    public function updateOrCreate($user)
    {
        return $this->user->updateOrCreate([
            'google_id' => $user->getId(),
        ], [
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => Hash::make($user->getName() . '@' . $user->getId()),
        ]);
    }

    /**
     * Cập nhật cột google id bảng user
     * @param mixed $user
     * @return mixed
     */
    public function updateGoogleId($user)
    {
        return $this->user->where('email', $user->getEmail())
            ->update(['google_id' => $user->getId()]);
    }
}
