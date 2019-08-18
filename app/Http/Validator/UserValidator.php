<?php

namespace App\Http\Validator;

class UserValidator{

    public static function ruleCrate(){
        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ];
    }

    public function ruleLogin(){
        
    }

}