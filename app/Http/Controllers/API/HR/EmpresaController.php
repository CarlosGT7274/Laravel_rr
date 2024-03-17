<?php

namespace App\Http\Controllers\API\HR;

use App\Models\ATT\att_terminal;
use App\Models\HR\Company\Employment\hr_departamentos;
use App\Models\HR\Company\Employment\hr_puestos;
use App\Models\HR\Company\Employment\hr_tipos_empleados;
use App\Models\HR\Company\Employment\hr_unidades;

use App\Http\Controllers\Controller;
use App\Models\ATT\att_registros;
use App\Models\HR\Company\Employment\hr_historial;
use App\Models\HR\Company\Employment\hr_organizacion;
use App\Models\HR\Company\General\hr_capacitaciones;
use App\Models\HR\Company\General\hr_capacitaciones_empleados;
use App\Models\HR\Company\General\hr_empresas;
use App\Models\HR\Company\Schedule\hr_detalles_horarios;
use App\Models\HR\Employee\General\hr_empleados;
use App\Models\HR\Employee\General\hr_vacaciones;
use App\Models\HR\Employee\Incidencies\hr_incidencias;
use App\Models\HR\Employee\Incidencies\hr_movimientos_vacaciones;
use App\Models\SYS\sys_usuarios;
use DateTime;
use Illuminate\Http\Request;

