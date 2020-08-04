<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Requests;
use App\Opciones;
use Crypt;
use DateTime;
use Response;

class OpcionesController extends Controller
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
		$PreguntaId                      = Request("PreguntaId");

		switch ($action)
		{
			case 'list':
				$rows                      = Opciones::where([
					['PreguntaId',$PreguntaId],
				])->count();


				$data                  = Opciones::where([
					['PreguntaId',$PreguntaId],
				])
					->get();

				return Response::json(
					array(
						"Result"			         	=>		"OK",
						"TotalRecordCount"	   		=>		$rows,
						"Records"			         	=>		$data,
					)
				);

				break;

			case 'create':

				$item                    = new Opciones();
				$item->Nombre            = Request::input("Nombre",'');
				$item->Descripcion       = Request::input("Descripcion",'');
				$item->Activo            = Request::input("Activo",'');
				$item->PreguntaId        = Request::input("PreguntaId",'');
				$item->Correcto          = Request::input("Correcto",'');
				$item->Codigo          	= Request::input("Codigo",'');

				if (Request::hasFile('Imagen') && Request::file('Imagen') -> isValid()) {
					$destinationPath = 'files/images/' . Request("ExamenId") . '/' . Request("PreguntaId");;
					$fileName = '2O_' . (new DateTime()) -> format('Ymd_His') . '.' . Request::file('Imagen') -> getClientOriginalExtension();
					Request::file('Imagen')->move($destinationPath, $fileName);
					$item->Imagen = '/' . $destinationPath . '/' . $fileName;
				}

				if($item->save())
				{
					$toView                = Opciones::find($item->id);

					return Response::json(array(
						"Result"			     =>		"OK",
						"Record"			     =>		$toView
					));
				}

				break;

			case 'update':

				$item                    = Opciones::find(Request("id"));
				$item->Nombre            = Request::input("Nombre",'');
				$item->Descripcion       = Request::input("Descripcion",'');
				$item->Activo            = Request::input("Activo",'');
				$item->Correcto          = Request::input("Correcto",'');
				$item->Codigo          	= Request::input("Codigo",'');
				
				if (Request::hasFile('Imagen') && Request::file('Imagen') -> isValid()) {
					$destinationPath = 'files/images/' . Request("ExamenId") . '/' . Request("PreguntaId");;
					$fileName = '2O_' . (new DateTime()) -> format('Ymd_His') . '.' . Request::file('Imagen') -> getClientOriginalExtension();
					Request::file('Imagen')->move($destinationPath, $fileName);
					$item->Imagen = '/' . $destinationPath . '/' . $fileName;
				}
				elseif(Request('ImagenEdit') == 0 && empty($item->Imagen) == false) {
					$item->Imagen = null;
				}

				if($item->save())
				{
					$toView              = Opciones::find($item->id);
					return Response::json(array(
						"Result"			 =>		"OK",
						"Record"			 =>		$toView
					));
				}

				break;

			case 'delete':

				$item                    = Opciones::find(Request("id"));

				if($item->delete())
				{
					return Response::json(array(
						"Result"			     =>		"OK",
					));
				}

				break;

		}
	}
}