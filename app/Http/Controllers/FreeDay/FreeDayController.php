<?php

namespace App\Http\Controllers\FreeDay;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FreeDay;
use Carbon\Carbon;
use App\Role;
use Illuminate\Support\Facades\Session;
use App\Holiday;

class FreeDayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $freedays = FreeDay::latest()->paginate(10);
        if(!$freedays->isEmpty() || auth()->user()->role->id == Role::ANALISTA_VACACIONES){
            return view('holidays.freeDays',compact('freedays'));
        }
        return back()->with('info','No hay dias feriados');
    }

    public function store(Request $request)
    {
        $freeday = new FreeDay;
        $freeday->date = Carbon::createFromDate($request->fi)->format('Y-m-d');
        $freeday->description = $request->description;
        $freeday->save();
        if($freeday->save()){
            $true = Holiday::sumDay($freeday->date);
            if($true != null){
                return back()->with('success','Se ha guardado la fecha exitosamente y se han sumado los dias a los registros de vacaciones entre la fecha establecida');
            }
            return back()->with('success','Se ha guardado la fecha exitosamente');
        }
        return back()->with('error','Error al guardar la fecha');
    }

    public function edit($id)
    {
        $freeday = FreeDay::findOrFail($id);
        return view('partials.freedays.form2',compact('freeday'));
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
        $freeday = FreeDay::findOrFail($id);
        $freeday->date = Carbon::createFromDate($request->fival)->format('Y-m-d');
        $freeday->description = $request->description;
        $freeday->save();
        if($freeday->save()){
            alert()->success('Se ha editado la fecha correctamente');
            return redirect()->route('holidays.feriados');
        }
        alert()->error('Error al editar la fecha');
        return redirect()->route('holidays.feriados');

    }

    public function destroy($id)
    {
        $freeday = FreeDay::findOrFail($id);
        $date = $freeday->date;
        $freeday->delete();
        $true = Holiday::subsDay($date);
        if($true != false){
            return back()->with('success','Fecha eliminada correctamente y se ha restado el dia agregado a los registros de vacaciones correspondientes');
        }
        return back()->with('success','Fecha eliminada correctamente');
    }
}
