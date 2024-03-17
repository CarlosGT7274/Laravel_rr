<?php

namespace App\Http\Controllers\API\SYS;

use App\Http\Controllers\Controller;
use App\Mail\NotificationMail;
use App\Models\SYS\sys_grupos;
use App\Models\SYS\sys_notificaciones;
use App\Models\SYS\sys_usuarios;
use App\Models\SYS\sys_usuarios_grupos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class GruposController extends Controller
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
     * Read All Groups on the data base.
     * 
     * @return array|string
     */
    public function readAll()
    {
        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => sys_grupos::all()
        ], 200);
    }

    /**
     * Read os Group on the data base.
     * 
     * @param int $id
     * @return array|string
     */
    public function readOne($id)
    {
        $grupo = sys_grupos::find($id);

        if (empty($grupo)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Grupo Inexistente'
            ], 404);
        }

        $usuarios = [];

        foreach (sys_usuarios_grupos::where('id_grupo', $id)->select('id_usuario')->get() as $usuario) {
            array_push($usuarios, $usuario['id_usuario']);
        }

        $grupo['usuarios'] = $usuarios;

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $grupo
        ], 200);
    }

    /**
     * Creates a groups with an arrayof users id on the data base.
     * 
     * @param int $id
     * @param Request $request
     * @return array|string
     */
    public function create(Request $request)
    {
        $request->validate([
            'nombre' => 'required | string',
            'telefono' => 'string | regex:/^\d{10}$/ | required_without:email',
            'email' => 'string | email | required_without:telefono',
            'usuarios' => 'array',
            'usuarios.*' => 'integer | min:1 | exists:sys_usuarios,id_usuario'
        ]);

        $usuarios = [];

        if ($request->filled('usuarios')) {
            $usuarios = $request->usuarios;
            unset($request->usuarios);
        }

        $grupo = sys_grupos::create($request->all());

        foreach ($usuarios as $id_usuario) {
            if (!empty(sys_usuarios::find($id_usuario))) {
                sys_usuarios_grupos::create([
                    'id_grupo' => $grupo->id_grupo,
                    'id_usuario' => $id_usuario,
                ]);
            }
        }

        $grupo['usuarios'] = $usuarios;

        return response()->json([
            'error' => false,
            'mensaje' => 'Registros creados correctamente',
            'data' => $grupo
        ], 201);
    }

    /**
     * Update a Group on the data base.
     * 
     * @param int $id
     * @param Request $request
     * @return array|string
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'nombre' => 'sometimes | required | string',
            'email' => 'sometimes | required | string | email | required_without:telefono',
            'telefono' => 'sometimes | required | string | regex:/^\d{10}$/ | required_without:emial',
            'usuarios' => 'array ',
            'usuarios.*' => 'integer | min:1 | exists:sys_usuarios,id_usuario'
        ]);

        $grupo = sys_grupos::find($id);

        if (empty($grupo)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Grupo Inexistente'
            ], 404);
        }

        $usuarios = [];

        if ($request->filled('usuarios')) {
            $usuarios = $request->usuarios;
            unset($request->usuarios);
        }

        $grupo->update($request->all());

        foreach ($usuarios as $id_usuario) {
            if (sys_usuarios::find($id_usuario)) {
                sys_usuarios_grupos::create([
                    'id_grupo' => $id,
                    'id_usuario' => $id_usuario,
                ]);
            }
        }

        return response()->json([
            'error' => false,
            'mensaje' => 'Registros actualizado correctamente'
        ], 200);
    }

    /**
     * Delete a Group on the data base.
     * 
     * @param int $id
     * @return array|string
     */
    public function delete($id)
    {
        $group = sys_grupos::find($id);

        if (empty($group)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Grupo Inexistente'
            ], 404);
        }

        $attempt = [];
        try {
            $attempt = sys_grupos::destroy($id);
        } catch (\Throwable $th) {
            $attempt = false;
        }

        return response()->json([
            'error' => $attempt ? false : true,
            'mensaje' => $attempt ? 'Eliminado Correctamente' : 'No se puede borrar el grupo'
        ], 200);
    }

    /**
     * Add an User to a Group.
     * 
     * @param int $id
     * @param Request $request
     * @return array|string
     */
    public function addUser($id, Request $request)
    {
        $group = sys_grupos::find($id);

        if (empty($group)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Grupo Inexistente'
            ], 404);
        }

        $request->validate([
            'id_usuario' => 'required | integer | min:1 | exists:sys_usuarios,id_usuario'
        ]);

        sys_usuarios_grupos::create([
            'id_grupo' => $id,
            'id_usuario' => $request->id_usuario,
        ]);

        return response()->json([
            'error' => false,
            'mensaje' => 'Usuario añadido correctamente',
        ], 201);
    }

    /**
     * Remove an User to a Group.
     * 
     * @param int $id
     * @param Request $request
     * @return array|string
     */
    public function removeUser($id, Request $request)
    {
        $group = sys_grupos::find($id);

        if (empty($group)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Grupo Inexistente'
            ], 404);
        }

        $request->validate([
            'id_usuario' => 'required | integer | min:1 | exists:sys_usuarios,id_usuario'
        ]);

        sys_usuarios_grupos::where('id_grupo', $id)->firstWere('id_usuario', $request->id_usuario)->delete();

        return response()->json([
            'error' => false,
            'mensaje' => 'Usuario eliminado correctamente',
        ], 200);
    }

    /**
     * Create a Message on the data base.
     * 
     * @param int $id_group
     * @param Request $request
     * @return array|string
     */
    public function create_msg($id_group, Request $request)
    {
        $group = sys_grupos::find($id_group);

        if (empty($group)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Grupo Inexistente'
            ], 404);
        }

        $request->validate([
            'id_usuario' => 'integer | min:1',
            'mensaje' => 'required | string',
        ]);

        $request['id_grupo'] = $id_group;

        return response()->json([
            'error' => false,
            'mensaje' => 'Mensaje Creado',
            'data' => sys_notificaciones::create($request->all())
        ], 200);
    }

    /**
     * Refresh a Message on the data base.
     * 
     * @param int $id
     * @param Request $request
     * @return array|string
     */
    public function refresh_msg($id, Request $request)
    {
        $notification = sys_notificaciones::find($id);

        if (empty($notification)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Notificacion Inexistente'
            ], 404);
        }

        $request->validate([
            'mensaje' => 'required | string',
        ]);

        $notification->update($request->all());

        return response()->json([
            'error' => false,
            'mensaje' => 'Mensaje Actualizado'
        ], 200);
    }

    /**
     * Send a message of the data base.
     * 
     * @param int $id_group
     * @param int $id
     * @param Request $request
     * @return array|string
     */
    public function send_msg($id_group, $id, Request $request)
    {
        $group = sys_grupos::find($id_group);

        if (empty($group)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Notificacion Inexistente'
            ], 404);
        }

        $notification = sys_notificaciones::find($id);

        if (empty($notification)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Notificacion Inexistente'
            ], 404);
        }

        $request->validate([
            'metodo' => 'required | integer | min:1',
        ]);

        //TODO: Metodos de envio
        // if($request->metodo == 1 || $request->metodo == 3){
        //     Mail::to($group['email'])->send(new NotificationMail($notification, $group));
        // }
        // if($request->metodo >= 2){

        // }

        $notification->update([
            'publicacion' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
            'error' => false,
            'mensaje' => 'Mensaje Enviado'
        ], 200);
    }
}
