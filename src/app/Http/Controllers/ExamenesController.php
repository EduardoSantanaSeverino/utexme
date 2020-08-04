<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Requests;
use App\Examenes;
use App\Http\Requests\ExamenesRequest;
use App\Http\Requests\ImportExcelRequest;
use Crypt;
use DateTime;
use Redirect;
use Response;
use DB;
use Excel;
use Illuminate\Support\Facades\Input;

class ExamenesController extends Controller
{
    /**
     * Create a new controller instance.
     *
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
        $listadoexamenes = Examenes::orderBy('id', 'DESC')->paginate(5);
        return view('examenes.index', compact('listadoexamenes'))
            ->with('i', (Request::input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $examen = null;
        return View('examenes.create', compact('examen'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store( ExamenesRequest $request )
    {
        $examen = Examenes::create([
            'Nombre' => $request['Nombre'],
            'Descripcion' => $request->input('Descripcion', ''),
            'Activo' => $request->input('Activo', 0),
            'Minutos' => $request->input('Minutos', 0),
            'OrdenPreguntasFijo' => $request->input('OrdenPreguntasFijo', 0)
        ]);
        return Redirect::route('examenes.edit', array('id' => $examen->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {
        $examen = Examenes::findOrFail($id);
        return View('examenes.show', compact('examen'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        $examen = Examenes::findOrFail($id);
        return View('examenes.edit', compact('examen'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update( ExamenesRequest $request, $id )
    {

        $examen = Examenes::findOrFail($id);

        $examen->update([
            'Nombre' => $request['Nombre'],
            'Descripcion' => $request['Descripcion'],
            'Activo' => $request['Activo']
        ]);

        return redirect('examenes');
    }

    public function guardar( $id, $campo, $valor )
    {
        $examen = Examenes::findOrFail($id);

        $examen->update([
            $campo => $valor
        ]);

        $examenToView = Examenes::findOrFail($id);

        return Response::json(
            array(
                "Result" => "OK",
                "Examen" => $examenToView,
            )
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        Examenes::destroy($id);
        return redirect('examenes');
    }

    public function ImportExcel( $id )
    {
        $masterPage = 'layouts.app';
        $esAjax = Request::ajax();
        if($esAjax == true){
            $masterPage = 'layouts.popup';
        }
        $examen = Examenes::findOrFail($id);
        return View('examenes.importexcel', compact('examen','masterPage'));
    }

    public function ImportExcelPost(ImportExcelRequest $request, $id )
    {
        if(Input::hasFile('import_file')){
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {
            })->get();
            if(!empty($data) && $data->count()){
                $i = 0;
                foreach ($data as $key => $value) {
                    $insert[] = [
                        'Nombre' => $value->nombre,
                        'Descripcion' => $value->descripcion,
                        'Imagen' => $value->imagen,
                        'Activo' => 1,
                        'created_at' => (new DateTime()),
                        'updated_at' => (new DateTime()),
                        'ExamenId' => $id,
                        'ImagenEdit' => 1,
                        'Codigo' => $value->codigo,
                    ];
                    if(!empty($value->opcion1imagen) || !empty($value->opcion1nombre)){
                        $insertOpciones[] = [
                            'Nombre' => $value->opcion1nombre,
                            'Descripcion' => $value->opcion1descripcion,
                            'Imagen' => $value->opcion1imagen,
                            'Activo' => 1,
                            'Correcto' => $value->opcion1correcto,
                            'created_at' => (new DateTime()),
                            'updated_at' => (new DateTime()),
                            'PreguntaId' => $i,
                            'ImagenEdit' => 1,
                            'Codigo' => $value->opcion1codigo
                        ];
                    }
                    if(!empty($value->opcion2imagen) || !empty($value->opcion2nombre)){
                        $insertOpciones[] = [
                            'Nombre' => $value->opcion2nombre,
                            'Descripcion' => $value->opcion2descripcion,
                            'Imagen' => $value->opcion2imagen,
                            'Activo' => 1,
                            'Correcto' => $value->opcion2correcto,
                            'created_at' => (new DateTime()),
                            'updated_at' => (new DateTime()),
                            'PreguntaId' => $i,
                            'ImagenEdit' => 1,
                            'Codigo' => $value->opcion2codigo
                        ];
                    }
                    if(!empty($value->opcion3imagen) || !empty($value->opcion3nombre)){
                        $insertOpciones[] = [
                            'Nombre' => $value->opcion3nombre,
                            'Descripcion' => $value->opcion3descripcion,
                            'Imagen' => $value->opcion3imagen,
                            'Activo' => 1,
                            'Correcto' => $value->opcion3correcto,
                            'created_at' => (new DateTime()),
                            'updated_at' => (new DateTime()),
                            'PreguntaId' => $i,
                            'ImagenEdit' => 1,
                            'Codigo' => $value->opcion3codigo
                        ];
                    }
                    if(!empty($value->opcion4imagen) || !empty($value->opcion4nombre)){
                        $insertOpciones[] = [
                            'Nombre' => $value->opcion4nombre,
                            'Descripcion' => $value->opcion4descripcion,
                            'Imagen' => $value->opcion4imagen,
                            'Activo' => 1,
                            'Correcto' => $value->opcion4correcto,
                            'created_at' => (new DateTime()),
                            'updated_at' => (new DateTime()),
                            'PreguntaId' => $i,
                            'ImagenEdit' => 1,
                            'Codigo' => $value->opcion4codigo
                        ];
                    }
                    $i++;
                }

                foreach($insert as $insertItem1)
                {
                    $ids[] = DB::table('preguntas')->insertGetId($insertItem1);
                }

                if(!empty($insertOpciones)){
                    foreach($insertOpciones as $insertItem2)
                    {
                        $replace = ['PreguntaId' => $ids[$insertItem2['PreguntaId']]];
                        $result = array_merge($insertItem2, array_intersect_key($replace, $insertItem2));
                        DB::table('opciones')->insert($result);
                    }
                }
                return Redirect::route('examenes.edit', array('id' => $id));
            }
        }
        return back();
    }

}
