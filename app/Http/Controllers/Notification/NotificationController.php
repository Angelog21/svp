<?php

namespace App\Http\Controllers\Notification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notification;
use App\User;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $n = Notification::where('destination_id',auth()->user()->id)->get();
        if(!$n->isEmpty()){
            return view('notifications',compact('n'));
        }
        return back()->with('info','No tiene notificaciones');
    }

    public function manuales(){
        return view('manuals');
    }

    public function manual(){
        $pdf = \PDF::loadView('reports.manual_general');
        return $pdf->stream();
    }

    public function manualEspecial(){
        $pdf = \PDF::loadView('reports.manual_especial');
        return $pdf->stream();
    }

}
