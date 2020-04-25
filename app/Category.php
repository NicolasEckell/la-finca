<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

	protected $table = 'categories';

	protected $fillable = [
		'name'
	];

	public function parent(){
		return $this->hasOne('App\Category','parent_id','id')->first();
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
