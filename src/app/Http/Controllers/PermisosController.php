<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Requests;
use App\Permisos;
use App\User;
use App\Examenes;
use Crypt;
use DateTime;
use Response;
use Mail;
use DB; 

class PermisosController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function index()
	{
		$usuarios = DB::table('users')
			->where('Activo', 1)
			->select('id','name')
			->get();

		$examenes = DB::table('examenes')
			->where('Activo', 1)
			->select('id','Nombre')
			->get();

		return View('permisos.index', compact('usuarios', 'examenes'));
	}

	public function getData($action)
	{
		$mainTable                       = 'permisos';
		$id                              = Request("id");
		$UsuarioId                       = Request("UsuarioId");
		$ExamenId                        = Request("ExamenId");
		$Activo                          = Request("Activo");
		$FechaDesde                      = Request("FechaDesde");
		$FechaHasta                      = Request("FechaHasta");
		$Editar                          = Request("Editar");
		$Cantidad                        = Request("Cantidad");
		$jtSorting                       = Request('jtSorting');
		$jtStartIndex                    = Request('jtStartIndex');
		$jtPageSize                      = Request('jtPageSize');

		if(false){
			//prueba de variables recibida
			$testArray                   			= array(
				"mainTable" 	                   	=> $mainTable,
				"UsuarioId"                        => $UsuarioId,
				"ExamenId"                         => $ExamenId,
				"Activo"                           => $Activo,
				"FechaDesde"                       => $FechaDesde,
				"FechaHasta"                       => $FechaHasta,
				"jtSorting" 	                    => $jtSorting,
				"jtStartIndex" 	               => $jtStartIndex,
				"jtPageSize"         	          => $jtPageSize
			);
			dd($testArray);
		}

		switch ($action)
		{
			case 'list':

				$query = Permisos::where('id', '>', '0');

				if(empty($UsuarioId) == false)
				{
					$query = $query -> where('UsuarioId', $UsuarioId);     
				}

				if(empty($ExamenId) == false)
				{
					$query = $query -> where('ExamenId', $ExamenId);     
				}

				$rows                      = $query->count();

				if(empty($jtSorting) == false)
				{
					$search                = explode(" ", $jtSorting);
					$query                  = $query
						->skip($jtStartIndex)
						->take($jtPageSize)
						->orderBy($search[0], $search[1]);
				}
				else
				{
					$query                  = $query
						->skip($jtStartIndex)
						->take($jtPageSize);
				}

				$data                      = $query->get();
				
				return Response::json(
					array(
						"Result"			          =>		"OK",
						"TotalRecordCount"	      	=>		$rows,
						"Records"			          =>		$data,
					)
				);

				break;

			case 'create':

				$item                         = new Permisos();
				$item->UsuarioId              = $UsuarioId;
				$item->ExamenId               = $ExamenId;
				$item->Activo                 = 1;
				$item->FechaDesde             = new DateTime($FechaDesde);
				$item->FechaHasta             = new DateTime($FechaHasta);
				$item->Cantidad               = $Cantidad;
				$item->Editar                 = $Editar;

				if($item->save())
				{
					if(Request::input('Notificar', 0)){
						$this->enviarNotificacion($item->id);
					}
					$toView                = Permisos::find($item->id);
					
					return Response::json(array(
						"Result"			     =>		"OK",
						"Record"			     =>		$toView
					)
									 );
				}

				break;

			case 'update':

				$item                         = Permisos::find($id);
				$item->UsuarioId              = $UsuarioId;
				$item->ExamenId               = $ExamenId;
				$item->Activo                 = $Activo;
				$item->Cantidad               = $Cantidad;
				$item->Editar                 = $Editar;
				$item->FechaDesde             = new DateTime($FechaDesde);
				$item->FechaHasta             = new DateTime($FechaHasta);
				
				if($item->save())
				{
					if(Request::input('Notificar', 0)){
						$this->enviarNotificacion($item->id);
					}
					$toView              = Permisos::find($item->id);
					return Response::json(array(
						"Result"			 =>		"OK",
						"Record"			 =>		$toView
					)
									 );
				}

				break;

			case 'delete':

				$item                    = Permisos::find($id);

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

	public function getOption($action)
	{
		switch ($action)
		{
			case 'users':

				$query = User::where('Activo', '1')->select('name as DisplayText','id as Value');

				$data                      = $query->get();
				
				return Response::json(
					array(
						"Result"			          =>		"OK",
						"Options"			          =>		$data,
					)
				);

				break;

			case 'exams':

				$query = Examenes::where('Activo', '1')->select('Nombre as DisplayText','id as Value');;

				$data                      = $query->get();

				return Response::json(
					array(
						"Result"			          =>		"OK",
						"Options"			          =>		$data,
					)
				);

				break;

		}

	}
	
	protected function enviarNotificacion($id)
	{
		$item = Permisos::findOrFail($id);
		$item -> subject = 'Examen Disponible - utex.me';
		$item -> titulo = 'Examen Disponible!';
		Mail::send('emails.permisos', 
				 ['item' => $item], 
				 function ($m) use ($item) {
					 $m->to($item -> usuario -> email, $item -> usuario -> name)
						 ->subject($item -> subject);
				 });
	}

}
