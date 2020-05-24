<?php

namespace App\Http\Controllers\User;

use App\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
 

class UserController extends Controller
{
    use ApiResponse;

    protected $resource = 'User';

    public function index(){
        $user = User::find(1);
        if(!$user){
            return $this->error('Resource not found', 404);
        }
        return $this->success($user, 200, $this->resource);
    }
}
