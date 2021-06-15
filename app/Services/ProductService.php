<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductService{

    public function findProductById(int $id){
		return Product::where('id',$id)->first();
	}

	public function findProductByCode(int $code){
		return Product::where('code',$code)->first();
	}

	public function getAll(): Collection{
		return Product::all();
	}

	public function turnOffAll(){
		$products = $this->getAll();
		foreach ($products as $key => $product) {
			$product->showOnStore = false;
			$product->save();
		}
	}

	public function getTurnedOff(){
		$products = $this->getAll();
		$n = 0;
		foreach ($products as $key => $product) {
			if(!$product->showOnStore){
				$n++;
			}
		}
		return $n;
	}

    public function isValidProduct(Product $product){
        $cat = $product->categories()->first();
        if((int) $product->price <= 0){
            return false;
        }
        if($cat){
            if($cat->isRoot()){
                return false;
            }
            else{
                return true;
            }
        }
        else{
            return false;
        }
    }
}
