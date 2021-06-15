<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

	protected $table = 'categories';

	protected $fillable = [
		'name','parent_id'
	];

	public function parent(){
		return $this->belongsTo(Category::class,'parent_id','id')->first();
	}

	public function children(){
		return $this->hasMany(Category::class,'parent_id','id');
	}

	public function products(){
		return $this->belongsToMany(Product::class,'products_categories','category_id','product_id')->withTimestamps();
	}

	public function isRoot(){
		if($this->parent_id == null && count($this->children()->get()) > 0)
			return true;
		else
			return false;
	}

	public function getParent(){
		$parent = $this->parent();
		if($parent){
			return $parent->getParent();
		}
		else{
			return $this;
		}
	}

	public function getFormatted(){
		$parent = $this->parent();
		if($parent){
			return $parent->export().', '.$this->name;
		}
		else{
			return $this->name;
		}
	}

	public function export(){
		$parent = $this->parent();
		if($parent){
			return $parent->export().' > '.$this->name;
		}
		else{
			return $this->name;
		}
	}
}
