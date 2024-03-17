<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Asistencias</title>
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

    <h3 style="padding-bottom: 10px">Reporte de Asistencias</h3>

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
                    <tr>
                        <td style="padding-left: 8px">{{ $empleado['id_empleado'] }}</td>
                        <td>{{ $empleado['nombre'] . ' ' . $empleado['apellidoP'] . ' ' . $empleado['apellidoM'] }}</td>
                        @foreach ($bloque as $fecha)
                            <td style="text-align: center">
                                @if (array_key_exists($fecha, $empleado['asistencias']))
                                    {{ $empleado['asistencias'][$fecha]['tipo_in'] }}
                                @elseif (in_array($fecha, $empleado['faltas']))
                                    Falta
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
    @endforeach

        <h3 style="padding-bottom: 10px">Asistencias por Empleado</h3>
    <table>
        <tbody>
            @foreach (array_chunk(
        array_filter($data['empleados'], function ($empleado) {
            return !empty($empleado['asistencias']);
        }),
        2,
    ) as $parElementos)
                <tr>
                    @foreach ($parElementos as $item)
                        <td>
                            <table>
                                <thead>
                                    <tr style="border-bottom: 1px solid white">
                                        <th colspan="5" style="text-align: center;padding: 3px">
                                            {{ $item['nombre'] . ' ' . $item['apellidoP'] . ' ' . $item['apellidoM'] }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th style="text-align: center; width: 18%">Fecha</th>
                                        <th style="text-align: center; width: 24%; border-left: 1px solid white">Hora de
                                            entrada</th>
                                        <th style="text-align: center; width: 18%; border-left: 1px solid white">Tipo de
                                            entrada</th>
                                        <th style="text-align: center; width: 22%; border-left: 1px solid white">Hora de
                                            salida</th>
                                        <th style="text-align: center; width: 18%; border-left: 1px solid white">Tipo de
                                            salida</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($item['asistencias'] as $key => $item)
                                        <tr>
                                            <td style="text-align: center; width: 18%">{{ $key }}</td>
                                            <td style="text-align: center; width: 24%; border-left: 1px solid white">
                                                {{ date_format(date_create($item['entrada']), 'H:s:i') }}</td>
                                            <td style="text-align: center; width: 18%; border-left: 1px solid white">
                                                {{ $item['tipo_in'] }}</td>
                                                @if (!empty($item['salida']))
                                                <td style="text-align: center; width: 22%; border-left: 1px solid white">
                                                    {{ date_format(date_create($item['salida']), 'H:s:i') }}</td>
                                                <td style="text-align: center; width: 18%; border-left: 1px solid white">
                                                    {{ $item['tipo_out'] }}</td>
                                                @endif
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
