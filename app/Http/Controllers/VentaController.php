<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Ventas;
use App\DetalleVenta;
use App\User;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $ventas = Ventas::join('clientes', 'ventas.idcliente', '=', 'clientes.id')
                ->join('users', 'ventas.idusuario', '=', 'users.id')
                ->select(
                    'ventas.id',
                    'ventas.tipo_comprobante',
                    'ventas.serie_comprobante',
                    'ventas.num_comprobante',
                    'ventas.fecha_hora',
                    'ventas.impuesto',
                    'ventas.subTotal',
                    'ventas.Igv',
                    'ventas.total',
                    'ventas.estado',
                    'clientes.nombre',
                    'users.usuario'
                )
                ->orderBy('ventas.id', 'desc')->paginate(6);
        } else {
            $ventas = Ventas::join('clientes', 'ventas.idcliente', '=', 'clientes.id')
                ->join('users', 'ventas.idusuario', '=', 'users.id')
                ->select(
                    'ventas.id',
                    'ventas.tipo_comprobante',
                    'ventas.serie_comprobante',
                    'ventas.num_comprobante',
                    'ventas.fecha_hora',
                    'ventas.impuesto',
                    'ventas.subTotal',
                    'ventas.Igv',
                    'ventas.total',
                    'ventas.estado',
                    'clientes.nombre',
                    'users.usuario'
                )
                ->where('ventas.' . $criterio, 'like', '%' . $buscar . '%')->orderBy('ventas.id', 'desc')->paginate(6);
        }

        return [
            'pagination' => [
                'total'        => $ventas->total(),
                'current_page' => $ventas->currentPage(),
                'per_page'     => $ventas->perPage(),
                'last_page'    => $ventas->lastPage(),
                'from'         => $ventas->firstItem(),
                'to'           => $ventas->lastItem(),
            ],
            'ventas' => $ventas
        ];
    }
    public function obtenerCabecera(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $venta = Ventas::join('clientes', 'ventas.idcliente', '=', 'clientes.id')
            ->join('users', 'ventas.idusuario', '=', 'users.id')
            ->select(
                'ventas.id',
                'ventas.tipo_comprobante',
                'ventas.serie_comprobante',
                'ventas.num_comprobante',
                'ventas.fecha_hora',
                'ventas.impuesto',
                'ventas.total',
                'ventas.estado',
                'clientes.nombre',
                'users.usuario'
            )
            ->where('ventas.id', '=', $id)
            ->orderBy('ventas.id', 'desc')->take(1)->get();

        return ['venta' => $venta];
    }
    public function obtenerDetalles(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $detalles = DetalleVenta::join('productos', 'detalle_ventas.idproducto', '=', 'productos.id')
            ->select('detalle_ventas.cantidad', 'detalle_ventas.precio', 'productos.nombre as articulo', 'detalle_ventas.descuento')
            ->where('detalle_ventas.idventa', '=', $id)
            ->orderBy('detalle_ventas.id', 'desc')->get();

        return ['detalles' => $detalles];
    }
    public function pdf(Request $request,$id){
        $venta = Ventas::join('clientes','ventas.idcliente','=','clientes.id')
        ->join('users','ventas.idusuario','=','users.id')
        ->select('ventas.id','ventas.tipo_comprobante','ventas.serie_comprobante',
        'ventas.num_comprobante','ventas.created_at','ventas.impuesto','ventas.total',
        'ventas.estado','clientes.nombre','clientes.tipo_documento','clientes.num_documento',
        'clientes.direccion','clientes.email',
        'clientes.telefono','users.usuario')
        ->where('ventas.id','=',$id)
        ->orderBy('ventas.id','desc')->take(1)->get();

        $detalles = DetalleVenta::join('productos','detalle_ventas.idproducto','=','productos.id')
        ->select('detalle_ventas.cantidad','detalle_ventas.precio','detalle_ventas.descuento',
        'productos.nombre as articulo')
        ->where('detalle_ventas.idventa','=',$id)
        ->orderBy('detalle_ventas.id','desc')->get();

        $numventa=Ventas::select('num_comprobante')->where('id',$id)->get();

        $pdf = \PDF::loadView('pdf.ventaTicket',['venta'=>$venta,'detalles'=>$detalles]);
       //$pdf ->setPaper('a4','portrait');
       $pdf->setPaper( [0, 0, 220.732,  841.89]); 
      // $pdf->setPaper( array(0,0,612.00,1008.0)); 
        
        return $pdf->download('venta-'.$numventa[0]->num_comprobante.'.pdf');
       
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try {
            DB::beginTransaction();

            $mytime = Carbon::now('America/Lima');

            $venta = new Ventas();
            $venta->idcliente = $request->idcliente;
            //$venta->idusuario = Auth::user()->id;
            $venta->idusuario = '1';
            $venta->tipo_comprobante = $request->tipo_comprobante;
            $venta->serie_comprobante = $request->serie_comprobante;
            $venta->num_comprobante = $request->num_comprobante;
            $venta->fecha_hora = $mytime->toDateString();
            $venta->impuesto = $request->impuesto;
            $venta->subTotal = $request->subTotal;
            $venta->Igv = $request->Igv;
            $venta->total = $request->total;
            $venta->estado = 'Registrado';
            $venta->save();

            $detalles = $request->data; //Array de detalles
            //Recorro todos los elementos

            foreach ($detalles as $ep => $det) {
                $detalle = new DetalleVenta();
                $detalle->idventa = $venta->id;
                $detalle->idproducto = $det['idarticulo'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio = $det['precio'];
                $detalle->descuento = $det['descuento'];
                $detalle->save();
            }

            DB::commit();
             //manda el id del ultimo ventas
             return [
                'id' => $venta->id
            ];
            
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $ventas = Ventas::findOrFail($request->id);
        $ventas->estado = 'Anulado';
        $ventas->save();
    }
}
