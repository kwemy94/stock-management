<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\ResourceRepository;

class UserRepository extends ResourceRepository {

    public function __construct(User $user) {
        $this->model = $user;
    }

    public function getAll() 
    {
        return $this->model->orderBy('id', 'DESC')->get();
    }

}
