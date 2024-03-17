<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte reasignaciones</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            text-align: center;
        }

        h3 {
            padding: 10px
            text-align: center;
        }

        table {
            width: 85%;
            border-collapse: collapse;
            margin: 20px auto;
            text-align: center;
        }

        th, td {
            text-align: center;
            padding: 10px;
        }

        thead {
            background-color: #36304a;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        tbody tr {
            font-size: 15px;
            color: gray;
        }
    </style>
</head>
<body>
    <h3>Reporte de Reasignaciones</h3>
    <table id="miTabla">
        <thead>
            <tr>
                <th class="py-3 px-6 text-left">
                    ID
                </th>
                <th class="py-3 px-6 text-left">
                    Nombre
                </th>
                <th class="py-3 px-6 text-left">
                    Fecha
                </th>
                <th class="py-3 px-6 text-left">
                    Motivo
                </th>
                <th class="py-3 px-6 text-left">
                    Entrevista
                </th>
                <th class="py-3 px-6 text-left">
                    Finiquito
                </th>
                <th class="py-3 px-6 text-left">
                    Firma
                </th>
                <th class="py-3 px-6 text-left">
                    Recontratable
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr class="hover:bg-gray-300">
                    <td class="py-2 px-6 text-center">
                        {{$item['id_empleado']}}
                    </td>
                    <td class="py-2 px-6 text-center">
                        {{ $item['nombre'] . ' ' . $item['apellidoP'] . ' ' . $item['apellidoM'] }}
                    </td>
                    <td class="py-2 px-6 text-center">
                        {{$item['fecha']}}
                    </td>
                    <td class="py-2 px-6 text-center">
                        {{$item['motivo'] == '' ? 'Sin motivo' : $item['motivo'] }}
                    </td>
                    <td class="py-2 px-6 text-center">
                        {{ $item['entrevista'] == 1 ? 'Si' : 'No' }}
                    </td>
                    
                    <td class="py-2 px-6 text-center">
                        {{ $item['finiquito'] == 1 ? 'Si' : 'No' }}
                    </td>
                    
                    <td class="py-2 px-6 text-center">
                        {{ $item['firma'] == 1 ? 'Si' : 'No' }}
                    </td>
                    
                    <td class="py-2 px-6 text-center">
                        {{ $item['recontratable'] == 1 ? 'Si' : 'No' }}
                    </td>
                    
                </tr>
                @endforeach
        </tbody>
    </table>
</body>
</html>