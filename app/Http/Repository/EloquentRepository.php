<?php

namespace App\Http\Repository;

abstract class EloquentRepository implements RepositoryInterface{
    
    protected $_model;

    public function __construct(){
        $this->setModel();
    }

    public function setModel(){
        $this->_model = app()->make(
            $this->getModel(),
        );
    }

    abstract protected function getModel();

    public function findOne(int $id){
        return $this->_model::findOrFail($id);
    }

    public function findAll(){
        return $this->_model::all();
    }

    public function create(array $datas){
        foreach($datas as $key => $data){
            $this->_model->{$key} = $data;
        }
        return $this->_model->save();
    }

    public function update(array $datas, int $id){
        
        $model = $this->_model::findOrFail($id);

        if($model){
            foreach($datas as $key => $data){
                $this->_model->{$key} = $data;
            }
            return $model->save();
        }
        return false;
    }

    public function delete(int $id){
        $model = $this->_model::findOrFail($id);
        if($model){
            return $model->delete();
        }
        return false;
    }

    public function findByAttribute($attribute, $value, $operator){
        return $this->_model->where($attribute, $operator, $value)->all();
    }

    /**
     * @param first: filed
     * @param second: value
     * @param third: operator
     */
    public function findByArrayAttribute(array $attribute){
        $arrQuery = array();

        foreach($attribute as $attr){
            if(count($attr) <= 1){
                abort(200, "Error: class" . $this->getModel() . " method findByArrayAttribute");
            }
            array_push($arrQuery, [$attr[0], $attr[2] ?? '=', $attr[1]]);
        }
        return $this->_model->where($arrQuery)->get();
    }
}