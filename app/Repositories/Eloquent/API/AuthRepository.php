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

    public function createUser($data)
    {
        return $this->user->insertGetId($data);
    }

    public function verifyUuid($uuid)
    {
        $result = $this->user->select('activate_date', 'unique_id', 'status')
            ->where('unique_id', $uuid)
            ->first();
        return $result;
    }

    public function updateStatusUser($id)
    {
        $result = $this->user
            ->where('unique_id', $id)
            ->update(
                ['status' => 1]
            );
        return $result;
    }

    public function verifyEmail($email)
    {
        $result = $this->user->select('*')
            ->where('email', $email)
            ->first();
        return $result;
    }

    public function verifyPhone($phone)
    {
        $result = $this->user->select('*')
            ->where('phone', $phone)
            ->first();
        return $result;
    }

    public function getDataUserId($user_id)
    {
        $result = $this->user->whereId($user_id)->first();
        return $result;
    }

    public function updatePassword($passwordNew, $uuid)
    {
        return $this->user->where('unique_id', $uuid)
            ->update(
                ['password' => $passwordNew]
            );
    }

    public function updatePasswordByEmail($password_new_hash, $email)
    {
        return $this->user->where('email', $email)
            ->update(
                [
                    'password' => $password_new_hash,
                    'status' => 1,
                ]
            );
    }

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

    public function updateGoogleId($user)
    {
        return $this->user->where('email', $user->getEmail())->update(
            [
            'google_id' => $user->getId(),
            ]
        );
    }

}
