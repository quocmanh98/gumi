<?php
namespace App\Services\API;

use Illuminate\Support\Facades\Auth;

class BaseService{

    public function sendError($error){
        throw new \Exception($error, 1);
    }

}

