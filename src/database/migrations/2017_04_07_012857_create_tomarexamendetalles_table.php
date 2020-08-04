<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTomarExamenDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tomarexamendetalles', function($newTable){
            $newTable->increments('id');
            $newTable->integer('TomarExamenId');
            $newTable->integer('ExamenId');
            $newTable->integer('PreguntaId');
            $newTable->integer('OpcionId');
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
        Schema::drop('tomarexamendetalles');
    }
}
