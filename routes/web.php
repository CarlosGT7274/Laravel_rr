<?php

use App\Http\Controllers\Pages\CompanyController;
use App\Http\Controllers\Pages\EmployeeController;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Pages\RegistersController;
use App\Http\Controllers\Pages\ReportesController;
use App\Http\Controllers\Pages\SessionController;
use App\Http\Controllers\Pages\systemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
|-------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
*/

/**
 * Create a new controller instance whit all the routes necessary.
 *
 * @param string $prefix Route prefix for all endpoints
 * @param string $uri_prefix API endpoint for the request
 * @param array | string $extraId Extra Id for the API endpoint
 * @param string $uri_suffix API endpoint for the request
 * @param string $url_name Base name for all the endpoints 
 * @param string $title Page title 
 * @param string $id_name Name id after the id_ in the data base
 * @param string $form_title Title for the creation form
 * @param array $validation_rules Rules for the request validation
 * @param array $changes Changes should perform to the request for the API 
 * @return void
 */
function SimpleRoutes($prefix, $uri_prefix, $extraId, $uri_suffix, $url_name, $title, $id_name, $form_title, $validation_rules, $changes = [], $employeesForForm = false)
{
    Route::prefix($prefix)->group(function () use ($uri_prefix, $extraId, $uri_suffix, $url_name, $title, $id_name, $form_title, $validation_rules, $changes, $employeesForForm, $prefix) {

        $controller = new CompanyController($prefix, $uri_prefix, $extraId, $uri_suffix, $title, $url_name, $id_name);

        Route::get('', function () use ($controller) {
            return $controller->getAll();
        })->name($url_name . '.all');

        Route::get('{id}', function ($id) use ($controller) {
            return $controller->getOne($id);
        })->where('id', '[0-9]+')->name($url_name . '.one');

        Route::get('search', function (Request $request) use ($controller) {
            return $controller->search($request);
        })->name($url_name . '.search');

        Route::get('create', function () use ($controller, $form_title, $employeesForForm) {
            return $controller->form($form_title, $employeesForForm);
        })->name($url_name . '.form');

        Route::post('create', function (Request $request) use ($controller, $validation_rules, $changes) {
            return $controller->create($request, $validation_rules, $changes);
        })->name($url_name . '.submit');

        Route::put('{id}', function ($id, Request $request) use ($controller, $validation_rules, $changes) {
            return $controller->update($id, $request, $validation_rules, $changes);
        })->where('id', '[0-9]+')->name($url_name . '.update');

        Route::delete('{id}', function ($id) use ($controller) {
            return $controller->delete($id);
        })->where('id', '[0-9]+')->name($url_name . '.delete');
    });
}

/**
 * Create a new controller instance whit all the routes necessary.
 *
 * @param string $father_route Route of the father for all endpoints
 * @param string $endpoint Route endpoint after father id for all Routes
 * @param string $uri_prefix API endpoint for the request
 * @param array | string $extraId Extra Id for the API endpoint
 * @param string $uri_suffix API endpoint for the request
 * @param string $url_name Base name for all the endpoints 
 * @param string $title Page title 
 * @param string $id_name Name id after the id_ in the data base
 * @param string $form_title Title for the creation form
 * @param array $validation_rules Rules for the request validation
 * @param array $changes Changes should perform to the request for the API 
 * @return void
 */
