<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Requests;
use App\Examenes;
use App\TomarExamen;
use App\Preguntas;
use App\Opciones;
use App\TomarExamenDetalles;
use App\Http\Requests\TomarExamenRequest ;
use DateTime;
use Redirect;
use Response;
use Auth;
use Debugbar;
use Mail;
use App\Permisos;
use DB;

class TomarExamenController extends Controller
{
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
		$listadoexamenes = DB::select('	Select ex.id, ex.Nombre, ex.Descripcion, ifnull(pe.Cantidad,1) Cantidad
							From examenes ex
							inner join permisos pe on ex.id = pe.ExamenId
							where  pe.Activo = 1 and ex.Activo = 1 and pe.UsuarioId = ? 
							and now() between pe.FechaDesde and pe.FechaHasta order by ex.id;', [auth()->user()->id]);
		
          return View('tomarexamen.index', compact('listadoexamenes'));
     }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
     {
		if(Request::has('id'))
		{
			$id = Request::input('id');
		}

		// VerificoExamenesActivos para ese examen para ese usuario
		$permisoId = auth()->user()->canTakeExam($id);

		if(!$permisoId)
		{
			return response()->view('errors.401', ['title' => 'No tiene fecha para examen', 'message' => 'No tiene fecha disponible para tomar este examen. por favor hable con el administrador.'], 401);
		}

		$UsuarioId                                        = Auth::id();
		$ExamenId                                         = $id;

		$examenesActivos                                  = TomarExamen::where([
			['ExamenId', $ExamenId],
			['UsuarioId', $UsuarioId]
		]) -> get();

		$crearNuevo = true;

		if($examenesActivos -> isEmpty()                  == 0) // si tiene
		{
			$nuevoTomarExamen                                  = $examenesActivos -> first();
			if($nuevoTomarExamen -> Activo == 1)
			{
				$crearNuevo = false;
			}
		}

		$permisoActual = Permisos::find($permisoId);

		if($crearNuevo == true)
		{
			// Declarar variables para asignarlas.
			$examenActual                                   = Examenes::findOrFail($ExamenId);
			$MinutosParaExamen                              = $examenActual -> Minutos;
			$FechaInicio                                    = new DateTime();
			$FechaLimiteTermino                             = new DateTime();
			$FechaLimiteTermino -> modify("+" . $MinutosParaExamen ." minutes");
			$TotalPreguntas                                 = $examenActual -> PreguntasCount;
			$PreguntaActual                                 = 1;
			$Activo                                         = 1;
			// Asignar variables.
			$nuevoTomarExamen                               = new TomarExamen();
			$nuevoTomarExamen -> UsuarioId                  = $UsuarioId; // para ese usuario
			$nuevoTomarExamen -> ExamenId                   = $ExamenId; // para ese examen
			$nuevoTomarExamen -> FechaInicio                = $FechaInicio;
			$nuevoTomarExamen -> FechaLimiteTermino         = $FechaLimiteTermino;
			$nuevoTomarExamen -> FechaTermino               = null;
			$nuevoTomarExamen -> MinutosParaExamen          = $MinutosParaExamen; // para ese tiempo desde el examen
			$nuevoTomarExamen -> NotaExamen                 = null;
			$nuevoTomarExamen -> CantidadCorrectas          = null;
			$nuevoTomarExamen -> CantidadErroneas           = null;
			$nuevoTomarExamen -> TotalPreguntas             = $TotalPreguntas; // para ese TotalPreguntas desde el totalLineasExamen
			$nuevoTomarExamen -> PreguntaActual             = $PreguntaActual; // PreguntaActual = 1
			$nuevoTomarExamen -> Activo                     = $Activo; //
			$nuevoTomarExamen -> Proxima                    = 0;
			$nuevoTomarExamen -> PermisoId 			       = $permisoId;
			$nuevoTomarExamen -> Editar 			           = $permisoActual -> Editar;

			if(!empty($nuevoTomarExamen -> Editar) && $nuevoTomarExamen -> Editar > 0)
			{
				$MinutosParaExamen = $MinutosParaExamen * 112;
				$nuevoTomarExamen -> MinutosParaExamen          = $MinutosParaExamen; // para ese tiempo desde el examen
				$FechaLimiteTermino                             = new DateTime();
				$FechaLimiteTermino -> modify("+" . $MinutosParaExamen ." minutes");
				$nuevoTomarExamen -> FechaLimiteTermino         = $FechaLimiteTermino;
			}

			if($nuevoTomarExamen->save())
			{
				// 	Inserto Preguntas del examen al tomarexamendetalle
				if ($examenActual -> OrdenPreguntasFijo       == 1)
				{
						$colPreguntas                             = $examenActual -> preguntas; // 		Se buscan todas las preguntas del examen // 		se ordenan por orden
				}
				else
				{
						$colPreguntas                             = $examenActual -> preguntas -> shuffle(); //  Se buscan todas las preguntas del exa se ordenan por orden
				}

				$contador                                     = 1;
				foreach ($colPreguntas as $pregunta) // 		se recorre el bucle
				{
						// 		se pone:
						$nuevoTomarExamenDetalle                  = new TomarExamenDetalles();
						$nuevoTomarExamenDetalle -> TomarExamenId = $nuevoTomarExamen -> id; // 			tomarExamenId desde variable
						$nuevoTomarExamenDetalle -> ExamenId      = $ExamenId; // 			ExamenId desde variable
						$nuevoTomarExamenDetalle -> PreguntaId    = $pregunta -> id; // 			PreguntaId desde el bucle
						$nuevoTomarExamenDetalle -> OpcionId      = null; // 			OptionId Nulla
						$nuevoTomarExamenDetalle -> Correcto      = null;
						$nuevoTomarExamenDetalle -> Orden         = $contador; // 			Orden desde auto incremental
						$nuevoTomarExamenDetalle -> save();
						if($contador == 1)
						{
							$nuevoTomarExamen -> DetalleActualId = $nuevoTomarExamenDetalle -> id;
							$nuevoTomarExamen -> save();
						}
						$contador                                 = $contador + 1;

				}

				if(!empty($permisoActual))
				{
					if(empty($permisoActual -> Cantidad) || $permisoActual -> Cantidad < 1)
					{
						$permisoActual -> Activo = 0;
					}
					else
					{
						$permisoActual -> Cantidad--;
						if($permisoActual -> Cantidad < 1)
						{
							$permisoActual -> Activo = 0;
						}
					}
					$permisoActual -> save();

				}

			}
		}

          return Redirect::route('tomarexamen.edit', array('id' => $nuevoTomarExamen -> id));
     }

