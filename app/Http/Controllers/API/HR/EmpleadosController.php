<?php

namespace App\Http\Controllers\API\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\Company\Employment\hr_historial;
use App\Models\HR\Company\General\hr_capacitaciones_empleados;
use App\Models\HR\Employee\General\hr_empleados;
use App\Models\HR\Employee\General\hr_vacaciones;
use App\Models\HR\Employee\Incidencies\hr_faltas;
use App\Models\HR\Employee\Incidencies\hr_incidencias;
use App\Models\HR\Employee\Incidencies\hr_movimientos_vacaciones;
use App\Models\HR\Company\Employment\hr_departamentos;
use App\Models\HR\Company\Employment\hr_puestos;
use App\Models\HR\Company\Employment\hr_tipos_empleados;
use App\Models\HR\Company\Employment\hr_unidades;
use App\Models\SYS\sys_usuarios;
use App\Models\SYS\sys_usuarios_empresas;
use Illuminate\Http\Request;

class EmpleadosController extends Controller
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
     * 
     * @return array|string
     *
     **/
    public function readAll()
    {
        return  response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => hr_empleados::all()
        ], 200);
    }

    /**
     * 
     * @param int $id
     * @return array|string
     * 
     **/
    public function readOne($id)
    {
        $employee = hr_empleados::find($id);

        if (empty($employee)) {
            return response()->json([
                'error' => true,
                'message' => 'Empleado Inexistente'
            ], 404);
        }

        $vacations = hr_vacaciones::firstWhere('id_empleado', $id);
        unset($vacations->id_empleado);

        $employee["vacaciones"] = $vacations;

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $employee
        ], 200);
    }

    /**
     * 
     * @param Request $request
     * @return array|string
     * 
     **/
    public function create(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required | integer | min:1 | exists:sys_usuarios,id_usuario',
            'telefono' => 'required | string | regex:/^\d{10}$/',
            'telefono2' => 'nullable | sometimes | string | regex:/^\d{10}$/',
            'email2' => 'nullable | sometimes | email',
            'rfc' => 'required | string | size:13',
            'curp' => 'required | string | size:18',
            'sexo' => 'required | integer | between:0,1',
            'estadoCivil' => 'required | integer | min:1 | max:6',
            'cumpleaños' => 'required | date | date_format:Y-m-d',
            'lugarNatal' => 'required | integer | between:1,32',
            'calle' => 'required | string | max:40',
            'colonia' => 'required | string | max:40',
            'poblacion' => 'required | string | max:40',
            'ciudad' => 'required | string | max:40',
            'estado' => 'required | integer | between:1,32',
            'codigoPostal' => 'required | string | size:5',
            'nombreEmergencia' => 'required | string | max:80',
            'dirEmergencia' => 'required | string | max:150',
            'telEmergencia' => 'required | string | regex:/^\d{10}$/',
            'imss' => 'required | string | size:11',
            'tipoSangre' => 'required | string | max:3',
            'enfermedades' => 'nullable | sometimes | string | max:300',
            'fonacot' => 'nullable | sometimes | string | max:15',
            'unidadMedica' => 'required | integer | min:1',
            'altaFiscal' => 'required | date | date_format:Y-m-d',
            'contratoInicio' => 'required | date | date_format:Y-m-d',
            'contratoFin' => 'required | date | date_format:Y-m-d',
            'sueldo' => 'required | decimal:0,6 | min:0',
            'formaPago' => 'required | string | size:1',
            'pensAlimenticia' => 'required | integer | between:0,1',
            'nomClave' => 'nullable | sometimes | string | max:10',
            'nomBanco' => 'nullable | sometimes | integer | min:0',
            'nomLocalidad' => 'nullable | sometimes | string | max:20',
            'nomReferencia' => 'nullable | sometimes | string | max:16',
            'nomCuenta' => 'nullable | sometimes | string | max:16',
            'id_unidad' => 'required | integer | min:1 | exists:hr_unidades,id_unidad',
            'id_departamento' => 'required | integer | min:1 | exists:hr_departamentos,id_departamento',
            'id_puesto' => 'required | integer | min:1 | exists:hr_puestos,id_puesto',
            'id_tipo_empleado' => 'required | integer | min:1 | exists:hr_tipos_empleados,id_tipo_empleado',
            'id_horario' => 'required | integer | min:1 | exists:hr_horarios,id_horario',
            'id_empresa' => 'required | integer | min:1 | exists:hr_empresas,id_empresa',
            'id_terminal_user' => 'required | integer | min:1 | exists:att_empleado,emp_id',
        ]);

        $hrEmpleado = hr_empleados::create($request->all());

        hr_vacaciones::create([
            'id_empleado' => $hrEmpleado->id_empleado,
            'id_empresa' => $hrEmpleado->id_empresa,
        ]);

        return response()->json([
            'error' => false,
            'mensaje' => 'Inserción exitosa'
        ], 200);
    }

    /**
     * 
     * @param int $id
     * @return array|string
     * 
     **/
    public function delete($id)
    {
        $user = hr_empleados::find($id);

        if (empty($user)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Usuario Inexistente'
            ], 404);
        }

        try {
            $attempt = hr_empleados::destroy($id);
        } catch (\Throwable $th) {
            $attempt = false;
        }

        return response()->json([
            'error' => $attempt ? false : true,
            'mensaje' => $attempt ? 'Eliminado Correctamente' : 'No se puede borrar el Usuario'
        ], 200);
    }

    /**
     * 
     * @param int $id
     * @param Request $request
     * @return array|string
     * 
     **/
    public function update($id, Request $request)
    {
        $request->validate([
            'id_usuario' => 'sometimes | required | integer | min:1 | exists:sys_usuarios,id_usuario',
            'telefono' => 'sometimes | required | string | regex:/^\d{10}$/',
            'telefono2' => 'nullable | sometimes | string | regex:/^\d{10}$/',
            'email2' => 'nullable | sometimes | email',
            'rfc' => 'sometimes | required | string | size:13',
            'curp' => 'sometimes | required | string | size:18',
            'sexo' => 'sometimes | required | integer | between:0,1',
            'estadoCivil' => 'sometimes | required | integer | min:1 | max:6',
            'cumpleaños' => 'sometimes | required | date | date_format:Y-m-d',
            'lugarNatal' => 'sometimes | required | integer | between:1,32',
            'calle' => 'sometimes | required | string | max:40',
            'colonia' => 'sometimes | required | string | max:40',
            'poblacion' => 'sometimes | required | string | max:40',
            'ciudad' => 'sometimes | required | string | max:40',
            'estado' => 'sometimes | required | integer | between:1,32',
            'codigoPostal' => 'sometimes | required | string | size:5',
            'nombreEmergencia' => 'sometimes | required | string | max:80',
            'dirEmergencia' => 'sometimes | required | string | max:150',
            'telEmergencia' => 'sometimes | required | string | regex:/^\d{10}$/',
            'imss' => 'sometimes | required | string | size:11',
            'tipoSangre' => 'sometimes | required | string | max:3',
            'enfermedades' => 'nullable | sometimes | string | max:300',
            'fonacot' => 'nullable | sometimes | string | max:15',
            'unidadMedica' => 'sometimes | required | integer | min:1',
            'altaFiscal' => 'sometimes | required | date | date_format:Y-m-d',
            'contratoInicio' => 'sometimes | required | date | date_format:Y-m-d',
            'contratoFin' => 'sometimes | required | date | date_format:Y-m-d',
            'sueldo' => 'sometimes | required | decimal:0,6 | min:0',
            'formaPago' => 'sometimes | required | string | size:1',
            'pensAlimenticia' => 'sometimes | required | integer | between:0,1',
            'nomClave' => 'nullable | sometimes | string | max:10',
            'nomBanco' => 'nullable | sometimes | integer | min:0',
            'nomLocalidad' => 'nullable | sometimes | string | max:20',
            'nomReferencia' => 'nullable | sometimes | string | max:16',
            'nomCuenta' => 'nullable | sometimes | string | max:16',
            'id_unidad' => 'sometimes | required | integer | min:1 | exists:hr_unidades,id_unidad',
            'id_departamento' => 'sometimes | required | integer | min:1 | exists:hr_departamentos,id_departamento',
            'id_puesto' => 'sometimes | required | integer | min:1 | exists:hr_puestos,id_puesto',
            'id_tipo_empleado' => 'sometimes | required | integer | min:1 | exists:hr_tipos_empleados,id_tipo_empleado',
            'id_horario' => 'sometimes | required | integer | min:1 | exists:hr_horarios,id_horario',
            'id_empresa' => 'sometimes | required | integer | min:1 | exists:hr_empresas,id_empresa',
            'id_terminal_user' => 'sometimes | required | integer | min:1 | exists:att_empleado,emp_id',
        ]);
        $data = $request->all();
        $empleado = hr_empleados::find($id);
        $empleado->update($data);
        if (!$empleado) {
            return response()->json(["mensaje" => 'Empleado no encontrado'], 404);
        }
        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $empleado
        ], 200);
    }

    /**
     * 
     * @param int $id
     * @param Request $request
     * @return array|string
     * 
     **/
    public function create_in(Request $request, $id_employee)
    {

        $request->validate([
            'clave' => 'required | string | max:5',
            'afectaNomina' => 'required | integer | between:0,1',
            'nombre' => 'required | string ',
            'fechaIn' => 'date | date_format:Y-m-d',


            'descripcion' => 'sometimes | string | max:200 | required_wiht_all:fecha,esIncapacidad',
            'observaciones' => 'sometimes | string | max:250 | required_wiht_all:fecha,esIncapacidad',
            'fecha' => 'date | date_format:Y-m-d | required_with:esIncapacidad',
            'esIncapacidad' => 'sometimes | integer | between:0,1 | required_with:fecha',

            'tipo' => 'sometimes | required_with:dias | integer | between:0,1',
            'dias' => 'sometimes | required_with:tipo | integer | min:1',
            'inicio' => 'required_if:tipo,0 | date | date_format:Y-m-d',
            'fin' => 'required_if:tipo,0 | date | date_format:Y-m-d',
            'pago' => 'required_if:tipo,1 | date | date_format:Y-m-d'
        ]);

        if (isset($request['dias'])) {
            $vacaciones = hr_vacaciones::find($id_employee);
            printf($vacaciones);

            if ($vacaciones['dias_disponibles'] < $request['dias']) {
                return response()->json([
                    'error' => true,
                    'mensaje' => 'No se cuentan con tantos dias disponibles'
                ], 422);
            }
        }

        $incidencias = hr_incidencias::create([
            'clave' => $request['clave'],
            'nombre' => $request['nombre'],
            'afectaNomina' => $request['afectaNomina'],
            'id_empleado' => $id_employee
        ]);

        if (!isset($request["tipo"])) {
            hr_faltas::create([
                'id_incidencia' => $incidencias->id_incidencia,
                'descripcion' => $request->descripcion,
                'observaciones' => $request->observaciones,
                'fecha' => $request->fecha,
                'esIncapacidad' => $request->esIncapacidad,
                'id_empresa' => $request->id_empresa
            ]);
        } else {
            hr_movimientos_vacaciones::create([
                'tipo' => $request->tipo,
                'dias' => $request->dias,
                'inicio' => $request->inicio,
                'fin' => $request->fin,
                'pago' => $request->pago,
                'id_incidencia' => $incidencias->id_incidencia,
                'id_empresa' => $request->id_empresa
            ]);

            $vacaciones = hr_vacaciones::find($id_employee);
            $vacaciones->update([
                'dias_disponibles' => $vacaciones['dias_disponibles'] - $request->dias
            ]);
        }

        return response()->json([
            'error' => false,
            'mensaje' => 'Registro creado correctamente',
            'data' => $incidencias
        ], 201);
    }

    /**
     * 
     * @param int $id
     * @param Request $request
     * @param int $id_employee
     * @return array|string
     * 
     **/
    public function update_in($id_employee, Request $request, $id)
    {
        $request->validate([
            'clave' => 'sometimes | required | string | max:5',
            'afectaNomina' => 'integer | between:0,1',
            'nombre' => 'sometimes | required | string ',
            'fechaIn' => 'date | date_format:Y-m-d',

            'descripcion' => 'sometimes | string | max:200 | required_wiht_all:fecha,esIncapacidad',
            'observaciones' => 'sometimes | string | max:250 | required_wiht_all:fecha,esIncapacidad',
            'fecha' => 'date | date_format:Y-m-d | required_with:esIncapacidad',
            'esIncapacidad' => 'sometimes | integer | between:0,1 | required_with:fecha',

            'tipo' => 'sometimes | required_with:dias | integer | between:0,1',
            'dias' => 'sometimes | required_with:tipo | integer | min:1',
            'inicio' => 'required_if:tipo,0 | date | date_format:Y-m-d',
            'fin' => 'required_if:tipo,0 | date | date_format:Y-m-d',
            'pago' => 'required_if:tipo,1 | date | date_format:Y-m-d'
        ]);

        $incidencia = hr_incidencias::find($id);
        $incidencia->update([
            'clave' => $request->clave,
            'afectaNomina' => $request->afectaNomina
        ]);
        if (empty($incidencia)) {
            return response()->json(["mensaje" => ' no encontrado'], 404);
        }

        $mv_faltas = hr_faltas::firstWhere('id_incidencia', $id);
        /* if(empty($mv_faltas)){
            $mv_faltas = hr_movimientos_vacaciones::firstWhere('id_incidencia', $id);
        }  */

        if (!empty($mv_faltas)) {
            $mv_faltas->update([
                'descripcion' => $request->descripcion,
                'observaciones' => $request->observaciones,
                'fecha' => $request->fecha,
                'esIncapacidad' => $request->esIncapacidad,
            ]);
        } else {
            $mv_faltas = hr_movimientos_vacaciones::firstWhere('id_incidencia', $id);

            if (empty($mv_faltas)) {
                return response()->json([
                    'error' => true,
                    'message' => 'no se pudo completar la acción'
                ], 404);
            }

            $mv_faltas->update([
                'tipo' => $request->tipo,
                'dias' => $request->dias,
                'inicio' => $request->inicio,
                'fin' => $request->fin,
                'pago' => $request->pago
            ]);
        }

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $incidencia
        ], 200);
    }

    /**
     * 
     * @return array|string
     * 
     **/
    public function readAll_in($id_employee)
    {
        $empleados = hr_incidencias::where('columna', $id_employee)->get();
        return  response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $empleados
        ], 200);
    }

    /**
     * 
     * @param int $id
     * @param int $id_employee
     * @return array|string
     * 
     **/
    public function readOne_in($id_employee, $id)
    {
        $incidencia = hr_incidencias::find($id);

        if (!$incidencia) {
            return response()->json([
                'error' => true,
                'message' => 'incidencia  no existe'
            ], 404);
        }

        $mv_faltas = hr_faltas::firstWhere('id_incidencia', $id);
        if (empty($mv_faltas)) {
            $mv_faltas = hr_movimientos_vacaciones::firstWhere('id_incidencia', $id);
            if (empty($mv_faltas)) {
                return response()->json([
                    'error' => true,
                    'message' => 'no se pudo completar la acción'
                ], 404);
            }
        }

        $incidencia["extra"] = $mv_faltas;

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $incidencia
        ], 200);
    }

    public function delete_in($id_employee)
    {
        try {
            $incidencia = hr_incidencias::find($id_employee);

            if (!$incidencia) {
                return response()->json([
                    'error' => true,
                    'mensaje' => 'La incidencia no existe'
                ], 404);
            }

            $vacaciones = hr_vacaciones::find($id_employee);
            $movimiento = hr_movimientos_vacaciones::where('id_incidencia', $incidencia["id_incidencia"]);
            $rec = $movimiento["dias"] + $vacaciones["dias_disponibles"];

            $vacaciones->update([
                'dias_disponibles' => $rec
            ]);
            $incidencia->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'La incidencia ha sido eliminada correctamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Se produjo un error al eliminar la incidencia: '
            ], 500);
        }
    }

    /**
     * 
     * @param int $id_employee
     * @param Request $request
     * @return array|string
     * 
     **/
    public function youarefired(Request $request, $id_employee)
    {
        $empleado = hr_empleados::find($id_employee);

        if (empty($empleado)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Empleado Inexistente',
            ], 404);
        }

        $request->validate([
            'observaciones' => 'sometimes | required | string | max:255',
            'infoBaja' => 'required | integer | between:0,15'
        ]);

        $historial = hr_historial::create([
            'id_empleado' => $id_employee,
            'id_empresa' => $empleado['id_empresa'],
            'movimiento' => 'B',
            'estado' => 1,
            'id_unidad' => $empleado['id_unidad'],
            'id_puesto' => $empleado['id_puesto'],
            'id_departamento' => $empleado['id_departamento'],
            'sueldo' => $empleado['sueldo'],
            'observaciones' => $request->observaciones,
            'infoBaja' => $request->infoBaja
        ]);

        $usuario = sys_usuarios::find($empleado['id_usuario']);
        $companies = sys_usuarios_empresas::where('id_usuario', $empleado['id_usuario'])->get();

        if (count($companies) == 1) {
            $usuario->activo = 0;
            $usuario->save();
        }

        $register = sys_usuarios_empresas::where('id_empresa', $empleado['id_empresa'])
            ->where('id_usuario', $empleado['id_usuario'])
            ->first();

        $register->update([
            'activo' => 0
        ]);

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $historial
        ], 201);
    }

    /**
     * 
     * @param int $id
     * @param Request $request
     * @return array|string
     * 
     **/
    public function cambios_hist(Request $request, $id)
    {
        $empleado = hr_empleados::find($id);

        if (empty($empleado)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Empleado Inexistente',
            ], 404);
        }

        $request->validate([
            'movimiento' => 'required | string | size:1',
            'estado' => 'required | integer | between:0,1',
            'id_unidad' => 'required | integer | min:1 | exists:hr_unidades,id_unidad',
            'id_puesto' => 'required | integer | min:1 | exists:hr_puestos,id_puesto',
            'id_departamento' => 'required | integer | min:1 | exists:hr_departamentos,id_departamento',
            'sueldo' => 'required | decimal:0,6 | min:0',
            'observaciones' => 'sometimes | required | string | max:255'
        ]);

        hr_historial::create([
            'id_empleado' => $id,
            'id_empresa' => $empleado["id_empresa"],
            'movimiento' => $request->movimiento,
            'estado' => $request->estado,
            'id_unidad' => $empleado['id_unidad'],
            'id_puesto' => $empleado['id_puesto'],
            'id_departamento' => $empleado['id_departamento'],
            'sueldo' => $empleado['sueldo'],
            'observaciones' => $request->observaciones
        ]);


        $empleado->update([
            'id_unidad' => $request->id_unidad,
            'id_puesto' => $request->id_puesto,
            'id_departamento' => $request->id_departamento,
            'sueldo' => $request->sueldo
        ]);

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $empleado
        ], 201);
    }

    public function updatev($id_employee)
    {
        $vacaciones = hr_vacaciones::find($id_employee);
        if (empty($vacaciones)) {
            return response()->json([
                'error' => true,
                'message' => 'Empleado Inexiste'
            ], 404);
        }

        $vacaciones->update([
            'años_totales' => $vacaciones['años_totales'] + 1,
            'dias_disponibles' => $vacaciones['dias_disponibles'] + \App\Models\HR\hr_derechos_vacaciones::where('inicio', '<=', $vacaciones['años_totales'] + 1)
                ->firstWhere('fin', '>=', $vacaciones['años_totales'] + 1)['dias']
        ]);

        return response()->json([
            'error' => false,
            'mensaje' => 'Cambio exitoso',
            'data' => $vacaciones
        ], 200);
    }

    public function training(Request $request, $id_employee)
    {
        $employee = hr_empleados::find($id_employee);

        if (empty($employee)) {
            return response()->json([
                'error' => true,
                'message' => 'Empleado Inexiste'
            ], 404);
        }

        $request->validate([
            'capacitacion' => 'required | integer | exists:hr_capacitaciones,id_capacitacion'
        ]);

        hr_capacitaciones_empleados::create([
            'id_capacitacion' => $request->capacitacion,
            'id_empleado' => $id_employee
        ]);

        return response()->json([
            'error' => false,
            'message' => 'Registro Creado'
        ], 200);
    }

    public function search($name)
    {
        $data = sys_usuarios::join('hr_empleados', 'sys_usuarios.id_usuario', '=', 'hr_empleados.id_usuario')->where('nombre', 'LIKE', '%' . $name . '%')
            ->orWhere('apellidoP', 'LIKE', '%' . $name . '%')
            ->orWhere('apellidoM', 'LIKE', '%' . $name . '%')->get();

        if (!empty($data)) {
            foreach ($data as $employee) {
                $employee['id_unidad'] = hr_unidades::find($employee['id_unidad'])['nombre'];
                $employee['id_departamento'] = hr_departamentos::find($employee['id_departamento'])['nombre'];
                $employee['id_puesto'] = hr_puestos::find($employee['id_puesto'])['nombre'];
                $employee['id_tipo_empleado'] = hr_tipos_empleados::find($employee['id_tipo_empleado'])['nombre'];
            }
        }

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $data
        ], 200);
    }
}
