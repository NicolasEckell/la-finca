<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    protected $table = 'products';

    protected $fillable = [
        'code','name','stock','price','categories','variant_id','details','vendor','barcode','buyDate','showOnStore'
    ];

    public function categories(){
    	return $this->belongsToMany('App\Category','products_categories','product_id','category_id')->withTimestamps();
    }

    public function addCategory(Category $cat){
    	$val = $this->categories()->get()->where('id',$cat->id)->first();
    	if(!$val){
    		$this->categories()->attach($cat);
            $val = $cat;
        }
        $this->fixCategories($val);
    }

    public function fixCategories(Category $cat){
        $this->categories = $cat->getFormatted();
        $this->save();
    }

    public function hasCategory(int $pos, int $id = null){
        $result = false;
        $cats = $this->categories()->get();
        if($cats->count() > 0 && $pos >= 0 && $pos < $cats->count()){
            if($cats[$pos]->id == $id){
                $result = true;
            }
        }
        return $result;
    }

    public function purge(){
        $this->name = preg_replace('/\s+/', ' ',  $this->name);
        $this->categories = preg_replace('/\s+/', ' ',  $this->categories);
        $this->details = preg_replace('/\s+/', ' ',  $this->details);
        $this->vendor = preg_replace('/\s+/', ' ',  $this->vendor);
        $this->barcode = preg_replace('/\s+/', ' ',  $this->barcode);
    }

    public function variant(){
        if($this->variant_id){
            return $this->belongsTo('App\Variant','variant_id','id')->first();
        }
        return null;
    }

    public function getVariant(){
        if($this->variant_id){
            $variant = $this->belongsTo('App\Variant','variant_id','id')->first();
            return 'ID '.$variant->id.': '.$variant->variants;
        }
        return "";
    }

    public function showCategories(){
        $cats = $this->categories()->get();
        $result = "";
		foreach($cats as $cat){
            if($result !== ""){
                $result .= "<br> ";
            }
            $result .= $cat->export();
        }
        return $result;
    }

    public function exportCategories(){
        $cats = $this->categories()->get();
        $result = "";
		foreach($cats as $cat){
            if($result !== ""){
                $result .= ", ";
            }
            $result .= $cat->export();
        }
        return $result;
    }

}
