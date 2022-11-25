<?php
namespace App\Services\API;

use App\Http\Resources\API\UserResource;
use App\Repositories\Eloquent\API\UserRepository;

class UserService extends BaseService
{

    protected $userRepository;
    public function __construct()
    {
        $this->userRepository = new UserRepository;
    }

    public function getAllUser($status,$roleId,$search,$sortBy,$sortType){
        $filters = [];

        if(!empty($status)){
            if($status == 'active'){
                $status = 1;
            }else{
                $status = 0;
            }


            $filters[] = ['users.status','=',$status];
        }

        if(!empty($roleId)){
            $filters[] = ['users.role_id','=',$roleId];
        }

        $allowSort = ['asc','desc'];
        if(!empty($sortType) && in_array($sortType,$allowSort)){
            if($sortType == 'desc'){
                $sortType = 'asc';
            }else{
                $sortType = 'desc';
            }
        }else{
            $sortType = 'asc';
        }

        $sortArr =  [
            'sortBy' => $sortBy,
            'sortType' => $sortType
        ];

        $result = $this->userRepository->getAllUser($filters, $search,$sortArr,config('services.PER_PAGE'));
        if($result->count() > 0){
            return UserResource::collection( $result  );
        }
        throw new \Exception('Error ! Fetch Data User No Success', 1);
    }

}
