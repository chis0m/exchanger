<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Tymon\JWTAuth\Claims\Issuer;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use JWTAuth;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;
    use DispatchesJobs;
    use ApiResponse;

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token = null, $user = null)
    {
        // @phpstan-ignore-next-line
        $expiresIn = Auth::guard()->factory()->getTTL() * config('jwt.ttl');
        $date = Carbon::now()->addSeconds($expiresIn);
        $timestamp = date_timestamp_get($date) * 1000;
        $user = ($user) ? $user : auth()->user();
        $data = [
            'access_token' => ($token) ? $token :  JWTAuth::fromUser($user),
            'token_type' => 'bearer',
            'expires_in' => $expiresIn,
            'expires_at' => $timestamp,
            'user' => $user,
        ];
        return $data;
    }

    public function me()
    {
        return $this->respondWithToken();
    }
}
