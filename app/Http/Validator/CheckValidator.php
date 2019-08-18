<?php

namespace App\Http\Validator;

use App\Http\Validator\BaseValidator;

class CheckValidator{

    public static function check(string $className,string $method,array $datas){
        $class = "App\Http\Validator\\" . $className;

        $rules = call_user_func([$class, $method]);

        if(empty($rules)){
            abort(200, "Rules of " . $class ." is null, please check Again");
        }
        //dd($datas);
        $validator = BaseValidator::make($datas, $rules);
        
        if($validator->fails()){
            return $validator->errors();
        }

        return true;
    }
}