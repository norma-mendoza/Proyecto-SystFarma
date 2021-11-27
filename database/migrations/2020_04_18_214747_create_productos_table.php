<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id');            
            $table->string('codigo',50)->nullable();
            $table->string('nombre',200)->unique();
            $table->string('usoTerapeutico',100)->nullable();
            $table->string('sustanciaActiva',100)->nullable();
            $table->decimal('precio_compra',11,2);
            $table->decimal('precio_venta',11,2);
            $table->dateTime('fechaVencimiento');
            $table->integer('stock');
            $table->string('ubicacion',200)->nullable();
            $table->string('lote',50);
            
            $table->integer('idCategoria')->unsigned();
            $table->integer('idLaboratorio')->unsigned();
            $table->integer('idPresentacion')->unsigned();
            $table->integer('idProveedor')->unsigned();
            $table->string('igv_incluido')->nullable();            
            $table->string('descuento')->nullable();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
           //relaciones
            $table->foreign('idCategoria')->references('id')->on('categorias');
            $table->foreign('idLaboratorio')->references('id')->on('laboratorios');
            $table->foreign('idPresentacion')->references('id')->on('presentacion');
            $table->foreign('idProveedor')->references('id')->on('proveedores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
