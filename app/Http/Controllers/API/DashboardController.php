<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\HR\Company\Employment\hr_historial;
use App\Models\HR\Company\Employment\hr_puestos;
use App\Models\HR\Company\Employment\hr_unidades;
use App\Models\HR\Company\Schedule\hr_detalles_horarios;
use App\Models\ATT\att_registros;
use App\Models\HR\Company\General\hr_capacitaciones_empleados;
use App\Models\HR\Company\General\hr_capacitaciones;
use App\Models\SYS\sys_usuarios;
use App\Models\HR\Employee\Info\hr_familiares;
use App\Models\SYS\sys_usuarios_empresas;
use Illuminate\Http\Request;

class DashboardController extends Controller
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
     * Get all Active Employees of a company
     * 
     * @param Request $request
     * @param int $active
     * @return array|int 
     */
    public function getEmployees(Request $request, $active = 1, $birthdays = false)
    {
        $request->validate([
            'date' => 'required | date | date_format:Y-m-d',
            'position' => 'integer | min:1 | exists:hr_puestos,id_puesto',
            'department' => 'integer | min:1 | exists:hr_departamentos,id_departamento',
            'region' => 'sometimes | required | string',
            'unit' => 'integer | min:1 | exists:hr_unidades,id_unidad',
        ]);

        $company = sys_usuarios_empresas::firstWhere('id_usuario', auth()->user()->id_usuario);

        if (empty($company) || $company['activo'] == 0) {
            return -1;
        }

        $company = $company['id_empresa'];

        $employees = sys_usuarios_empresas::join('hr_empleados', 'hr_empleados.id_usuario', '=', 'sys_usuarios_empresas.id_usuario')
            ->where('sys_usuarios_empresas.id_empresa', $company)
            ->where('activo', $active)->select('hr_empleados.*')->get();

        $units = [];

        if (isset($request->region)) {
            foreach (hr_unidades::where('id_empresa', $company)->where('region', $request->region)->select('id_unidad')->get() as $unit) {
                array_push($units, $unit['id_unidad']);
            }
        }

        foreach ($employees as $key => $employee) {
            $month = date('m', strtotime($request->date));
            $employeeDate = date('m', strtotime($employee['alta']));

            if ($employeeDate > $month && $active == 1 && !$birthdays) {
                unset($employees[$key]);
                continue;
            }

            if (isset($request->position)) {
                if ($employees[$key]['id_puesto'] != $request->position) {
                    unset($employees[$key]);
                    continue;
                }
            } else if (isset($request->department)) {
                if ($employees[$key]['id_departamento'] != $request->department) {
                    unset($employees[$key]);
                    continue;
                }
            }

            if (isset($request->unit)) {
                if ($employees[$key]['id_unidad'] != $request->unit) {
                    unset($employees[$key]);
                    continue;
                }
            } else if (!empty($units)) {
                if (!in_array($employees[$key]['id_unidad'], $units)) {
                    unset($employees[$key]);
                    continue;
                }
            }
        }

        return $employees;
    }

    /**
     * Return the attendance for a 7-days timelaps
     * 
     * @param boolean $needEncode
     * @return array|string 
     */
    public function attendance(Request $request)
    {
        $data = [];
        $data['dates'] = [];

        $employees = $this->getEmployees($request);

        if (is_int($employees)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Unauthorized',
                'data' => []
            ], 401);
        }

        $request->validate([
            'paramDate' => 'date | date_format:Y-m-d'
        ]);

        for ($i = 0; $i < 7; $i++) {

            $date = date('Y-m-d', strtotime("-$i days", strtotime(date('Y-m-d', isset($request->paramDate) ? strtotime($request->paramDate) : null))));
            $temp_object = ['asistencias' => 0, 'faltas' => 0];

            foreach ($employees as $employee) {
                $register = att_registros::where('emp_id', $employee->id_terminal_user)->whereBetween(
                    'punch_time',
                    [date('Y-m-d H:i:s', strtotime($date . " 00:00:00")), date('Y-m-d H:i:s', strtotime($date . " 23:59:59"))]
                )->first();

                if (empty($register)) {
                    $numeroDiaSemana = date('N', strtotime($date));

                    $comparar = hr_detalles_horarios::where('id_horario', $employee->id_horario)->firstWhere('dia', $numeroDiaSemana);

                    if ($comparar['tipo'] == 1) {
                        $temp_object['faltas']++;
                    }
                } else {
                    $temp_object['asistencias']++;
                }
            }


            $data['dates'][$date] = $temp_object;
        }

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $data
        ], 200);
    }

    /**
     * Return General Stadistics
     * 
     * @param Request $request
     * @return array|string 
     */
    public function general(Request $request)
    {
        $data = [];

        $employees = $this->getEmployees($request);

        if (is_int($employees)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Unauthorized',
                'data' => []
            ], 401);
        }

        $data['total'] = count($employees);

        $currentDate = date("Y-m-d");

        $company = sys_usuarios_empresas::firstWhere('id_usuario', auth()->user()->id_usuario);

        if (empty($company) || $company['activo'] == 0) {
            return response()->json(['error' => true, 'mensaje' => 'Unauthorize', 'data' => []], 401);
        }

        $company = $company['id_empresa'];

        $totalTrainings = hr_capacitaciones::where('id_empresa', $company)->count();
        $totalTrainingsEmp = 0;

        $data['hombres'] = $data['mujeres'] = [
            'total' => 0,
            'con_hijos' => 0,
            'edades' => ["<25" => 0, "25-35" => 0, "35-49" => 0, "50+" => 0]
        ];

        foreach ($employees as $employee) {

            $totalTrainingsEmp += hr_capacitaciones_empleados::where('id_empleado', $employee->id_empleado)->count();

            $sex = $employee["sexo"];

            $edad = date_diff(date_create($employee["cumpleaños"]), date_create($currentDate))->y;

            $hasChildren = hr_familiares::where('id_empleado', $employee["id_empleado"])->where(function ($query) {
                $query->where('parentesco', 8)
                    ->orWhere('parentesco', 9);
            })->count();

            $data[$sex == 1 ? 'hombres' : 'mujeres']['total']++;

            if ($hasChildren) {
                $data[$sex == 1 ? 'hombres' : 'mujeres']['con_hijos']++;
            }

            if ($edad < 25) {
                $data[$sex == 1 ? 'hombres' : 'mujeres']['edades']["<25"]++;
            } else if ($edad >= 25 && $edad <= 35) {
                $data[$sex == 1 ? 'hombres' : 'mujeres']['edades']["25-35"]++;
            } else if ($edad >= 35 && $edad <= 49) {
                $data[$sex == 1 ? 'hombres' : 'mujeres']['edades']["35-49"]++;
            } else {
                $data[$sex == 1 ? 'hombres' : 'mujeres']['edades']["50+"]++;
            }
        }

        $data['capacitaciones'] =  $totalTrainings > 0 ? $totalTrainingsEmp / ((count($employees) == 0 ? 1 : count($employees)) * $totalTrainings) * 100 : 100;

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $data
        ], 200);
    }

    /**
     * Search for all employyes with Birthday in the given Month
     * 
     * @param Request $request
     * @return array|string 
     */
    public function monthBirthdays(Request $request)
    {
        $data = [];

        $employees = $this->getEmployees($request, 1, true);

        if (is_int($employees)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Unauthorized',
                'data' => []
            ], 401);
        }

        foreach ($employees as $employee) {

            $month = date('m', strtotime($request->date));
            $employeeBDay = date('m', strtotime($employee['cumpleaños']));

            if ($month == $employeeBDay) {
                $user = sys_usuarios::find($employee['id_usuario']);
                $data[] = [
                    'nombre' => $user['nombre'],
                    'apellidoP' => $user['apellidoP'],
                    'apellidoM' => $user['apellidoM'],
                    'unidad' => hr_unidades::where('id_unidad', $employee['id_unidad'])->value('nombre'),
                    'puesto' => hr_puestos::where('id_puesto', $employee['id_puesto'])->value('nombre'),
                    'cumpleaños' => $employee['cumpleaños'],
                    'telefono' => $employee['telefono'],
                    'email' => $user['email']
                ];
            }
        }

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $data
        ], 200);
    }

    /**
     * Delete duplicate objectas and broup them by an attribute
     * 
     * @param array $mainAray
     * @param string $attribute
     * @return array
     */
    public function groupDuplicates($mainAray, $attribute)
    {
        $temp_array = [];

        while (!empty($mainAray)) {
            $temp_object = [];

            foreach ($mainAray as $key => $object) {
                if (empty($temp_object)) {
                    $temp_object = ['total' => 1, $attribute => $object[$attribute]];

                    unset($mainAray[$key]);
                } else if ($object[$attribute] == $temp_object[$attribute]) {
                    $temp_object['total']++;

                    unset($mainAray[$key]);
                }
            }

            array_push($temp_array, $temp_object);
        }

        return $temp_array;
    }

    /**
     * Return All data with ex-employees
     * 
     * @param Request $request
     * @return array|string 
     */
    public function rotations(Request $request)
    {
        $data = [];

        $employees = $this->getEmployees($request, 0);

        if (is_int($employees)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Unauthorized',
                'data' => []
            ], 401);
        }

        $data['hombres'] = 0;
        $data['mujeres'] = 0;

        $data['recontratables'] = 0;
        $data['finiquitos'] = 0;
        $data['firmas'] = 0;
        $data['entrevistas'] = 0;

        $month = date('m', strtotime($request->date));

        $temp_array = [];
        $first = true;

        while (count($employees) != 0) {
            $temp_object = [];

            foreach ($employees as $key => $employee) {

                $hist = hr_historial::where('id_empleado', $employee['id_empleado'])->firstWhere('movimiento', 'B');
                $nomP = hr_puestos::where('id_puesto', $hist['id_puesto'])->value('nombre');
                $nomU = hr_unidades::where('id_unidad', $hist['id_unidad'])->value('nombre');

                $histMonth = date('m', strtotime($hist['fecha']));

                $infoBaja = $hist['infoBaja'];

                if ($month <= $histMonth) {
                    if ($first) {
                        $data[$employee['sexo'] == 0 ? 'mujeres' : 'hombres']++;
                        if ($infoBaja - 8 >= 0) {
                            $data['recontratables']++;
                            $infoBaja -= 8;
                        };
                        if ($infoBaja - 4 >= 0) {
                            $data['finiquitos']++;
                            $infoBaja -= 4;
                        };
                        if ($infoBaja - 2 >= 0) {
                            $data['firmas']++;
                            $infoBaja -= 2;
                        };
                        if ($infoBaja - 1 >= 0) {
                            $data['entrevistas']++;
                            $infoBaja -= 1;
                        };
                    }

                    if (empty($temp_object)) {
                        $temp_object = ['unidad' => $nomU, 'puestos' => [], 'motivos' => []];

                        array_push($temp_object['puestos'], ['total' => 1, 'puesto' => $nomP]);

                        array_push($temp_object['motivos'], ['total' => 1, 'motivo' => $hist['observaciones']]);

                        unset($employees[$key]);
                    } else if ($nomU == $temp_object['unidad']) {

                        array_push($temp_object['puestos'], ['total' => 1, 'puesto' => $nomP]);

                        array_push($temp_object['motivos'], ['total' => 1, 'motivo' => $hist['observaciones']]);

                        unset($employees[$key]);
                    }
                } else {
                    unset($employees[$key]);
                }
            }

            $first = false;

            if (!empty($temp_object)) {
                array_push($temp_array, $temp_object);
            }
        }

        $data['total'] = $data['hombres'] + $data['mujeres'];

        $data['detalles'] = [];

        foreach ($temp_array as $unit) {
            $unit['puestos'] = $this->groupDuplicates($unit['puestos'], 'puesto');

            $unit['motivos'] =  $this->groupDuplicates($unit['motivos'], 'motivo');

            array_push($data['detalles'], $unit);
        }

        if ($data['total'] > 0) {
            $data['recontratables'] /= $data['total'] / 100;
            $data['finiquitos'] /= $data['total'] / 100;
            $data['firmas'] /= $data['total'] / 100;
            $data['entrevistas'] /= $data['total'] / 100;
        }

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $data
        ], 200);
    }

    /**
     * Gives all teh salaries by position and the complete salary investment
     * 
     * @param Request $request
     * @return array|string 
     */
    public function salaries(Request $request)
    {
        $data = [];
        $data['total'] = 0;
        $data['puestos'] = [];

        $employees = $this->getEmployees($request);

        if (is_int($employees)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Unauthorized',
                'data' => []
            ], 401);
        }

        $temp_array = [];

        foreach ($employees as $employee) {
            $data['total'] += $employee['sueldo'] * 7;
            array_push($temp_array, [
                'puesto' => $employee['id_puesto'],
                'unidad' => $employee['id_unidad'],
                'empleados' => 1,
                'salario' => $employee['sueldo']
            ]);
        }

        while (!empty($temp_array)) {
            $temp_object = [];

            foreach ($temp_array as $key => $object) {
                if (empty($temp_object)) {
                    $temp_object = $object;
                    unset($temp_array[$key]);
                } else if ($object['puesto'] == $temp_object['puesto'] && $object['unidad'] == $temp_object['unidad']) {
                    $temp_object['empleados']++;
                    $temp_object['salario'] += $object['salario'];
                    unset($temp_array[$key]);
                }
            }

            $temp_object['salario'] = $temp_object['salario'] / $temp_object['empleados'];
            $temp_object['puesto'] = hr_puestos::where('id_puesto', $temp_object['puesto'])->value('nombre');
            $temp_object['unidad'] = hr_unidades::where('id_unidad', $temp_object['unidad'])->value('nombre');
            array_push($data['puestos'], $temp_object);
        }

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $data
        ], 200);
    }
}
