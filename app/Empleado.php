<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';
    protected $fillable =['id','nombre','tipo_documento','num_documento','direccion','telefono','email','sueldo','condicion'];
    public $timestamps =false;
    //relacion con tabla users
    public function user(){
        return $this->hasOne('App\User');
    }
}
