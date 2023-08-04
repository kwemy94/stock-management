<?php

namespace App\Repositories;


abstract class ResourceRepository {

    protected $model;

    public function getPaginate($n=null) {
        if($n){
            return $this->model->paginate($n);
        }
        return $this->model->get();
    }

    public function store($inputs) {
        return $this->model->create($inputs);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id) {
        return $this->model->where('id', $id)->first();
    }
    public function getByEmail($email){
        $result = $this->model->where('email',$email)->first();
        return  $result;
    }
    public function update($id, $inputs) {
        $this->getById($id)->update($inputs);
    }

    public function destroy($id) {
        $this->getById($id)->delete();
    }

}

