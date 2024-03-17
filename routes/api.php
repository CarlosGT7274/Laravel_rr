<?php

use App\Models\SYS\sys_roles;
use App\Models\SYS\sys_roles_permisos;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\SimpleCRUDController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\SYS\AuthController;
use App\Http\Controllers\API\SYS\GruposController;
use App\Http\Controllers\API\SYS\RolController;
use App\Http\Controllers\API\SYS\UsuarioController;
use App\Http\Controllers\API\HR\EmpresaController;
use App\Http\Controllers\API\HR\HorariosController;
use App\Http\Controllers\API\HR\EmpleadosController;

use App\Models\ATT\att_empleado;
use App\Models\ATT\att_excepciones;
use App\Models\ATT\att_registros;
use App\Models\ATT\att_template;
use App\Models\ATT\att_terminal;
use App\Models\ATT\att_terminal_emp;
use App\Models\ATT\att_terminal_para;
use App\Models\HR\Company\Employment\hr_departamentos;
use App\Models\HR\Company\Employment\hr_organizacion;
use App\Models\HR\Company\Employment\hr_puestos;
use App\Models\HR\Company\Employment\hr_tipos_empleados;
use App\Models\HR\Company\Employment\hr_unidades;
use App\Models\HR\Company\Employment\hr_unidades_terminales;
use App\Models\HR\Company\General\hr_capacitaciones;
use App\Models\HR\Company\General\hr_codigos_pagos;
use App\Models\HR\Company\General\hr_dias_feriados;
use App\Models\HR\Company\General\hr_politicas_pagos;
use App\Models\HR\Employee\General\hr_empleados;
use App\Models\HR\Employee\Info\hr_documentos;
use App\Models\HR\Employee\Info\hr_familiares;
use App\Models\HR\Employee\Info\hr_imagenes;
use App\Models\SYS\sys_permisos;


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

