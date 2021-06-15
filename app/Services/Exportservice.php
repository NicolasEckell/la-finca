<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ExportService {

	public function getProducts(): Collection{
		return (new ProductService)->getAll();
	}

	public function getPriceOfVariant(float $variant, float $pricePerKilo){
		$price = ($variant * $pricePerKilo) / 1000;
		return $price;
	}

	public function exportProducts(){
		$products = $this->getProducts();
		$data = [];

		foreach ($products as $key => $product) {
			$product->purge();

			if(strcmp($product->type,"Unidad") == 0){
				$price = $product->price;
				$weight = "";
				$item = $this->createRow($product,$price,$weight);
				array_push($data, $item);
			}
			else if(strcmp($product->type,"Peso") == 0){
				$variant = $product->variant();
				if(!$variant) continue;
				$variants = json_decode($variant->variants);
				for ($j=0; $j < count($variants); $j++) {
					$price = $this->getPriceOfVariant((float) $variants[$j], (float) $product->price);
					$weight = $variants[$j];
					$item = $this->createRow($product,$price,$weight);
					array_push($data, $item);
				}
			}
		}
		return $data;
	}

	public function createRow(Product $product, $price, $weight){
		$item = [];
		$item[0] = $this->parseUrl($product->code);
		$item[1] = $product->name;
		$item[2] = $this->parseCategories($product);
		$item[3] = $this->parseType($product->type);
		$item[4] = $this->parseWeight($weight);
		$item[5] = "";
		$item[6] = "";
		$item[7] = "";
		$item[8] = "";
		$item[9] = $price;
		$item[10] = "";
		$item[11] = $weight;
		$item[12] = $this->parseStock($product->stock);
		$item[13] = $product->code;
		$item[14] = $product->barcode;
		$item[15] = $this->parseBoolean($product->showOnStore);
		$item[16] = "NO";
		$item[17] = $product->details;
		$item[18] = $this->parseTags($product->name, $product->categories);
		$item[19] = $this->parseSeoTitle($product->name);
		$item[20] = $this->parseSeoDes($product->details);
		$item[21] = $product->vendor;
		return $item;
	}

	public function parseStock($val){
		return ($val < 0)?"":$val;
	}

	public function parseBoolean($val): string{
		if($val) return "SI";
		else return "NO";
	}

	public function parseUrl(string $name): string {
		return $this->seoUrl($name);
	}

	public function parseCategories(Product $product): string {
        return $product->exportCategories();
	}

	public function parseType($type){
		if($type == "Peso")
			return $type;
		else
			return "";
	}

	public function parseWeight($weight): string {
		if($weight == 1000) {
			return "1 Kg";
		}
		else{
			if($weight === "")
				return "";
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
