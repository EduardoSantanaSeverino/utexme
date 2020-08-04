<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Requests;
use App\Preguntas;
use Crypt;
use DateTime;
use Response;

class PreguntasController extends Controller
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

	public function getData($action)
	{
		$mainTable                       = 'preguntas';
		$ExamenId                        = Request("ExamenId");
		$jtSorting                       = Request('jtSorting');
		$jtStartIndex                    = Request('jtStartIndex');
		$jtPageSize                      = Request('jtPageSize');

		if(false){
			//prueba de variables recibida
			$testArray                   = array(
				"mainTable" 	           =>	$mainTable,
				"ExamenId" 	             =>	$ExamenId,
				"jtSorting" 	           =>	$jtSorting,
				"jtStartIndex" 	         =>	$jtStartIndex,
				"jtPageSize" 	           =>	$jtPageSize
			);
			dd($testArray);
		}

		switch ($action)
		{
			case 'list':
				$rows                      = Preguntas::where([
					['ExamenId',$ExamenId],
				])->count();

				if (Request('jtSorting'))
				{
					$search                = explode(" ", Request("jtSorting"));
					$data                  = Preguntas::where([
						['ExamenId',$ExamenId],
					])
						->skip(Request("jtStartIndex"))
						->take(Request("jtPageSize"))
						->orderBy($search[0], $search[1])
						->get();

				}
				else
				{
					$data                  = Preguntas::where([
						['ExamenId',$ExamenId],
					])
						->skip(Request("jtStartIndex"))
						->take(Request("jtPageSize"))
						->get();
				}

				return Response::json(
					array(
						"Result"			         =>		"OK",
						"TotalRecordCount"	   =>		$rows,
						"Records"			         =>		$data,
					)
				);

				break;

			case 'create':

				$item                    = new Preguntas();
				$item->Nombre            = Request("Nombre");
				$item->Descripcion       = Request("Descripcion");
				$item->Imagen            = '';
				$item->Activo            = Request("Activo");
				$item->ExamenId          = Request("ExamenId");
				$item->Codigo          	= Request::input("Codigo",'');

				if($item->save())
				{
					$toView                = Preguntas::find($item->id);

					if (Request::hasFile('Imagen') && Request::file('Imagen') -> isValid()) {
						$destinationPath = 'files/images/' . $toView->ExamenId . '/' . $toView->id;
						$fileName = '1P_' . (new DateTime()) -> format('Ymd_His') . '.' . Request::file('Imagen') -> getClientOriginalExtension();
						Request::file('Imagen')->move($destinationPath, $fileName);
						$toView->Imagen = '/' . $destinationPath . '/' . $fileName;
						$toView->save();
					}

					return Response::json(array(
						"Result"			     =>		"OK",
						"Record"			     =>		$toView
					)
									 );
				}

				break;

			case 'update':

				$item                    = Preguntas::find(Request("id"));
				$item->Nombre            = Request("Nombre");
				$item->Descripcion       = Request("Descripcion");
				$item->Activo            = Request("Activo");
				$item->ExamenId          = Request("ExamenId");
				$item->Codigo          	= Request::input("Codigo",'');

				if (Request::hasFile('Imagen') && Request::file('Imagen') -> isValid()) {
					$destinationPath = 'files/images/' . $item->ExamenId . '/' . $item->id;
					$fileName = '1P_' .(new DateTime()) -> format('Ymd_His') . '.' . Request::file('Imagen') -> getClientOriginalExtension();
					Request::file('Imagen')->move($destinationPath, $fileName);
					$item->Imagen = '/' . $destinationPath . '/' . $fileName;
				}
				elseif(Request('ImagenEdit') == 0 && empty($item->Imagen) == false) {
					$item->Imagen = null;
				}

				if($item->save())
				{
					$toView              = Preguntas::find($item->id);
					return Response::json(array(
						"Result"			 =>		"OK",
						"Record"			 =>		$toView
					)
									 );
				}

				break;

			case 'delete':

				$item                    = Preguntas::find(Request("id"));

				if($item->delete())
				{
					return Response::json(array(
						"Result"			     =>		"OK",
					)
									 );
				}

				break;

		}
	}
}