     /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
     public function store(TomarExamenRequest $request)
     {
          return redirect('tomarexamen');
     }

     /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
     public function show($id)
     {
          $tomarExamen = TomarExamen::findOrFail($id);
          return View('tomarexamen.show', compact('tomarExamen'));
     }

     /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
     {
          $tomarExamen = TomarExamen::findOrFail($id);

          // 	se tomaInformacion
          Debugbar::info('Entrando a Tiene 1');

          if($tomarExamen -> Activo == 0)
          {
               return Redirect::route('tomarexamen.show', array('id' => $tomarExamen -> id));
          }

          $cerrarExamen = false;
          $fechaActual = new DateTime();
          $FechaLimiteTermino = new DateTime($tomarExamen -> FechaLimiteTermino);

          if($fechaActual >= $FechaLimiteTermino)
          {
               $cerrarExamen = true;
          }
          elseif($tomarExamen -> PreguntaActual > $tomarExamen -> TotalPreguntas)
          {
               $cerrarExamen = true;
          }

          if($cerrarExamen == true) // Verifico el numero de la pregunta actual y fecha de termino.
          {
               // si es igual o mayor al total de total de preguntas
               // 		entonces cierro examen, poniendo Activo = 0 y paso a dar el total resultado optenido;
               $tomarExamen -> Activo = 0;
               $tomarExamen -> FechaTermino = new DateTime();
               // Poner la Ruta de Dar el resultado. y mensaje de examen terminado.
               $pCorrectas = 0;
               $pIncorrect = 0;

               foreach ($tomarExamen -> tomarExamenDetalles as $det) // 		se recorre el bucle
               {
                    if($det -> Correcto == 1)
                    {
                         $pCorrectas = $pCorrectas + 1;
                    }
                    else
                    {
                         $pIncorrect = $pIncorrect + 1;
                    }
               }

               $tomarExamen -> CantidadCorrectas = $pCorrectas;
               $tomarExamen -> CantidadErroneas = $pIncorrect;
               $notaExamen = ($pCorrectas / $tomarExamen -> TotalPreguntas) * 100;
               $tomarExamen -> Nota = $notaExamen;
               $tomarExamen -> NotaExamen = $notaExamen . ' of 100 pts';
               $tomarExamen -> save();

               $this -> enviarNotificacionExamen($tomarExamen -> id);

               return Redirect::route('tomarexamen.show', array('id' => $tomarExamen -> id));

          }
          else
          {
               $diffInSeconds = $FechaLimiteTermino -> getTimestamp() - $fechaActual -> getTimestamp();
          }

          Debugbar::info('PreguntaActual: ' . $tomarExamen -> PreguntaActual);

          return View('tomarexamen.edit', compact('tomarExamen', 'diffInSeconds'));
     }