Route::prefix('v1')->group(function () {
    //? ----------------------------------------------------------------------------
    //? ---------------------------------   api   ---------------------------------
    //? ----------------------------------------------------------------------------

    Route::controller(AuthController::class)->group(function () {

        Route::post('login', 'login');

        Route::post('logout', 'logout');

        Route::post('refresh', 'refresh');

        Route::get('validate', 'validateToken');

        Route::get('me', 'me');

        Route::get('resetToken', 'generateResetToken');

        Route::put('updatePassword', 'updatePassword');
    });

    //* ----------------------------------------------------------------------------
    //* ---------------------------------   SYS   ----------------------------------
    //* ----------------------------------------------------------------------------

    Route::prefix('privileges')->group(function () {
        $controller = new SimpleCRUDController(new sys_permisos);

        Route::get('', function () use ($controller) {
            return $controller->readAll([]);
        });

        Route::get('{id}', function ($id) use ($controller) {
            return $controller->readOne($id, []);
        });

        Route::post('', function (Request $request) use ($controller) {

            $response = $controller->create(
                $request,
                [],
                [
                    'id_permiso' => 'integer | min:0',
                    'nombre' => 'required | string',
                    'padre' => 'integer | exists:sys_permisos,id_permiso',
                    'endpoint' => 'required | string',
                    'activo' => 'integer | between:0,1',
                ]
            );

            foreach (sys_roles::all() as $rol) {
                sys_roles_permisos::create([
                    'id_rol' => $rol['id_rol'],
                    'id_permiso' => $request['id_permiso'],
                    'valor' => -1,
                ]);
            }

            return $response;
        });

        Route::put('{id}', function ($id, Request $request) use ($controller) {
            return $controller->update(
                $id,
                $request,
                [
                    'id_permiso' => 'integer | min:0',
                    'nombre' => 'sometimes | required | string',
                    'padre' => 'integer | exists:sys_permisos,id_permiso',
                    'endpoint' => 'sometimes | required | string',
                    'activo' => 'integer | between:0,1',
                ]
            );
        });

        Route::delete('{id}', function ($id) use ($controller) {
            return $controller->delete($id);
        });
    });

    Route::prefix('rols')->controller(RolController::class)->group(function () {

        Route::post('', 'create');

        Route::put('{id}', 'update');

        Route::delete('{id}', 'delete');

        Route::get('', 'readAll');

        Route::get('{id}', 'readOne');
    });

    Route::prefix('groups')->controller(GruposController::class)->group(function () {

        Route::get('', 'readAll');

        Route::get('{id}', 'readOne');

        Route::post('', 'create');

        Route::put('{id}', 'update');

        Route::delete('{id}', 'delete');

        Route::prefix('{id_group}')->group(function () {

            Route::post('add/{id}', 'addUser');

            Route::delete('remove/{id}', 'removeUser');

            Route::post('message', 'create_msg');

            Route::put('refresh/{id}', 'refresh_msg');

            Route::put('send/{id}', 'send_msg');
        });
    });

    Route::prefix('users')->controller(UsuarioController::class)->group(function () {

        Route::get('', 'readAll');

        Route::get('{id}', 'readOne');

        Route::post('', 'create');

        Route::put('{id}', 'update');

        Route::delete('{id}', 'delete');
    });

    //? ----------------------------------------------------------------------------
    //? ----------------------------------   HR   ----------------------------------
    //? ----------------------------------------------------------------------------

    Route::group(['prefix' => 'companies'], function () {

        Route::controller(EmpresaController::class)->group(function () {

            Route::get('', 'readAll');

            Route::get('{id}', 'readOne');

            Route::post('', 'create');

            Route::put('{id}', 'update');

            Route::delete('{id}', 'delete');
        });

        Route::prefix('{id_company}')->middleware('auth:api')->group(function () {

            Route::prefix('holidays')->group(function () {
                $controller = new SimpleCRUDController(new hr_dias_feriados);

                Route::get('', function ($id_company) use ($controller) {
                    return $controller->readAll(['column' => 'id_empresa', 'value' => $id_company]);
                });

                Route::get('{id}', function ($id_company, $id) use ($controller) {
                    return $controller->readOne($id, ['column' => 'id_empresa', 'value' => $id_company]);
                })->where('id', '[0-9]+');

                Route::get('{name}', function ($id_company, $name) use ($controller) {
                    return $controller->searchByName($name, ['column' => 'id_empresa', 'value' => $id_company]);
                });

                Route::post('', function ($id_company, Request $request) use ($controller) {
                    return $controller->create(
                        $request,
                        ['id_empresa' => $id_company],
                        [
                            'nombre' => 'required | string',
                            'tipo' => 'required | integer | between:0,1',
                            'inicio' => 'required | date | date_format:Y-m-d',
                            'fin' => 'required | date | date_format:Y-m-d'
                        ]
                    );
                });

                Route::put('{id}', function ($id_company, $id, Request $request) use ($controller) {
                    return $controller->update(
                        $id,
                        $request,
                        [
                            'nombre' => 'sometimes | required | string',
                            'tipo' => 'integer | between:0,1',
                            'inicio' => 'date | date_format:Y-m-d',
                            'fin' => 'date | date_format:Y-m-d'
                        ]
                    );
                });

                Route::delete('{id}', function ($id_company, $id) use ($controller) {
                    return $controller->delete($id);
                });
            });

            Route::prefix('trainings')->group(function () {
                $controller = new SimpleCRUDController(new hr_capacitaciones);

                Route::get('', function ($id_company) use ($controller) {
                    return $controller->readAll(['column' => 'id_empresa', 'value' => $id_company]);
                });

                Route::controller(EmpresaController::class)->group(function () {
                    Route::get('{id}', 'readOneTraining')->where('id', '[0-9]+');

                    Route::post('', 'createTraining');

                    Route::put('{id}', 'updateTraining');
                });

                Route::get('{name}', function ($id_company, $name) use ($controller) {
                    return $controller->searchByName($name, ['column' => 'id_empresa', 'value' => $id_company]);
                });

                Route::delete('{id}', function ($id_company, $id) use ($controller) {
                    return $controller->delete($id);
                });
            });

            Route::prefix('employeeTypes')->group(function () {
                $controller = new SimpleCRUDController(new hr_tipos_empleados);

                Route::get('', function ($id_company) use ($controller) {
                    return $controller->readAll(['column' => 'id_empresa', 'value' => $id_company]);
                });

                Route::get('{id}', function ($id_company, $id) use ($controller) {
                    $employees['empleados'] = hr_empleados::select('nombre', 'apellidoP', 'apellidoM')->where('id_tipo_empleado', $id)->join('sys_usuarios', 'sys_usuarios.id_usuario', 'hr_empleados.id_usuario')->get();
                    return $controller->readOne($id, ['column' => 'id_empresa', 'value' => $id_company], false, $employees);
                })->where('id', '[0-9]+');

                Route::get('{name}', function ($id_company, $name) use ($controller) {
                    return $controller->searchByName($name, ['column' => 'id_empresa', 'value' => $id_company]);
                });

                Route::post('', function ($id_company, Request $request) use ($controller) {
                    return $controller->create($request, ['id_empresa' => $id_company], ['nombre' => 'required | string']);
                });

                Route::put('{id}', function ($id_company, $id, Request $request) use ($controller) {
                    return $controller->update($id, $request, ['nombre' => 'sometimes | required | string']);
                });

                Route::delete('{id}', function ($id_company, $id) use ($controller) {
                    return $controller->delete($id);
                });
            });

            Route::prefix('departments')->group(function () {
                $controller = new SimpleCRUDController(new hr_departamentos);

                Route::get('', function ($id_company) use ($controller) {
                    return $controller->readAll(['column' => 'id_empresa', 'value' => $id_company]);
                });

                Route::get('{id}', function ($id_company, $id) use ($controller) {
                    $employees['empleados'] = hr_empleados::select('nombre', 'apellidoP', 'apellidoM')->where('id_departamento', $id)->join('sys_usuarios', 'sys_usuarios.id_usuario', 'hr_empleados.id_usuario')->get();
                    return $controller->readOne($id, ['column' => 'id_empresa', 'value' => $id_company], false, $employees);
                })->where('id', '[0-9]+');

                Route::get('{name}', function ($id_company, $name) use ($controller) {
                    return $controller->searchByName($name, ['column' => 'id_empresa', 'value' => $id_company]);
                });

                Route::post('', function ($id_company, Request $request) use ($controller) {
                    return $controller->create($request, ['id_empresa' => $id_company], ['nombre' => 'required | string']);
                });

                Route::put('{id}', function ($id_company, $id, Request $request) use ($controller) {
                    return $controller->update($id, $request, ['nombre' => 'sometimes | required | string']);
                });

                Route::delete('{id}', function ($id_company, $id) use ($controller) {
                    return $controller->delete($id);
                });
            });

            Route::prefix('positions')->group(function () {
                $controller = new SimpleCRUDController(new hr_puestos);

                Route::get('', function ($id_company) use ($controller) {
                    return $controller->readAll(['column' => 'id_empresa', 'value' => $id_company]);
                });

                Route::get('{id}', function ($id_company, $id) use ($controller) {
                    $employees['empleados'] = hr_empleados::select('nombre', 'apellidoP', 'apellidoM')->where('id_departamento', $id)->join('sys_usuarios', 'sys_usuarios.id_usuario', 'hr_empleados.id_usuario')->get();
                    return $controller->readOne($id, ['column' => 'id_empresa', 'value' => $id_company], false, $employees);
                })->where('id', '[0-9]+');

                Route::get('{name}', function ($id_company, $name) use ($controller) {
                    return $controller->searchByName($name, ['column' => 'id_empresa', 'value' => $id_company]);
                });

                Route::post('', function ($id_company, Request $request) use ($controller) {
                    return $controller->create(
                        $request,
                        ['id_empresa' => $id_company],
                        [
                            'nombre' => 'required | string',
                            'sueldoSug' => 'required | decimal:0,6 | min:0',
                            'sueldoMax' => 'required | decimal:0,6 | min:0',
                            'riesgo' => 'required | integer | between:1,5',
                        ]
                    );
                });

                Route::put('{id}', function ($id_company, $id, Request $request) use ($controller) {
                    return $controller->update(
                        $id,
                        $request,
                        [
                            'nombre' => 'sometimes | required | string',
                            'sueldoSug' => 'sometimes | required | decimal:0,6 | min:0',
                            'sueldoMax' => 'sometimes | required | decimal:0,6 | min:0',
                            'riesgo' => 'sometimes | required | integer | between:1,5',
                        ]
                    );
                });

                Route::delete('{id}', function ($id_company, $id) use ($controller) {
                    return $controller->delete($id);
                });
            });

            Route::prefix('units')->group(function () {
                $controller = new SimpleCRUDController(new hr_unidades);

                Route::get('', function ($id_company)  use ($controller) {
                    return $controller->readAll(['column' => 'id_empresa', 'value' => $id_company]);
                });

                Route::get('{id}', function ($id_company, $id)  use ($controller) {
                    $employees['empleados'] = hr_empleados::select('nombre', 'apellidoP', 'apellidoM')->where('id_unidad', $id)->join('sys_usuarios', 'sys_usuarios.id_usuario', 'hr_empleados.id_usuario')->get();
                    return $controller->readOne($id, ['column' => 'id_empresa', 'value' => $id_company], false, $employees);
                })->where('id', '[0-9]+');

                Route::get('{name}', function ($id_company, $name) use ($controller) {
                    return $controller->searchByName($name, ['column' => 'id_empresa', 'value' => $id_company]);
                });

                Route::post('', function ($id_company, Request $request)  use ($controller) {
                    return $controller->create(
                        $request,
                        ['id_empresa' => $id_company],
                        [
                            'nombre' => 'required | string',
                            'tipo' => 'required | string',
                            'poblacion' => 'required | string',
                            'estado' => 'required | integer | between:1,32',
                            'region' => 'sometimes | required | string',
                        ]
                    );
                });

                Route::put('{id}', function ($id_company, $id, Request $request)  use ($controller) {
                    return $controller->update(
                        $id,
                        $request,
                        [
                            'nombre' => 'sometimes | required | string',
                            'tipo' => 'sometimes | required | string',
                            'poblacion' => 'sometimes | required | string',
                            'estado' => 'integer | between:1,32',
                            'region' => 'sometimes | required | string',
                        ]
                    );
                });

                Route::delete('{id}', function ($id_company, $id)  use ($controller) {
                    return $controller->delete($id);
                });

                Route::post('{id}', function ($id_company, $id, Request $request) {
                    $controller = new SimpleCRUDController(new hr_unidades_terminales);
                    return $controller->create(
                        $request,
                        ['id_unidad' => $id],
                        ['terminal_id' => 'required | integer | min:0 | exists:att_terminal,terminal_id']
                    );
                });
            });

            Route::prefix('tree')->group(function () {
                $controller = new SimpleCRUDController(new hr_organizacion);

                Route::get('', function ($id_company) use ($controller) {
                    return $controller->readAll(['column' => 'id_empresa', 'value' => $id_company]);
                });

                Route::get('{id}', function ($id_company, $id) use ($controller) {
                    return $controller->readOne($id, ['column' => 'id_empresa', 'value' => $id_company]);
                });

                Route::post('', function ($id_company, Request $request) use ($controller) {
                    return $controller->create(
                        $request,
                        ['id_empresa' => $id_company],
                        [
                            'key' => 'required | string',
                            'parent_key' => 'required | string',
                            'id_departamento' => ['required', 'integer', 'min:1', Rule::exists('hr_departamentos')->where('id_empresa', $id_company)],
                            'id_puesto' => ['required', 'integer', 'min:1', Rule::exists('hr_puestos')->where('id_empresa', $id_company)],
                        ]
                    );
                });

                Route::put('{id}', function ($id_company, $id, Request $request) use ($controller) {
                    return $controller->update(
                        $id,
                        $request,
                        [
                            'key' => 'sometimes | required | string',
                            'parent_key' => 'sometimes | required | string',
                            'id_departamento' => ['integer', 'min:1', Rule::exists('hr_departamentos')->where('id_empresa', $id_company)],
                            'id_puesto' => ['integer', 'min:1', Rule::exists('hr_puestos')->where('id_empresa', $id_company)],
                        ]
                    );
                });

                Route::delete('{id}', function ($id_company, $id) use ($controller) {
                    return $controller->delete($id);
                });
            });

            Route::prefix('schedules')->controller(HorariosController::class)->group(function () {

                Route::get('', 'readAll');

                Route::get('{id}', 'readOne');

                Route::post('', 'create');

                Route::delete('{id}', 'delete');

                Route::put('{id}', 'update');
            });

            Route::prefix('payCodes')->group(function () {
                $controller = new SimpleCRUDController(new hr_codigos_pagos);

                Route::get('', function ($id_company) use ($controller) {
                    return $controller->readAll(['column' => 'id_empresa', 'value' => $id_company]);
                });

                Route::get('{id}', function ($id_company, $id) use ($controller) {
                    $extraInfo['politics'] = hr_politicas_pagos::select('id_politica_pago', 'nombre')->where('id_codigo_pago', $id)->get();
                    return $controller->readOne($id, ['column' => 'id_empresa', 'value' => $id_company], false, $extraInfo);
                });

                Route::post('', function ($id_company, Request $request) use ($controller) {
                    return $controller->create(
                        $request,
                        ['id_empresa' => $id_company],
                        [
                            'descripcion' => 'required | string',
                            'codexport' => 'required | string',
                            'siglas' => 'required | string',
                            'tipo' => 'required | integer | between:-1,1',
                        ]
                    );
                });

                Route::put('{id}', function ($id_company, $id, Request $request) use ($controller) {
                    return $controller->update(
                        $id,
                        $request,
                        [
                            'descripcion' => 'sometimes | required | string',
                            'codexport' => 'sometimes | required | string',
                            'siglas' => 'sometimes | required | string',
                            'tipo' => 'integer | between:-1,1',
                        ]
                    );
                });

                Route::delete('{id}', function ($id_company, $id) use ($controller) {
                    return $controller->delete($id);
                });
            });

            Route::prefix('payPolitics')->group(function () {
                $controller = new SimpleCRUDController(new hr_politicas_pagos);

                Route::get('', function ($id_company) use ($controller) {
                    return $controller->readAll(['column' => 'id_empresa', 'value' => $id_company]);
                });

                Route::get('{id}', function ($id_company, $id) use ($controller) {
                    return $controller->readOne($id, ['column' => 'id_empresa', 'value' => $id_company]);
                })->where('id', '[0-9]+');

                Route::get('{name}', function ($id_company, $name) use ($controller) {
                    return $controller->searchByName($name, ['column' => 'id_empresa', 'value' => $id_company]);
                });

                Route::post('', function ($id_company, Request $request) use ($controller) {
                    return $controller->create(
                        $request,
                        ['id_empresa' => $id_company],
                        [
                            'nombre' => 'required | string',
                            'activo' => 'required | integer | between:0,1',
                            'pagaFeriados' => 'required | integer | between:0,1',
                            'pagaExtras' => 'required | integer | between:0,1'
                        ]
                    );
                });

                Route::put('{id}', function ($id_company, $id, Request $request) use ($controller) {
                    return $controller->update(
                        $id,
                        $request,
                        [
                            'nombre' => 'sometimes | required | string',
                            'activo' => 'integer | between:0,1',
                            'pagaFeriados' => 'integer | between:0,1',
                            'pagaExtras' => 'integer | between:0,1'
                        ]
                    );
                });

                Route::delete('{id}', function ($id_company, $id) use ($controller) {
                    return $controller->delete($id);
                });
            });

            Route::controller(EmpresaController::class)->group(function () {
                Route::get('employees', 'employees');

                Route::get('reportAttendance', 'asistenciasReport');

                Route::get('reportIncidencies', 'reportIncidencias');

                Route::get('reportVacations', 'reportvacaciones');

                Route::get('reportResignations', 'reportFiredPeople');

                Route::get('reportTerminals', 'reportBiometrics');

                Route::get('reportDelays', 'reportDelays');
            });
        });
    });

    Route::prefix('employees')->group(function () {

        Route::controller(EmpleadosController::class)->group(function () {
            Route::get('', 'readAll');

            Route::get('{id}', 'readOne')->where('id', '[0-9]+');

            Route::get('{name}', 'search');

            Route::post('', 'create');

            Route::put('{id}', 'update');

            Route::delete('{id}', 'delete');
        });

        Route::prefix('{id_employee}')->middleware('auth:api')->group(function () {

            Route::controller(EmpleadosController::class)->group(function () {
                Route::post('training', 'training');

                Route::put('updateHolidays', 'updatev');

                Route::post('youAreFired', 'youarefired');

                Route::post('changePosition', 'cambios_hist');

                Route::prefix('incidencies')->group(function () {

                    Route::get('', 'readAll_in');

                    Route::get('{id}', 'readOne_in');

                    Route::post('', 'create_in');

                    Route::put('{id}', 'update_in');

                    Route::delete('{id}', 'delete_in');
                });
            });

            Route::prefix('documents')->group(function () {
                $controller = new SimpleCRUDController(new hr_documentos);

                Route::get('', function ($id_employee) use ($controller) {
                    return $controller->readAll(['column' => 'id_empleado', 'value' => $id_employee], true);
                });

                Route::get('{id}', function ($id_employee, $id) use ($controller) {
                    return $controller->readOne($id, ['column' => 'id_empleado', 'value' => $id_employee], true);
                });

                Route::post('', function (Request $request, $id_employee) use ($controller) {
                    return $controller->create(
                        $request,
                        ['id_empleado' => $id_employee],
                        [
                            'nombre' => 'required | string',
                            'tipo' => 'required | integer | min:0',
                            'info' => 'required | string'
                        ],
                        true
                    );
                });

                Route::put('{id}', function ($id_employee, $id, Request $request) use ($controller) {
                    return $controller->update(
                        $id,
                        $request,
                        [
                            'nombre' => 'sometimes | required | string',
                            'tipo' => 'integer | required_with:info | min:0',
                            'info' => 'sometimes | required | string'
                        ],
                        true
                    );
                });

                Route::delete('{id}', function ($id_employee, $id) use ($controller) {
                    return $controller->delete($id);
                });
            });

            Route::prefix('images')->group(function () {
                $controller = new SimpleCRUDController(new hr_imagenes);

                Route::get('', function ($id_employee) use ($controller) {
                    return $controller->readAll(['column' => 'id_empleado', 'value' => $id_employee], true);
                });

                Route::get('{id}', function ($id_employee, $id) use ($controller) {
                    return $controller->readOne($id, ['column' => 'id_empleado', 'value' => $id_employee], true);
                });

                Route::post('', function (Request $request, $id_employee) use ($controller) {
                    return $controller->create(
                        $request,
                        ['id_empleado' => $id_employee],
                        ['info' => 'required | string'],
                        true
                    );
                });

                Route::put('{id}', function ($id_employee, $id, Request $request) use ($controller) {
                    return $controller->update(
                        $id,
                        $request,
                        ['info' => 'sometimes | required | string'],
                        true
                    );
                });

                Route::delete('{id}', function ($id_employee, $id) use ($controller) {
                    return $controller->delete($id);
                });
            });

            Route::prefix('relatives')->group(function () {
                $controller = new SimpleCRUDController(new hr_familiares);

                Route::get('', function ($id_employee) use ($controller) {
                    return $controller->readAll(['column' => 'id_empleado', 'value' => $id_employee], true);
                });

                Route::get('{id}', function ($id_employee, $id) use ($controller) {
                    return $controller->readOne($id, ['column' => 'id_empleado', 'value' => $id_employee], true);
                });

                Route::post('', function (Request $request, $id_employee) use ($controller) {
                    return $controller->create(
                        $request,
                        ['id_empleado' => $id_employee],
                        [
                            'nombre' => 'required | string | max:40',
                            'apellidoP' => 'required | string | max:20',
                            'apellidoM' => 'required | string | max:20',
                            'parentesco' => 'required | integer | min:0',
                            'telefono' => 'required | string | size:10',
                            'telefono2' => 'nullable | sometimes | string | size:10',
                        ],
                        true
                    );
                });

                Route::put('{id}', function ($id_employee, $id, Request $request) use ($controller) {
                    return $controller->update(
                        $id,
                        $request,
                        [
                            'nombre' => 'sometimes | required | string | max:40',
                            'apellidoP' => 'sometimes | required | string | max:20',
                            'apellidoM' => 'sometimes | required | string | max:20',
                            'parentesco' => 'integer | min:1',
                            'telefono' => 'sometimes | required | string | size:10',
                            'telefono2' => 'sometimes | required | string | size:10',
                        ],
                        true
                    );
                });

                Route::delete('{id}', function ($id_employee, $id) use ($controller) {
                    return $controller->delete($id);
                });
            });
        });
    });

    //* ----------------------------------------------------------------------------
    //* ---------------------------------   ATT   ----------------------------------
    //* ----------------------------------------------------------------------------

    Route::prefix('biometrics')->middleware('auth:api')->group(function () {

        Route::prefix('terminals')->group(function () {
            $controller = new SimpleCRUDController(new att_terminal);

            Route::get('', function () use ($controller) {
                return $controller->readAll([]);
            });

            Route::get('{id}', function ($id) use ($controller) {
                return $controller->readOne($id, []);
            });

            Route::post('', function (Request $request) use ($controller) {
                return $controller->create(
                    $request,
                    [],
                    [
                        'terminal_id' => 'required | integer | min:0',
                        'teminal_no' => 'required | integer | min:0',
                        'terminal_status' => 'required | integer | min:0',
                        'terminal_name' => 'required | string',
                        'terminal_location' => 'required | string',
                        'termnal_conecttype' => 'required | integer | min:0',
                        'terminal_conectpwd' => 'required | string',
                        'terminal_domainname' => 'required | string',
                        'terminal_tcpip' => 'required | string',
                        'terminal_port' => 'required | integer | min:0',
                        'terminal_serial' => 'required | string',
                        'terminal_baudrate' => 'required | integer | min:0',
                        'terminal_type' => 'required | string',
                        'terminal_users' => 'required | integer | min:0',
                        'terminal_fingerprints' => 'required | integer | min:0',
                        'terminal_punches' => 'required | integer | min:0',
                        'terminal_faces' => 'required | integer | min:0',
                        'terminal_zem' => 'required | string',
                        'terminal_kind' => 'required | integer | min:0',
                        'IsSelect' => 'required | integer | min:0',
                        'terminal_timechk' => 'required | integer | min:0',
                        'terminal_lastchk' => 'required | date | date_format:Y-m-d H:i:s',
                    ]
                );
            });

            Route::put('{id}', function ($id, Request $request) use ($controller) {
                return $controller->update(
                    $id,
                    $request,
                    [
                        'terminal_id' => 'integer | min:0',
                        'teminal_no' => 'integer | min:0',
                        'terminal_status' => 'integer | min:0',
                        'terminal_name' => 'sometimes | required | string',
                        'terminal_location' => 'sometimes | required | string',
                        'termnal_conecttype' => 'integer | min:0',
                        'terminal_conectpwd' => 'sometimes | required | string',
                        'terminal_domainname' => 'sometimes | required | string',
                        'terminal_tcpip' => 'sometimes | required | string',
                        'terminal_port' => 'integer | min:0',
                        'terminal_serial' => 'sometimes | required | string',
                        'terminal_baudrate' => 'integer | min:0',
                        'terminal_type' => 'sometimes | required | string',
                        'terminal_users' => 'integer | min:0',
                        'terminal_fingerprints' => 'integer | min:0',
                        'terminal_punches' => 'integer | min:0',
                        'terminal_faces' => 'integer | min:0',
                        'terminal_zem' => 'sometimes | required | string',
                        'terminal_kind' => 'integer | min:0',
                        'IsSelect' => 'integer | min:0',
                        'terminal_timechk' => 'integer | min:0',
                        'terminal_lastchk' => 'date | date_format:Y-m-d H:i:s',
                    ]
                );
            });

            Route::delete('{id}', function ($id) use ($controller) {
                return $controller->delete($id);
            });

            Route::prefix('{id_terminal}')->group(function () {

                Route::prefix('parameters')->group(function () {
                    $controller = new SimpleCRUDController(new att_terminal_para);

                    Route::get('', function ($id_terminal) use ($controller) {
                        return $controller->readAll(['column' => 'terminal_id', 'value' => $id_terminal]);
                    });

                    Route::get('{id}', function ($id_terminal, $id) use ($controller) {
                        return $controller->readOne($id, ['column' => 'terminal_id', 'value' => $id_terminal]);
                    });

                    Route::post('', function ($id_terminal, Request $request) use ($controller) {
                        return $controller->create(
                            $request,
                            ['terminal_id' => $id_terminal],
                            [
                                'para_id' => 'required | integer | min:0',
                                'parameter_name' => 'required | string',
                                'parameter_value' => 'required | string',
                                'infoid' => 'required | integer | min:0',
                            ]
                        );
                    });

                    Route::put('{id}', function ($id_terminal, $id, Request $request) use ($controller) {
                        return $controller->update(
                            $id,
                            $request,
                            [
                                'para_id' => 'integer | min:0',
                                'parameter_name' => 'sometimes | required | string',
                                'parameter_value' => 'sometimes | required | string',
                                'infoid' => 'integer | min:0',
                            ]
                        );
                    });

                    Route::delete('{id}', function ($id_terminal, $id) use ($controller) {
                        return $controller->delete($id);
                    });
                });

                Route::prefix('employees')->group(function () {
                    $controller = new SimpleCRUDController(new att_terminal_emp);

                    Route::get('', function ($id_terminal) use ($controller) {
                        return $controller->readAll(['column' => 'terminal_serial', 'value' => $id_terminal]);
                    });

                    Route::get('{id}', function ($id_terminal, $id) use ($controller) {
                        return $controller->readOne($id, ['column' => 'terminal_serial', 'value' => $id_terminal]);
                    });

                    Route::post('', function ($id_terminal, Request $request) use ($controller) {
                        return $controller->create(
                            $request,
                            ['terminal_serial' => $id_terminal],
                            [
                                'emp_pin' => 'required | integer | min:0 | exists:att_empleado,emp_pin',
                                'emp_status' => 'required | integer | min:0',
                                'last_sync' => 'required | date | date_format:Y-m-d H:i:s',
                                'Isdone' => 'required | integer | min:0',
                                'IsSelect' => 'required | integer | min:0',
                            ]
                        );
                    });

                    Route::put('{id}', function ($id_terminal, $id, Request $request) use ($controller) {
                        return $controller->update(
                            $id,
                            $request,
                            [
                                'emp_pin' => 'integer | min:0 | exists:att_empleado,emp_pin',
                                'emp_status' => 'integer | min:0',
                                'last_sync' => 'date | date_format:Y-m-d H:i:s',
                                'Isdone' => 'integer | min:0',
                                'IsSelect' => 'integer | min:0',
                            ]
                        );
                    });

                    Route::delete('{id}', function ($id_terminal, $id) use ($controller) {
                        return $controller->delete($id);
                    });
                });
            });
        });

        Route::prefix('employees')->group(function () {
            $controller = new SimpleCRUDController(new att_empleado);

            Route::get('', function () use ($controller) {
                return $controller->readAll([]);
            });

            Route::get('{id}', function ($id) use ($controller) {
                return $controller->readOne($id, []);
            });

            Route::post('', function (Request $request) use ($controller) {
                return $controller->create(
                    $request,
                    [],
                    [
                        'emp_pin' => 'required | integer | min:0',
                        'emp_code' => 'required | string',
                        'emp_role' => 'required | string',
                        'emp_firstname' => 'required | string',
                        'emp_lastname' => 'required | string',
                        'emp_username' => 'required | string',
                        'emp_pwd' => 'required | string',
                        'emp_privilege' => 'required | string',
                        'emp_group' => 'required | string',
                        'emp_active' => 'required | integer | min:0',
                        'emp_cardNumber' => 'required | string',
                        'IsSelect' => 'required | integer | min:0',
                    ]
                );
            });

            Route::put('{id}', function ($id, Request $request) use ($controller) {
                return $controller->update(
                    $id,
                    $request,
                    [
                        'emp_pin' => 'integer | min:0',
                        'emp_code' => 'sometimes | required | string',
                        'emp_role' => 'sometimes | required | string',
                        'emp_firstname' => 'sometimes | required | string',
                        'emp_lastname' => 'sometimes | required | string',
                        'emp_username' => 'sometimes | required | string',
                        'emp_pwd' => 'sometimes | required | string',
                        'emp_privilege' => 'sometimes | required | string',
                        'emp_group' => 'sometimes | required | string',
                        'emp_active' => 'integer | min:0',
                        'emp_cardNumber' => 'sometimes | required | string',
                        'IsSelect' => 'integer | min:0',
                    ]
                );
            });

            Route::delete('{id}', function ($id) use ($controller) {
                return $controller->delete($id);
            });

            Route::prefix('{id_emp}/templates')->group(function () {
                $controller = new SimpleCRUDController(new att_template);

                Route::get('', function ($id_emp) use ($controller) {
                    return $controller->readAll(['column' => 'emp_id', 'value' => $id_emp]);
                });

                Route::get('{id}', function ($id_emp, $id) use ($controller) {
                    return $controller->readOne($id, ['column' => 'emp_id', 'value' => $id_emp]);
                });

                Route::post('', function ($id_emp, Request $request) use ($controller) {
                    return $controller->create(
                        $request,
                        ['emp_id' => $id_emp],
                        [
                            'finger_id' => 'required | integer | min:0',
                            'effective' => 'required | integer | min:0',
                            'template_type' => 'required | integer | min:0',
                            'template_len' => 'required | integer | min:0',
                            'template_str' => 'required | string',
                            'template_obj' => 'required | string',
                            'template_remark' => 'required | string',
                        ]
                    );
                });

                Route::put('{id}', function ($id_emp, $id, Request $request) use ($controller) {
                    return $controller->update(
                        $id,
                        $request,
                        [
                            'finger_id' => 'integer | min:0',
                            'effective' => 'integer | min:0',
                            'template_type' => 'integer | min:0',
                            'template_len' => 'integer | min:0',
                            'template_str' => 'sometimes | required | string',
                            'template_obj' => 'sometimes | required | string',
                            'template_remark' => 'sometimes | required | string',
                        ]
                    );
                });

                Route::delete('{id}', function ($id_emp, $id) use ($controller) {
                    return $controller->delete($id);
                });
            });
        });

        Route::prefix('registers')->group(function () {
            $controller = new SimpleCRUDController(new att_registros);

            Route::get('', function () use ($controller) {
                return $controller->readAll([]);
            });

            Route::get('{id}', function ($id) use ($controller) {
                return $controller->readOne($id, []);
            });

            Route::post('', function (Request $request) use ($controller) {
                return $controller->create(
                    $request,
                    [],
                    [
                        'emp_id' => 'required | integer | min:0 | exists:att_empleado,emp_id',
                        'punch_time' => 'required | date | date_format:Y-m-d H:i:s',
                        'workcode' => 'required | string',
                        'workstate' => 'required | string',
                        'terminal_id' => 'required | integer | min:0 | exists:att_terminal,terminal_id',
                        'punch_type' => 'required | string',
                        'operator' => 'required | string',
                        'operator_reason' => 'required | string',
                        'operator_time' => 'required | date | date_format:Y-m-d H:i:s',
                        'IsSelect' => 'required | integer | min:0',
                    ]
                );
            });

            Route::put('{id}', function ($id, Request $request) use ($controller) {
                return $controller->update(
                    $id,
                    $request,
                    [
                        'emp_id' => 'integer | min:0 | exists:att_empleado,emp_id',
                        'punch_time' => 'date | date_format:Y-m-d H:i:s',
                        'workcode' => 'sometimes | required | string',
                        'workstate' => 'sometimes | required | string',
                        'terminal_id' => 'integer | min:0 | exists:att_terminal,terminal_id',
                        'punch_type' => 'sometimes | required | string',
                        'operator' => 'sometimes | required | string',
                        'operator_reason' => 'sometimes | required | string',
                        'operator_time' => 'date | date_format:Y-m-d H:i:s',
                        'IsSelect' => 'integer | min:0',
                    ]
                );
            });

            Route::delete('{id}', function ($id) use ($controller) {
                return $controller->delete($id);
            });
        });

        Route::prefix('exceptions')->group(function () {
            $controller = new SimpleCRUDController(new att_excepciones);

            Route::get('', function () use ($controller) {
                return $controller->readAll([]);
            });

            Route::get('{id}', function ($id) use ($controller) {
                return $controller->readOne($id, []);
            });

            Route::post('', function (Request $request) use ($controller) {
                return $controller->create(
                    $request,
                    [],
                    [
                        'fecha_excep' => 'required | date | date_format:Y-m-d H:i:s',
                        'tiempoini' => 'required | date | date_format:Y-m-d H:i:s',
                        'tiempofin' => 'required | date | date_format:Y-m-d H:i:s',
                        'observacion' => 'required | string',
                        'id_codpago' => 'required | integer | min:0 | exists:hr_codigos_pagos,id_codigo_pago',
                        'id_trabajador' => 'required | integer | min:0 | exists:hr_empleados,id_empleado',
                    ]
                );
            });

            Route::put('{id}', function ($id, Request $request) use ($controller) {
                return $controller->update(
                    $id,
                    $request,
                    [
                        'fecha_excep' => 'date | date_format:Y-m-d H:i:s',
                        'tiempoini' => 'date | date_format:Y-m-d H:i:s',
                        'tiempofin' => 'date | date_format:Y-m-d H:i:s',
                        'observacion' => 'sometimes | required | string',
                        'id_codpago' => 'integer | min:0 | exists:hr_codigos_pagos,id_codigo_pago',
                        'id_trabajador' => 'integer | min:0 | exists:hr_empleados,id_empleado',
                    ]
                );
            });

            Route::delete('{id}', function ($id) use ($controller) {
                return $controller->delete($id);
            });
        });
    });

    //? ----------------------------------------------------------------------------
    //? ------------------------------   DASHBOARD   -------------------------------
    //? ----------------------------------------------------------------------------

    Route::prefix('dashboard')->controller(DashboardController::class)->group(function () {

        Route::get('general', 'general');

        Route::get('attendance', 'attendance');

        Route::get('birthdays', 'monthBirthdays');

        Route::get('salaries', 'salaries');

        Route::get('rotations', 'rotations');
    });
});
