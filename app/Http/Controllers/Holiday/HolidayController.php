<?php

namespace App\Http\Controllers\Holiday;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Holiday;
use App\User;
use Carbon\Carbon;
use App\Period;
use App\Person;
use Illuminate\Support\Facades\DB;
use App\Trace;
use App\Notification;
use App\Area;
use App\Role;
use App\Http\Controllers\Period\PeriodController;
use App\FreeDay;
use Illuminate\Support\Facades\URL;

class HolidayController extends Controller
{
    public function index()
    {
        $holidays = Holiday::where('applicant_id',auth()->user()->id)->get();
        if(!$holidays->isEmpty())
            return view('holidays.holiday_record',compact('holidays'));
        return back()->with('info','No tiene registros de vacaciones');
    }

    public function store(Request $request)
    {
        $h = DB::table('holidays')->selectRaw('DATE(created_at) AS date')->whereDate('created_at',Carbon::now()->format('Y-m-d'))->get();
        if(!$h->isEmpty()){
            $success = true;
            $p_id = [];
            if(isset($request['p'])){
                $p = $request['p'];
                for ($i=0; $i < $request['p']; $i++){
                    $p_id[$i]=$request["period_".($i+1)];
                }
                if(isset($request['especial'])){
                    array_push($p_id,PeriodController::newPeriod());
                    $p++;
                }
            }else{
                $p_id=PeriodController::newPeriod();
            }
            $fi = date("Y-m-d", strtotime($request['fi']));
            $ff = date("Y-m-d", strtotime($request['ff']));
            $total = $request['freedays'] + $request['request_days'];

            DB::beginTransaction();
            try{
                if(auth()->user()->role_id !== Role::DIRECTOR_LINEA){
                    $holiday = Holiday::create([
                        'applicant_id'=>$request['applicant_id'],
                        'supervisor_id'=>$request['supervisor_id'],
                        'approver_id'=>$request['approver_id'],
                        'office_id'=>auth()->user()->office->id,
                        'request_days'=>$request['request_days'],
                        'enjoyed_days'=>0,
                        'leftover_days'=>$total,
                        'start_date'=> $fi,
                        'end_date' => $ff,
                        'refund_date' => date("Y-m-d", strtotime($request['refund_date'])),
                        'state' => Holiday::PROCESO
                    ]);
                    if($request['supervisor_id']){
                        $notification = Notification::create([
                            'origin_id'=>$request['applicant_id'],
                            'destination_id'=>$request['supervisor_id'],
                            'title'=>'Solicitud de vacaciones',
                            'description'=>Notification::SOLICITUD_VACACIONES
                        ]);
                    }
                    $notification2 = Notification::create([
                        'origin_id'=>$request['applicant_id'],
                        'destination_id'=>$request['approver_id'],
                        'title'=>'Solicitud de vacaciones',
                        'description'=>Notification::SOLICITUD_VACACIONES
                    ]);
                    $trace = Trace::create([
                        'user_id'=>$request['applicant_id'],
                        'type'=>Trace::HOLIDAY,
                        'description'=>'Solicitud de vacaciones'
                    ]);
                }else{
                    $holiday = Holiday::create([
                        'applicant_id'=>$request['applicant_id'],
                        'supervisor_id'=>$request['supervisor_id'],
                        'approver_id'=>$request['approver_id'],
                        'office_id'=>auth()->user()->office->id,
                        'request_days'=>$request['request_days'],
                        'enjoyed_days'=>0,
                        'leftover_days'=>$total,
                        'start_date'=> $fi,
                        'end_date' => $ff,
                        'refund_date' => date("Y-m-d", strtotime($request['refund_date'])),
                        'state' => Holiday::PROCESO
                    ]);
                    $notification = Notification::create([
                        'origin_id'=>$request['applicant_id'],
                        'destination_id'=>$request['approver_id'],
                        'title'=>'Solicitud de vacaciones',
                        'description'=>Notification::SOLICITUD_VACACIONES
                    ]);
                    $trace = Trace::create([
                        'user_id'=>$request['applicant_id'],
                        'type'=>Trace::HOLIDAY,
                        'description'=>'Solicitud de vacaciones'
                    ]);
                }
            }catch(Exception $e){
                $success = $e->getMessage();
                DB::rollback();
            }
            if($success === true){
                if(isset($request['p'])){
                    for ($i=0; $i < $p; $i++){
                        $holiday->periods()->attach($p_id[$i]);
                    }
                }else{
                    $holiday->periods()->attach($p_id);
                }
                DB::commit();
                return redirect(route('holidays.status'))->with('success','Se ha enviado la solicitud exitosamente');
            }
            return view('home')->with('error',$success);
        }else{
            alert()->error('Ya se ha creado su registro de vacaciones, para revisar el estatus en el que se encuentra debe seleccionar la opcion "Estatus de Solicitud"');
            return redirect(route('home'));
        }

    }

