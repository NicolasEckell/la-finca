<?php

namespace App\Services;

use App\Category;

class CategoryService{

    public function getOrCreateCategory(string $name, int $parent_id = null)
    {
        $exist = $this->getCategoryByName($name, $parent_id);
        if ($exist) return $exist;

        $cat = new Category();
        $cat->name = $this->autocorrect($name);
        $cat->parent_id = $parent_id;
        $cat->save();
        return $cat;
    }

    public function createFromString($category)
    {
        $match = preg_match("/(, )/", $category);
        if ($match == 1) {
            $i = strpos($category, ',');
            $padre_cat = substr($category, 0, $i);
            $hija_cat = substr($category, $i + 2);

            $padre = $this->getOrCreateCategory($padre_cat);
            $hija = $this->getOrCreateCategory($hija_cat, $padre->id);
        } else {
            $hija = $this->getOrCreateCategory($category);
        }

        return $hija;
    }

    public function autocorrect($str)
    {
        $arr = explode(" ", $str);
        $aux = "";
        for ($i = 0; $i < count($arr); $i++) {
            $value = $arr[$i];
            $value = strtolower($value);
            if (strlen($value) > 1)
                $aux = $aux . ucwords($value);
            else
                $aux = $aux . $value;
            if ($i + 1 < count($arr))
                $aux = $aux . " ";
        }
        return $aux;
    }

    public function getById(int $id)
    {
        return Category::where('id', $id)->first();
    }

    public function getCategoryByName(string $name, $parent_id)
    {
        return Category::where('name', $name)->where('parent_id', $parent_id)->first();
    }

    public function getAll()
    {
        return Category::all();
    }

    //if not formatted, is full category item
    public function getListed($formatted = true)
    {
        $categories = Category::where('parent_id', null)->get();
        if($formatted)
            $list = array(['id' => null, 'name' => 'Seleccione un valor...', 'disabled' => false]);
        else
            $list = array();

        foreach ($categories as $key => $category) {
            $list = array_merge($list, $this->treeView($category, $formatted));
        }
        return $list;
    }

    private function treeView($category, $formatted, $prefix = "")
    {
        $children = $category->children;
        if ($formatted) {
            $disabled = (count($children) > 0) ? true : false;
            $list[] = ['id' => $category->id, 'name' => $prefix . $category->name, 'disabled' => $disabled];
        } else {
            $list[] = $category;
        }
        if (count($children) > 0) {
            foreach ($children as $key => $child) {
                $list = array_merge($list, $this->treeView($child, $formatted, $prefix . ($key + 1) . ". "));
            }
        }
        return $list;
    }

}
