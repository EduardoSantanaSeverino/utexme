<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Requests;
use App\User;
use App\Http\Requests\UsuariosRequest;
use App\Http\Requests\UsuariosUpdateRequest;
use Debugbar;
use Mail;
use Auth;
use Redirect;

class UsuariosController extends Controller
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
		if(Auth::user() -> rolId != 1)
		{
			return Redirect::route('usuarios.edit', array('id' => Auth::user() -> id));
		}

		$listado = User::latest()->get();
		return View('usuarios.index', compact('listado'));
	}

	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function create()
	{
		if(Auth::user() -> rolId != 1)
		{
			return Redirect::route('usuarios.edit', array('id' => Auth::user() -> id));
		}
		return View('usuarios.create');
	}

	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

	public function store(UsuariosRequest $request)
	{
		if(Auth::user() -> rolId != 1)
		{
			return Redirect::route('usuarios.edit', array('id' => Auth::user() -> id));
		}

		$usuario = User::create([
			'name' => $request['name'],
			'email' => $request['email'],
			'rolId' => $request['rolId'],
			'Activo' => 1,
			'nopassword' => $request['password'],
			'password' => bcrypt($request['password'])
		]);

		$enviar = $request['enviarNotificacion'];
		if($enviar == 1)
		{
			$this -> enviarNotificacionCreado($usuario -> id);
		}

		return redirect('usuarios');
	}

	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function show($id)
	{
		$modelo = User::findOrFail($id);
		return View('usuarios.show', compact('modelo'));
	}


	/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function edit($id)
	{
		if(auth()->user()->id != $id){
			return response()->view('errors.401', [], 401);
		}
		$usuario = User::findOrFail($id);
		return View('usuarios.edit', compact('usuario'));
	}

	/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function update(UsuariosUpdateRequest $request, $id)
	{
		if(auth()->user()->id != $id){
			return response()->view('errors.401', [], 401);
		}
		$usuario = User::findOrFail($id);
		$usuario->update([
			'name' => $request['name'],
			'email' => $request['email'],
			'nopassword' => $request['password'],
			'password' => bcrypt($request['password'])
		]);
		$this -> enviarNotificacion($usuario -> id);
		return redirect()->route('usuarios.edit', array('id' => $id))
			->with('success','Password updated correctly!');
	}

	/**
     * Notificar usuario con correo.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function notificar($id)
	{
		$this -> enviarNotificacion($id);
		return redirect()->route('users.index')
			->with('success','Email sended correctly.');
	}

	protected function enviarNotificacion($id)
	{
		$user = User::findOrFail($id);
		$user -> subject = 'Recordatorio de Usuario - utex.me';
		$user -> titulo1 = 'Informacion de Usuario!';
		$user -> texto1 = 'La informacion de usuario se muestra anteriormente. ';
		Mail::send('emails.usuarios', 
				 ['user' => $user], 
				 function ($m) use ($user) {
					 $m->to($user->email, $user->name)
						 ->subject($user -> subject);
				 });
	}
	protected function enviarNotificacionCreado($id)
	{
		$user = User::findOrFail($id);
		$user -> subject = 'Notificacion de usuario - utex.me';
		$user -> titulo1 = 'Usuario Ha Sido Creado!';
		$user -> texto1 = 'Su usuario ha sido creado con exito';
		Mail::send('emails.usuarios', 
				 ['user' => $user], 
				 function ($m) use ($user) {
					 $m->to($user->email, $user->name)
						 ->subject($user -> subject);
				 });
	}


	/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function destroy($id)
	{
		if(Auth::user() -> rolId != 1)
		{
			return Redirect::route('usuarios.edit', array('id' => Auth::user() -> id));
		}

		User::destroy($id);
		return redirect('usuarios');
	}
}
