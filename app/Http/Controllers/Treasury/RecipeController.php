<?php

namespace App\Http\Controllers\Treasury;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\Treasury\RecipeRepository;

class RecipeController extends Controller
{
    private $recipeRepository;

    public function __construct(RecipeRepository $recipeRepository){
        $this->recipeRepository = $recipeRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        toggleDBsqlite();
        $recipes = $this->recipeRepository->getAll();

        return view('admin.treasury.recipe.index', compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recipe $recipe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recipe $recipe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe)
    {
        //
    }
}
