<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Requests;
use App\TomarExamen;
use App\Http\Requests\TomadosRequest;

class TomadosController extends Controller
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
		if(auth()->user()->can('perms','ver-examen-todos')){
			$data = TomarExamen::orderBy('id','DESC')->paginate(5);
		}
		else{
			$data = TomarExamen::where('UsuarioId',auth()->user()->id)->orderBy('id','DESC')->paginate(5);
		}
         return view('tomados.index',compact('data'))
			->with('i', (Request::input('page', 1) - 1) * 5);
	}

	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function create()
	{
		return redirect('tomados');
	}

	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function store(TomadosRequest $request)
	{
		return redirect('tomados');
	}

	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function show($id)
	{
		$tomarExamen = TomarExamen::findOrFail($id);
		return View('tomados.show', compact('tomarExamen'));
	}

	/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function edit($id)
	{
		return redirect('tomados');
	}

	/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function update(TomadosRequest $request, $id)
	{
		return redirect('tomados');
	}

	/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function destroy($id)
	{
		return redirect('tomados');
	}
}