    public function edit($id)
    {
        $holiday = Holiday::findOrFail($id);
        return view('holidays.confirmRefund',compact('holiday'));
    }

    public function refund(Request $request, $id){
        $h = Holiday::findOrFail($id);
        $h->state = Holiday::COMPLETO;
        $request_days = $h->request_days;
        $leftover = $h->leftover_days;
        $h->observation = $request['observation'];
        foreach($h->periods as $key => $val){
            if($h->request_days > $val->available_days){
                $h->request_days -= $val->available_days;
                $val->available_days = 0;
                $val->save();
            }else{
                $val->available_days -= $h->request_days;
                $h->enjoyed_days = $leftover;
                $h->leftover_days = 0;
                $val->save();
            }
        }
        $h->request_days = $request_days;
        $h->save();
        $u = User::findOrFail($h->applicant_id);
        $u->state = User::AVAILABLE;
        $u->save();
        return redirect(route('holidays.menu'))->with('success','Se ha editado el estado del usuario correctemente');
    }

    public function update(Request $request, $id)
    {
        $h=Holiday::findOrFail($id);
        $action = $request['action'];
        if($action == 'success'){
            $h->state = Holiday::APROBADO;
            $h->save();
        }else{
            $h->state = Holiday::RECHAZADO;
            if(auth()->user()->id == $h->supervisor_id){
                $destino = $h->approver_id;
            }else{
                $destino = $h->supervisor_id;
            }
            $vp = Period::validatePeriod();
            if($vp === true){
                $vp = Period::where('user_id',$h->applicant_id)->get()->last();
                $h->periods()->detach($vp->id);
                $vp->delete();
            }
            $h->save();
        }
        $user = User::where('id',$request['destination_id'])->get();
        try{
            DB::beginTransaction();
            if($action == 'success'){
                $notification = Notification::create([
                    'origin_id'=>auth()->user()->id,
                    'destination_id'=> $request['destination_id'],
                    'title'=>'Vacaciones Aprobadas',
                    'description'=> Notification::APROBACION_VACACIONES
                ]);
                $notification2 = Notification::create([
                    'origin_id'=>auth()->user()->id,
                    'destination_id'=> $h->supervisor_id,
                    'title'=>'Vacaciones Aprobadas',
                    'description'=> Notification::APROBADA.$user[0]->person->name
                ]);
                $trace = Trace::create([
                    'user_id'=>auth()->user()->id,
                    'type'=>Trace::HOLIDAY,
                    'description'=>'Solicitud de vacaciones aprobada'
                ]);
                $text="La solicitud de vacaciones ha sido aprobada";
            }elseif($action == 'cancel'){
                $notification = Notification::create([
                    'origin_id'=>auth()->user()->id,
                    'destination_id'=> $request['destination_id'],
                    'title'=>'Vacaciones Rechazadas',
                    'description'=> Notification::RECHAZO_VACACIONES
                ]);
                $notification2 = Notification::create([
                    'origin_id'=>auth()->user()->id,
                    'destination_id'=> $destino,
                    'title'=>'Vacaciones Rechazadas',
                    'description'=> Notification::RECHAZADA.$user[0]->person->name
                ]);
                $trace = Trace::create([
                    'user_id'=>auth()->user()->id,
                    'type'=>Trace::HOLIDAY,
                    'description'=>'Vacaciones Rechazadas'
                ]);
                $text="La solicitud de vacaciones ha sido rechazada";
                }
                $success = true;
        }catch(Exception $e){
            $success = $e->getMessage();
            DB::rollback();
        }
        if($success === true){
            DB::commit();
            return redirect(route('holidays.menu'))->with('success',$text);
        }
        return redirect('home')->with('error',$success);
    }

