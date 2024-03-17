<?php

namespace App\Http\Controllers\API\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\Company\Schedule\hr_detalles_horarios;
use App\Models\HR\Company\Schedule\hr_horarios;
use App\Models\HR\Employee\General\hr_empleados;
use Illuminate\Http\Request;

class HorariosController extends Controller
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
     * Read the Schedules of a Company on the data base.
     * 
     * @param int $id_company
     * @return array|string
     */
    public function readAll($id_company)
    {
        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => hr_horarios::where('id_empresa', $id_company)->get()
        ], 200);
    }

    /**
     * Read a Specific Schedule on the data base.
     * 
     * @param int $id
     * @return array|string
     */
    public function readOne($id_company, $id)
    {
        $horario = hr_horarios::find($id);

        if (empty($horario)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Horario Inexistente'
            ], 404);
        }

        $detalles = [];

        foreach (hr_detalles_horarios::where('id_horario', $id)->get() as $detalle) {
            array_push($detalles, $detalle);
        }

        $horario['detalles'] = $detalles;

        $horario['empleados'] = hr_empleados::select('nombre', 'apellidoP', 'apellidoM')->where('id_tipo_empleado', $id)->join('sys_usuarios', 'sys_usuarios.id_usuario', 'hr_empleados.id_usuario')->get();

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $horario
        ], 200);
    }

    /**
     * Create an New Schedule
     * 
     * @param $id_company
     * @param Request
     * @return boolean
     */
    public function create($id_company, Request $request)
    {
        $request->validate([
            'descripcion' => 'required | string',
            'conComida' => 'required | integer | between:0,1',
            'estado' => 'required | integer | between:0,1',
            'detalles' => 'required | array | size:7',
            'detalles.*.dia' => 'required | integer | between:1,7',
            'detalles.*.inicio' => 'required | date_format:H:i:s',
            'detalles.*.fin' => 'required | date_format:H:i:s',
            'detalles.*.toleranciaIn' => 'integer | min:0',
            'detalles.*.toleranciaFin' => 'integer | min:0',
            'detalles.*.tipo' => 'required | integer | between:0,1'
        ]);

        $details = $request->detalles;
        unset($request->detalles);

        $request['id_empresa'] = $id_company;
        $horario = hr_horarios::create($request->all());

        $detalles = [];

        foreach ($details as $detail) {
            $detalle = hr_detalles_horarios::create([
                'id_horario' => $horario->id_horario,
                'dia' => $detail['dia'],
                'inicio' => $detail['inicio'],
                'fin' => $detail['fin'],
                'toleranciaIn' => $detail['toleranciaIn'],
                'toleranciaFin' => $detail['toleranciaFin'],
                'tipo' => $detail['tipo'],
            ]);

            array_push($detalles, $detalle);
        }

        $horario['detalles'] = $detalles;

        return response()->json([
            'error' => false,
            'mensaje' => 'Registro creado correctamente',
            'data' => $horario
        ], 201);
    }

    /**
     * Create an User on the data base.
     * @param int $id
     * @param Request
     * @return boolean
     */
    public function update($id_company, $id, Request $request)
    {
        $request->validate([
            'descripcion' => 'sometimes | required | string',
            'conComida' => 'sometimes | required | integer | between:0,1',
            'estado' => 'sometimes | required | integer | between:0,1',
            'detalles' => 'sometimes | required | array | max:7',
            'detalles.*.dia' => 'required | integer | between:1,7',
            'detalles.*.inicio' => 'required | date_format:H:i:s',
            'detalles.*.fin' => 'required | date_format:H:i:s',
            'detalles.*.toleranciaIn' => 'integer | min:0',
            'detalles.*.toleranciaFin' => 'integer | min:0',
            'detalles.*.tipo' => 'required | integer | between:0,1'
        ]);

        $horario = hr_horarios::find($id);

        if (empty($horario)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Horario Inexistente'
            ], 404);
        }

        if ($request->detalles) {
            foreach ($request->detalles as $detalle) {
                $detalle_horario = hr_detalles_horarios::where('id_horario', $id)->where('dia', $detalle['dia'])->first();

                $detalle_horario->update([
                    'inicio' => isset($detalle['inicio']) ? $detalle['inicio'] : $detalle_horario->inicio,
                    'fin' => isset($detalle['fin']) ? $detalle['fin'] : $detalle_horario->fin,
                    'toleranciaIn' => isset($detalle['toleranciaIn']) ? $detalle['toleranciaIn'] : $detalle_horario->toleranciaIn,
                    'toleranciaFin' => isset($detalle['toleranciaFin']) ? $detalle['toleranciaFin'] : $detalle_horario->toleranciaIFin,
                    'tipo' => isset($detalle['tipo']) ? $detalle['tipo'] : $detalle_horario->tipo
                ]);
            }

            unset($request->detalles);
        }


        $horario->update($request->all());

        $detalles = hr_detalles_horarios::where('id_horario', $id)->get();

        $horario['detalles'] = $detalles;

        return response()->json([
            'error' => false,
            'mensaje' => 'Registros actualzados correctamente',
            'data' => $horario
        ], 200);
    }

    /**
     * Delete a Specific User on the data base.
     * @param int $id
     * @return array|string
     */
    public function delete($id_company, $id)
    {
        $horario = hr_horarios::find($id);

        if (empty($horario)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Horario no registrado',
            ], 404);
        }

        $attempt = false;
        try {
            $attempt = hr_horarios::destroy($id);
        } catch (\Throwable $th) {
            $attempt = false;
        }

        return response()->json([
            'error' => $attempt ? false : true,
            'mensaje' => $attempt ? 'Eliminado Correctamente' : 'No se puede borrar el horario'
        ], 200);
    }
}
