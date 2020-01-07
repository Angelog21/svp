<?php

namespace App\Http\Controllers\Reason;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Reason;

class ReasonController extends Controller
{
    public function index()
    {
        $reasons = Reason::all();
        if(!$reasons->isEmpty()){
            return view('permits.reasonManage',compact('reasons'));
        }
        return view('permits.reasonManage');
    }

    public function store(Request $request)
    {
        $reason = new Reason;
        $reason->name = $request->name;
        $reason->save();
        if($reason->save()){
            return back()->with('success','Se ha guardado el motivo exitosamente');
        }
        return back()->with('error','Error al guardar la fecha');
    }

    public function edit($id)
    {
        $reason = Reason::findOrFail($id);
        return view('partials.reason.form2',compact('reason'));
    }

    public function update(Request $request, $id)
    {
        $reason = Reason::findOrFail($id);
        $reason->name = $request->name;
        $reason->save();
        if($reason->save()){
            alert()->success('Se ha editado el motivo correctamente');
            return redirect()->route('permits.reasonAdmin');
        }
        alert()->error('Error al editar el motivo');
        return redirect()->route('permits.reasonAdmin');

    }

    public function destroy($id)
    {
        $reason = Reason::findOrFail($id);
        $reason->delete();
        return back()->with('success','Motivo eliminado correctamente');
    }
}
