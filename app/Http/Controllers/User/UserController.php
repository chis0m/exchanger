<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\Detail as UserDetailRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Exception;
use DB;

class UserController extends Controller
{
    protected $userservice;

    public function __construct(UserService $userservice)
    {
        $this->userservice = $userservice;
    }

    public function update(UserDetailRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->userservice->update($request)->toArray();
            DB::commit();
            return $this->success('Update Successful', $data, Response::HTTP_ACCEPTED);
        } catch (Exception $e) {
            DB::rollback();
            return $this->respond($e);
        }
    }
}
