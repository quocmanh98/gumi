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
     * Summary of createUser
     * @param mixed $data
     * @return mixed
     */
    public function createUser($data)
    {
        return $this->user->insertGetId($data);
    }

    /**
     * Summary of verifyUuid
     * @param mixed $uuid
     * @return mixed
     */
    public function verifyUuid($uuid)
    {
        $result = $this->user->select('activate_date', 'unique_id', 'status')
            ->where('unique_id', $uuid)
            ->first();
        return $result;
    }

    /**
     * Summary of updateStatusUser
     * @param mixed $uuid
     * @return mixed
     */
    public function updateStatusUser($uuid)
    {
        $result = $this->user
            ->where('unique_id', $uuid)
            ->update(
                ['status' => 1]
            );
        return $result;
    }

    /**
     * Summary of verifyEmail
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
     * Summary of verifyPhone
     * @param int $phone
     * @return mixed
     */
    public function verifyPhone(int $phone)
    {
        $result = $this->user->select('*')
            ->where('phone', $phone)
            ->first();
        return $result;
    }

    /**
     * Summary of getDataUserId
     * @param int $userId
     * @return mixed
     */
    public function getDataUserId(int $userId)
    {
        $result = $this->user->whereId($userId)->first();
        return $result;
    }

    /**
     * Summary of updatePassword
     * @param mixed $passwordNew
     * @param mixed $uuid
     * @return mixed
     */
    public function updatePassword($passwordNew, $uuid)
    {
        return $this->user->where('unique_id', $uuid)
            ->update(
                ['password' => $passwordNew]
            );
    }

    /**
     * Summary of updatePasswordByEmail
     * @param mixed $passwordNewHash
     * @param mixed $email
     * @return mixed
     */
    public function updatePasswordByEmail($passwordNewHash, $email)
    {
        return $this->user->where('email', $email)
            ->update(
                [
                    'password' => $passwordNewHash,
                    'status' => 1,
                ]
            );
    }

    /**
     * Summary of updateOrCreate
     * @param mixed $user
     * @return mixed
     */
    public function updateOrCreate($user)
    {
        return $this->user->updateOrCreate(
            [
            'google_id' => $user->getId(),
            ], [
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => Hash::make($user->getName() . '@' . $user->getId()),
            ]
        );
    }

    /**
     * Summary of updateGoogleId
     * @param mixed $user
     * @return mixed
     */
    public function updateGoogleId($user)
    {
        return $this->user->where('email', $user->getEmail())->update(
            [
            'google_id' => $user->getId(),
            ]
        );
    }

}
