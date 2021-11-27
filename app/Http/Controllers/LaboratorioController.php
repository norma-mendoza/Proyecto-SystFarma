<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Laboratorio;
class LaboratorioController extends Controller
{
    public function index(Request $request)
    {
        //if(!$request->ajax())return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $laboratorios = Laboratorio::orderBy('id','desc')->paginate(6);//elocuen           
        }
        else{
           $laboratorios = Laboratorio::where($criterio, 'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(3);
        }
        //$laboratorios =DB::table('categorias')->paginate(6);//generador de paginacio
        
        return [
            'pagination' =>[
                'total'   =>$laboratorios->total(),
                'current_page' => $laboratorios->currentPage(),
                'per_page' => $laboratorios->perPage(),
                'last_page' => $laboratorios->lastPage(),
                'from'=> $laboratorios->firstItem(),
                'to' => $laboratorios->lastItem(),
        ],
        'laboratorios' => $laboratorios
        ];
    }

  
    public function store(Request $request)
    {
        if(!$request->ajax())return redirect('/');
       $laboratorio = new Laboratorio();
       $laboratorio->nombre=$request->nombre;
       $laboratorio->descripcion=$request->descripcion;
       $laboratorio->condicion='1';
       $laboratorio->save();
    } 
    //funcion para cargar laboratorios para mantenimiento de formulario articulo
    public function selectLaboratorio(Request $request){
        if(!$request->ajax())return redirect('/');
        
         $laboratorios = Laboratorio::where('condicion','=','1')
            ->select('id','nombre')->orderBy('nombre','asc')->get();

        return ['laboratorios'=>$laboratorios];
    }
 

    public function update(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $laboratorio = Laboratorio::findOrFail($request->id);
        $laboratorio->nombre=$request->nombre;
        $laboratorio->descripcion=$request->descripcion;
        $laboratorio->condicion='1';
        $laboratorio->save();
    }
   
    public function desactivar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $laboratorio = Laboratorio::findOrFail($request->id);        
        $laboratorio->condicion='0';
        $laboratorio->save();
        
    }
    public function activar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $laboratorio = Laboratorio::findOrFail($request->id);        
        $laboratorio->condicion='1';
        $laboratorio->save();
    }
}
