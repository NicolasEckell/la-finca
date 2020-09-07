<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code')->unsigned()->unique();
            $table->string('name',150);
            $table->string('type',50)->nullable();
            $table->integer('stock')->nullable();
            $table->double('price', 10, 2)->default(0);
            $table->string('categories',100)->nullable();
            $table->string('details',1024)->nullable();
            $table->string('vendor',100)->nullable();
            $table->string('barcode',100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
