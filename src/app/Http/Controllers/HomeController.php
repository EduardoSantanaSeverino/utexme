<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\TomarExamen;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
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
    public function index()
    {
        $UsuarioId                                        = Auth::id();
        $listado = TomarExamen::where('UsuarioId', $UsuarioId) -> latest() -> take(6) -> get();
        return view('home.index', compact('listado'));
    }

}
