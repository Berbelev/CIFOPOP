<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnunciosTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
         //crea la tabla anuncios
         Schema::create('anuncios', function(Blueprint $table){
            // crea id como clave primaria
            $table->id();

            // crea los campos de la tabla anuncios
            $table->string('titulo', 255);
            $table->string('descripcion',255);
            $table->float('importe')->default(0);
            $table->string('imagen')->nullable();



            // crea marcas de tiempo: created_at y updated_at
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()    {


        // deshacer la tabla bikes
         Schema::dorpIfExists('anuncios');

    }
}
