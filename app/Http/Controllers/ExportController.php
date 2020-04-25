<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Category;
use App\Product;

use App;

class ExportController extends Controller {

	public function getProducts(){
		return App::make('App\Http\Controllers\ProductController')->getAll();
	}

	public function getVariants(Category $child_cat): array{
		$parent_cat = $child_cat->getParent();
		if($child_cat->name == "Al Peso"){
			if($parent_cat->name == "Aceitunas y Encurtidos"){
				return [100,150,250,500];
			}
			else if($parent_cat->name == "Panificados"){
				return [250,600,1000];
			}
		}
		else {
			switch ($child_cat->name) {
				case 'Barras Feteados':
				return [200,250,300,500];
				break;
				case 'Cremosos / Mozzarella / Por Salut':
				return [400,600,1000];
				break;
				case 'Semiduros':
				return [400,600,1000];
				break;
				case 'Duros':
				return [400,600,1000];
				break;
				case 'Rallados':
				return [100,150,250,500];
				break;
				case 'Especiales Fraccionados':
				return [150,250,500];
				break;
				case 'Cocidos y Arrollados':
				return [200,250,300,500];
				break;
				case 'Crudos':
				return [100,150,250,300,500];
				break;
				case 'Salames Feteados y Mortadela':
				return [150,250,300,500];
				break;
				case 'Ahumados':
				return [150,250,300,500];
				break;
				case 'Frutos Secos y Deshidratados':
				return [100,150,250,500];
				break;
				case 'Elaborados':
				return [460,620,1000];
				break;
				default:
				return [];
				break;
			}
		}
	}

	public function getPriceOfVariant(float $variant, float $pricePerKilo){
		$price = ($variant * $pricePerKilo) / 1000;
		return $price;
	}

	public function exportProducts(){
		$products = $this->getProducts();
		$data = [];

		for ($i=0; $i < count($products) ; $i++) {
			$product = $products[$i];
			$variants = $this->getVariants($product->categories()->first());

			if(count($variants) == 0){
				$price = $product->price;
				$weight = "";
				$item = $this->createRow($product,$price,$weight);
				array_push($data, $item);
			}
			else if(count($variants) > 0){
				for ($j=0; $j < count($variants); $j++) {
					$price = $this->getPriceOfVariant((float) $variants[$j], (float) $product->price);
					$weight = $variants[$j];
					$product->tipo = "Peso";
					$item = $this->createRow($product,$price,$weight);
					array_push($data, $item);
				}
			}
		} 
		return $data;
	}

	public function createRow(Product $product, $price, $weight){
		$item = [];
		$item[0] = $this->parseUrl($product->name);
		$item[1] = $product->name;
		$item[2] = $this->parseCategories($product->categories()->first());
		$item[3] = $product->tipo;
		$item[4] = $this->parseWeight($weight);
		$item[5] = "";
		$item[6] = "";
		$item[7] = "";
		$item[8] = "";
		$item[9] = $price;
		$item[10] = "";
		$item[11] = $weight;
		$item[12] = $product->stock;
		$item[13] = "";
		$item[14] = "";
		$item[15] = "SI";
		$item[16] = "NO";
		$item[17] = $product->details;
		$item[18] = $this->parseTags($product->name, $product->categories);
		$item[19] = $this->parseSeoTitle($product->name);
		$item[20] = $this->parseSeoDes($product->details);
		$item[21] = $product->vendor;
		return $item;
	}

	public function parseUrl(string $name): string {
		return $this->seoUrl($name);
	}

	public function parseCategories(Category $child_cat): string {
		return $child_cat->getParsed();
	}

	public function parseWeight($weight): string {
		if($weight == 1000) {
			return "1 Kg";
		}
		else{
			if($weight === "")
				return "unidad";
			else
				return $weight." gramos";
		}
		
	}

	public function parseTags($name, $categories){
		$tags_names = explode(" ", $name);
		$tags_categories = explode(",", $categories);
		$tags = "";
		foreach ($tags_names as $key => $tag) {
			if($tags === "")
				$tags = $tag;
			else
				$tags = $tags.", ".$tag;
		}
		foreach ($tags_categories as $key => $tag) {
			$tags = $tags.", ".$tag;
		}
		return $tags;
	}

	public function parseSeoTitle($name){
		return $this->seoUrl($name);
	}

	public function parseSeoDes($details){
		return $details;
	}

	function seoUrl($str){
   		//Lower case everything
		$str = strtolower($str);
    	//Make alphanumeric (removes all other characters)
		$str = preg_replace("/[^a-z0-9_\s-]/", "", $str);
    	//Clean up multiple dashes or whitespaces
		$str = preg_replace("/[\s-]+/", " ", $str);
    	//Convert whitespaces and underscore to dash
		$str = preg_replace("/[\s_]/", "-", $str);
		return $str;
	}
}