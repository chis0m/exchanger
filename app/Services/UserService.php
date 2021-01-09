<?php

namespace App\Services;

use Exception;
use App\User;

class UserService
{

    public function update($request)
    {
        $user = $request->user();
        $firstName = $request['first_name'] ? $request['first_name'] : $user['first_name'];
        $lastName = $request['last_name'] ? $request['last_name'] : $user['last_name'];
        $email = $request['email'] ? $request['email'] : $user['email'];
        $phoneNo = $request['phone_no'] ? $request['phone_no'] : $user['phone_no'];
        $country = $request['country'] ? $request['country'] : $user['country'];
        $baseCurrency = $request['base_currency'] ? $request['base_currency'] : $user['base_currency'];

        $data = User::updateOrCreate(
            ['id' => auth()->id()],
            [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone_no' => $phoneNo,
                'country' => $country,
                'base_currency' => strtoupper($baseCurrency),
            ]
        );
        return $data;
    }
}
