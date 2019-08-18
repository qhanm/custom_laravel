<?php

namespace App\Http\IInterface;

interface RepositoryInterface{

    // primary key
    public function findOne(int $id);

    public function findAll();

    public function create(array $data);

    public function update(array $data, int $id);

    // primary key
    public function delete($id);

    public function findByAttribute($attribute, $value, $operator = '=');

    public function findByArrayAttribute(array $attribute);
}