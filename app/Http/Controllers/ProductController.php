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

	// public function calculateTypeOfProduct(string $name){
	// 	$name = strtolower($name);
	// 	$type = "";

	// 	$match = preg_match("/( gr)|( ml) | (\d+((gr)|(ml)))/", $name);
	// 	if($match == 1){
	// 		$type = "Unidad";
	// 	}
	// 	else{
	// 		$match = preg_match("/( x )/",$name);
	// 		if($match == 1){
	// 			$type = "Peso";
	// 		}
	// 		else{
	// 			$match = preg_match("/( kg)|(\d+(kg))|( kilo)/", $name);
	// 			if($match == 1){
	// 				$type = "Peso";
	// 			}
	// 			else{
	// 				$type = "Unidad";
	// 			}
	// 		}
	// 	}

	// 	return $type;
	// }
}