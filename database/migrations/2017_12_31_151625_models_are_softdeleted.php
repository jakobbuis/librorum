<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModelsAreSoftdeleted extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (['notebooks', 'pages', 'tags', 'users'] as $tableName) {
            Schema::table($tableName, function(Blueprint $table){
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach (['notebooks', 'pages', 'tags', 'users'] as $tableName) {
            Schema::table($tableName, function(Blueprint $table){
                $table->dropColumn('deleted_at');
            });
        }
    }
}
