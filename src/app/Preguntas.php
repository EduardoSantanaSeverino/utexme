<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preguntas extends Model
{
	protected $fillable = [
		'Nombre',
		'Descripcion',
		'Activo',
		'Imagen',
		'ExamenId',
		'Codigo'
	];

	public function opciones()
	{
		return $this->hasMany('App\Opciones','PreguntaId','id');
	}

	public function getImagenEditAttribute()
	{
		$retVal = 1;
		if(empty($this -> Imagen) == true)
		{
			$retVal = 0;
		}
	  	return $retVal;
	}

	public function getOpcionesCountAttribute()
	{
		return $this->hasMany('App\Opciones','PreguntaId','id')->count();
	}

	public static function boot()
	{
		parent::boot();

		// cause a delete of a product to cascade to children so they are also deleted
		static::deleted(function($pregunta)
					 {
						 $pregunta->opciones()->delete();
					 });
	}

	public function getOrdenAttribute()
	{
		return rand(100,999);
	}
}
