<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    protected $table = 'products';

    protected $fillable = [
        'code','name','stock','price','categories','details','vendor','barcode','buyDate'
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

    public function purge(){
        $this->name = preg_replace('/\s+/', ' ',  $this->name);
        $this->categories = preg_replace('/\s+/', ' ',  $this->categories);
        $this->details = preg_replace('/\s+/', ' ',  $this->details);
        $this->vendor = preg_replace('/\s+/', ' ',  $this->vendor);
        $this->barcode = preg_replace('/\s+/', ' ',  $this->barcode);
    }

}