    public function menu(){
        $roleUser = User::roleUser();
        return view('holidays.holiday_menu', compact('roleUser'));
    }

    public function getDays(){
        $days = Period::getAvailableDays();
        if($days != 0){
            return $days;
        }
        return null;
    }

    public function validateStartDate($fi){
        $date_admission = Person::getDateAdmission();
        $date1 = substr($fi,0,4).'-'.substr($date_admission,5);
        $date2 = substr($fi,0,-9);
        $int1 = date('Y-m-d',strtotime($date1));
        $int2 = date('Y-m-d',strtotime($date2));
        if($int2 >= $int1)
            return true;
        return null;
    }

    public function calculate(Request $request){
        //validar campos
        if(!$request['fival'] || !$request['ff'])
            return back()->with('error',__("Debe ingresar ambas fechas"));
        //datos vacaciones
        $fi=Carbon::createFromFormat('Y-m-d',$request['fival']);
        $ff=Carbon::createFromFormat('Y-m-d',$request['ff']);
        $rd = $request['rd'];
        $available_periods = Period::getAvailablePeriod($rd);
        $freedays = FreeDay::getDaysInRange($fi,$ff);
        $rf = clone $ff;
        if($freedays != 0){
            $rf->addDays($freedays);
        }else{
            $rf->addDay();
        }
        while($rf->isSunday() || $rf->isSaturday()){
            $rf->addDay();
        }
        //datos flujo
        $approver = User::getApprover(0);
        $supervisor = User::getSupervisor();
        if($available_periods){
            $available_days = $this->getDays();
            if($rd > $available_days){
                $result = $this->validateStartDate($fi);
                $result2 = Period::validatePeriod();
                if($result && $result2 === true){
                    $d = $available_periods[0]['available_days']+30;
                    if($rd < $d){
                        $datos = [
                            'fi'=>$fi,
                            'ff'=>$ff,
                            'periods'=>$available_periods,
                            'request_days'=>$rd,
                            'available_days'=>$d,
                            'refund_date'=> $rf,
                            'restant'=>$d-$rd,
                            'freedays'=>$freedays,
                            'approver'=>$approver,
                            'supervisor'=>$supervisor
                        ];
                        $especial = true;
                        alert()->success('Ha solicitado mas días de los que ya tiene disponible, Sin embargo para la fecha que usted ha solicitado sus vacaciones ya tendrá un periodo vencido con 30 días adicionales.')->persistent("Cerrar");
                        return view('holidays.dataHoliday',compact('datos','especial'));
                    }else{
                        return back()->with('error','Los dias solicitados superan los dias que usted tiene disponible');
                    }
                }else{
                    return back()->with('error','Los dias solicitados superan los dias que usted tiene disponible');
                }
            }else{
                $datos = [
                    'fi'=>$fi,
                    'ff'=>$ff,
                    'periods'=>$available_periods,
                    'request_days'=>$rd,
                    'available_days'=>$available_days,
                    'freedays'=>$freedays,
                    'refund_date'=> $rf,
                    'restant'=>$available_days-$rd,
                    'approver'=>$approver,
                    'supervisor'=>$supervisor
                ];
                return view('holidays.dataHoliday',compact('datos'));
            }
        }else{
            $result = $this->validateStartDate($fi);
            if($result){
                if($rd <= 30){
                    $datos = [
                        'fi'=>$fi,
                        'ff'=>$ff,
                        'periods'=>null,
                        'request_days'=>$rd,
                        'available_days'=>30,
                        'refund_date'=> $rf,
                        'restant'=>30-$rd,
                        'freedays'=>$freedays,
                        'approver'=>$approver,
                        'supervisor'=>$supervisor
                    ];
                    alert()->success('Usted aun no cuenta con periodos vacacionales disponibles, Sin embargo para la fecha que usted ha solicitado sus vacaciones ya tendrá un periodo vencido.')->persistent("Cerrar");
                    return view('holidays.dataHoliday',compact('datos'));
                }else{
                    return back()->with('error','Los dias solicitados superan el limite de los dias disponibles');
                }
            }else{
                return back()->with('error','Error, no cuenta con periodos vencidos para solicitar sus vacaciones');
            }
        }
    }

