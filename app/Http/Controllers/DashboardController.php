<?php

namespace App\Http\Controllers;

use App\Ventas;
use App\Ingreso;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $anio=date('Y');
        
        $ingresos=DB::table('ingresos as i')
        ->select(DB::raw('MONTHNAME(i.fecha_hora) as mes'),
        DB::raw('YEAR(i.fecha_hora) as anio'),
        DB::raw('SUM(i.total) as total'))
        ->whereYear('i.fecha_hora',$anio)
        ->groupBy(DB::raw('MONTHNAME(i.fecha_hora)'),DB::raw('YEAR(i.fecha_hora)'))
        ->get();

        $ventas=DB::table('ventas as v')
        ->select(DB::raw('MONTHNAME(v.fecha_hora) as mes'),
        DB::raw('YEAR(v.fecha_hora) as anio'),
        DB::raw('SUM(v.total) as total'))
        ->whereYear('v.fecha_hora',$anio)
        ->groupBy(DB::raw('MONTHNAME(v.fecha_hora)'),DB::raw('YEAR(v.fecha_hora)'))
        ->get();


        $mytime = Carbon::now('America/Lima');
        $mytime->toDateString();
        
        
       // $date = DB::table('ventas')
                
                //->whereDate('fecha_hora', $mytime)
                //->sum('total');

        //ventas en dia
        $ventaDia = Ventas::whereDate('fecha_hora',$mytime)
        ->get();

        //compra en dia
        $IngresoDia = Ingreso::whereDate('fecha_hora',$mytime)
        ->get();
        //compras todo
        $totalIngreso = Ingreso::get();
        //ventas todo
        $totalVentas = Ventas::get();

        return ['ingresos'=>$ingresos,'ventas'=>$ventas,'anio'=>$anio,'ventaDia'=>$ventaDia,'ingresoDia'=>$IngresoDia,'TotalCompras'=>$totalIngreso,'TotalVentas'=>$totalVentas]; 
    }
}
