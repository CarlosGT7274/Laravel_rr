<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte vacaciones</title>
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
    <h3>Reporte de Vacaciones</h3>
    <table id="miTabla">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Alta</th>
                <th>Antigüedad</th>
                <th>Días</th>
                <th>Días usados</th>
                <th>Días pendientes</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr>
                <td>{{$item['id']}}</td>
                <td>{{ $item['nombre'] . ' ' . $item['apellidoP'] . ' ' . $item['apellidoM'] }}</td>
                <td>{{$item['alta']}}</td>
                <td>{{$item['antiguedad']}}</td>
                <td>{{$item['dias']}}</td>
                <td>{{$item['usados']}}</td>
                <td>{{$item['pendientes']}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
