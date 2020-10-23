<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Category;
use Flash;

class CategoryController extends Controller {

	public function index(){
		$categories = $this->getListed(false);
		return view('categories.index')->with('categories',$categories);
	}

	public function create(){
		$categories = $this->getListed(false);
		return view('categories.create')->with('categories',$categories);
	}

	public function edit($id){
		$category = $this->getById($id);
		return view('categories.edit')->with('category',$category);
	}

	public function showProducts($id){
		$category = $this->getById($id);
		return view('categories.products')->with('category',$category);
	}

	public function store(Request $request){

		if(!isset($request['parent_id']) || !isset($request['name']))
			return -1;

		$parent_id = null;
		if($request['parent_id'] != 0){
			$parent = $this->getById($request['parent_id']);
			if(!$parent)
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

	public function update(Request $request){
		if(!isset($request['id']))
			return -1;

		$category = $this->getById($request['id']);
		if(!$category) return -1;

		if(!isset($request['name']))
			return -1;

		$category->name = $request['name'];
		$category->save();

		return redirect()->route('categories');
	}

	public function delete($id){
		$category = $this->getById($id);
		if(!$category) return -1;

		if(count($category->children) > 0){
			Flash::error('No es posible eliminar una categoría que tenga subcategorías');
			return redirect()->route('categories');
		}
		elseif(count($category->products) > 0){
			$n = count($category->products);
			foreach ($category->products as $key => $product) {
				$product->categories()->detach($category->id);
				$product->showOnStore = false;
				$product->save();
			}
			Flash::info('Categoría eliminada! Sin embargo, ' . $n .' productos quedaron sin una categoría asignada');
		}
		else{
			Flash::success('Categoría eliminada!');
		}

		$category->delete();
		return redirect()->route('categories');
	}

	public function getOrCreateCategory(string $name,int $parent_id = null){
		$exist = $this->getCategoryByName($name,$parent_id);
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

	public function getById(int $id){
		return Category::where('id',$id)->first();
	}

	public function getCategoryByName(string $name, $parent_id){
		return Category::where('name',$name)->where('parent_id',$parent_id)->first();
	}

	public function getAll(){
		return Category::all();
	}

	//if not formatted, is full category item
	public function getListed($formatted = true){
		$categories = Category::where('parent_id', null)->get();
		$list = array();
		foreach ($categories as $key => $category) {
			$list = array_merge($list,$this->treeView($category,$formatted));
		}
		return $list;
	}

	private function treeView($category, $formatted, $prefix = ""){
		$children = $category->children;
		if($formatted){
			$disabled = (count($children) > 0)?true:false;
			$list[] = ['id' => $category->id,'name' => $prefix.$category->name,'disabled' => $disabled];
		}
		else{
			$list[] = $category;
		}
		if(count($children) > 0){
			foreach ($children as $key => $child) {
				$list = array_merge($list, $this->treeView($child,$formatted,$prefix.($key+1).". "));
			}
		}
		return $list;
	}
}