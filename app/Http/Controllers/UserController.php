<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Empleado;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $empleados = User::join('empleados', 'users.id', '=', 'empleados.id')
                ->join('roles', 'users.idrol', '=', 'roles.id')
                ->select(
                    'empleados.id',
                    'empleados.nombre',
                    'empleados.tipo_documento',
                    'empleados.num_documento',
                    'empleados.direccion',
                    'empleados.telefono',
                    'empleados.email',
                    'empleados.sueldo',
                    'users.usuario',
                    'users.password',
                    'users.condicion',
                    'users.idrol',
                    'roles.nombre as rol'
                )
                ->orderBy('empleados.id', 'desc')->paginate(6);
        } else {
            $empleados = User::join('empleados', 'users.id', '=', 'empleados.id')
                ->join('roles', 'users.idrol', '=', 'roles.id')
                ->select(
                    'empleados.id',
                    'empleados.nombre',
                    'empleados.tipo_documento',
                    'empleados.num_documento',
                    'empleados.direccion',
                    'empleados.telefono',
                    'empleados.email',
                    'empleados.sueldo',
                    'users.usuario',
                    'users.password',
                    'users.condicion',
                    'users.idrol',
                    'roles.nombre as rol'
                )
                ->where('empleados.' . $criterio, 'like', '%' . $buscar . '%')
                ->orderBy('empleados.id', 'desc')->paginate(6);
        }

        return [
            'pagination' => [
                'total'        => $empleados->total(),
                'current_page' => $empleados->currentPage(),
                'per_page'     => $empleados->perPage(),
                'last_page'    => $empleados->lastPage(),
                'from'         => $empleados->firstItem(),
                'to'           => $empleados->lastItem(),
            ],
            'empleados' => $empleados
        ];
    }
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try {
            DB::beginTransaction();
            $empleado = new Empleado();
            $empleado->nombre = $request->nombre;
            $empleado->tipo_documento = $request->tipo_documento;
            $empleado->num_documento = $request->num_documento;
            $empleado->direccion = $request->direccion;
            $empleado->telefono = $request->telefono;
            $empleado->email = $request->email;
            $empleado->sueldo = $request->sueldo;
            $empleado->save();

            $user = new User();
            $user->usuario = $request->usuario;
            $user->password = bcrypt($request->password);
            $user->condicion = '1';
            $user->idrol = $request->idrol;

            $user->id = $empleado->id;

            $user->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try {
            DB::beginTransaction();

            //Buscar primero el proveedor a modificar
            $user = User::findOrFail($request->id);

            $empleado = Empleado::findOrFail($user->id);

            $empleado->nombre = $request->nombre;
            $empleado->tipo_documento = $request->tipo_documento;
            $empleado->num_documento = $request->num_documento;
            $empleado->direccion = $request->direccion;
            $empleado->telefono = $request->telefono;
            $empleado->email = $request->email;
            $empleado->sueldo = $request->sueldo;
            $empleado->save();


            $user->usuario = $request->usuario;
            $user->password = bcrypt($request->password);
            $user->condicion = '1';
            $user->idrol = $request->idrol;
            $user->save();


            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '0';
        $user->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '1';
        $user->save();
    }
}