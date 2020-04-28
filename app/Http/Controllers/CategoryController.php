<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Category;

class CategoryController extends Controller {

	public function findCategoryById(int $id){
		return Category::where('id',$id)->first();
	}

	public function findCategoryByName(string $name, $parent_id){
		return Category::where('name',$name)->where('parent_id',$parent_id)->first();
	}

	public function getAll(){
		return Category::all();
	}

	public function getOrCreateCategory(string $name,int $parent_id = null){
		$exist = $this->findCategoryByName($name,$parent_id);
		if($exist) return $exist;

		$cat = new Category();
		$cat->name = $this->autocorrect($name);
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

	public function autocorrect($str){
		$arr = explode(" ",$str);
		$aux = "";
		for ($i=0; $i < count($arr) ; $i++) {
			$value = $arr[$i];
			$value = strtolower($value);
			if(strlen($value) > 1)
				$aux = $aux.ucwords($value);
			else
				$aux = $aux.$value;
			if($i + 1 < count($arr))
				$aux = $aux." ";
		}
		return $aux;
	}

}