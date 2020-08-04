<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamenesTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::create('examenes', function($newTable){
            $newTable->increments('id');
            $newTable->string('Nombre');
            $newTable->string('Descripcion');
		  	$newTable->boolean('Activo');
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
        Schema::drop('examenes');
    }
}
