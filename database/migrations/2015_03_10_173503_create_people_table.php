<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->integer('gender_id')->nullable()->unsigned();
            $table->foreign('gender_id')->references('id')->on('genders');
            $table->integer('nationality_id')->nullable()->unsigned();
            $table->foreign('nationality_id')->references('id')->on('nationalities');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('first_surname')->nullable();
            $table->string('last_surname')->nullable();
            $table->string('identity_card')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->date('birth_date')->nullable();
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
        Schema::drop('people');
    }
}
