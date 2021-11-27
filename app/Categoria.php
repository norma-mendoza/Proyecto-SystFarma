<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable =['nombre','descripcion','condicion'];
    //relacion de modelo productos
    public function productos(){
        return $this->hasMany('App\Producto');
    }
}
