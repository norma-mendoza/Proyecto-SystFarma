<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware'=>['guest']],function(){
    Route::get('/','Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
    
});
Route::group(['middleware'=>['auth']],function(){
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/dashboard','DashboardController');
   // Route::post('/notification/get','NotificationController@get');

    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');

    //ALMACENERO
    Route::group(['middleware' => ['Almacenero']], function () {
        //ruta Categorias
        Route::get('/categoria', 'CategoriaController@index');
        Route::post('/categoria/registrar', 'CategoriaController@store');
        Route::put('/categoria/actualizar', 'CategoriaController@update');
        Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
        Route::put('/categoria/activar', 'CategoriaController@activar');
        Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');
        
        //ruta presentacion
        
        Route::get('/presentacion', 'PresentacionController@index');
        Route::post('/presentacion/registrar', 'PresentacionController@store');
        Route::put('/presentacion/actualizar', 'PresentacionController@update');
        Route::put('/presentacion/desactivar', 'PresentacionController@desactivar');
        Route::put('/presentacion/activar', 'PresentacionController@activar');
        Route::get('/presentacion/selectPresentacion', 'PresentacionController@selectPresentacion');
        
        //ruta laboratorio
        
        Route::get('/laboratorio', 'LaboratorioController@index');
        Route::post('/laboratorio/registrar', 'LaboratorioController@store');
        Route::put('/laboratorio/actualizar', 'LaboratorioController@update');
        Route::put('/laboratorio/desactivar', 'LaboratorioController@desactivar');
        Route::put('/laboratorio/activar', 'LaboratorioController@activar');
        Route::get('/laboratorio/selectLaboratorio', 'LaboratorioController@selectLaboratorio');
        //proveedores
        
        Route::get('/proveedor', 'ProveedorController@index');
        Route::post('/proveedor/registrar', 'ProveedorController@store');
        Route::put('/proveedor/actualizar', 'ProveedorController@update');
        Route::put('/proveedor/desactivar', 'ProveedorController@desactivar');
        Route::put('/proveedor/activar', 'ProveedorController@activar');
        Route::get('/proveedor/selectProveedor', 'ProveedorController@selectProveedor');
        //Productos
        Route::get('/producto', 'ProductoController@index');
        Route::post('/producto/registrar', 'ProductoController@store');
        Route::put('/producto/actualizar', 'ProductoController@update');
        Route::put('/producto/desactivar', 'ProductoController@desactivar');
        Route::put('/producto/activar', 'ProductoController@activar');
        Route::get('/producto/listarPdf', 'ProductoController@listarPdf')->name('productos_pdf');
        Route::get('/producto/listarProducto', 'ProductoController@listarProducto');
        Route::get('/producto/buscarProducto', 'ProductoController@buscarProducto');
        Route::get('/producto/buscarProductoVenta', 'ProductoController@buscarProductoVenta');
        Route::get('/producto/listarProductoVenta', 'ProductoController@listarProductoVenta');
        //compra
        Route::get('/ingreso', 'IngresoController@index');
        Route::post('/ingreso/registrar', 'IngresoController@store');        
        Route::put('/ingreso/desactivar', 'IngresoController@desactivar');
        Route::get('/ingreso/obtenerCabecera', 'IngresoController@obtenerCabecera');
        Route::get('/ingreso/obtenerDetalles', 'IngresoController@obtenerDetalles');
        

    });

    //ALMACENERO
    Route::group(['middleware' => ['Vendedor']], function () {
         //clientes
        Route::get('/cliente', 'ClienteController@index');
        Route::post('/cliente/registrar', 'ClienteController@store');
        Route::put('/cliente/actualizar', 'ClienteController@update');
        Route::put('/cliente/desactivar', 'ClienteController@desactivar');
        Route::put('/cliente/activar', 'ClienteController@activar');
        Route::get('/cliente/selectCliente', 'ClienteController@selectCliente');
        Route::get('/cliente/listarPdf', 'ClienteController@listarPdf')->name('clientes_pdf');
            //venta
        Route::get('/venta', 'VentaController@index');
        Route::post('/venta/registrar', 'VentaController@store');        
        Route::put('/venta/desactivar', 'VentaController@desactivar');
        Route::get('/venta/obtenerCabecera', 'VentaController@obtenerCabecera');
        Route::get('/venta/obtenerDetalles', 'VentaController@obtenerDetalles');
        Route::get('/venta/pdf/{id}', 'VentaController@pdf')->name('venta_pdf');//para reportes de comprobante
        //listar produc para la venta
        Route::get('/producto/listarProducto', 'ProductoController@listarProducto');
        Route::get('/producto/buscarProducto', 'ProductoController@buscarProducto');
        Route::get('/producto/buscarProductoVenta', 'ProductoController@buscarProductoVenta');
        Route::get('/producto/listarProductoVenta', 'ProductoController@listarProductoVenta');
        

    });
      //ADMINISTRADOR      
        Route::group(['middleware' => ['Administrador']], function () {
          //ruta Categorias
        Route::get('/categoria', 'CategoriaController@index');
        Route::post('/categoria/registrar', 'CategoriaController@store');
        Route::put('/categoria/actualizar', 'CategoriaController@update');
        Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
        Route::put('/categoria/activar', 'CategoriaController@activar');
        Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');
        
        //ruta presentacion
        
        Route::get('/presentacion', 'PresentacionController@index');
        Route::post('/presentacion/registrar', 'PresentacionController@store');
        Route::put('/presentacion/actualizar', 'PresentacionController@update');
        Route::put('/presentacion/desactivar', 'PresentacionController@desactivar');
        Route::put('/presentacion/activar', 'PresentacionController@activar');
        Route::get('/presentacion/selectPresentacion', 'PresentacionController@selectPresentacion');
        
        //ruta laboratorio
        
        Route::get('/laboratorio', 'LaboratorioController@index');
        Route::post('/laboratorio/registrar', 'LaboratorioController@store');
        Route::put('/laboratorio/actualizar', 'LaboratorioController@update');
        Route::put('/laboratorio/desactivar', 'LaboratorioController@desactivar');
        Route::put('/laboratorio/activar', 'LaboratorioController@activar');
        Route::get('/laboratorio/selectLaboratorio', 'LaboratorioController@selectLaboratorio');
        
        //proveedores
        
        Route::get('/proveedor', 'ProveedorController@index');
        Route::post('/proveedor/registrar', 'ProveedorController@store');
        Route::put('/proveedor/actualizar', 'ProveedorController@update');
        Route::put('/proveedor/desactivar', 'ProveedorController@desactivar');
        Route::put('/proveedor/activar', 'ProveedorController@activar');
        Route::get('/proveedor/selectProveedor', 'ProveedorController@selectProveedor');
        
        //empleado
        
        Route::get('/empleado', 'EmpleadoController@index');
        Route::post('/empleado/registrar', 'EmpleadoController@store');
        Route::put('/empleado/actualizar', 'EmpleadoController@update');
        Route::put('/empleado/desactivar', 'EmpleadoController@desactivar');
        Route::put('/empleado/activar', 'EmpleadoController@activar');
        
        
        //clientes
        Route::get('/cliente', 'ClienteController@index');
        Route::post('/cliente/registrar', 'ClienteController@store');
        Route::put('/cliente/actualizar', 'ClienteController@update');
        Route::put('/cliente/desactivar', 'ClienteController@desactivar');
        Route::put('/cliente/activar', 'ClienteController@activar');
        Route::get('/cliente/selectCliente', 'ClienteController@selectCliente');
        Route::get('/cliente/listarPdf', 'ClienteController@listarPdf')->name('clientes_pdf');
        //Productos
        Route::get('/producto', 'ProductoController@index');
        Route::post('/producto/registrar', 'ProductoController@store');
        Route::put('/producto/actualizar', 'ProductoController@update');
        Route::put('/producto/desactivar', 'ProductoController@desactivar');
        Route::put('/producto/activar', 'ProductoController@activar');
        Route::get('/producto/listarPdf', 'ProductoController@listarPdf')->name('productos_pdf');
        Route::get('/producto/listarProducto', 'ProductoController@listarProducto');
        Route::get('/producto/buscarProducto', 'ProductoController@buscarProducto');
        Route::get('/producto/buscarProductoVenta', 'ProductoController@buscarProductoVenta');
        Route::get('/producto/listarProductoVenta', 'ProductoController@listarProductoVenta');
        
        //roles
        Route::get('/rol', 'RolController@index');
        Route::get('/rol/selectRol', 'RolController@selectRol');
        
        //user
        Route::get('/user', 'UserController@index');
        Route::post('/user/registrar', 'UserController@store');
        Route::put('/user/actualizar', 'UserController@update');
        Route::put('/user/desactivar', 'UserController@desactivar');
        Route::put('/user/activar', 'UserController@activar');
        
        //compra
        Route::get('/ingreso', 'IngresoController@index');
        Route::post('/ingreso/registrar', 'IngresoController@store');        
        Route::put('/ingreso/desactivar', 'IngresoController@desactivar');
        Route::get('/ingreso/obtenerCabecera', 'IngresoController@obtenerCabecera');
        Route::get('/ingreso/obtenerDetalles', 'IngresoController@obtenerDetalles');
        
        //venta
        Route::get('/venta', 'VentaController@index');
        Route::post('/venta/registrar', 'VentaController@store');        
        Route::put('/venta/desactivar', 'VentaController@desactivar');
        Route::get('/venta/obtenerCabecera', 'VentaController@obtenerCabecera');
        Route::get('/venta/obtenerDetalles', 'VentaController@obtenerDetalles');
        Route::get('/venta/pdf/{id}', 'VentaController@pdf')->name('venta_pdf');//para reportes de comprobante
        

      });
    
    
});



//Auth::routes();


//Route::get('/home', 'HomeController@index')->name('home');