function ChildRoutes($father_prefix, $father_route, $endpoint, $uri_prefix, $extraId, $uri_suffix, $url_name, $title, $id_name, $form_title, $validation_rules, $changes = [], $employeesForForm = false)
{
    Route::prefix($father_prefix)->group(function () use ($father_route, $endpoint, $uri_prefix, $extraId, $uri_suffix, $url_name, $title, $id_name, $form_title, $validation_rules, $changes, $employeesForForm) {
        $controller = new CompanyController($endpoint, $uri_prefix, $extraId, $uri_suffix, $title, $url_name, $id_name, $father_route);

        Route::get('{father_id}/' . $endpoint . '/{id}', function ($father_id, $id) use ($controller) {
            return $controller->getOne($id, false, $father_id);
        })->where('id', '[0-9]+')->name($url_name . '.one');

        Route::get('{father_id}/' . $endpoint . '/create', function ($father_id) use ($controller, $form_title, $employeesForForm) {
            return $controller->form($form_title, $employeesForForm, $father_id);
        })->name($url_name . '.form');

        Route::post('{father_id}/' . $endpoint . '/create', function ($father_id, Request $request) use ($controller, $validation_rules, $changes) {
            return $controller->create(
                $request,
                $validation_rules,
                $changes,
                $father_id
            );
        })->name($url_name . '.submit');

        Route::put('{father_id}/' . $endpoint . '/{id}', function ($father_id, $id, Request $request) use ($controller, $validation_rules, $changes) {
            return $controller->update(
                $id,
                $request,
                $validation_rules,
                $changes,
                $father_id
            );
        })->where('id', '[0-9]+')->name($url_name . '.update');

        Route::delete('{father_id}/' . $endpoint . '/{id}', function ($father_id, $id) use ($controller) {
            return $controller->delete($id, $father_id);
        })->where('id', '[0-9]+')->name($url_name . '.delete');
    });
}

Route::middleware('needToken')->get('getFile/{file_name}', function($file_name) {
        $filePath = storage_path('app/public/files/' . $file_name);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return response()->json([
                'error' => 'El archivo no existe',
                'file_name' => $file_name,
                'file_p' => $filePath,
            ], 404);
        }
})->name('file');

//* ---------------------------------------------------------------------------------
//* ----------------------------  Rutas para Sesión  ----------------------------
//* ---------------------------------------------------------------------------------
Route::controller(SessionController::class)->group(function () {
    Route::get('login', 'login')->name('login.form');

    Route::post('login', 'submit')->name('login.submit');

    Route::get('resetPassword', 'getEmail')->name('resetPassword.form');
    
    Route::post('resetPassword', 'sendToken')->name('resetPassword.submit');

    Route::get('changePassword', 'changePassword')->name('changePassword.form');

    Route::post('changePassword', 'updatePassword')->name('changePassword.submit');
    
    Route::get('logout', 'logout')->name('logout');
});
//* ---------------------------------------------------------------------------------

//? ---------------------------------------------------------------------------------
//? ----------------------------  Rutas para Home  ----------------------------
//? ---------------------------------------------------------------------------------
Route::middleware('needToken')->controller(HomeController::class)->group(function () {
    Route::get('/', 'home')->name('home');

    Route::get('/dashboard', 'dashboard')->name('dashboard.show');

    Route::post('/dashboard', 'graph')->name('attendance.graph');
});
//? ---------------------------------------------------------------------------------

