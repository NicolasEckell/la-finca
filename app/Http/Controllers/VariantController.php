<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\VariantService;
use App\Variant;

class VariantController extends Controller {

	public function index(){
		$variants = (new VariantService)->getAll();
		return view('variants.index')->with('variants',$variants);
	}

	public function create(){
		return view('variants.create');
	}

	public function edit($id){
		$variant = (new VariantService)->getById($id);
		$variant->variants = json_decode($variant->variants);
		return view('variants.edit')->with('variant',$variant);
	}

	public function store(Request $request){
		$variants = [];
		for ($i=0; $i < 10 ; $i++) {
			$val = $request['val_'.$i];
			if($val){
				$variants[] = $val;
			}
			else{
				break;
			}
		}

		if(count($variants) < 1)
			return -1;

		$variant = new Variant();
		$variant->variants = json_encode($variants);
		$variant->save();

		return redirect()->route('variants');
	}

	public function update(Request $request){
		$id = $request['id'];
		$variant = (new VariantService)->getById($id);

		$variants = [];
		for ($i=0; $i < 10 ; $i++) {
			$val = $request['val_'.$i];
			if($val){
				$variants[] = $val;
			}
			else{
				break;
			}
		}

		if(count($variants) < 1)
			return -1;

		$variant->variants = json_encode($variants);
		$variant->save();

		return redirect()->route('variants');
	}

}
