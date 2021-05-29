<?php

namespace App\Services;

use App\Variant;

class VariantService{

    public function getById(int $id){
		return Variant::where('id',$id)->first();
	}

	public function getAll(){
		return Variant::all();
	}

}
