<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presentacion extends Model
{
    protected $table = 'presentacion';
    protected $fillable =['nombre','descripcion','condicion'];
    public function productos(){
        return $this->hasMany('App\Producto');
    }
}
