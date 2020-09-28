<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Product;

class ProductController extends Controller {

	public function index(){
		$products = app()->make('\App\Http\Controllers\ProductController')->getAll();
		$variants = app()->make('\App\Http\Controllers\VariantController')->getAll();
		return view('products.index')->with('products',$products)->with('variants',$variants);
	}

	public function edit($id){
		$product = $this->findProductById($id);
		if(!$product) return -1;

		$variants = app()->make('\App\Http\Controllers\VariantController')->getAll();
		$categories = app()->make('\App\Http\Controllers\CategoryController')->getListed();
		return view('products.edit')->with('product',$product)->with('variants',$variants)->with('categories',$categories);
	}

	public function update(Request $request){
		if(!isset($request['id'])) return -1;
		$product = $this->findProductById($request['id']);
		if(!$product) return -1;

		if(!isset($request['variant_id']) || !isset($request['category_id']))
			return -1;

		$category = app()->make('\App\Http\Controllers\CategoryController')->getById($request['category_id']);
		if(!$category) return -1;

		if($request['variant_id'] != 0){
			$variant = app()->make('\App\Http\Controllers\VariantController')->getById($request['variant_id']);
			if(!$variant)
				return -1;
			else{
				$product->type = "Peso";
				$product->variant_id = $request['variant_id'];
			}
		}
		else{
			$product->type = "Unidad";
			$product->variant_id = null;
		}

		$cats = $product->categories()->first();
		if($cats)
			$product->categories()->detach();
		$product->addCategory($category);
		$product->save();

		return redirect()->route('products');
	}

	public function findProductById(int $id){
		return Product::where('id',$id)->first();
	}

	public function findProductByCode(int $code){
		return Product::where('code',$code)->first();
	}

	public function getAll(){
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
}