Route::middleware('needToken')->group(function () {

    SimpleRoutes(
        'usuarios',
        'users',
        '',
        '',
        'system.users',
        'Usuarios',
        'usuario',
        'un Usuario',
        [
            'correo' => 'required | string | email',
            'contraseña' => 'sometimes | string',
            'nombre' => 'required | string',
            'apellido_paterno' => 'required | string',
            'apellido_materno' => 'required | string',
            'rol' => 'required | integer | min:1 | exists:sys_roles,id_rol',
            'empresa' => 'integer | min:1 | excludeIf:rol,1 | exists:hr_empresas,id_empresa'
        ],
        [
            'correo' => 'email',
            'contraseña' => 'password',
            'apellido_paterno' => 'apellidoP',
            'apellido_materno' => 'apellidoM',
            'rol' => 'id_rol',
            'empresa' => 'id_empresa',
            'id_rol' => 'int',
            'id_empresa' => 'int',
            'activo' => 'int'
        ]
    );

    SimpleRoutes(
        'departamentos',
        'companies',
        'company',
        'departments',
        'company.departments',
        'Departamentos',
        'departamento',
        'un Departamento',
        [
            'nombre' => 'required | string | between:0,40'
        ]
    );

    SimpleRoutes(
        'tipos-empleados',
        'companies',
        'company',
        'employeeTypes',
        'company.employees-types',
        'Tipos de Empleados',
        'tipo_empleado',
        'un Tipo de Empleado',
        [
            'nombre' => 'required | string | between:0,40'
        ]
    );

    SimpleRoutes(
        'unidades',
        'companies',
        'company',
        'units',
        'company.units',
        'Unidades',
        'unidad',
        'una Unidad',
        [
            'nombre' => 'required | string',
            'tipo' => 'required | string',
            'población' => 'required | string',
            'estado' => 'required | integer | between:1,32',
            'región' => 'sometimes | required | string',
        ],
        [
            'población' => 'poblacion',
            'región' => 'region',
            'estado' => 'int'
        ]
    );

    SimpleRoutes(
        'puestos',
        'companies',
        'company',
        'positions',
        'company.positions',
        'Puestos',
        'puesto',
        'un Puesto',
        [
            'nombre' => 'required | string',
            'sueldo_sugerido' => 'required | decimal:0,6 | min:0',
            'sueldo_máximo' => 'required | decimal:0,6 | min:0',
            'clave' => 'required | integer | between:1,5',
        ],
        [
            'sueldo_sugerido' => 'sueldoSug',
            'sueldo_máximo' => 'sueldoMax',
            'sueldoSug' => 'float',
            'sueldoMax' => 'float',
            'clave' => 'riesgo'
        ]
    );

    SimpleRoutes(
        'dias-feriados',
        'companies',
        'company',
        'holidays',
        'company.holidays',
        'Días Feriados',
        'dia_feriado',
        'un Día Feriado',
        [
            'nombre' => 'required | string',
            'tipo' => 'required | integer | between:0,1',
            'inicio' => 'required | date | date_format:Y-m-d',
            'fin' => 'required | date | after_or_equal:inicio',
        ],
        [
            'tipo' => 'int'
        ]
    );

    SimpleRoutes(
        'codigos-de-pago',
        'companies',
        'company',
        'payCodes',
        'company.pay-codes',
        'Códigos de Pago',
        'codigo_pago',
        'un Código de Pago',
        [
            'descripción' => 'required | string',
            'número_de_percepción' => 'required | string',
            'abreviatura' => 'required | string',
            'tipo' => 'required | integer | between:-1,1',
        ],
        [
            'tipo' => 'int',
            'descripción' => 'descripcion',
            'número_de_percepción' => 'codexport',
            'abreviatura' => 'siglas'
        ]
    );

    SimpleRoutes(
        'politicas-de-pago',
        'companies',
        'company',
        'payPolitics',
        'company.pay-politics',
        'Políticas de Pago',
        'politica_pago',
        'una Política de Pago',
        [
            'nombre' => 'required | string',
            'activo' => 'required | integer | between:0,1',
            'paga_días_feriados' => 'required | integer | between:0,1',
            'paga_horas_extras' => 'required | integer | between:0,1'
        ],
        [
            'paga_días_feriados' => 'pagaFeriados',
            'paga_horas_extras' => 'pagaExtras',
            'pagaFeriados' => 'int',
            'pagaExtras' => 'int',
            'activo' => 'int'
        ]
    );

    SimpleRoutes(
        'horarios',
        'companies',
        'company',
        'schedules',
        'company.schedules',
        'Horarios',
        'horario',
        'un Horario',
        [
            'descripción' => 'required | string',
            'incluye_hora_de_comida' => 'required | integer | between:0,1',
            'estado' => 'required | integer | between:0,1',
            'detalles' => 'required | array | size:7',
            'detalles.*.día' => 'required | integer | between:1,7',
            'detalles.*.inicio' => 'required | date_format:H:i:s',
            'detalles.*.fin' => 'required | date_format:H:i:s',
            'detalles.*.toleranciaIn' => 'integer | min:0',
            'detalles.*.toleranciaFin' => 'integer | min:0',
            'detalles.*.tipo' => 'required | integer | between:0,1'
        ],
        [
            'descripción' => 'descripcion',
            'incluye_hora_de_comida' => 'conComida',
            'día' => 'dia',
            'conComida' => 'int',
            'dia' => 'int',
            'estado' => 'int',
            'tipo' => 'int',
            'toleranciaIn' => 'int',
            'toleranciaFin' => 'int'
        ]
    );

    SimpleRoutes(
        'capacitaciones',
        'companies',
        'company',
        'trainings',
        'company.trainings',
        'Capacitaciones',
        'capacitacion',
        'una Capacitación',
        [
            'nombre' => 'required | string',
            'descripción' => 'sometimes | required | string',
            'empleados' => 'array',
            'empleados.*.id_empleado' => 'integer | min:1 | exists:hr_empleados,id_empleado',
            'empleados.*.fecha' => 'date | date_format:Y-m-d'
        ],
        [
            'descripción' => 'descripcion',
            'id_empleado' => 'int',
        ],
        true
    );

    Route::prefix('perfil')->controller(systemController::class)->group(function () {

        Route::get('', 'getAll')->name('rol.all');

        Route::get('{id}', 'getOne')->where('id', '[0-9]+')->name('rol.one');

        Route::get('create', 'form')->name('rol.form');

        Route::post('create', 'create')->name('rol.create');

        Route::put('{id}', 'update')->where('id', '[0-9]+')->name('rol.update');

        Route::delete('{id}', 'delete')->where('id', '[0-9]+')->name('rol.delete');
    });

    SimpleRoutes(
        'permisos',
        'privileges',
        '',
        '',
        'system.permisos',
        'Permisos',
        'permiso',
        'un Permiso',
        [
            'clave' => 'required | integer | min:0',
            'nombre_del_permiso' => 'required | string',
            'clave_del_padre' => 'required | integer | exists:sys_permisos,id_permiso',
            'endpoint' => 'required | string',
            'activo' => 'required | integer | between:0,1',
        ],
        [
            'nombre_del_permiso' => 'nombre',
            'clave' => 'id_permiso',
            'clave_del_padre' => 'padre',
            'activo' => 'int',
            'padre' => 'int'
        ]
    );

    SimpleRoutes(
        'empresas',
        'companies',
        '',
        '',
        'system.companies',
        'Empresas',
        'empresa',
        'Nueva Empresa',
        [
            'razón_social' => 'required | string | min:1',
            'rfc' => 'required | string | min:1 | max:13',
            'giro_comercial' => 'required | string | min:1',
            'contacto' => 'required | string | min:1',
            'teléfono' => 'required | string | min:1 | max:10',
            'email' => 'required | string | min:1 | email',
            'fax' => 'nullable | string | min:1',
            'web' => 'nullable | string | min:1',
            'calle' => 'required | string | min:1',
            'colonia' => 'required | string | min:1',
            'población' => 'required | string | min:1',
            'estado' => 'required | integer',
            'logo' => 'nullable | string | min:1'
        ],
        [
            "razón_social" => 'razonSocial',
            "giro_comercial" => 'giroComercial',
            'teléfono' => 'telefono',
            'población' => 'poblacion'
        ]
    );

    Route::prefix('empleados')->controller(EmployeeController::class)->group(function () {

        Route::get('', 'getAll')->name('employees.general.all');

        Route::get('search', 'search')->name('employees.general.search');

        Route::get('{id}', 'getOne')->where('id', '[0-9]+')->name('employees.general.one');

        Route::get('create', 'form')->name('employees.general.form');

        Route::post('create', 'create')->name('employees.general.create');

        Route::put('{id_employee}/hr/{id}', 'update_HR')->where('id_employee', '[0-9]+')->where('id', '[0-9]+')->name('employees.general.update.HR');

        Route::put('{id_employee}/sys/{id}', 'update_SYS')->where('id_employee', '[0-9]+')->where('id', '[0-9]+')->name('employees.general.update.SYS');

        Route::put('{id_employee}/att/{id}', 'update_ATT')->where('id_employee', '[0-9]+')->where('id', '[0-9]+')->name('employees.general.update.ATT');

        Route::post('{id_employee}/img', 'create_IMG')->where('id_employee', '[0-9]+')->name('employees.general.create.IMG');

        Route::put('{id_employee}/img/{id}', 'update_IMG')->where('id_employee', '[0-9]+')->where('id', '[0-9]+')->name('employees.general.update.IMG');

        Route::get('{father_id}/cambia_puesto', 'cambia_puesto_form')->where('father_id', '[0-9]+')->name('employees.general.change_position.form');

        Route::post('{father_id}/cambia_puesto', 'cambia_puesto')->where('father_id', '[0-9]+')->name('employees.general.change_position.submit');
        
        Route::get('{father_id}/baja', 'baja_form')->where('father_id', '[0-9]+')->name('employees.general.dismiss.form');

        Route::post('{father_id}/baja', 'baja')->where('father_id', '[0-9]+')->name('employees.general.dismiss.submit');

        Route::delete('{id}', 'delete')->where('id', '[0-9]+')->name('employees.general.delete');
    });

    ChildRoutes(
        'empleados',
        'employees.general',
        'familiares',
        'employees',
        'emp',
        'relatives',
        'employees.relatives',
        'Familiares',
        'familiar',
        'un Familiar',
        [
            'nombre' => 'required | string | max:40',
            'apellido_paterno' => 'required | string | max:20',
            'apellido_materno' => 'required | string | max:20',
            'parentesco' => 'required | integer | min:0 ',
            'teléfono' => 'required | string | size:10',
            'teléfono_de_respaldo' => 'nullable | sometimes | string | size:10',
        ],
        [
            'apellido_paterno' => 'apellidoP',
            'apellido_materno' => 'apellidoM',
            'parentesco' => 'int',
            'teléfono' => 'telefono',
            'teléfono_de_respaldo' => 'telefono2',
        ]
    );

    ChildRoutes(
        'empleados',
        'employees.general',
        'documentos',
        'employees',
        'emp',
        'documents',
        'employees.documents',
        'Documentos',
        'documento',
        'un Documento',
        [
            'nombre' => 'required | string',
            'archivo' => 'required | file | mimes:rtf,doc,docx,csv,xls,xlsx,ppt,pptx,rar,7z,zip,txt,pdf,xml,json,mp3,wav,mp4,avi,webm,jpg,jpeg,png,gif,bmp,svg,webp',
        ],
        [
            'archivo' => 'info',
            'info' => 'file'
        ]
    );
});

