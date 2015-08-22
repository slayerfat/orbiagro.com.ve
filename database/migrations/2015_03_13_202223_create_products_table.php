<?php

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
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('maker_id')->unsigned();
            $table->foreign('maker_id')->references('id')->on('makers');
            $table->integer('sub_category_id')->unsigned();
            $table->foreign('sub_category_id')->references('id')->on('sub_categories');
            $table->string('title');
            $table->text('description');
            $table->text('heroDetails')->nullable();
            $table->double('price', 12, 2)->unsigned();
            $table->integer('quantity')->unsigned();
            $table->string('slug');
            $table->timestamps();
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('updated_by')->unsigned();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->softDeletes();
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::drop('products');
    }
}
