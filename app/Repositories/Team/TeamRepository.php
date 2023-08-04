<?php

namespace App\Repositories\Team;

use App\Models\Team;
use App\Repositories\ResourceRepository;

class TeamRepository extends ResourceRepository {

    public function __construct(Team $team) {
        $this->model = $team;
    }

    public function getAll() 
    {
        return $this->model->get();
    }

}
