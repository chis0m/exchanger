<?php
namespace App\Traits;

use JWTAuth;
use JWTFactory;
use App\User;
use Tymon\JWTAuth\Claims\Issuer;
use App\Http\Resources\User as UserResource;

trait Jwt 
{

    public function getTokenFromUserObject()
    {
        $response = [];
        $user = auth()->user();
        $token = JWTAuth::fromUser($user);
        $response['access_token'] = $token;
        $response['id'] = $user->id;
        $response['name'] = $user->name;
        $response['email'] = $user->email;
        $response['roles'] = $user->roles(); 
        return $response;
        // $token = $this->respondWithToken($token);
    }

    // public function getTokenFromOtherAttributes()
    // {
    //     $claims = [
    //         'iss' => new Issuer(config('app.name')),
    //     ];
    //     $data = array_merge($this->user(), $claims);
    //     $customClaims = JWTFactory::customClaims($data);
    //     $payload = JWTFactory::make($data);
    //     $token = JWTAuth::encode($payload);
    //     // return $this->respondWithToken($token->get());
    //     return ['token' => $token->get(), 'type' => 'bearer'];
    // }

    public function me()
    {
        return response()->json($this->user());
    }
}