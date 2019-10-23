<?php

namespace App\Http\Controllers\Stadistics;

use App\Holiday;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Office;
use App\Role;
use App\User;
use Carbon\Carbon;
use App\Permit;

class StadisticsController extends Controller
{
    public function getStadistics(Request $request){
        if($request->path() == "holidays/estadisticas"){
            if(auth()->user()->role->id == Role::SUPERADMIN){
                $offices = Office::all();
                $yearly = DB::table('holidays')->select(DB::raw('count(*) as ty'), DB::raw('extract(year from created_at) as year'))->groupBy('year')
                  ->orderBy('year','ASC')->get();
                //conteo mensual
                $monthly = DB::table('holidays')->select(DB::raw('count(*) as tm'), DB::raw('extract(month from created_at) as month'))
                  ->whereYear('created_at',Carbon::now()->format('Y'))->groupBy('month')->orderBy('month','ASC')->get();
                //conteo diario
                $daily= Holiday::whereDate('created_at',Carbon::now()->format('Y-m-d'))->count();
                //funcionarios de vacaciones
                $users = Office::withCount(['users'=> function($query){
                    $query->where('state',User::HOLIDAY);
                }])->get();

                return view('holidays.stadistics',compact('yearly','users','daily','monthly','offices'));

            }elseif(auth()->user()->role->id == Role::DIRECTOR_GENERAL || auth()->user()->role->id == Role::DIRECTOR_LINEA){
                //conteo anual
                $yearly = DB::table('holidays')->select(DB::raw('count(*) as ty'), DB::raw('extract(year from created_at) as year'))->where('office_id',auth()->user()->office_id)->groupBy('year')
                  ->orderBy('year','ASC')->get();
                //conteo mensual
                $monthly = DB::table('holidays')->select(DB::raw('count(*) as tm'), DB::raw('extract(month from created_at) as month'))
                  ->whereYear('created_at',Carbon::now()->format('Y'))->where('office_id',auth()->user()->office_id)->groupBy('month')->orderBy('month','ASC')->get();
                //conteo diario
                $daily= Holiday::whereDate('created_at',Carbon::now()->format('Y-m-d'))->where('office_id',auth()->user()->office_id)->count();
                //cantidad de funcionarios de vacaciones
                $users = Office::withCount(['users'=> function($query){
                    $query->where('state',User::HOLIDAY);
                }])->where('id',auth()->user()->office_id)->get();

                return view('holidays.stadistics',compact('yearly','users','daily','monthly'));
            }
        }elseif($request->path() == "permits/estadisticas"){
            if(auth()->user()->role->id == Role::SUPERADMIN){
                $offices = Office::all();
                $yearly = DB::table('permits')->select(DB::raw('count(*) as ty'), DB::raw('extract(year from created_at) as year'))->groupBy('year')
                  ->orderBy('year','ASC')->get();
                //conteo mensual
                $monthly = DB::table('permits')->select(DB::raw('count(*) as tm'), DB::raw('extract(month from created_at) as month'))
                  ->whereYear('created_at',Carbon::now()->format('Y'))->groupBy('month')->orderBy('month','ASC')->get();
                //conteo diario
                $daily= Permit::whereDate('created_at',Carbon::now()->format('Y-m-d'))->count();
                //funcionarios de vacaciones
                $users = Office::withCount(['users'=> function($query){
                    $query->where('state',User::PERMIT);
                }])->get();

                return view('permits.stadistics',compact('yearly','users','daily','monthly','offices'));

            }elseif(auth()->user()->role->id == Role::DIRECTOR_GENERAL || auth()->user()->role->id == Role::DIRECTOR_LINEA){

                //conteo anual
                $yearly = DB::table('permits')->select(DB::raw('count(*) as ty'), DB::raw('extract(year from created_at) as year'))->where('office_id',auth()->user()->office_id)->groupBy('year')
                  ->orderBy('year','ASC')->get();
                //conteo mensual
                $monthly = DB::table('permits')->select(DB::raw('count(*) as tm'), DB::raw('extract(month from created_at) as month'))
                  ->whereYear('created_at',Carbon::now()->format('Y'))->where('office_id',auth()->user()->office_id)->groupBy('month')->orderBy('month','ASC')->get();
                //conteo diario
                $daily= Permit::whereDate('created_at',Carbon::now()->format('Y-m-d'))->where('office_id',auth()->user()->office_id)->count();
                //cantidad de funcionarios de vacaciones
                $users = Office::withCount(['users'=> function($query){
                    $query->where('state',User::PERMIT)->where('office_id',auth()->user()->office_id);
                }])->get();
                return view('permits.stadistics',compact('yearly','users','daily','monthly'));
            }
        }
    }

    public function getStadisticsByOffice(Request $request){
        if(auth()->user()->role_id == Role::SUPERADMIN){
            $office = $request['office_id'];
            $offices = Office::all()->toArray();
            if($office == "0"){
                return redirect()->route('holidays.stadistics');
            }
            //conteo anual
            $yearly = DB::table('holidays')->select(DB::raw('count(*) as ty'), DB::raw('extract(year from created_at) as year'))->where('office_id',$office)->groupBy('year')
            ->orderBy('year','ASC')->get();
            //conteo mensual
            $monthly = DB::table('holidays')->select(DB::raw('count(*) as tm'), DB::raw('extract(month from created_at) as month'))
                ->whereYear('created_at',Carbon::now()->format('Y'))->where('office_id',$office)->groupBy('month')->orderBy('month','ASC')->get();
            //conteo diario
            $daily= Holiday::whereDate('created_at',Carbon::now()->format('Y-m-d'))->where('office_id',$office)->count();
            //cantidad de funcionarios de vacaciones
            $users = Office::withCount(['users'=> function($query){
                $query->where('state',User::HOLIDAY);
            }])->where('id',$office)->get();

            foreach($offices as $key => $val){
                $indice = array_search($office,$val);
                if($indice){
                    $name = $val['acronimo'];
                }

            }
            $title = "Estadísticas de la ".$name;
            return view('holidays.stadistics',compact('yearly','users','daily','monthly','office','offices','title'));
        }else{
            return back()->with('warning','Usted no tiene permiso para acceder a este módulo');
        }

    }
}