     /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
     public function update(TomarExamenRequest $request, $id)
     {
		$tomarExamen = TomarExamen::findOrFail($id);
		// toma el preguntaId
		// toma el opcionId
		// y hace un update a esa pregunta dentro de detalles para poner la optionId
		// envia el los segundos faltantes.

		$irAnterior = false;
		$irSiguiente = false;

		if($request -> has('Anterior'))
		{
			$irAnterior = true;
		}
		elseif($request -> has('Siguiente'))
		{
			$irSiguiente = true;
		}

		$TomarExamenDetalleId = $tomarExamen -> DetalleActualId;

		$tomarExamenDetalle = TomarExamenDetalles::findOrFail($TomarExamenDetalleId);

		$tomarExamenDetalle -> OpcionId = $request['OpcionId'];

		if(!empty($tomarExamen -> Editar) && $tomarExamen -> Editar > 0)
		{
			Opciones::where('PreguntaId', $tomarExamenDetalle -> pregunta -> id)->update(['Correcto' => 0]);
			$tempOpcion = Opciones::findOrFail($tomarExamenDetalle -> OpcionId);
			$tempOpcion -> Correcto = 1;
			$tempOpcion -> save();
		}
		
		$opcionCorrecto = $tomarExamenDetalle -> pregunta -> opciones() -> where('Correcto', 1) -> first();

		if(empty($opcionCorrecto))
		{	
			$opcionCorrecto = $tomarExamenDetalle -> pregunta -> opciones -> first();
		}
		if($tomarExamenDetalle -> OpcionId == $opcionCorrecto -> id)
		{
			$tomarExamenDetalle -> Correcto = 1;
		}
		else
		{
			$tomarExamenDetalle -> Correcto = 0;
		}
		if(!empty($request -> input('Comentario', '')))
		{
			$tomarExamenDetalle -> Comentario = $request -> input('Comentario', '');
		}

		$tomarExamenDetalle -> save();

		if($irAnterior == true && $tomarExamen -> PreguntaActual > 1)
		{
			$tomarExamen -> PreguntaActual += -1;
		}
		elseif ($irSiguiente == true)
		{
			$tomarExamen -> PreguntaActual += 1;
		}
		if(($irAnterior == true && $tomarExamen -> PreguntaActual > 0) || $irSiguiente == true)
		{
			if($tomarExamen -> PreguntaActual <= $tomarExamen -> TotalPreguntas)
			{
				$detId = $tomarExamen -> tomarExamenDetalles() -> where('Orden', $tomarExamen -> PreguntaActual) -> first() -> id;
				$tomarExamen -> DetalleActualId = $detId;
			}
			$tomarExamen -> save();
		}
        return Redirect::route('tomarexamen.edit', array('id' => $id));
     }

     /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
     {
          TomarExamen::destroy($id);
          return redirect('tomados');
     }

     /**
     * Notificar usuario con correo.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function notificar($id)
     {
          $this -> enviarNotificacionExamen($id);
          //return Redirect::route('tomados.show', array('id' => $id));
          return redirect()->route('tomados.show', array('id' => $id))
               ->with('success','Email sended correctly.');
     }

     protected function enviarNotificacionExamen($id)
     {
          $item = TomarExamen::findOrFail($id);
          $item -> subject = 'Resultado de examen - utex.me';
          $item -> titulo = 'Resultado de examen!';
          $item -> texto = 'Has finalizado el examen ' . $item -> examen -> Nombre . ', ';
          Mail::send('emails.tomarexamen', 
                     ['item' => $item], 
                     function ($m) use ($item) {
                          $m->to($item -> usuario -> email, $item -> usuario -> name)
                               ->subject($item -> subject);
                     });
     }

}
