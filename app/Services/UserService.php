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
        $baseCurrencyId = $request['base_currency_id'] ? $request['base_currency_id'] : $user['base_currency_id'];

        $data = User::updateOrCreate(
            ['id' => auth()->id()],
            [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone_no' => $phoneNo,
                'country' => $country,
                'base_currency_id' => $baseCurrencyId
            ]
        );
        \Log::info('hello');
        return $data;
    }
}
