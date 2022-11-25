<?php
namespace App\Repositories\Eloquent\API;

use App\Models\User;

class AuthRepository extends BaseRepository
{

    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function createUser($data)
    {
        return $this->user->create($data);
    }

    public function verifyUniid($id)
    {
        $result = $this->user->select('activate_date', 'unique_id', 'status')
            ->where('unique_id', $id)
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

}
