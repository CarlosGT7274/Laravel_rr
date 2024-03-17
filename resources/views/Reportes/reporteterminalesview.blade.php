<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte terminales</title>
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
            text-align: center;
            padding: 5px;
        }

        table td.l,
        table th.l {
            text-align: center;
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
        $cols = $data;
        $bloques = array_chunk($cols, 2);
    @endphp

    <h3 style="padding-bottom: 10px">Reporte de Terminales</h3>

    @foreach ($bloques as $bloque)
        <table id="miTabla">
            <thead>
                <tr>
                    {{-- <th>ID Terminal</th> --}}
                    <th>Nombre Terminal</th>
                    <th>Número de Terminal</th>
                    <th>Estado Terminal</th>
                    <th>Ubicación Terminal</th>
                    <th>Tipo de Conexión</th>
                    <th>Contraseña de Conexión</th>
                    <th>Nombre de Dominio</th>
                    <th>Dirección TCP/IP</th>
                    <th>Puerto</th>
                    <th>Número Serial</th>
                    <th>Tasa de Baudios</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $terminal)
                    <tr class="hover:bg-gray-100">
                        {{-- <td>{{ $terminal['terminal_id'] }}</td> --}}
                        <td>{{ $terminal['terminal_name'] }}</td>
                        <td>{{ $terminal['teminal_no'] }}</td>
                        <td>{{ $terminal['terminal_status'] }}</td>
                        <td>{{ $terminal['terminal_location'] }}</td>
                        <td>{{ $terminal['termnal_conecttype'] }}</td>
                        <td>{{ $terminal['terminal_conectpwd'] }}</td>
                        <td>{{ $terminal['terminal_domainname'] }}</td>
                        <td>{{ $terminal['terminal_tcpip'] }}</td>
                        <td>{{ $terminal['terminal_port'] }}</td>
                        <td>{{ $terminal['terminal_serial'] }}</td>
                        <td>{{ $terminal['terminal_baudrate'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
    @endforeach

    @foreach ($bloques as $bloque)
        <table id="miTabla">
            <thead>
                <tr>
                    <th>Nombre Terminal</th>
                    <th>Tipo de Terminal</th>
                    <th>Usuarios Permitidos</th>
                    <th>Huellas Digitales Permitidas</th>
                    <th>Registros de Marcajes</th>
                    <th>Rostros Permitidos</th>
                    <th>ZEM</th>
                    <th>Tipo de Terminal</th>
                    <th>Seleccionado</th>
                    <th>Intervalo de Tiempo para Verificación</th>
                    <th>Última Verificación</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $terminal)
                    <tr class="hover:bg-gray-100">
                        <td>{{ $terminal['terminal_name'] }}</td>
                        <td>{{ $terminal['terminal_type'] }}</td>
                        <td>{{ $terminal['terminal_users'] }}</td>
                        <td>{{ $terminal['terminal_fingerprints'] }}</td>
                        <td>{{ $terminal['terminal_punches'] }}</td>
                        <td>{{ $terminal['terminal_faces'] }}</td>
                        <td>{{ $terminal['terminal_zem'] }}</td>
                        <td>{{ $terminal['terminal_kind'] }}</td>
                        <td>{{ $terminal['IsSelect'] }}</td>
                        <td>{{ $terminal['terminal_timechk'] }}</td>
                        <td>{{ $terminal['terminal_lastchk'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
    @endforeach

</body>

</html>
