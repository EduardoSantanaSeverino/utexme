<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use DB;
use Hash;
use Mail;
use Auth;
use Redirect;

class UserController extends Controller
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
	public function index(Request $request)
	{
		$data = User::orderBy('id','DESC')->paginate(5);
		return view('users.index',compact('data'))
			->with('i', ($request->input('page', 1) - 1) * 5);
	}

	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function create()
	{
		$roles = Role::lists('display_name','id');
		return view('users.create',compact('roles'));
	}

	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function store(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required|email|unique:users,email',
			'password' => 'required|same:confirm-password',
			'roles' => 'required'
		]);

		$input = $request->all();
		$input['password'] = bcrypt($input['password']);
		$input['Activo'] = 1;
		$input['nopassword'] = $request['password'];

		$user = User::create($input);

		$user->roles()->sync($request->input('roles'));

		//foreach ($request->input('roles') as $key => $value) {
		//	$user->attachRole($value);
		//}
		
		$enviar = $request->input('enviarNotificacion', 0);
		if($enviar == 1)
		{
			$this -> enviarNotificacionCreado($user -> id);
		}

		return redirect()->route('users.index')
			->with('success','User created successfully');
	}

	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function show($id)
	{
		$user = User::find($id);
		return view('users.show',compact('user'));
	}

	/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function edit($id)
	{
		$user = User::find($id);
		$roles = Role::lists('display_name','id');
		$userRole = $user->roles->lists('id','id')->toArray();

		return view('users.edit',compact('user','roles','userRole'));
	}

	/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required|email|unique:users,email,'.$id,
			'password' => 'same:confirm-password',
			'roles' => 'required'
		]);

		$input = $request->all();
		if(!empty($input['password'])){ 
			$input['password'] = bcrypt($input['password']);
			$input['nopassword'] = $request['password'];
		}else{
			$input = array_except($input,array('password'));    
		}
		$input['Activo'] = $request['Activo'];
		$user = User::find($id);
		$user->update($input);
		DB::table('role_user')->where('user_id',$id)->delete();

		$user->roles()->sync($request->input('roles'));

		//foreach ($request->input('roles') as $key => $value) {
		//	$user->attachRole($value);
		//}
		
		$enviar = $request->input('enviarNotificacion', 0);
		if($enviar == 1)
		{
			$this -> enviarNotificacion($user -> id);
		}

		return redirect()->route('users.index')
			->with('success','User updated successfully');
	}

	/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function destroy($id)
	{
		User::find($id)->delete();
		return redirect()->route('users.index')
			->with('success','User deleted successfully');
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
}