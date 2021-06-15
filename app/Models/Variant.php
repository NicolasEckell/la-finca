<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model {

	protected $table = 'variants';

	protected $fillable = [
		'variants'
	];

    public function products(){
        return $this->hasMany(Product::class,'variant_id','id')->get();
    }
}
