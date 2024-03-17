<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

use Barryvdh\DomPDF\Facade\PDF;
use dompdf\Dompdf;
use Dompdf\Options;

class ReportesController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $pageTitle = "";

    public function __construct()
    {
    }

    public function homeAsistencias(Request $request)
    {
        $fin = Carbon::now()->format('Y-m-d');
        $inicio = Carbon::now()->subWeek()->format('Y-m-d');

        if ($request->method() === 'POST') {
            $request->validate([
                'inicio' => 'required | date | date_format:Y-m-d',
                'fin' => 'required | date | date_format:Y-m-d'
            ]);

            $fin = $request->input('fin');
            $inicio = $request->input('inicio');
        }

        $data = [
            'inicio' => $inicio,
            'fin' => $fin,
            'pageTitle' => $this->pageTitle,
            'data' => $this->apiRequest('companies/' . session('company') . '/reportAttendance', 'GET', [
                'inicio' => $inicio,
                'fin' => $fin
            ])['data'],
        ];

        return view("Reportes.all", $data);
    }

    public function aboutIncidencias(Request $request)
    {
        if ($request->has('inicio') && $request->has('fin')) {
            if (empty($request->input('inicio')) && empty($request->input('fin'))) {
                $fin = Carbon::now()->format('Y-m-d');
                $inicio = Carbon::now()->subWeek()->format('Y-m-d');
                // dd('c');    
            } else {
                $fin = $request->input('fin');
                $inicio = $request->input('inicio');
                // dd('a');
            }
        } else {
            // dd('b');
            $fin = Carbon::now()->format('Y-m-d');
            $inicio = Carbon::now()->subWeek()->format('Y-m-d');
        }

        $data = [
            'inicio' => $inicio,
            'fin' => $fin,
            'pageTitle' => $this->pageTitle,
            'data' => $this->apiRequest('companies/' . session('company') . '/reportIncidencies', 'GET', [
                'inicio' => $inicio,
                'fin' => $fin
            ])['data'],
        ];
        return view('Reportes.incidencias', $data);
    }

    public function aboutVacaciones(Request $request)
    {

        if ($request->has('inicio') && $request->has('fin')) {
            if (empty($request->input('inicio')) && empty($request->input('fin'))) {
                $fin = Carbon::now()->format('Y-m-d');
                $inicio = Carbon::now()->subWeek()->format('Y-m-d');
                // dd('c');    
            } else {
                $fin = $request->input('fin');
                $inicio = $request->input('inicio');
                // dd('a');
            }
        } else {
            // dd('b');
            $fin = Carbon::now()->format('Y-m-d');
            $inicio = Carbon::now()->subWeek()->format('Y-m-d');
        }

        $data = [
            'inicio' => $inicio,
            'fin' => $fin,
            'pageTitle' => $this->pageTitle,
            'data' => $this->apiRequest('companies/' . session('company') . '/reportVacations', 'GET', [
                'inicio' => $inicio,
                'fin' => $fin
            ])['data'],
        ];

        return view('Reportes.vacaciones', $data);
    }

    public function reporteRotaciones(Request $request)
    {
        if ($request->has('inicio') && $request->has('fin')) {
            if (empty($request->input('inicio')) && empty($request->input('fin'))) {
                $fin = Carbon::now()->format('Y-m-d');
                $inicio = Carbon::now()->subWeek()->format('Y-m-d');
                // dd('c');    
            } else {
                $fin = $request->input('fin');
                $inicio = $request->input('inicio');
                // dd('a');
            }
        } else {
            // dd('b');
            $fin = Carbon::now()->format('Y-m-d');
            $inicio = Carbon::now()->subWeek()->format('Y-m-d');
        }

        $data = [
            'inicio' => $inicio,
            'fin' => $fin,
            'pageTitle' => $this->pageTitle,
            'data' => $this->apiRequest('companies/' . session('company') . '/reportResignations', 'GET', [
                'inicio' => $inicio,
                'fin' => $fin
            ])['data'],
        ];

        return view('Reportes.Rotaciones', $data);
    }

    public function reporteTerminales(Request $request)
    {
        if ($request->has('inicio') && $request->has('fin')) {
            if (empty($request->input('inicio')) && empty($request->input('fin'))) {
                $fin = Carbon::now()->format('Y-m-d');
                $inicio = Carbon::now()->subWeek()->format('Y-m-d');
                // dd('c');    
            } else {
                $fin = $request->input('fin');
                $inicio = $request->input('inicio');
                // dd('a');
            }
        } else {
            // dd('b');
            $fin = Carbon::now()->format('Y-m-d');
            $inicio = Carbon::now()->subWeek()->format('Y-m-d');
        }

        $data = [
            'inicio' => $inicio,
            'fin' => $fin,
            'pageTitle' => $this->pageTitle,
            'data' => $this->apiRequest('companies/' . session('company') . '/reportTerminals', 'GET', [
                'inicio' => $inicio,
                'fin' => $fin
            ])['data'],
        ];

        return view('Reportes.reportTerminales', $data);
    }

    public function reportedelays(Request $request)
    {
        if ($request->has('inicio') && $request->has('fin')) {
            if (empty($request->input('inicio')) && empty($request->input('fin'))) {
                $fin = Carbon::now()->format('Y-m-d');
                $inicio = Carbon::now()->subWeek()->format('Y-m-d');
                // dd('c');    
            } else {
                $fin = $request->input('fin');
                $inicio = $request->input('inicio');
                // dd('a');
            }
        } else {
            // dd('b');
            $fin = Carbon::now()->format('Y-m-d');
            $inicio = Carbon::now()->subWeek()->format('Y-m-d');
        }

        $data = [
            'inicio' => $inicio,
            'fin' => $fin,
            'pageTitle' => $this->pageTitle,
            'data' => $this->apiRequest('companies/' . session('company') . '/reportDelays', 'GET', [
                'inicio' => $inicio,
                'fin' => $fin
            ])['data'],
        ];

        return view('Reportes.reporteRetrasos', $data);
    }

    public function generarPDF(Request $request)
    {
        $viewName = $request->input('viewName');
        $inicio = $request->input('inicio');
        $fin = $request->input('fin');
        $endpointApi = $request->input('endpointApi');

        if ($inicio === null) {
            $inicio = Carbon::now()->subWeek()->format('Y-m-d');
        }

        if ($fin === null) {
            $fin = Carbon::now()->format('Y-m-d');
        }

        $data = [
            'titulo' => 'Ejemplo de PDF en Laravel',
            'pageTitle' => $this->pageTitle,
            'data' => $this->apiRequest('companies/' . session('company') . '/' . $endpointApi, 'GET', [
                'inicio' => $inicio,
                'fin' => $fin,
            ])['data'],
        ];

        $pdf = PDF::loadView($viewName, $data)->setPaper('a4', 'landscape');

        return $pdf->download('Reporte.pdf');
    }
}
