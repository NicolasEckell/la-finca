<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryService;
use Laracasts\Flash\Flash;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = (new CategoryService)->getListed(false);
        return view('categories.index')->with('categories', $categories);
    }

    public function create()
    {
        $categories = (new CategoryService)->getListed(false);
        return view('categories.create')->with('categories', $categories);
    }

    public function edit($id)
    {
        $category = (new CategoryService)->getById($id);
        return view('categories.edit')->with('category', $category);
    }

    public function getProducts($id)
    {
        $category = (new CategoryService)->getById($id);
        return view('categories.products')->with('category', $category);
    }

    public function store(Request $request)
    {

        if (!isset($request['parent_id']) || !isset($request['name']))
            return -1;

        $parent_id = null;
        if ($request['parent_id'] != 0) {
            $parent = (new CategoryService)->getById($request['parent_id']);
            if (!$parent)
                return -1;
            else
                $parent_id = $parent->id;
        }

        $category = new Category();
        $category->name = $request['name'];
        $category->parent_id = $parent_id;
        $category->save();

        return redirect()->route('categories');
    }

    public function update(Request $request)
    {
        if (!isset($request['id']))
            return -1;

        $category = (new CategoryService)->getById($request['id']);
        if (!$category) return -1;

        if (!isset($request['name']))
            return -1;

        $category->name = $request['name'];
        $category->save();

        return redirect()->route('categories');
    }

    public function delete($id)
    {
        $category = (new CategoryService)->getById($id);
        if (!$category) return -1;

        if (count($category->children) > 0) {
            Flash::error('No es posible eliminar una categoría que tenga subcategorías');
            return redirect()->route('categories');
        } elseif (count($category->products) > 0) {
            $n = count($category->products);
            foreach ($category->products as $key => $product) {
                $product->categories()->detach($category->id);
                $product->showOnStore = false;
                $product->save();
            }
            Flash::info('Categoría eliminada! Sin embargo, ' . $n . ' productos quedaron sin una categoría asignada');
        } else {
            Flash::success('Categoría eliminada!');
        }

        $category->delete();
        return redirect()->route('categories');
    }
}
