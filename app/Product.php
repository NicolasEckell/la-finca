<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    protected $table = 'products';

    protected $fillable = [
        'code','name','stock','price','categories','details','vendor','buyDate'
    ];

}
