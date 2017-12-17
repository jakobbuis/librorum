<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitialStructure extends Migration
{
    public function up()
    {
        Schema::create('notebooks', function(Blueprint $table){
            $table->char('id', 36);
            $table->string('slug');
            $table->string('page_count')->nullable();
            $table->timestamps();

            $table->primary('id');
            $table->unique('slug');
        });

        Schema::create('pages', function(Blueprint $table){
            $table->char('id', 36);
            $table->char('notebook_id', 36);
            $table->integer('start_number');
            $table->integer('end_number');
            $table->string('description')->nullable();
            $table->timestamps();

            $table->primary('id');
            $table->foreign('notebook_id')
                  ->references('id')->on('notebooks')
                  ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('tags', function(Blueprint $table){
            $table->char('id', 36);
            $table->string('tag');
            $table->timestamps();

            $table->primary('id');
        });

        Schema::create('pages_tags', function(Blueprint $table){
            $table->char('page_id', 36);
            $table->char('tag_id', 36);

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
