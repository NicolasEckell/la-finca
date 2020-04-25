<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    protected $table = 'products';

    protected $fillable = [
        'code','name','stock','price','categories','details','vendor','buyDate'
    ];

    public function categories(){
    	return $this->belongsToMany('App\Category','products_categories','product_id','category_id')->withTimestamps();
    }

    public function addCategory($cat){
    	$val = $this->categories()->get()->where('id',$cat->id)->first();
    	if(!$val){
    		$this->categories()->attach($cat);
    	}
    }

}
