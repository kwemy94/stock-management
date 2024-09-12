<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Repositories\Category\CategoryRepository;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        toggleDBsqlite();
        $categories = $this->categoryRepository->getAll();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        toggleDBsqlite();
        try {
            $this->categoryRepository->store($request->post());

            return redirect(route('category.index'))->with('success', 'Catégorie crée !');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', 'Oups!! Echec de création de la catégorie!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        toggleDBsqlite();
        $category = $this->categoryRepository->getById($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        toggleDBsqlite();
        try {
            $category = $this->categoryRepository->getById($id);
            $this->categoryRepository->update($category->id, $request->post());

            return redirect(route('category.index'))->with('success', 'Catégorie mis à jour !');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', 'Oups!! Echec de mise à jour de la catégorie!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        toggleDBsqlite();
        try {
            $category = $this->categoryRepository->getById($id);
            $category->delete();

            return redirect()->back()->with('success', 'Catégorie supprimée !');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Oups!! Echec de suppression');
        }
    }
}
