<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleado;
class EmpleadoController extends Controller
{
    public function index(Request $request)
    {
       // if(!$request->ajax())return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $empleados = Empleado::orderBy('id','desc')->paginate(6);
        }
        else{
            $empleados = Empleado::where($criterio, 'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(6);//elocuen
        }
        //$personas =DB::table('categorias')->paginate(6);//generador de paginacio
        
        return [
            'pagination' =>[
                'total'   =>$empleados->total(),
                'current_page' => $empleados->currentPage(),
                'per_page' => $empleados->perPage(),
                'last_page' => $empleados->lastPage(),
                'from'=> $empleados->firstItem(),
                'to' => $empleados->lastItem(),
        ],
        'empleados' => $empleados
        ];
        //return $personas;
    }
     //funcion para cargar proveedor para mantenimiento de formulario articulo
    

    public function store(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $empleado = new Empleado();
        $empleado->nombre=$request->nombre;
        $empleado->tipo_documento=$request->tipo_documento;
        $empleado->num_documento=$request->num_documento;
        $empleado->direccion=$request->direccion;
        $empleado->telefono=$request->telefono;
        $empleado->email=$request->email;
        $empleado->email=$request->email;
        $empleado->sueldo = $request->sueldo;
        $empleado->condicion='1';        
        $empleado->save();
        

    }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empleado = Empleado::findOrFail($request->id);
        $empleado->nombre = $request->nombre;
        $empleado->tipo_documento = $request->tipo_documento;
        $empleado->num_documento = $request->num_documento;
        $empleado->direccion = $request->direccion;
        $empleado->telefono = $request->telefono;
        $empleado->email = $request->email;
        $empleado->sueldo = $request->sueldo;
        $empleado->condicion='1';
        $empleado->save();

        
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $empleado = Empleado::findOrFail($request->id);        
        $empleado->condicion='0';
        $empleado->save();
        
    }
    public function activar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $empleado = Empleado::findOrFail($request->id);        
        $empleado->condicion='1';
        $empleado->save();
    }
    
}