    public function form_request(){
        $holiday = Holiday::where('applicant_id',auth()->user()->id)->orderby('id','DESC')->take(1)->get();
        $date_admission = Person::getDateAdmission();
        $dates = date('Y').'-'.substr($date_admission,5);
        $date = Carbon::createFromFormat('Y-m-d',$dates);
        if($date >= date('Y-m-d')){
            $rdate = $date->format('d-m-Y');
        }else{
            $rdate = $date->addYear()->format('d-m-Y');
        }
        $days = Period::getAvailableDays();
        if($holiday->isEmpty()){
            return view('holidays.form_holiday',compact('days','rdate'));
        }else{
            if($holiday[0]->state == Holiday::APROBADO || $holiday[0]->state == Holiday::PROCESO || $holiday[0]->state == Holiday::FIRMADO || $holiday[0]->state == Holiday::DISFRUTANDO){
                return back()->with('info','Ya tiene una solicitud en proceso');
            }
            return view('holidays.form_holiday',compact('days','rdate'));
        }
    }

    public function status(){
        $holiday = Holiday::where('applicant_id',auth()->user()->id)->where('state','<>',Holiday::COMPLETO)->get();
        if(!$holiday->isEmpty()){
            return view('holidays.holiday_status',compact('holiday'));
        }
        return back()->with('warning','Aun no ha solicitado vacaciones');
    }

    public function getRequestHolidays(){
        if(auth()->user()->role->id == Role::DIRECTOR_LINEA || auth()->user()->role->id == Role::DIRECTOR_GENERAL || auth()->user()->role->id == Role::SUPERADMIN){
            $holidays = Holiday::where('state',Holiday::PROCESO)->where('approver_id',auth()->user()->id)->get();
            if(!$holidays->isEmpty()){
                return view('holidays.holiday_request',compact('holidays'));
            }
        }elseif(auth()->user()->role->id == Role::SUPERVISOR){
            $holidays = Holiday::where('state',Holiday::PROCESO)->where('supervisor_id',auth()->user()->id)->get();
            if(!$holidays->isEmpty()){
                return view('holidays.holiday_request',compact('holidays'));
            }
        }
        return back()->with('warning','No tiene nuevas solicitudes');
    }

    public function revision(){
        $holidays = Holiday::where('state',Holiday::APROBADO)->get();
        if(!$holidays->isEmpty()){
            return view('holidays.holiday_revision',compact('holidays'));
        }
        return back()->with('info','no hay solicitudes nuevas para revisar');
    }

    public function records(){
        $h = Holiday::orderby('id','DESC')->get();
        if(!$h->isEmpty()){
            $user = User::where('id',$h[0]->applicant_id)->get();
            return view('holidays.holidays_records',compact('h','user'));
        }
        return back()->with('info','no hay registros');
    }

    public function pdf($id){
        $idd = decrypt($id);
        $holiday = Holiday::findOrFail($idd);
        $applicant = User::findOrFail($holiday->applicant_id);
        $supervisor = User::findOrFail($holiday->supervisor_id);
        $approver = User::findOrFail($holiday->approver_id);
        if(auth()->user()->role->id == Role::ANALISTA_VACACIONES || auth()->user()->id == $applicant->id){
            $pdf = \PDF::loadView('reports.reporte_vacaciones',['holiday'=>$holiday,'applicant'=>$applicant,'supervisor'=>$supervisor,'approver'=>$approver]);
            return $pdf->stream();
        }else{
            return back()->with('error','Error, no puede visualizar esta constancia');
        }

    }

    public function checkRefund(){
        $holidays = Holiday::where("state",Holiday::DISFRUTANDO)->where("end_date",">=",Carbon::now()->format('Y-m-d'))->get();
        if(!$holidays->isEmpty()){
            return view('holidays.holiday_checkRefund',compact('holidays'));
        }
        alert()->info("No hay registros de vacaciones culminadas aún...")->persistent();
        return back();
    }

    public function manageStaff(){
        return view('holidays.manageStaff');
    }

    public function createHoliday($user_id){
        $periods = Period::where('user_id',$user_id)->get();
        $user = User::where('id',$user_id)->get();
        $approver = User::getApprover($user_id);
        return view('holidays.holiday_create_form',compact('periods','user','approver'));
    }

}
