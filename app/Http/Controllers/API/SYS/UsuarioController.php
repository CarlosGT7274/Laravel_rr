<?php

namespace App\Http\Controllers\API\SYS;

use App\Http\Controllers\Controller;
use App\Models\Sys\sys_roles;
use App\Models\Sys\sys_usuarios;
use App\Models\SYS\sys_usuarios_empresas;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
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
     * Read All Users on the data base.
     * 
     * @return array|string
     */
    public function readAll()
    {
        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => sys_usuarios::all()
        ], 200);
    }

    /**
     * Read a Specific User on the data base.
     * 
     * @param int $id
     * @return array|string
     */
    public function readOne($id)
    {
        $user = sys_usuarios::find($id);

        if (empty($user)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'No se encontro el usuario'
            ], 404);
        }

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $user
        ], 200);
    }

    /**
     * Create an User on the data base.
     * 
     * @param Request
     * @return boolean
     */
    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required | string | email',
            'password' => 'required | string',
            'nombre' => 'required | string',
            'apellidoP' => 'required | string',
            'apellidoM' => 'required | string',
            'id_rol' => 'required | integer | min:1 | exists:sys_roles,id_rol',
            'id_empresa' => ['integer', 'min:1', 'exists:hr_empresas,id_empresa', Rule::requiredIf($request->id_rol > 1)]
        ]);

        $id_empresa = $request->id_empresa;

        if ($id_empresa) {
            unset($request['id_empresa']);
        }

        $rol = sys_roles::find($request['id_rol']);

        if (empty($rol)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Rol Inexistente'
            ], 404);
        }

        $request['password'] = Hash::make($request['password']);

        $user = sys_usuarios::create($request->all());

        if (!empty($id_empresa)) {
            sys_usuarios_empresas::create([
                'id_usuario' => $user->id_usuario,
                'id_empresa' => $id_empresa
            ]);
        }

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $user
        ], 201);
    }

    /**
     * Create an User on the data base.
     * 
     * @param int $id
     * @param Request
     * @return boolean
     */
    public function update($id, Request $request)
    {
        $user = sys_usuarios::find($id);

        if (empty($user)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Usuario Inexistente'
            ], 404);
        }

        $request->validate([
            'email' => 'sometimes | required | string | email',
            'nombre' => 'sometimes | required | string',
            'apellidoP' => 'sometimes | required | string',
            'apellidoM' => 'sometimes | required | string',
            'id_rol' => 'integer | min:1 | exists:sys_roles,id_rol',
        ]);

        if ($request->password) {
            unset($request->password);
        }

        if ($request->filled('id_rol')) {
            $rol = sys_roles::find($request['id_rol']);

            if (empty($rol)) {
                return response()->json([
                    'error' => true,
                    'mensaje' => 'Rol Inexistente'
                ], 404);
            }
        }

        $success = $user->update($request->all());

        return response()->json([
            'error' => $success ? false : true,
            'mensaje' => $success ? 'Cambios Realizados' : 'Ocurrio un error'
        ], $success ? 200 : 400);
    }

    /**
     * Delete a Specific User on the data base.
     * 
     * @param int $id
     * @return array|string
     */
    public function delete($id)
    {
        $user = sys_usuarios::find($id);

        if (empty($user)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Usuario Inexistente'
            ], 404);
        }

        try {
            $attempt = sys_usuarios::destroy($id);
        } catch (\Throwable $th) {
            $attempt = false;
        }

        return response()->json([
            'error' => $attempt ? false : true,
            'mensaje' => $attempt ? 'Eliminado Correctamente' : 'No se puede borrar el Usuario'
        ], 200);
    }
}
