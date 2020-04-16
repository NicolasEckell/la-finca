<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Product;

class ProductController extends Controller {

	public function findProductById(int $id){
		return Product::where('id',$id)->first();
	}

	public function findProductByCode(int $code){
		return Product::where('code',$code)->first();
	}

	public function getAll(){
		return Product::all();
	}

	public function getAllReady2Export(){
		$array = $this->getAll();
		$data = [];
		for ($i=0; $i < count($array) ; $i++) { 
			$item = [];
			$item[0] = $this->parseUrl($array[$i]->name);
			$item[1] = $array[$i]->name;
			$item[3] = $this->parseCategories($array[$i]->categories);

			$item[9] = $array[$i]->price;
			$item[11] = "";
			$item[12] = $this->parseWeight($array[$i]->categories);
			$item[13] = "";
			array_push($data, $item);
		} 
		return $data;
	}

	public function parseUrl($name){}

	public function parseCategories($categories){}

	public function parseVariants($name){}

	public function parseWeight($name){}

	public function parseTags($name){}

	public function parseSeoTitle($name){}

	public function parseSeoDes($name){}
}