<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

	protected $table = 'categories';

	protected $fillable = [
		'name'
	];

	public function parent(){
		return $this->belongsTo('App\Category','parent_id','id')->first();
	}

	public function children(){
		return $this->hasMany('App\Category','parent_id','id');
	}

	public function products(){
		return $this->belongsToMany('App\Product','products_categories','category_id','product_id')->withTimestamps();
	}

	public function isRoot(){
		if($this->parent_id == null)
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
			return $parent->getParsed().', '.$this->name;
		}
		else{
			return $this->name;
		}
	}

	public function getParsed(){
		$parent = $this->parent();
		if($parent){
			return $parent->getParsed().' > '.$this->name;
		}
		else{
			return $this->name;
		}
	}
}
