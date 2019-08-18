<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper\JsonParse;
use App\Http\Validator\CheckValidator;
use App\Http\Validator\UserValidator;

class TestController extends Controller
{
    public function index(){
        $name = " nam";
        $age = 14;

        $std  = new \stdClass;

        $std->email = "Quach hoai nam";


        dd(CheckValidator::check("UserValidator", "ruleCrate", ['email' => "qhnam@gmail.com"]));
    }
}
