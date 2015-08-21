<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionsTable extends Migration
{

    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('promo_type_id')->unsigned();
            $table->foreign('promo_type_id')->references('id')->on('promo_types');
            $table->string('title');
            $table->string('slug');
            $table->integer('percentage')->unsigned()->nullable();
            $table->integer('static')->unsigned()->nullable();
            $table->date('begins');
            $table->date('ends');
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('updated_by')->unsigned();
            $table->foreign('updated_by')->references('id')->on('users');
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
        Schema::drop('promotions');
    }
}
