<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpcionesTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::create('opciones', function($newTable){
            $newTable->increments('id');
            $newTable->string('Nombre');
            $newTable->string('Descripcion');
			$newTable->string('Imagen');
		  	$newTable->boolean('Activo');
			$newTable->boolean('Correcto');
            $newTable->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('opciones');
    }
}
