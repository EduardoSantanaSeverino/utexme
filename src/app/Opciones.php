<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Opciones extends Model
{
	protected $fillable = [
		'Nombre',
		'Descripcion',
		'Activo',
		'Imagen',
		'Correcto',
		'PreguntaId',
		'Codigo'
	];

	public function getOrdenAttribute()
	{
		return rand(1,9);
	}
}
