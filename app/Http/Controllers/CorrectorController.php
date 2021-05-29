<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Category;
use App\Product;

class CorrectorController extends Controller {

	public function getProducts(){
		return app()->make('App\Http\Controllers\ProductController')->getAll();
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

    public function corrector(){
		$this->correctorCategories();
		$this->correctorVariants();
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
		$categoryController = app()->make('App\Http\Controllers\CategoryController');
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
				$product->showOnStore = false;
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
}
