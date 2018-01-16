<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ObjectsAreOwnedByUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notebooks', function (Blueprint $table){
            $table->string('user_id')->nullable(false);
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('tags', function (Blueprint $table){
            $table->string('user_id')->nullable(false);
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notebooks', function (Blueprint $table){
            $table->dropForeign('notebooks_user_id_foreign');
            $table->dropColumn('user_id');
        });

        Schema::table('tags', function (Blueprint $table){
            $table->dropForeign('tags_user_id_foreign');
            $table->dropColumn('user_id');
        });
    }
}
