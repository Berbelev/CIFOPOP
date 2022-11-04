<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AnunciosAddSoftDeletes extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()    {
        Schema::table('anuncios', function(Blueprint $table){
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()    {
        Schema::table('anuncios', function(Blueprint $table){
            $table->dropSoftDeletes();
        });
    
    }
}
