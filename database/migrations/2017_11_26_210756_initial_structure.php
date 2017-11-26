<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitialStructure extends Migration
{
    public function up()
    {
        Schema::create('notebooks', function(Blueprint $table){
            $table->increments('id');
            $table->string('slug');
            $table->string('page_count')->nullable();
            $table->timestamps();

            $table->unique('slug');
        });

        Schema::create('pages', function(Blueprint $table){
            $table->increments('id');
            $table->integer('notebook_id')->unsigned();
            $table->integer('start_number');
            $table->integer('end_number');
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('notebook_id')
                  ->references('id')->on('notebooks')
                  ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('tags', function(Blueprint $table){
            $table->increments('id');
            $table->string('tag');
            $table->timestamps();
        });

        Schema::create('pages_tags', function(Blueprint $table){
            $table->integer('page_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            $table->foreign('page_id')
                  ->references('id')->on('pages')
                  ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('tag_id')
                  ->references('id')->on('tags')
                  ->onUpdate('cascade')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('pages_tags');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('notebooks');
        Schema::dropIfExists('tags');
    }
}
