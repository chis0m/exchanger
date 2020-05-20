<?php

namespace App\Traits;

use App\Http\Resources\Error; 

trait ApiResponse {

    public function success($data, $code, $resource){
        $full_resource_path = 'App\Http\Resources'.'\\'.$resource;
        return (new $full_resource_path($data))
        ->response()
        ->setStatusCode($code);
    }

    public function error($error, $code){
        $typed_cast_to_object = (object)['message' => $error];
        return (new Error($typed_cast_to_object))
        ->response()
        ->setStatusCode($code);
    }

}