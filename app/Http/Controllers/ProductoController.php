<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $productos = Producto::join('categorias','productos.idCategoria','=','categorias.id')
                            ->join('laboratorios','productos.idLaboratorio','=','laboratorios.id')
                            ->join('presentacion','productos.idPresentacion','=','presentacion.id')
                            ->join('proveedores','productos.idProveedor','=','proveedores.id')
                            ->select('productos.id','productos.codigo','productos.nombre','productos.usoTerapeutico','productos.sustanciaActiva','productos.precio_compra as precioCompra','precio_venta',
                                    'productos.fechaVencimiento','productos.stock','productos.ubicacion','productos.lote','productos.idCategoria','categorias.nombre as categoria','productos.idLaboratorio','laboratorios.nombre as laboratorio',
                                    'productos.idpresentacion','presentacion.nombre as presentacion','productos.idProveedor','proveedores.nombre as proveedor','productos.igv_incluido as IgvIncluido','productos.descuento','productos.condicion')
                            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        else{
            $productos = Producto::join('categorias','productos.idCategoria','=','categorias.id')
                            ->join('laboratorios','productos.idLaboratorio','=','laboratorios.id')
                            ->join('presentacion','productos.idPresentacion','=','presentacion.id')
                            ->join('proveedores','productos.idProveedor','=','proveedores.id')
                            ->select('productos.id','productos.codigo','productos.nombre','productos.usoTerapeutico','productos.sustanciaActiva','productos.precio_compra as precioCompra','precio_venta',
                                    'productos.fechaVencimiento','productos.stock','productos.ubicacion','productos.lote','productos.idCategoria','categorias.nombre as categoria','productos.idLaboratorio','laboratorios.nombre as laboratorio',
                                    'productos.idpresentacion','presentacion.nombre as presentacion','productos.idProveedor','proveedores.nombre as proveedor','productos.igv_incluido as IgvIncluido','productos.descuento','productos.condicion')
            ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        return [
            'pagination' =>[
                'total'   =>$productos->total(),
                'current_page' => $productos->currentPage(),
                'per_page' => $productos->perPage(),
                'last_page' => $productos->lastPage(),
                'from'=> $productos->firstItem(),
                'to' => $productos->lastItem(),
        ],
        'productos' => $productos
        ];

        
    }

    public function listarProducto(Request $request)
    {
     if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $articulos = Producto::join('categorias','productos.idcategoria','=','categorias.id')
            ->select('productos.id','productos.idcategoria','productos.codigo','productos.nombre','categorias.nombre as nombre_categoria','productos.precio_venta','productos.stock','productos.condicion')
            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        else{
            $articulos = Producto::join('categorias','productos.idcategoria','=','categorias.id')
            ->select('productos.id','productos.idcategoria','productos.codigo','productos.nombre','categorias.nombre as nombre_categoria','productos.precio_venta','productos.stock','productos.condicion')
            ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        

        return ['articulos' => $articulos];
    }

    public function listarProductoVenta(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $productos = Producto::join('categorias','productos.idcategoria','=','categorias.id')
            ->select('productos.id','productos.idcategoria','productos.codigo','productos.nombre','categorias.nombre as nombre_categoria','productos.precio_venta','productos.stock','productos.condicion')
            ->where('productos.stock','>','0')
            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        else{
            $productos = Producto::join('categorias','productos.idcategoria','=','categorias.id')
            ->select('productos.id','productos.idcategoria','productos.codigo','productos.nombre','categorias.nombre as nombre_categoria','productos.precio_venta','productos.stock','productos.condicion')
            ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
            ->where('productos.stock','>','0')
            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        

        return ['productos' => $productos];
    }
    public function listarPdf(){
        $productos = Producto::join('categorias','productos.idCategoria','=','categorias.id')
        ->join('laboratorios','productos.idLaboratorio','=','laboratorios.id')
        ->join('presentacion','productos.idPresentacion','=','presentacion.id')
        ->join('proveedores','productos.idProveedor','=','proveedores.id')
        ->select('productos.id','productos.codigo','productos.nombre','productos.usoTerapeutico','productos.sustanciaActiva','productos.precio_compra as precioCompra','precio_venta',
                'productos.fechaVencimiento','productos.stock','productos.ubicacion','productos.lote','productos.idCategoria','categorias.nombre as categoria','productos.idLaboratorio','laboratorios.nombre as laboratorio',
                'productos.idpresentacion','presentacion.nombre as presentacion','productos.idProveedor','proveedores.nombre as proveedor','productos.igv_incluido as IgvIncluido','productos.descuento','productos.condicion')
        ->orderBy('productos.id', 'desc')->get();

        $cont=Producto::count();

        $pdf = \PDF::loadView('pdf.productospdf',['productos'=>$productos,'cont'=>$cont]);
        return $pdf->download('productos.pdf');
    }

    public function buscarProducto(Request $request){
        //busca el producto por codigo
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $productos = Producto::where('codigo','=', $filtro)
        ->select('id','nombre')->orderBy('nombre', 'asc')->take(1)->get();

        return ['articulos' => $productos];
    }

    public function buscarProductoVenta(Request $request){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $productos = Producto::where('codigo','=', $filtro)
        ->select('id','nombre','stock','precio_venta')
        ->where('stock','>','0')
        ->orderBy('nombre', 'asc')
        ->take(1)->get();

        return ['productos' => $productos];
    }
    
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $producto = new Producto();        
        $producto->codigo = $request->codigo;
        $producto->nombre = $request->nombre;
        $producto->usoTerapeutico = $request->usoTerapeutico;
        $producto->sustanciaActiva = $request->sustanciaActiva;
        $producto->precio_compra = $request->precio_compra;
        $producto->precio_venta = $request->precio_venta;       
        $producto->fechaVencimiento = $request->fechaVencimiento;
        $producto->stock = $request->stock;
        $producto->ubicacion = $request->ubicacion;
        $producto->lote = $request->lote;       
        $producto->idCategoria = $request->idCategoria;
        $producto->idLaboratorio = $request->idLaboratorio;
        $producto->idPresentacion = $request->idPresentacion;
        $producto->idProveedor = $request->idProveedor;
        $producto->igv_incluido = $request->igv_incluido;
        $producto->descuento = $request->descuento;
        $producto->condicion = '1';
        $producto->save();
    }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $producto = Producto::findOrFail($request->id);            
        $producto->codigo = $request->codigo;
        $producto->nombre = $request->nombre;
        $producto->usoTerapeutico = $request->usoTerapeutico;
        $producto->sustanciaActiva = $request->sustanciaActiva;
        $producto->precio_compra = $request->precio_compra;
        $producto->precio_venta = $request->precio_venta;       
        $producto->fechaVencimiento = $request->fechaVencimiento;
        $producto->stock = $request->stock;
        $producto->ubicacion = $request->ubicacion;
        $producto->lote = $request->lote;       
        $producto->idCategoria = $request->idCategoria;
        $producto->idLaboratorio = $request->idLaboratorio;
        $producto->idPresentacion = $request->idPresentacion;
        $producto->idProveedor = $request->idProveedor;
        $producto->igv_incluido = $request->igv_incluido;
        $producto->descuento = $request->descuento;
        $producto->condicion = '1';
        $producto->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $producto = Producto::findOrFail($request->id);
        $producto->condicion = '0';
        $producto->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $producto = Producto::findOrFail($request->id);
        $producto->condicion = '1';
        $producto->save();
    }
}
