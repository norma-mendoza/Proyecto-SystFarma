<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Presentacion;
class PresentacionController extends Controller
{   
    public function index(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $presentaciones = Presentacion::orderBy('id','desc')->paginate(6);//elocuen           
        }
        else{
           $presentaciones = Presentacion::where($criterio, 'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(3);
        }
        //$presentaciones =DB::table('categorias')->paginate(6);//generador de paginacio
        
        return [
            'pagination' =>[
                'total'   =>$presentaciones->total(),
                'current_page' => $presentaciones->currentPage(),
                'per_page' => $presentaciones->perPage(),
                'last_page' => $presentaciones->lastPage(),
                'from'=> $presentaciones->firstItem(),
                'to' => $presentaciones->lastItem(),
        ],
        'presentaciones' => $presentaciones
        ];
    }
    //funcion para cargar presentacion para mantenimiento de formulario articulo
    public function selectPresentacion(Request $request){
        if(!$request->ajax())return redirect('/');
        
         $presentaciones = Presentacion::where('condicion','=','1')
            ->select('id','nombre')->orderBy('nombre','asc')->get();

        return ['presentaciones'=>$presentaciones];
    }

  
    public function store(Request $request)
    {
        if(!$request->ajax())return redirect('/');
       $presentacion = new Presentacion();
       $presentacion->nombre=$request->nombre;
       $presentacion->descripcion=$request->descripcion;
       $presentacion->condicion='1';
       $presentacion->save();
    } 
 

    public function update(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $presentacion = Presentacion::findOrFail($request->id);
        $presentacion->nombre=$request->nombre;
        $presentacion->descripcion=$request->descripcion;
        $presentacion->condicion='1';
        $presentacion->save();
    }
   
    public function desactivar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $presentacion = Presentacion::findOrFail($request->id);        
        $presentacion->condicion='0';
        $presentacion->save();
        
    }
    public function activar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $presentacion = Presentacion::findOrFail($request->id);        
        $presentacion->condicion='1';
        $presentacion->save();
    }
}
