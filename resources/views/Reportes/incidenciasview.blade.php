<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de incidencias</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }

        h3 {
            width: 100vw;
            text-align: center;
            margin-top: 0;
            margin-bottom: 0;
        }

        table {
            border-spacing: 1;
            border-collapse: collapse;
            background: #fff;
            overflow: hidden;
            width: 100%;
            margin: 0 auto;
            position: relative;
        }

        table td,
        table th {
            text-align: center;
        }

        table thead tr {
            height: 60px;
            background: #36304a !important;
            color: white;
            text-align: center;
        }

        table tbody tr {
            height: 50px;
            text-align: center;
        }

        table tbody tr:last-child {
            border: 0;
        }

        table td,
        table th {
            text-align: left;
        }

        table td.l,
        table th.l {
            text-align: right;
        }

        table td.c,
        table th.c {
            text-align: center;
        }

        table td.r,
        table th.r {
            text-align: center;
        }


        tbody tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        tbody tr {
            font-family: OpenSans-Regular;
            font-size: 15px;
            color: gray;
            line-height: 1.2;
            font-weight: unset;
        }
    </style>
</head>

<body>
    @php
        $fechas = $data['fechas'];
        $bloques = array_chunk($fechas, 7);
    @endphp

    <h3 style="padding-bottom: 10px">Reporte de Incidencias</h3>

    @foreach ($bloques as $bloque)
        <table id="miTabla">
            <thead>
                <tr>
                    <th style="padding-left: 8px">ID</th>
                    <th>Nombre</th>
                    @foreach ($bloque as $fecha)
                        <th style="text-align: center">{{ $fecha }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($data['empleados'] as $empleado)
                    <tr class="border-b">
                        <td class="px-4 py-2 sticky left-0 bg-light z-10">{{ $empleado['id_empleado'] }}</td>
                        <td class="px-4 py-2 sticky left-12 bg-light z-10">
                            {{ $empleado['nombre'] . ' ' . $empleado['apellidoP'] . ' ' . $empleado['apellidoM'] }}</td>
                        @foreach ($bloque as $fecha)
                            <td class="px-4 py-2 relative text-center" style="text-align: center">
                                @if (in_array($fecha, $empleado['asistencias']))
                                    A
                                    {{-- {{ $empleado['asistencias'][$fecha] }} --}}
                                @elseif (array_key_exists($fecha, $empleado['incidencias']))
                                    {{-- Falta --}}
                                    {{ $empleado['incidencias'][$fecha] }}
                                    {{-- @if ($empleado['incidencias'][$fecha] != 'D')
                                        @if ($empleado['incidencias'][$fecha] != '')
                                            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-light p-2 border border-ldark rounded-lg shadow-md z-50 w-72 hidden">
                                                Fecha Registro: {{ $empleado['incidenciasInfo'][$fecha]['fechaIn'] }} <br/>
                                                Nombre: {{ $empleado['incidenciasInfo'][$fecha]['nombre'] }} <br/>
                                                Clave: {{ $empleado['incidenciasInfo'][$fecha]['clave'] }} <br/>
                                                Afecta Nomina: @if ($empleado['incidenciasInfo'][$fecha]['afectaNomina'] == 1) si @elseif($empleado['incidenciasInfo'][$fecha]['afectaNomina'] == 0) No @endif
                                            </div>
                                        @endif
                                    @endif --}}
                                @else
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
    @endforeach

    <h3 style="padding-bottom: 10px">Incidencias por Empleado</h3>
    <table>
        <tbody>
            @foreach (array_chunk(
        array_filter($data['empleados'], function ($empleado) {
            return !empty($empleado['incidenciasInfo']);
        }),
        2,
    ) as $parElementos)
                <tr>
                    @foreach ($parElementos as $item)
                        <td>
                            <table>
                                <thead>
                                    <tr style="border-bottom: 1px solid white">
                                        <th colspan="4" style="text-align: center;padding: 3px">
                                            {{ $item['nombre'] . ' ' . $item['apellidoP'] . ' ' . $item['apellidoM'] }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th style="text-align: center; width: 18%; border-left: 1px solid white">Fecha
                                            Incidencia</th>
                                        <th style="text-align: center; width: 22%; border-left: 1px solid white">Nombre
                                        </th>
                                        <th style="text-align: center; width: 24%; border-left: 1px solid white">Clave
                                        </th>
                                        <th style="text-align: center; width: 18%; border-left: 1px solid white">
                                            Afecta Nomina</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($item['incidenciasInfo'] as $key => $item)
                                        <tr>
                                            {{-- <td style="text-align: center; width: 18%">{{ $key }}</td> --}}
                                            <td style="text-align: center; width: 18%; border-left: 1px solid white">
                                                {{ $item['fechaIn'] }}</td>
                                            <td style="text-align: center; width: 18%; border-left: 1px solid white">
                                                {{ $item['nombre'] }}</td>
                                            <td style="text-align: center; width: 18%; border-left: 1px solid white">
                                                {{ $item['clave'] }}</td>
                                            <td style="text-align: center; width: 22%; border-left: 1px solid white">
                                                {{ $item['afectaNomina'] }}</td>
                                            {{-- <td style="text-align: center; width: 18%; border-left: 1px solid white">
                                                {{ $item['id_empleado'] }}</td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>


</body>

</html>
