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
		if(strcmp($child_cat->name, "Al Peso") == 0){
			if(strcmp($parent_cat->name,"Aceitunas y Encurtidos") == 0){
				return [100,150,250,500];
			}
			else if(strcmp($parent_cat->name,"Panificacion") == 0){
				return [250,600,1000];
			}
		}
		else {
			if(strcmp($child_cat->name, 'Barras Feteados') == 0)
				return [200,250,300,500];
			elseif(strcmp($child_cat->name, 'Cremosos / Mozzarella / Por Salut') == 0)
				return [400,600,1000];
			elseif(strcmp($child_cat->name, 'Semiduros') == 0)
				return [400,600,1000];
			elseif(strcmp($child_cat->name, 'Duros') == 0)
				return [400,600,1000];
			elseif(strcmp($child_cat->name, 'Rallados') == 0)
				return [100,150,250,500];
			elseif(strcmp($child_cat->name, 'Especiales') == 0)
				return [150,250,500];
			elseif(strcmp($child_cat->name, 'Cocidos y Arrollados') == 0)
				return [200,250,300,500];
			elseif(strcmp($child_cat->name, 'Crudos') == 0)
				return [100,150,250,300,500];
			elseif(strcmp($child_cat->name, 'Salames Feteados y Mortadelas') == 0)
				return [150,250,300,500];
			elseif(strcmp($child_cat->name, 'Ahumados') == 0)
				return [150,250,300,500];
			elseif(strcmp($child_cat->name, 'Frutas Secas y Deshidratadas') == 0)
				return [100,150,250,500];
			elseif(strcmp($child_cat->name, 'Elaborados') == 0)
				return [460,620,1000];
			else
				return [];
		}
	}

	public function getPriceOfVariant(float $variant, float $pricePerKilo){
		$price = ($variant * $pricePerKilo) / 1000;
		return $price;
	}

	public function isValidProduct(Product $product){
		$isValid = true;
		if((int) $product->price == 0 || $product->categories()->first()){
			$isValid = false;
			if($product->categories()->first()->isRoot())
				$isValid = false;
			else
				$isValid = true;
		}
		return $isValid;
	}

	private function correctorCategories(){
		$products = $this->getProducts();
		$categoryController = App::make('App\Http\Controllers\CategoryController');
		foreach ($products as $key => $product) {
            $cat = $categoryController->createFromString($product->categories);
			$product->save();
            $product->addCategory($cat);
		}
	}

	private function correctorVariants(){
		$products = $this->getProducts();
		foreach ($products as $key => $product) {
			if(!$this->isValidProduct($product)){
				$product->type = "No especificado";
				$product->save();
				continue;
			}
			$variants = $this->getVariants($product->categories()->first());
			if(count($variants) == 0){
				$product->type = "Unidad";
				$product->save();
			}
			else if(count($variants) > 0){
				$product->type = "Peso";
				$product->save();

				$COREvariants = app()->make('\App\Http\Controllers\VariantController')->getAll();
				for ($j=0; $j < count($COREvariants); $j++) {
					$CORE = json_decode($COREvariants[$j]->variants);
					for ($k=0; $k < count($CORE); $k++) {
						if((float)$CORE[$k] != (float) $variants[$k]){
							continue 2;
						}
					}
					$product->variant_id = $COREvariants[$j]->id;
					$product->save();
					continue 2;
				}
			}
		}
	}

	public function corrector(){
		$this->correctorCategories();
		$this->correctorVariants();
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
		$item[2] = $this->parseCategories($product->categories()->first());
		$item[3] = $this->parseType($product->type);
		$item[4] = $this->parseWeight($weight);
		$item[5] = "";
		$item[6] = "";
		$item[7] = "";
		$item[8] = "";
		$item[9] = $price;
		$item[10] = "";
		$item[11] = $weight;
		$item[12] = "";//$product->stock;
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

	public function parseBoolean($val): string{
		if($val) return "SI";
		else return "NO";
	}

	public function parseUrl(string $name): string {
		return $this->seoUrl($name);
	}

	public function parseCategories(Category $child_cat): string {
		return $child_cat->getParsed();
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