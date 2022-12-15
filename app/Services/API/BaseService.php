<?php
namespace App\Services\API;

class BaseService
{
    /**
     * Summary of sendError
     * @param mixed $error
     * @throws \Exception
     * @return never
     */
    public function sendError($error)
    {
        throw new \Exception($error, 1);
    }
}
