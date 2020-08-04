<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|

// Para Desabilitar la gestion de creacion de usuarios.
Route::get('register', 'Auth\AuthController@showRegistrationForm');
Route::post('register', 'Auth\AuthController@register');

// Authentication Routes...
$this->get('login', 'Auth\AuthController@showLoginForm');
$this->post('login', 'Auth\AuthController@login');
$this->get('logout', 'Auth\AuthController@logout');

// Registration Routes...
$this->get('register', 'Auth\AuthController@showRegistrationForm');
$this->post('register', 'Auth\AuthController@register');

// Password Reset Routes...
$this->get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
$this->post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
$this->post('password/reset', 'Auth\PasswordController@reset');

Route::auth();
*/

Route::get('/','HomeController@index');

Route::get('/examples/{examenId}/details/{preguntaId}','ExamplesController@index');

Route::get('login', 'Auth\AuthController@showLoginForm');

Route::post('login', 'Auth\AuthController@login');

Route::get('logout', 'Auth\AuthController@logout');

Route::group(['perms' => 'ver-tomados'], function (){
     Route::resource('tomados','TomadosController',['except'=>['store','create','destroy','update','edit']]);
});

Route::group(['perms' => 'ver-examenes-crear'], function (){
     Route::resource('examenes','ExamenesController', ['except' => ['update']]);
     Route::post('tomarexamen/{id}/notificar','TomarExamenController@notificar');
     Route::post('api/preguntas/getData/{action}','PreguntasController@getData');
     Route::post('api/opciones/getData/{action}','OpcionesController@getData');
     Route::post('api/examenes/guardar/{id}/{campo}/{valor}','ExamenesController@guardar');
     Route::post('api/permisos/getData/{action}','PermisosController@getData');
     Route::post('api/permisos/getOption/{action}','PermisosController@getOption');
     Route::get('permisos',['uses'=>'PermisosController@index','as'=>'permisos.index']);
     Route::get('examenes/{id}/importexcel', 'ExamenesController@ImportExcel');
     Route::post('examenes/{id}/importexcelpost', 'ExamenesController@ImportExcelPost');
});

Route::group(['perms' => 'ver-tomar'], function (){
     Route::resource('tomarexamen','TomarExamenController',['except'=>['store','destroy']]);
});

Route::group(['perms' => 'ver-usuarios'], function (){
     Route::resource('users','UserController');
     Route::post('usuarios/{id}/notificar','UsuariosController@notificar');
});

Route::group(['perms' => 'ver-roles'], function (){
     Route::get('roles',['as'=>'roles.index','uses'=>'RoleController@index']);
     Route::get('roles/create',['as'=>'roles.create','uses'=>'RoleController@create']);
     Route::post('roles/create',['as'=>'roles.store','uses'=>'RoleController@store']);
     Route::get('roles/{id}',['as'=>'roles.show','uses'=>'RoleController@show']);
     Route::get('roles/{id}/edit',['as'=>'roles.edit','uses'=>'RoleController@edit',]);
     Route::patch('roles/{id}',['as'=>'roles.update','uses'=>'RoleController@update',]);
     Route::delete('roles/{id}',['as'=>'roles.destroy','uses'=>'RoleController@destroy',]);
});

Route::group(['perms' => 'editar-usuario'], function (){
     Route::get('usuarios/{id}/edit',['as'=>'usuarios.edit','uses'=>'UsuariosController@edit',]);
     Route::patch('usuarios/{id}',['as'=>'usuarios.update','uses'=>'UsuariosController@update',]);
});

Route::group(['perms' => 'view-display-files'], function (){
     Route::get('displayfiles',['as'=>'display.files','uses'=>'DisplayController@index']);
     Route::post('api/display/getData/{action}','DisplayController@getData');
});

/*
Route::get('importExport', 'MaatwebsiteDemoController@importExport');
Route::get('downloadExcel/{type}', 'MaatwebsiteDemoController@downloadExcel');
Route::post('importExcel', 'MaatwebsiteDemoController@importExcel');
*/

//$permission = [
//'ver-usuarios','ver-roles','ver-examenes-crear',
//			[editar-usuario
//				'name' => 'admin-admin',
//				'display_name' => 'Administrador de aplicacion',
//				'description' => 'Administrador de la aplicacion'
//			],
//			[
//				'name' => 'ver-examen',
//				'display_name' => 'Ver propio examen',
//				'description' => 'Ver mi propio examen'
//			],
//			[
//				'name' => 'ver-examen-todos',
//				'display_name' => 'Ver todos los examenes',
//				'description' => 'Ver todos los examenes'
//			],
//			[
//				'name' => 'ver-examenes-crear',
//				'display_name' => 'Ver todos los examenes',
//				'description' => 'Ver todos los examenes'
//			],
//			[
//				'name' => 'ver-usuarios',
//				'display_name' => 'Ver todos los usuarios',
//				'description' => 'Ver todos los usuarios'
//			],
//			[
//				'name' => 'ver-roles',
//				'display_name' => 'Ver todos los roles',
//				'description' => 'Ver todos los roles'
//			],
//			[
//				'name' => 'ver-tomar',
//				'display_name' => 'Ver tomar examen',
//				'description' => 'Ver tomar examen'
//			],
//			[
//				'name' => 'ver-tomados',
//				'display_name' => 'Ver examenes tomados',
//				'description' => 'Ver examenes tomados'
//			]
//		];