//* ---------------------------------------------------------------------------------
//* ----------------------------  Rutas para terminales  ----------------------------
//* ---------------------------------------------------------------------------------
Route::middleware('needToken')->group(function () {
    SimpleRoutes(
        'excepciones',
        'biometrics',
        '',
        'exceptions',
        'biometrics.exceptions',
        'Excepciones',
        'id',
        'una Excepción',
        [
            'id' => 'required | integer | min:0',
            'fecha_excep' => 'required | string | regex:/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}$/',
            'tiempoini' => 'required | string | regex:/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}$/',
            'tiempofin' => 'required | string | regex:/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}$/',
            'observacion' => 'required | string',
            'id_codpago' => 'required | integer | min:0 | exists:hr_codigos_pagos,id_codigo_pago',
            'id_trabajador' => 'required | integer | min:0 | exists:hr_empleados,id_empleado',
        ],
        [
            'id' => 'int',
            'id_codpago' => 'int',
            'id_trabajador' => 'int',
            'fecha_excep' => 'datetime',
            'tiempoini' => 'datetime',
            'tiempofin' => 'datetime'

        ],
        true
    );

    SimpleRoutes(
        'biometricos',
        'biometrics',
        '',
        'terminals',
        'biometrics.terminals',
        'Terminales',
        'terminal_id',
        'una Terminal',
        [
            'terminal_id' => 'required | integer | min:0',
            'Número' => 'required | integer | min:0',
            'estado' => 'required | integer | min:0',
            'Nombre' => 'required | string',
            'Ubicación' => 'required | string',
            'tipo_de_conexión' => 'required | integer | min:0',
            'contraseña_de_la_terminal' => 'required | string',
            'Nombre_del_Dominio' => 'required | string',
            'Dirección_tcp_ip' => 'required | string',
            'Puerto' => 'required | integer | min:0',
            'Número_Serial' => 'required | string',
            'Tasa_de_Baudios' => 'required | integer | min:0',
            'Tipo' => 'required | string',
            'Usuarios' => 'required | integer | min:0',
            'Huella_Digital' => 'required | integer | min:0',
            'Punches' => 'required | integer | min:0',
            'Faces' => 'required | integer | min:0',
            'Zem' => 'required | string',
            'kind' => 'required | integer | min:0',
            'IsSelect' => 'required | integer | min:0',
            'time_checked' => 'required | integer | min:0',
            'last_checked' => 'required | date | date_format:Y-m-d H:i:s',
        ],
        [
            'estado' => 'terminal_status',
            'nombre' => 'terminal_name',
            'ubicación' => 'terminal_location',
            'tipoconexion' => 'termnal_conecttype',
            'terminal_id' => 'int',
            'teminal_no' => 'int',
            'termnal_conecttype' => 'int',
            'IsSelect' => 'int',
            // 'terminal_id' => 'terminal_id',
            'Número' => 'teminal_no',
            // 'estado' => 'estado',
            'Nombre' => 'nombre',
            'Ubicación' => 'ubicación',
            'tipo_de_conexión' => 'tipoconexion',
            'contraseña_de_la_terminal' => 'terminal_conectpwd',
            'Nombre_del_Dominio' => 'terminal_domainname',
            'Dirección_tcp_ip' => 'terminal_tcpip',
            'Puerto' => 'terminal_port',
            'Número_Serial' => 'terminal_serial',
            'Tasa_de_Baudios' => 'terminal_baudrate',
            'Tipo' => 'terminal_type',
            'Usuarios' => 'terminal_users',
            'Huella_Digital' => 'terminal_fingerprints',
            'Punches' => 'terminal_punches',
            'Faces' => 'terminal_faces',
            'Zem' => 'terminal_zem',
            'kind' => 'terminal_kind',
            'time_checked' => 'terminal_timechk',
            'last_checked' => 'terminal_lastchk'
        ]
    );

    Route::controller(RegistersController::class)->group(function () {
        Route::prefix('registros')->group(function () {

            Route::get('', 'getAllContent')->name('raiz');
        });
    });
});
//* ---------------------------------------------------------------------------------