class EmpresaController extends Controller
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
     * Read All Companies on the data base.
     * 
     * @return array|string
     */
    public function readAll()
    {
        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => hr_empresas::all()
        ], 200);
    }

    /**
     * Read a Specific User on the data base.
     * @param int $id
     * @return array|string
     */
    public function readOne($id)
    {
        $empresa = hr_empresas::find($id);

        if (empty($empresa)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Empresa no registrado',
            ], 404);
        }

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $empresa
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
            'razonSocial' => 'required | string | min:1',
            'rfc' => 'required | string | min:1 | max:13',
            'giroComercial' => 'required | string | min:1',
            'contacto' => 'required | string | min:1',
            'telefono' => 'required | string | min:1 | max:10',
            'email' => 'required | string | min:1 | email',
            'fax' => 'nullable | string | min:1',
            'web' => 'nullable | string | min:1',
            'calle' => 'required | string | min:1',
            'colonia' => 'required | string | min:1',
            'poblacion' => 'required | string | min:1',
            'estado' => 'required | integer',
            'logo' => 'nullable | string | min:1'
        ]);

        $empresa = hr_empresas::create($request->all());

        // TODO: añadir parent Key '_0' a tabla organizacion con key de empresa donde tenga un distintivo dependiendo la empresa

        hr_organizacion::create([
            'key' => $empresa['id_empresa'] . '_0',
            'id_empresa' => $empresa['id_empresa']
        ]);

        return response()->json([
            'error' => false,
            'mensaje' => 'Empresa Creada Correctamente',
            'data' => $empresa
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
        $empresa = hr_empresas::find($id);

        if (empty($empresa)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Empresa no registrado',
            ], 404);
        }

        $request->validate([
            'razonSocial' => 'string | min:1',
            'rfc' => 'string | min:1 | max:13',
            'giroComercial' => 'string | min:1',
            'contacto' => 'string | min:1',
            'telefono' => 'string | min:1 | max:10',
            'email' => 'string | min:1 | email',
            'fax' => 'nullable | string | min:1',
            'web' => 'nullable | string | min:1',
            'calle' => 'string | min:1',
            'colonia' => 'string | min:1',
            'poblacion' => 'string | min:1',
            'ciudad' => 'string | min:1',
            'estado' => 'integer',
            'logo' => 'nullable | string | min:1'
        ]);

        return response()->json([
            'error' => $empresa->update($request->all()) ? false : true,
            'mensaje' => 'Cambios Realizados'
        ], 200);
    }

    /**
     * Delete a Specific User on the data base.
     * @param int $id
     * @return array|string
     */
    public function delete($id)
    {
        $empresa = hr_empresas::find($id);

        if (empty($empresa)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Empresa no registrado',
            ], 404);
        }

        $attempt = false;
        try {
            $attempt = hr_empresas::destroy($id);
        } catch (\Throwable $th) {
            $attempt = false;
        }

        return response()->json([
            'error' => $attempt ? false : true,
            'mensaje' => $attempt ? 'Eliminado Correctamente' : 'No se puede borrar la empresa'
        ], 200);
    }

    /**
     * Read All Trainings on the data base for a given company.
     * 
     * @param int $id
     * @param int $id_company
     * @return array|string
     */
    public function readOneTraining($id_company, $id)
    {
        $empresa = hr_empresas::find($id_company);

        if (empty($empresa)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Empresa no registrado',
            ], 404);
        }

        $training = hr_capacitaciones::find($id);

        if (empty($training)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Capacitacion no registrada',
            ], 404);
        }

        $employees = hr_capacitaciones_empleados::select('hr_empleados.id_empleado', 'nombre', 'apellidoP', 'apellidoM', 'fecha')->where('id_capacitacion', $training->id_capacitacion)->join('hr_empleados', 'hr_capacitaciones_empleados.id_empleado', '=', 'hr_empleados.id_empleado')->join('sys_usuarios', 'sys_usuarios.id_usuario', '=', 'hr_empleados.id_usuario')->get();
        $training['empleados'] = $employees;

        $all_empleados = hr_empleados::where('id_empresa', $id_company)->join('sys_usuarios', 'sys_usuarios.id_usuario', '=', 'hr_empleados.id_usuario')->get();
        $empleados = hr_capacitaciones_empleados::select('id_empleado')->where('id_capacitacion', $training->id_capacitacion)->get();

        $nuevosEmpleados = []; // Crear un nuevo array para almacenar los empleados que no se deben eliminar

        foreach ($all_empleados as $key => $employee) {
            if ($empleados->contains('id_empleado', $employee['id_empleado'])) {
                unset($all_empleados[$key]);
            } else {
                $nuevosEmpleados[] = $employee;
            }
        }

        $training['all_empleados'] = $nuevosEmpleados;

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $training
        ], 200);
    }

    /**
     * Create a new training an associate employees to it
     * 
     * @param int $id_company
     * @param Request $request
     * @return array|string
     */
    public function createTraining($id_company, Request $request)
    {
        $empresa = hr_empresas::find($id_company);

        if (empty($empresa)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Empresa no registrado',
            ], 404);
        }

        $request->validate([
            'nombre' => 'required | string',
            'descripcion' => 'sometimes | required | string',
            'empleados' => 'array',
            'empleados.*.id_empleado' => 'integer | min:1 | exists:hr_empleados,id_empleado',
            'empleados.*.fecha' => 'date | date_format:Y-m-d'
        ]);

        $employees = [];

        if (!empty($request->empleados)) {
            $employees = $request->empleados;
            unset($request->empleados);
        }

        $request['id_empresa'] = $id_company;
        $training = hr_capacitaciones::create($request->all());
        $training_emps = [];

        foreach ($employees as $employee) {
            $register = hr_capacitaciones_empleados::create([
                'id_capacitacion' => $training->id_capacitacion,
                'id_empleado' => $employee['id_empleado'],
                'fecha' => isset($employee['fecha']) ? $employee['fecha'] : null
            ]);

            array_push($training_emps, $register);
        }

        $training['empleados'] = $training_emps;

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $training
        ], 200);
    }

    public function updateTraining($id_company, $id, Request $request)
    {
        $training = hr_capacitaciones::find($id);

        if (empty($training)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Capacitacion no registrado',
            ], 404);
        }

        $request->validate([
            'nombre' => 'sometimes | required | string',
            'descripcion' => 'sometimes | required | string',
            'empleados' => 'array',
            'empleados.*.id_empleado' => 'integer | min:1 | exists:hr_empleados,id_empleado',
            'empleados.*.fecha' => 'date | date_format:Y-m-d'
        ]);

        $employees = [];

        if (!empty($request->empleados)) {
            $employees = $request->empleados;
            unset($request->empleados);
        }

        $training->update($request->all());
        $training_emps = [];

        foreach ($employees as $employee) {
            $register = hr_capacitaciones_empleados::create([
                'id_capacitacion' => $training->id_capacitacion,
                'id_empleado' => $employee['id_empleado'],
                'fecha' => isset($employee['fecha']) ? $employee['fecha'] : null
            ]);

            array_push($training_emps, $register);
        }

        $training['empleados'] =  hr_capacitaciones_empleados::where('id_capacitacion',  $training->id_capacitacion)->get();

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $training
        ], 200);
    }

    public function employees($id_company, Request $request)
    {
        $empresa = hr_empresas::find($id_company);

        if (empty($empresa)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Empresa no registrado',
            ], 404);
        }

        $data = [];

        $request->validate([
            'id_unidad' => 'integer | min:1 | exists:hr_unidades,id_unidad',
            'id_departamento' => 'integer | min:1 | exists:hr_departamentos,id_departamento',
            'id_puesto' => 'integer | min:1 | exists:hr_puestos,id_puesto',
            'id_tipo_empleado' => 'integer | min:1 | exists:hr_tipos_empleados,id_tipo_empleado',
            'alta' => 'date | date_format:Y-m-d',
            'agruparpor' => ['sometimes', 'required', 'string', 'regex:/^id_(unidad|departamento|puesto|tipo_empleado)|alta$/'],
        ]);

        if (empty($request)) {
            $data = hr_empleados::where('empresa_id', $id_company)->join('sys_usuarios', 'sys_usuarios.id_usuario', '=', 'hr_empleados.id_usuario')->get();
        } else {
            $query = hr_empleados::join('sys_usuarios', 'sys_usuarios.id_usuario', '=', 'hr_empleados.id_usuario')->where('id_empresa', $id_company);

            foreach ($request->all() as $param => $value) {
                if ($param === 'agruparpor') {
                    $query->orderBy($value, "desc");
                } else {
                    $query->where($param, $value);
                }
            }

            $data = $query->get();
        }

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

    private function reportParams(Request $request, $id_company)
    {
        $request->validate([
            'inicio' => 'required | date | date_format:Y-m-d',
            'fin' => 'required | date | date_format:Y-m-d',
            'id' => 'integer | min:1 | exists:hr_empleados,id_empleado',
            'unidad' => 'integer | min:1 | exists:hr_unidades,id_unidad'
        ]);

        $employees = [];

        if (!empty($request->id)) {
            $employee = hr_empleados::find($request->id);

            if (empty($employee)) {
                return response()->json([
                    'error' => true,
                    'mensaje' => 'No existe el empleado'
                ], 200);
            } else {
                $employees[] = $employee;
            }
        } else if (!empty($request->unidad)) {
            $employees = hr_empleados::where('id_unidad', $request->unidad)->get();
        } else {
            $employees = hr_empleados::where('id_empresa', $id_company)->get();
        }

        return $employees;
    }

    private function getDates(Request $request)
    {
        $fechas = [];

        $fechaFin = new DateTime(date('Y-m-d H:i:s', strtotime($request->fin . " 23:59:59")));
        $fechaInicio = new DateTime(date('Y-m-d H:i:s', strtotime($request->inicio . " 00:00:00")));

        for ($i = date_diff($fechaFin, $fechaInicio)->days; $i >= 0; $i--) {
            $fechas[] = date('Y-m-d', strtotime("-$i days", strtotime($fechaFin->format('Y-m-d H:i:s'))));
        }

        return $fechas;
    }

    private function getRegisters($employee, $fechaInicio, $fechaFin)
    {
        return att_registros::where('emp_id', $employee->id_terminal_user)
            ->whereBetween('punch_time', [$fechaInicio, $fechaFin])
            ->orderBy('punch_time', 'asc')
            ->get();
    }

    public function asistenciasReport(Request $request, $id_company)
    {
        $empresa = hr_empresas::find($id_company);

        if (empty($empresa)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Empresa no registrado',
            ], 404);
        }

        $data = [];
        $data['fechas'] = $this->getDates($request);
        $data['empleados'] = [];
        $employees = $this->reportParams($request, $id_company);

        $fechaFin = new DateTime(date('Y-m-d H:i:s', strtotime($request->fin . " 23:59:59")));
        $fechaInicio = new DateTime(date('Y-m-d H:i:s', strtotime($request->inicio . " 00:00:00")));

        foreach ($employees as $employee) {
            $registers = $this->getRegisters($employee, $fechaInicio, $fechaFin);
            
            $usuarioinfo = sys_usuarios::firstWhere('id_usuario', $employee->id_usuario);

            $data['empleados'][] = [
                'id_empleado' => $employee->id_empleado,
                'nombre' => $usuarioinfo->nombre,
                'apellidoP' => $usuarioinfo->apellidoP,
                'apellidoM' => $usuarioinfo->apellidoM,
                'asistencias' => [],
                'faltas' => [],
                'registros' => $registers
            ];

            $empleado_i = count($data['empleados']) - 1;

            $esEntrada = 1;

            foreach ($data['fechas'] as $date) {

                $hasRegister = false;

                foreach ($registers as $key => $register) {
                    $registerDate = date('Y-m-d', strtotime($register['punch_time']));

                    if ($registerDate == $date || $esEntrada % 2 == 0) {

                        if ($esEntrada % 2 == 0) {
                            $data['empleados'][$empleado_i]['asistencias'][$date]['salida'] = $register['punch_time'];
                            $data['empleados'][$empleado_i]['asistencias'][$date]['tipo_out'] = $register->punch_type == 0 ? 'Manual' : 'Normal';
                        } else {
                            $data['empleados'][$empleado_i]['asistencias'][$date] = [
                                'entrada' => $register['punch_time'],
                                'tipo_in' => $register->punch_type == 0 ? 'Manual' : 'Normal'
                            ];
                        }

                        unset($registers[$key]);

                        $esEntrada++;
                        $hasRegister = true;
                    }
                }

                if (!$hasRegister) {
                    $usuarioinfo = sys_usuarios::firstWhere('id_usuario', $employee->id_usuario);
                    $numeroDiaSemana = date('N', strtotime($date));

                    $comparar = hr_detalles_horarios::where('id_horario', $employee->id_horario)->firstWhere('dia', $numeroDiaSemana);

                    if ($comparar['tipo'] == 1) {
                        $data['empleados'][$empleado_i]['faltas'][] = $date;
                    }
                }
            }
        }

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $data
        ], 200);
    }

    public function reportIncidencias(Request $request, $id_company)
    {
        $empresa = hr_empresas::find($id_company);

        if (empty($empresa)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Empresa no registrado',
            ], 404);
        }

        $data = [];
        $data['fechas'] = $this->getDates($request);
        $data['empleados'] = [];

        $employees = $this->reportParams($request, $id_company);

        $fechaFin = new DateTime(date('Y-m-d H:i:s', strtotime($request->fin . " 23:59:59")));
        $fechaInicio = new DateTime(date('Y-m-d H:i:s', strtotime($request->inicio . " 00:00:00")));

        foreach ($employees as $employee) {
            $registers = $this->getRegisters($employee, $fechaInicio, $fechaFin);

            $usuarioinfo = sys_usuarios::firstWhere('id_usuario', $employee->id_usuario);

            $data['empleados'][] = [
                'id_empleado' => $employee->id_empleado,
                'nombre' => $usuarioinfo->nombre,
                'apellidoP' => $usuarioinfo->apellidoP,
                'apellidoM' => $usuarioinfo->apellidoM,
                'asistencias' => [],
                'incidencias' => [],
                'incidenciasInfo'=> [],
            ];

            $empleado_i = count($data['empleados']) - 1;

            foreach ($data['fechas'] as $date) {

                $hasRegister = false;

                foreach ($registers as $key => $register) {
                    $registerDate = date('Y-m-d', strtotime($register['punch_time']));

                    if ($registerDate == $date) {

                        $usuarioinfo = sys_usuarios::firstWhere('id_usuario', $employee->id_usuario);

                        $data['empleados'][$empleado_i]['asistencias'][] = $date;

                        unset($registers[$key]);

                        $hasRegister = true;

                        break;
                    }
                }

                if (!$hasRegister) {
                    $numeroDiaSemana = date('N', strtotime($date));

                    $comparar = hr_detalles_horarios::where('id_horario', $employee->id_horario)->firstWhere('dia', $numeroDiaSemana);

                    $incidencia = hr_incidencias::where('id_empleado', $employee->id_empleado)->firstWhere('fechaIn', $date);

                    if (!empty($incidencia)) {
                        $data['empleados'][$empleado_i]['incidencias'][$date] = $incidencia->clave;
                        $data['empleados'][$empleado_i]['incidenciasInfo'][$date] = $incidencia;
                    } else {
                        $data['empleados'][$empleado_i]['incidencias'][$date] = $comparar->tipo == 0 ? 'D' : '';
                    }
                }
            }
        }

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $data
        ], 200);
    }

    public function reportvacaciones(Request $request, $id_company)
    {
        $empresa = hr_empresas::find($id_company);

        if (empty($empresa)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Empresa no registrado',
            ], 404);
        }

        $data = [];

        $employees = [];

        if (!empty($request->id)) {
            $employeess = hr_empleados::find($request->id);

            if (empty($employeess)) {
                return response()->json([
                    'error' => true,
                    'mensaje' => 'No existe el empleado'
                ], 200);
            } else {
                $employees[] = $employeess;
            }
        } else if (!empty($request->unidad)) {
            $employees = hr_empleados::where('id_unidad', $request->unidad)->get();
        } else {
            $employees = hr_empleados::where('id_empresa', $id_company)->get();
        }

        foreach ($employees as $employee) {
            $movimientosvaccount = 0;
            $sysusers = sys_usuarios::find($employee->id_usuario);
            $incidencias = hr_incidencias::firstWhere('id_empleado', $employee->id_empleado);
            if (!empty($incidencias)) {
                $movimientosvac = hr_movimientos_vacaciones::firstWhere('id_incidencia', $incidencias->id_incidencia);
                $movimientosvaccount += $movimientosvac->dias;
            }
            $vac = hr_vacaciones::firstWhere('id_empleado', $employee->id_empleado);

            $data[] = [
                'id' => $employee->id_empleado,
                'nombre' => $sysusers->nombre,
                'apellidoP' => $sysusers->apellidoP,
                'apellidoM' => $sysusers->apellidoM,
                'alta' => $employee->alta,
                'antiguedad' => $vac->años_totales,
                'dias' => $vac->dias_disponibles + $movimientosvaccount,
                'usados' => $movimientosvaccount,
                'pendientes' => $vac->dias_disponibles
            ];
        }


        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $data
        ], 200);
    }

    public function reportFiredPeople(Request $request, $id_company)
    {
        $empresa = hr_empresas::find($id_company);

        if (empty($empresa)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Empresa no registrado',
            ], 404);
        }

        $data = [];

        $request->validate([
            'inicio' => 'required | date | date_format:Y-m-d',
            'fin' => 'required | date | date_format:Y-m-d'
        ]);

        foreach (hr_historial::where('id_empresa', $id_company)->whereBetween('fecha', [$request->inicio, $request->fin])->where('movimiento', 'B')->get() as $resignation) {

            $employee = hr_empleados::join('sys_usuarios', 'hr_empleados.id_usuario', '=', 'sys_usuarios.id_usuario')
                ->select('id_empleado', 'nombre', 'apellidoP', 'apellidoM')
                ->firstWhere('id_empleado', $resignation['id_empleado']);

            $data[] = [
                'id_empleado' => $employee->id_empleado,
                'nombre' => $employee->nombre,
                'apellidoP' => $employee->apellidoP,
                'apellidoM' => $employee->apellidoM,
                'fecha' => $resignation->fecha,
                'motivo' => $resignation->observaciones,
                'entrevista' => $resignation->infoBaja % 2 != 0 ? true : false,
                'finiquito' => $resignation->infoBaja >= 2 ? true : false,
                'firma' => $resignation->infoBaja >= 4 ? true : false,
                'recontratable' => $resignation->infoBaja > 7 ? true : false
            ];
        }

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $data
        ], 200);
    }

    public function reportBiometrics($id_company)
    {
        $empresa = hr_empresas::find($id_company);

        if (empty($empresa)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Empresa no registrado',
            ], 404);
        }

        $data = [];

        $units = hr_unidades::where('id_empresa', $id_company)->select('id_unidad')->get();

        foreach ($units as $unit) {
            $terminals = att_terminal::join('hr_unidades_terminales', 'hr_unidades_terminales.terminal_id', '=', 'att_terminal.terminal_id')
                ->where('id_unidad', $unit['id_unidad'])
                ->select('att_terminal.*')
                ->get();

            foreach ($terminals as $terminal) {
                $data[] = $terminal;
            }
        }

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $data
        ], 200);
    }

    public function reportDelays(Request $request, $id_company)
    {
        $empresa = hr_empresas::find($id_company);

        if (empty($empresa)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Empresa no registrado',
            ], 404);
        }

        $data = [];
        $data['fechas'] = $this->getDates($request);
        $data['empleados'] = [];

        $employees = $this->reportParams($request, $id_company);

        $fechaFin = new DateTime(date('Y-m-d H:i:s', strtotime($request->fin . " 23:59:59")));
        $fechaInicio = new DateTime(date('Y-m-d H:i:s', strtotime($request->inicio . " 00:00:00")));

        foreach ($employees as $keyEmployee => $employee) {
            $registers = $this->getRegisters($employee, $fechaInicio, $fechaFin);

            $usuarioinfo = sys_usuarios::select('nombre', 'apellidoP', 'apellidoM')->firstWhere('id_usuario', $employee->id_usuario);

            $data['empleados'][] = [
                'id_empleado' => $employee->id_empleado,
                'nombre' => $usuarioinfo->nombre,
                'apellidoP' => $usuarioinfo->apellidoP,
                'apellidoM' => $usuarioinfo->apellidoM,
                'retrasos' => []
            ];

            foreach ($data['fechas'] as $date) {

                foreach ($registers as $key => $register) {
                    $registerDate = date('Y-m-d', strtotime($register['punch_time']));
                    if ($registerDate == $date) {
                        
                        $usuarioinfo = sys_usuarios::firstWhere('id_usuario', $employee->id_usuario);
                        
                        $numeroDiaSemana = date('N', strtotime($date));
                        
                        $detalle = hr_detalles_horarios::where('id_horario', $employee->id_horario)->firstWhere('dia', $numeroDiaSemana);
                        
                        if ($detalle['tipo'] == 1) {
                            $time = new DateTime(date('H:i:s', strtotime($register['punch_time'])));
                            $timeIn = new DateTime(date('H:i:s', strtotime($detalle['inicio'])));
                            $timeIn->modify('+' . $detalle['toleranciaIn'] . ' minutes');
                            $interval = $timeIn->diff($time);

                            if ($time >= $timeIn) {
                                $data['empleados'][$keyEmployee]['retrasos'][] = [
                                    'fecha' => $register['punch_time'],
                                    'max' => $timeIn->format('H:i:s'),
                                    'retraso' => $interval->format('%h') . ':' . $interval->format('%i')
                                ];
                            }
                        }

                        unset($registers[$key]);

                        break;
                    }
                }
            }
        }

        $temp_array = [];

        foreach ($data['empleados'] as $employee) {
            if (count($employee['retrasos']) > 0) {
                $temp_array[] = $employee;
            }
        };

        $data['empleados'] = $temp_array;

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $data
        ], 200);
    }
}
