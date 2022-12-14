<?php
namespace App\Services\API;

class BaseService
{
    public function sendError($error)
    {
        throw new \Exception($error, 1);
    }
}
