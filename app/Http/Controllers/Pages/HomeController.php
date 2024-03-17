<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function home()
    {
        return view('home.welcome', [
            'pageTitle' => 'Home'
        ]);
    }

    public function dashboard()
    {

        $fechaActual = Carbon::now()->format('Y-m-d');

        $attendance = $this->apiRequest('dashboard/attendance', 'GET', [
            'date' => $fechaActual
        ]);

        $unidades = $this->apiRequest('companies/' . session('company') . '/units', 'get', []);

        $departamentos = $this->apiRequest('companies/' . session('company') . '/departments', 'get', []);

        $posiciones = $this->apiRequest('companies/' . session('company') . '/positions', 'get', []);

        $general1 = $this->apiRequest('dashboard/general', 'get', [
            'date' => $fechaActual
        ]);

        $salaries1 = $this->apiRequest("dashboard/salaries", "get", [
            "date" => $fechaActual
        ]);

        $birthdays1 = $this->apiRequest("dashboard/birthdays", "get", [
            'date' => $fechaActual
        ]);

        $rotations1 = $this->apiRequest("dashboard/rotations", "get", [
            'date' => $fechaActual
        ]);

        return view('home.home', [
            'pageTitle' => 'Home',
            'attendance' => $attendance,
            "general" => $general1,
            "salaries" => $salaries1,
            "birthdays" => $birthdays1,
            "rotations" => $rotations1,
            "unidades" => $unidades['data'],
            "departamentos" => $departamentos['data'],
            "posiciones" => $posiciones['data'],
            "filtros" => [
                "fecha" => '',
                "unidad" => '',
                "departamentoss" => '',
                "puesto" => '',
                "region" => ''
            ]
        ]);
    }


    public function graph(Request $request)
    {
        $request->validate([
            'fecha' => 'required | date | date_format:Y-m-d',
            'unidad' => 'string | regex:/^\d+$/ | nullable',
            "posiciones" => 'string | regex:/^\d+$/ | nullable',
            'departamento' => 'string | regex:/^\d+$/ | nullable',
        ]);

        $apiParams = [];

        $value = $request->fecha;
        $unidad = $request->unidad;
        $departamentos = $request->departamento;
        $puesto = $request->posiciones;
        $region = $request->region;


        foreach ($request->all() as $key => $param) {
            if ($param != null && $key != '_token') {
                $newKey = '';

                switch ($key) {
                    case 'fecha':
                        $newKey = 'date';
                        break;
                    case 'unidad':
                        $newKey = 'unit';
                        break;
                    case 'departamento':
                        $newKey = 'department';
                        break;
                    case 'posiciones':
                        $newKey = 'position';
                        break;
                    case 'region':
                        $newKey = 'region';
                        break;
                }
                $apiParams[$newKey] = $param;
            }
        }

        $unidades = $this->apiRequest('companies/' . session('company') . '/units', 'get', []);

        $departamentos = $this->apiRequest('companies/' . session('company') . '/departments', 'get', []);

        $posiciones = $this->apiRequest('companies/' . session('company') . '/positions', 'get', []);

        $general = $this->apiRequest('dashboard/general', 'get', $apiParams);

        $salaries = $this->apiRequest("dashboard/salaries", "get", $apiParams);

        $birthdays = $this->apiRequest("dashboard/birthdays", "get", $apiParams);

        $rotations = $this->apiRequest("dashboard/rotations", "get", $apiParams);

        $apiParams['paramDate'] = $request->fecha;

        $attendance = $this->apiRequest('dashboard/attendance', 'get', $apiParams);

        return view('home.home', [
            'pageTitle' => 'Home',
            'attendance' => $attendance,
            'general' => $general,
            "salaries" => $salaries,
            "birthdays" => $birthdays,
            "rotations" => $rotations,
            "unidades" => $unidades['data'],
            "departamentos" => $departamentos['data'],
            "posiciones" => $posiciones['data'],
            "filtros" => [
                "fecha" => $value,
                "unidad" => $unidad,
                "departamentoss" => $departamentos,
                "puesto" => $puesto,
                "region" => $region
            ]
        ]);
    }
}
