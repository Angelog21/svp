<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Holiday;
use App\Role;
use App\Person;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $u = User::findOrFail($id);
        $u->state = User::HOLIDAY;
        $u->save();
        $h = Holiday::where('applicant_id',$id)->orderby('created_at','DESC')->first();
        $h->state = Holiday::DISFRUTANDO;
        $h->save();
        return redirect(route('holidays.menu'))->with('success','Se ha editado el estado del usuario correctamente');
    }

    public function getHolidayPersonal(){
        if(auth()->user()->role_id == Role::DIRECTOR_GENERAL || auth()->user()->role_id == Role::DIRECTOR_LINEA || auth()->user()->role_id == Role::SUPERADMIN){
            $holidays = Holiday::where('office_id',auth()->user()->office_id)->where('state',Holiday::DISFRUTANDO)->get();
            if(!$holidays->isEmpty()){
                return view('holidays.holiday_personal',compact('holidays'));
            }
            return back()->with('info','No hay personal de vacaciones');
        }elseif(auth()->user()->role_id == Role::SUPERVISOR){
            $h = Holiday::where('office_id',auth()->user()->office_id)->where('state',Holiday::DISFRUTANDO)->get();
            $holidays = [];
            foreach($h as $key => $val){
                if($val->applicant->area->id == auth()->user()->area_id){
                    $holidays[$key] = $val;
                }
            }
            return view('holidays.holiday_personal',compact('holidays'));
        }else{
            return back()->with('info',"Usted no tiene permiso para aceder a este módulo");
        }
    }

    public function search($cedula){
        $person = Person::where('card_id',$cedula)->get();
        if(!$person->isEmpty()){
            return $person;
        }
        return null;
    }
}
