<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Laboratorio extends Model
{
    protected $table = 'laboratorios';
    protected $fillable =['nombre','descripcion','condicion'];
    public function productos(){
        return $this->hasMany('App\Producto');
    }
}
