<?php

namespace App\Http\Controllers\Permit;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Permit;
use App\Reason;
use App\Notification;
use App\Role;
use App\Trace;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PermitController extends Controller
{

    public function index()
    {
        $permits = Permit::where('applicant_id',auth()->user()->id)->get();
        if(!$permits->isEmpty())
            return view('permits.permit_record',compact('permits'));
        return back()->with('info','No tiene registros de permisos');
    }

    public function store(Request $request)
    {
        //validar campos
        if(!$request['fip'] || !$request['ff'])
            return back()->with('error',__("Debe ingresar ambas fechas"));

        $success = true;
        $fi=Carbon::createFromFormat('Y-m-d',$request['fip']);
        $ff=Carbon::createFromFormat('Y-m-d',$request['ff']);
        $rf = clone $ff;
        $rf->addDay();
        while($rf->isSunday() || $rf->isSaturday()){
            $rf->addDay();
        }

        $turn = $request['turn'] ? $request['turn'] : null;

        //aprobador
        $approver = User::getSupervisor(0);
        if(!$approver || auth()->user()->id == $approver[0]->id){
            $approver = User::getApprover(0);
        }
        DB::beginTransaction();
        try{
            $permit = Permit::create([
                'applicant_id'=>auth()->user()->id,
                'supervisor_id'=>$approver[0]->id,
                'office_id'=>auth()->user()->office->id,
                'start_date'=> $fi,
                'end_date' => $ff,
                'refund_date' => $rf,
                'reason_id' => $request['reason'],
                'days' => $request['days'],
                'turn' => $turn,
                'remunerate' => $request['remunerate'],
                'substitute_require'=>$request['require'],
                'description' => $request['description'],
                'state' => Permit::PROCESO
            ]);
            if($approver[0]->role->id == Role::SUPERVISOR){
                $notification = Notification::create([
                    'origin_id'=>auth()->user()->id,
                    'destination_id'=>$approver[0]->id,
                    'title'=>'Solicitud de permiso',
                    'description'=>Notification::SOLICITUD_PERMISO
                ]);
                $approver2 = User::getApprover(0);
                $notification2 = Notification::create([
                    'origin_id'=>auth()->user()->id,
                    'destination_id'=>$approver2[0]->id,
                    'title'=>'Solicitud de permiso',
                    'description'=>Notification::SOLICITUD_PERMISO
                ]);
            }else{
                $notification = Notification::create([
                    'origin_id'=>auth()->user()->id,
                    'destination_id'=>$approver[0]->id,
                    'title'=>'Solicitud de permiso',
                    'description'=>Notification::SOLICITUD_PERMISO
                ]);
            }
            $trace = Trace::create([
                'user_id'=>auth()->user()->id,
                'type'=>Trace::PERMIT,
                'description'=>'Solicitud de permiso'
            ]);
        }catch(Exception $e){
            $success = $e->getMessage();
            DB::rollback();
        }
        if($success === true){
            DB::commit();
            return redirect(route('permits.status'))->with('success','Se ha enviado la solicitud exitosamente');
        }
        return redirect('home')->with('error',$success);


    }

    public function edit($id)
    {
        $permit = Permit::findOrFail($id);
        return view('permits.permit_confirmRefund',compact('permit'));
    }

    public function update(Request $request, $id)
    {
        $h=Permit::findOrFail($id);
        $action = $request['action'];
        if($action == 'success'){
            $h->state = Permit::APROBADO;
            $h->save();
            if($h->supervisor->role->id == Role::SUPERVISOR){
                $d = User::getApprover(0);
                $destino = $d[0]->id;
            }
        }else{
            $h->state = Permit::RECHAZADO;
            if($h->supervisor->role->id == Role::SUPERVISOR){
                $d = User::getApprover(0);
                $destino = $d[0]->id;
            }
            $h->save();
        }
        $success = true;
        //para guardar el nombre en la notificacion
        $user = User::where('id',$request['destination_id'])->get();
        try{
            DB::beginTransaction();
            //si la solicitud es aprobada
            if($action == 'success'){
                //si quien ha aprobado la solicitud es el supervisor
                if($h->supervisor->role->id == Role::SUPERVISOR){
                    $notification = Notification::create([
                        'origin_id'=>auth()->user()->id,
                        'destination_id'=> $user[0]->id,
                        'title'=>'Permiso Aprobado',
                        'description'=> Notification::APROBACION_PERMISO
                    ]);
                    $notification2 = Notification::create([
                        'origin_id'=>auth()->user()->id,
                        'destination_id'=> $destino,
                        'title'=>'Permiso Aprobado',
                        'description'=> Notification::APROBADA.$user[0]->person->name
                    ]);
                    $trace = Trace::create([
                        'user_id'=>auth()->user()->id,
                        'type'=>Trace::PERMIT,
                        'description'=>'Solicitud de permiso aprobada'
                    ]);
                    $text="La solicitud de permiso ha sido aprobada";
                    //si fueron los directores los que aprobaron
                }elseif($h->supervisor->role->id == Role::DIRECTOR_LINEA || $h->supervisor->role->id == Role::DIRECTOR_GENERAL || $h->supervisor->role->id == Role::SUPERADMIN){
                    $notification = Notification::create([
                        'origin_id'=>auth()->user()->id,
                        'destination_id'=> $user[0]->id,
                        'title'=>'Permiso Aprobado',
                        'description'=> Notification::APROBACION_PERMISO
                    ]);
                    $trace = Trace::create([
                        'user_id'=>auth()->user()->id,
                        'type'=>Trace::PERMIT,
                        'description'=>'Solicitud de permiso aprobada'
                    ]);
                    $text="La solicitud de permiso ha sido aprobada";
                }
            //si la solicitud es rechazada
            }elseif($action == 'cancel'){
                //si quien rechaza la solicitud es el supervisor
                if($h->supervisor->role->id == Role::SUPERVISOR){
                    $notification = Notification::create([
                        'origin_id'=>auth()->user()->id,
                        'destination_id'=> $user[0]->id,
                        'title'=>'Permiso Rechazado',
                        'description'=> Notification::RECHAZO_PERMISO
                    ]);
                    $notification2 = Notification::create([
                        'origin_id'=>auth()->user()->id,
                        'destination_id'=> $destino,
                        'title'=>'Permiso Rechazado',
                        'description'=> Notification::RECHAZADA.$user[0]->person->name
                    ]);
                    $trace = Trace::create([
                        'user_id'=>auth()->user()->id,
                        'type'=>Trace::PERMIT,
                        'description'=>'Permiso Rechazado'
                    ]);
                    $text="La solicitud de vacaciones ha sido rechazada";
                //si quien rechaza la solicitud son los directores
                }elseif($h->supervisor->role->id == Role::DIRECTOR_LINEA || $h->supervisor->role->id == Role::DIRECTOR_GENERAL || $h->supervisor->role->id == Role::SUPERADMIN){
                    $supervisor = User::getSupervisor();
                    //si hay un supervisor la notificacion será para el
                    if($supervisor){
                        $notification = Notification::create([
                            'origin_id'=>auth()->user()->id,
                            'destination_id'=> $user[0]->id,
                            'title'=>'Permiso Rechazado',
                            'description'=> Notification::RECHAZO_PERMISO
                        ]);
                        $notification2 = Notification::create([
                            'origin_id'=>auth()->user()->id,
                            'destination_id'=> $supervisor[0]->id,
                            'title'=>'Permiso Rechazado',
                            'description'=> Notification::RECHAZADA.$user[0]->person->name
                        ]);
                        $trace = Trace::create([
                            'user_id'=>auth()->user()->id,
                            'type'=>Trace::PERMIT,
                            'description'=>'Permiso Rechazado'
                        ]);
                        $text="La solicitud de vacaciones ha sido rechazada";
                    //sino no se creará la notificacion para el supervisor
                    }else{
                        $notification = Notification::create([
                            'origin_id'=>auth()->user()->id,
                            'destination_id'=> $user[0]->id,
                            'title'=>'Permiso Rechazado',
                            'description'=> Notification::RECHAZO_PERMISO
                        ]);
                        $trace = Trace::create([
                            'user_id'=>auth()->user()->id,
                            'type'=>Trace::PERMIT,
                            'description'=>'Permiso Rechazado'
                        ]);
                        $text="La solicitud de permiso ha sido rechazada";
                    }

                }

            }
        }catch(Exception $e){
            $success = $e->getMessage();
            DB::rollback();
        }
        if($success === true){
            DB::commit();
            return redirect(route('permits.menu'))->with('success',$text);
        }
        return redirect('home')->with('error',$success);
    }

    public function menu(){
        return view('permits.permit_menu');
    }

    public function form_request(){
        $permit = Permit::where('applicant_id',auth()->user()->id)->orderby('id','DESC')->take(1)->get();
        $reason = Reason::all();
        if($permit->isEmpty()){
            return view('permits.form_permit',compact('reason'));
        }else{
            if($permit[0]->state == Permit::APROBADO || $permit[0]->state == Permit::PROCESO){
                return back()->with('info','Ya tiene una solicitud en proceso');
            }
            return view('permits.form_permit',compact('reason'));
        }
    }

    public function status(){
        $permit = Permit::where('applicant_id',auth()->user()->id)->wherein('state',[Permit::APROBADO,Permit::PROCESO])->get();
        if(!$permit->isEmpty()){
            if($permit[0]->turn){
                if($permit[0]->turn == 't'){
                    $turn = 'Tarde';
                }else{
                    $turn = "Mañana";
                }
            }else{
                $turn = null;
            }
            return view('permits.permit_status',compact('permit','turn'));
        }
        return back()->with('warning','Aun no ha solicitado permiso');
    }

    public function getRequestPermits(){
        if(auth()->user()->role->id == Role::DIRECTOR_LINEA || auth()->user()->role->id == Role::DIRECTOR_GENERAL || auth()->user()->role->id == Role::SUPERADMIN){
            $permits = Permit::where('state',Permit::PROCESO)->where('office_id',auth()->user()->office->id)->get();
            if(!$permits->isEmpty()){
                if($permits[0]->turn){
                    $turno = $permits[0]->turn == 'm' ? 'Mañana' : 'Tarde';
                }else{
                    $turno = null;
                }
                return view('permits.permit_request',compact('permits','turno'));
            }
        }elseif(auth()->user()->role->id == Role::SUPERVISOR){
            $permits = Permit::where('state',Permit::PROCESO)->where('supervisor_id',auth()->user()->id)->get();
            if(!$permits->isEmpty()){
                if ($permits[0]->turn) {
                    $turno = $permits[0]->turn == 'm' ? 'Mañana' : 'Tarde';
                }else{
                    $turno = null;
                }
                return view('permits.permit_request',compact('permits','turno'));
            }
        }
        return back()->with('warning','No tiene nuevas solicitudes');
    }

    public function pdf($id){
        $idd = decrypt($id);
        $permit = Permit::findOrFail($idd);
        $applicant = User::findOrFail($permit->applicant_id);
        $supervisor = User::findOrFail($permit->supervisor_id);
        if ($permit->turn) {
            $turno = $permit->turn == 'm' ? 'Mañana' : 'Tarde';
        }else{
            $turno = null;
        }
        if(auth()->user()->role->id == Role::ANALISTA_PERMISOS || auth()->user()->id == $applicant->id){
            $pdf = \PDF::loadView('reports.reporte_permiso',['permit'=>$permit,'applicant'=>$applicant,'supervisor'=>$supervisor,'turno'=>$turno]);
            return $pdf->stream();
        }else{
            return back()->with('error','Error, no puede visualizar esta constancia.');
        }

    }

    public function revision(){
        $permits = Permit::where('state',Permit::APROBADO)->with('applicant')->get();
        if(!$permits->isEmpty()){
            if($permits[0]->applicant->state != User::PERMIT){
                if ($permits[0]->turn){
                    $turno = $permits[0]->turn == 'm' ? 'Mañana' : 'Tarde';
                }else{
                    $turno = null;
                }
                return view('permits.permit_revision',compact('permits','turno'));
            }
        }
        return back()->with('info','No hay solicitudes nuevas para revisar.');
    }

    public function records(){
        $permits = Permit::orderby('id','DESC')->get();
        if(!$permits->isEmpty()){
            if ($permits[0]->turn){
                $turno = $permits[0]->turn == 'm' ? 'Mañana' : 'Tarde';
            }else{
                $turno = null;
            }
            return view('permits.permit_records',compact('permits','turno'));
        }
        return back()->with('info','No hay registros.');
    }

    public function checkRefund(){
        $permits = Permit::where("state",Permit::DISFRUTANDO)->where("end_date",">=",Carbon::now()->format('Y-m-d'))->get();
        if(!$permits->isEmpty()){
            if ($permits[0]->turn){
                $turno = $permits[0]->turn == 'm' ? 'Mañana' : 'Tarde';
            }else{
                $turno = null;
            }
            return view('permits.permit_checkRefund',compact('permits','turno'));
        }
        alert()->info("No hay registros de permisos culminados aún...")->persistent();
        return back();
    }

    public function refund(Request $request, $id){
        $p = Permit::findOrFail($id);
        $p->state = Permit::COMPLETO;
        $p->save();
        $u = User::findOrFail($p->applicant_id);
        $u->state = User::AVAILABLE;
        $u->save();
        return redirect(route('permits.menu'))->with('success','Se ha editado el estado del usuario correctemente');
    }
}
