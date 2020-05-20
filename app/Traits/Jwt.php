<?php
namespace App\Traits;

use JWTAuth;
use JWTFactory;
use App\Traits\Helper;
use App\Traits\ApiResponse;
use Tymon\JWTAuth\Claims\Issuer;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\User as UserResource;

trait Jwt 
{
    use ApiResponse, Helper;

    public function handleValidation($validation){
        $validator = Validator::make(request()->all(),  $validation);
        if($validator->fails()){
           return $this->error($validator->errors(), 422);
        }
    }

    public function getTokenFromUserObject()
    {
        $user = $this->array_to_model($this->user(), $this->model);
        $token = JWTAuth::fromUser($user);
        return $this->respondWithToken($token);
    }

    public function getTokenFromOtherAttributes()
    {
        $claims = [
            'iss' => new Issuer(config('app.name')),
        ];
        $data = array_merge($this->user(), $claims);
        $customClaims = JWTFactory::customClaims($data);
        $payload = JWTFactory::make($data);
        $token = JWTAuth::encode($payload);
        return $this->respondWithToken($token->get());
    }

    public function me()
    {
        return response()->json($this->user());
    }

    public function user()
    {
        $user = [];
        $row = auth()->user();
        $user['id'] = $row->id;
        $user['name'] = $row->name;
        $user['email'] = $row->email;
        $user['role'] = strtolower($this->model);
        return $user;
    }
}