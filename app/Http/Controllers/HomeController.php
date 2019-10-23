<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Holiday;
use App\Permit;
use Illuminate\Support\Facades\Session;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $h = Holiday::where('applicant_id',auth()->user()->id)->latest()->first();
        $p = Permit::where('applicant_id',auth()->user()->id)->latest()->first();
        if($h){
            if($h->state == Holiday::APROBADO){
                alert()->success('Sus vacaciones han sido aprobadas!','Debe dirigirse a la Oficina de gestión humana para firmar su solicitud');
                return view('home');
            }
        }elseif($p){
            if($h->state == Permit::APROBADO){
                alert()->success('La solicitud de permiso ha sido aprobada!');
                return view('home');
            }
        }
        return view('home');
    }
}
