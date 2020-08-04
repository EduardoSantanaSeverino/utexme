<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Auth;
use Illuminate\Http\Request;
use App\Examenes;

class ExamplesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($examenId, $preguntaId)
    {
		$item = Examenes::find($examenId)->preguntas()->where('codigo', $preguntaId)->first();
		$preguntaImagen = "";

		if (empty($item) == false && empty($item -> Imagen) == false)
		{
			$preguntaImagen = $item -> Imagen;
		}
					
		$examenId = str_pad($examenId, 3, "0", STR_PAD_LEFT); 
		$preguntaId = str_pad($preguntaId, 3, "0", STR_PAD_LEFT); 
        return view('examples.index',compact('examenId','preguntaId','preguntaImagen'));
    }

}
