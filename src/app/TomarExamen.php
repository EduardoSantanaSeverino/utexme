<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TomarExamen extends Model
{
	protected $fillable = [
		'UsuarioId',
		'ExamenId',
		'FechaInicio',
		'FechaLimiteTermino',
		'FechaTermino',
		'MinutosParaExamen',
		'NotaExamen',
		'CantidadCorrectas',
		'CantidadErroneas',
		'TotalPreguntas',
		'PreguntaActual',
		'DetalleActualId',
		'Activo',
		'Proxima',
		'Nota',
		'PermisoId',
        'Editar'
	];

	protected $table = "tomarexamen";

	public function usuario()
	{
		return $this->hasOne('App\User','id','UsuarioId');
	}

	public function examen()
	{
		return $this->hasOne('App\Examenes','id','ExamenId');
	}

	public function detalle()
	{
		return $this->hasOne('App\TomarExamenDetalles','id','DetalleActualId');
	}

	public function tomarExamenDetalles()
	{
		return $this->hasMany('App\TomarExamenDetalles','TomarExamenId','id');
	}

	public static function boot()
	{
		parent::boot();

		// cause a delete of a product to cascade to children so they are also deleted
		static::deleted(function($tomarExamen)
					 {
						 $tomarExamen->tomarExamenDetalles()->delete();
					 });
	}

}