//? ---------------------------------------------------------------------------------
//? -----------------------------  Rutas para reportes  -----------------------------
//? ---------------------------------------------------------------------------------
Route::middleware('needToken')->controller(ReportesController::class)->group(function () {

    Route::get('Asistencias', 'homeAsistencias')->name('repoattendance');

    Route::post('Asistencias', 'homeAsistencias')->name('repoattendance.post');

    Route::get('incidencias', 'aboutIncidencias')->name('reporteincidencias');

    Route::post('incidencias', 'aboutIncidencias')->name('reporteincidencias.post');

    Route::get('vacaciones', 'aboutvacaciones')->name('reportevacaiones');

    Route::post('vacaciones', 'aboutvacaciones')->name('reportevacaiones.post');

    Route::get('Reasignaciones', 'reporteRotaciones')->name('reportereasignaicones');

    Route::post('Reasignaciones', 'reporteRotaciones')->name('reportereasignaicones.post');

    Route::get('terminales', 'reporteTerminales')->name('reporteterminales');

    Route::get('retrasos', 'reportedelays')->name('retrasos');

    Route::post('retrasos', 'reportedelays')->name('retrasos.post');

    Route::post('GenerarPDF', 'generarPDF')->name('pdf.general');
});
//? ---------------------------------------------------------------------------------