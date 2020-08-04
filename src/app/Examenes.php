<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examenes extends Model
{
     protected $fillable = [
          'Nombre',
          'Descripcion',
          'Minutos',
          'Activo',
          'OrdenPreguntasFijo'
     ];

     public function preguntas()
     {
          return $this->hasMany('App\Preguntas','ExamenId','id');
     }

     public function getPreguntasCountAttribute()
     {
          return $this->hasMany('App\Preguntas','ExamenId','id')->count();
     }

     public static function boot()
     {
          parent::boot();

          // cause a delete of a product to cascade to children so they are also deleted
          static::deleted(function($examen){
               $examen->preguntas()->delete();
          });
     }
}
