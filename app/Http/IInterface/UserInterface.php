<?php

namespace App\Http\IInterface;

interface UserInterface{

    public function login(Object $object);

    public function logout(Object $object);

    public function singin(Object $object);

    public function singout(Object $object);
}