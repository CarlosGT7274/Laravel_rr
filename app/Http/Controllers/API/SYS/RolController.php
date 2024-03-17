<?php

namespace App\Http\Controllers\API\SYS;

use App\Http\Controllers\Controller;
use App\Models\SYS\sys_permisos;
use App\Models\SYS\sys_roles;
use App\Models\SYS\sys_roles_permisos;
use Illuminate\Http\Request;

class RolController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Read all Rols on the data base.
     * 
     * @return array|string | min:1
     */
    public function readAll()
    {
        $user_rol = auth()->user()->id_rol;

        $roles = [];

        if ($user_rol <= 2) {
            $roles = sys_roles::where('id_rol', '>=', $user_rol)->get();
        } else {
            $roles = sys_roles::where('id_rol', $user_rol)->get();
        }

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $roles
        ], 200);
    }

    /**
     * Read a Specific User on the data base.
     * 
     * @param int $id
     * @return array|string | min:1
     */
    public function readOne($id)
    {
        $rol = sys_roles::find($id);

        if (empty($rol)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Rol Inexistente'
            ], 404);
        }

        $permisos = sys_roles_permisos::where('id_rol', $id)->get();

        $rol['permisos'] = $permisos;

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $rol
        ], 200);
    }

    /**
     * Create an User on the data base.
     * @param Request
     * @return boolean
     */
    public function create(Request $request)
    {

        $request->validate([
            'nombre' => 'required | string',
            'permisos' => 'required | array',
            'permisos.*.id_permiso' => 'required | integer | min:1 | exists:sys_permisos,id_permiso',
            'permisos.*.permiso' => 'required | integer | between:-1,15',
        ]);

        $rol = sys_roles::create([
            'nombre' => $request['nombre'],
        ]);

        $permisos = [];
        // dd($request['permisos']);
        foreach ($request['permisos'] as $permiso) {
            $permiso = sys_roles_permisos::create([
                'id_rol' => $rol->id_rol,
                'id_permiso' => $permiso['id_permiso'],
                'valor' => $permiso['permiso'],
            ]);

            array_push($permisos, $permiso);
        }

        $rol['permisos'] = $permisos;

        return response()->json([
            'error' => false,
            'mensaje' => 'Registro creado correctamente',
            'data' => $rol
        ], 201);
    }

    /**
     * Create an User on the data base.
     * @param int $id
     * @param Request
     * @return boolean
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'nombre' => 'sometimes | required | string',
            'permisos' => 'array',
            'permisos.*.id_permiso' => 'required | integer | min:0 | exists:sys_permisos,id_permiso',
            'permisos.*.permiso' => 'required | integer | between:-1,15',
        ]);

        $rol = sys_roles::find($id);

        if (!$rol) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Rol Inexistente'
            ], 404);
        }

        if ($request->filled('nombre')) {
            $rol->update($request->all());
        }

        if ($request->filled('permisos')) {
            foreach ($request->input('permisos') as $permiso) {

                if (empty(sys_permisos::find($permiso['id_permiso']))) {
                    return response()->json([
                        'error' => true,
                        'mensaje' => 'Algún Permiso es Inexistente'
                    ], 404);
                }

                sys_roles_permisos::where('id_rol', $id)
                    ->where('id_permiso', $permiso['id_permiso'])
                    ->update(['valor' => $permiso['permiso']]);
            }
        }

        return response()->json([
            'error' => false,
            'mensaje' => 'Registros actualizados correctamente',
            'data' => $rol
        ], 200);
    }

    /**
     * Delete a Specific User on the data base.
     * @param int $id
     * @return array | string | min:1
     */
    public function delete($id)
    {
        $rol = sys_roles::find($id);

        if (empty($rol)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Rol Inexistente'
            ], 404);
        }

        try {
            $attempt = sys_roles::destroy($id);
        } catch (\Throwable $th) {
            $attempt = false;
        }

        return response()->json([
            'error' => $attempt ? false : true,
            'mensaje' => $attempt ? 'Eliminado Correctamente' : 'No se puede borrar el rol, Porque esta asignado a un usuario'
        ], 200);
    }
}
