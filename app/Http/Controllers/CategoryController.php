<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Category;

class CategoryController extends Controller {

	public function findCategoryById(int $id){
		return Category::where('id',$id)->first();
	}

	public function findCategoryByName(string $name){
		return Category::where('name',$name)->first();
	}

	public function getAll(){
		return Category::all();
	}

	public function getOrCreateCategory(string $name,int $parent_id = null){
		$exist = $this->findCategoryByName($name);
		if($exist) return $exist;

		$cat = new Category();
		$cat->name = $name;
		$cat->parent_id = $parent_id;
		$cat->save();
		return $cat;
	}

	public function createFromString($category){
		$match = preg_match("/(, )/", $category);
		if($match == 1){
			$i = strpos($category,',');
			$padre_cat = substr($category,0,$i);
			$hija_cat = substr($category,$i + 2);

			$padre = $this->getOrCreateCategory($padre_cat);
			$hija = $this->getOrCreateCategory($hija_cat,$padre->id);
		}
		else{
			$hija = $this->getOrCreateCategory($category);
		}

		return $hija;
	}
}