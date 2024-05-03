<?php

namespace App\Repositories\Treasury;

use App\Models\Recipe;
use App\Repositories\ResourceRepository;

class RecipeRepository extends ResourceRepository {

    public function __construct(Recipe $recipe) {
        $this->model = $recipe;
    }

    public function getAll()
    {
        return $this->model->get();
    }

}
