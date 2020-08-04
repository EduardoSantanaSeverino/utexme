<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TomarExamenDetalles extends Model
{
	protected $fillable = [
		'TomarExamenId',
		'ExamenId',
		'PreguntaId',
		'OpcionId',
		'Correcto',
		'Orden',
		'Comentario'
	];

	protected $table = "tomarexamendetalles";

	public function pregunta()
	{
		return $this->hasOne('App\Preguntas','id','PreguntaId');
	}
	
	public function opcion()
	{
		return $this->hasOne('App\Opciones','id','OpcionId');
	}

}
