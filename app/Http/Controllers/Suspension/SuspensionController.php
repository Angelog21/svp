<?php

namespace App\Http\Controllers\Suspension;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Holiday;
use App\Notification;
use App\Suspension;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SuspensionController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            Suspension::create([
                'employee_id'=>$request['employee_id'],
                'supervisor_id'=>$request['supervisor_id'],
                'suspension_date'=>Carbon::now()->format('Y-m-d'),
                'refund_date'=>$request['frval'],
                'enjoyed_days'=>$request['enjoyed_days'],
                'leftover_days'=>$request['leftover_days'],
                'reason'=>$request['reason']
            ]);
            
            Holiday::whereId($request['holiday_id'])->update([
                    'enjoyed_days'=>$request['enjoyed_days'],
                    'leftover_days'=>$request['leftover_days'],
                    'state'=>Holiday::SUSPENDIDO
                ]);

            $h = Holiday::findOrFail($request['holiday_id']); 
            $period = $h->periods->first();
            $period->update([
                'available_days'=>$request['leftover_days']
            ]);
            
            User::whereId($request['employee_id'])->update([
                'state'=>User::AVAILABLE
            ]);

            Notification::create([
                'origin_id'=>auth()->user()->id,
                'destination_id'=>$request['employee_id'],
                'title'=>'Suspension de Vacaciones',
                'description'=>auth()->user()->person->name." ".Notification::SUSPENSION_VACACIONES
            ]);

            $success=true;
        }catch(Exception $e){
            $success = false;
            DB::rollback();
            alert()->error($e);
            return back();
        }
        if($success===true){
            DB::commit();
            alert()->success('Se han suspendido las vacaciones exitosamente.');
            return redirect(route('home'));
        }
    }

    public function show($id)
    {
        $holiday = Holiday::findOrFail($id);
        $fi = Carbon::createFromFormat('Y-m-d',$holiday->start_date);
        $ff = Carbon::createFromFormat('Y-m-d',$holiday->end_date);
        $now = new Carbon;
        $enjoyed = $fi->diffInDays(Carbon::now());
        $remaining = $now->diffInDays($ff);
        while($fi <= $ff){
            if($fi <= $now){
                if($fi->isSunday() || $fi->isSaturday()){
                    $enjoyed--;
                }
            }else{
                if($fi->isSunday() || $fi->isSaturday()){
                    $remaining--;
                }
            }
            $fi->addDay();
        }
        return view('holidays.suspension',compact('holiday','enjoyed','remaining'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
