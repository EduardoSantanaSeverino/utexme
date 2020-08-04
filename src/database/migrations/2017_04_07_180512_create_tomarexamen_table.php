<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTomarExamenTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::create('tomarexamen', function($newTable){
            $newTable->increments('id');
            $newTable->integer('UsuarioId');
            $newTable->integer('ExamenId');
            $newTable->dateTime('FechaInicio');
            $newTable->dateTime('FechaLimiteTermino');
            $newTable->dateTime('FechaTermino');
            $newTable->integer('MinutosParaExamen');
		  	$newTable->string('NotaExamen');
		  	$newTable->integer('CantidadCorrectas');
		  	$newTable->integer('CantidadErroneas');
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
        Schema::drop('tomarexamen');
    }
}
