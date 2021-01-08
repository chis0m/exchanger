<?php

namespace App\Traits;

trait Helper
{
    public function arrayToModel($array, $model)
    {
        $modelAbsolutePath = 'App\\' . $model;
        $object = new $modelAbsolutePath();
        $object->fill($array);
        return $object;
    }
}
