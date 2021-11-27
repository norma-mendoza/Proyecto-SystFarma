<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $fillable =[
        'id','codigo','nombre','usoTerapeutico','sustanciaActiva','precio_compra','precio_venta',
        'fechaVencimiento','stock','ubicacion','lote','idCategoria','idLaboratorio','idPresentacion',
        'idProveedor','igv_incluido','descuento','condicion'
    ];
    public $timestamps =false;
    //relacion con otros modelos

    public function categoria(){
        return $this->belongsTo('App\Categoria');
    }
    public function laboratorio(){
        return $this->belongsTo('App\Laboratorio');
    }
    public function presentacion(){
        return $this->belongsTo('App\Presentacion');
    }
    public function proveedor(){
        return $this->belongsTo('App\Proveedor');
    }
}
