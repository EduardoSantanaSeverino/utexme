<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permisos extends Model
{
     protected $fillable = [
          'UsuarioId',
          'ExamenId',
          'Activo',
          'FechaDesde',
          'FechaHasta',
          'Cantidad',
          'Editar'
     ];
	
	protected $table = "permisos";
	
	public function usuario()
	{
		return $this->hasOne('App\User','id','UsuarioId');
	}

	public function examen()
	{
		return $this->hasOne('App\Examenes','id','ExamenId');
	}

}