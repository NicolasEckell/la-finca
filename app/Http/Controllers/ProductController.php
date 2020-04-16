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
			$item[2] = $this->parseCategories($array[$i]->categories);
			[$item[3],$item[4],$item[5],$item[6],$item[7],$item[8]] = $this->parseVariants($array[$i]->name, $array[$i]->categories);
			$item[9] = $array[$i]->price;
			$item[10] = "";
			$item[11] = $this->parseWeight($array[$i]->name, $array[$i]->categories);
			$item[12] = $array[$i]->stock;
			$item[13] = "";
			$item[14] = "";
			$item[15] = "SI";
			$item[16] = "NO";
			$item[17] = $array[$i]->details;
			$item[18] = $this->parseTags($array[$i]->name, $array[$i]->categories);
			$item[19] = $this->parseSeoTitle($array[$i]->name);
			$item[20] = $this->parseSeoDes($array[$i]->details);
			$item[21] = $array[$i]->vendor;
			array_push($data, $item);
		} 
		return $data;
	}

	public function parseUrl($name){
		return $this->seoUrl($name);
	}

	public function parseCategories($categories){

	}

	public function parseVariants($name, $categories){

	}

	public function parseWeight($name, $categories){

	}

	public function parseTags($name, $categories){

	}

	public function parseSeoTitle($name){
		return $this->seoUrl($name);
	}

	public function parseSeoDes($details){
		return $details;
	}

	function seoUrl($string) {
   		//Lower case everything
		$string = strtolower($string);
    	//Make alphanumeric (removes all other characters)
		$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    	//Clean up multiple dashes or whitespaces
		$string = preg_replace("/[\s-]+/", " ", $string);
    	//Convert whitespaces and underscore to dash
		$string = preg_replace("/[\s_]/", "-", $string);
		return $string;
	}
}