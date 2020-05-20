<?php

namespace App\Traits;


trait Helper
{
    public function array_to_model($array, $model)
    {
        $model_absolute_path = 'App\\'.$model;
        $object = new $model_absolute_path();
        $object->fill($array);
        return $object;
    }
}