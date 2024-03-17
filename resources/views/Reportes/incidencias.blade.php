@extends('layouts.base')

@section('content')
    <style>
        td:hover>div {
            display: block;
        }
    </style>
    {{-- @foreach ($data['fechas'] as $item)
    {{json_encode($item)}}
    @endforeach --}}
    <div class="flex items-center justify-between mb-5">
        <form method="post" action="{{ route('pdf.general') }}">
            @csrf
            <input type="hidden" name="viewName" value="Reportes.incidenciasview">
            <input type="hidden" name="inicio" value="{{ $inicio }}">
            <input type="hidden" name="fin" value="{{ $fin }}">
            <input type="hidden" name="endpointApi" value="reportIncidencies">
            <button type="submit"
                class="bg-light hover:bg-ldark text-dlight border-2 border-ldark font-bold py-2 px-4 rounded inline-flex items-center">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z" />
                </svg>
                <span>Exportar</span>
            </button>
        </form>

        <form method="post" action="{{ route('reporteincidencias.post') }}"
            class="grid grid-cols-8 justify-center items-center">
            @csrf
            <div class="col-start-1 col-end-4">
                <x-input id="fecha_excep" icon="" type="date" name="inicio" placeholder="Inicio" />
            </div>

            <span class="text-gray-500 mx-auto mt-4">a</span>

            <div class="col-start-5 col-end-8">
                <x-input id="fecha_excep" icon="" type="date" name="fin" placeholder="Fin" />
            </div>

            <button
                class="text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 ml-2 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800">Enviar</button>

        </form>
    </div>

    <section class="w-full overflow-x-scroll">
        <table id="miTabla" class="table latabla ">
            <thead>
                <tr class="bg-dark text-white">
                    <th class="px-4 py-2 sticky left-0 bg-dark z-10">ID</th>
                    <th class="px-4 py-2 sticky left-12 bg-dark z-10">Nombre</th>
                    @foreach ($data['fechas'] as $fecha)
                        <th class="px-4 py-2 ">{{ $fecha }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($data['empleados'] as $empleado)
                    <tr class="border-b">
                        <td class="px-4 py-2 sticky left-0 bg-light z-10">{{ $empleado['id_empleado'] }}</td>
                        <td class="px-4 py-2 sticky left-12 bg-light z-10">
                            {{ $empleado['nombre'] . ' ' . $empleado['apellidoP'] . ' ' . $empleado['apellidoM'] }}</td>
                        @foreach ($data['fechas'] as $fecha)
                            <td class="px-4 py-2 relative text-center">
                                @if (in_array($fecha, $empleado['asistencias']))
                                    A
                                    {{-- {{ $empleado['asistencias'][$fecha] }} --}}
                                @elseif (array_key_exists($fecha, $empleado['incidencias']))
                                    {{-- Falta --}}
                                    {{ $empleado['incidencias'][$fecha] }}
                                    @if ($empleado['incidencias'][$fecha] != 'D')
                                        @if ($empleado['incidencias'][$fecha] != '')
                                            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-light p-2 border border-ldark rounded-lg shadow-md z-50 w-72 hidden">
                                                Fecha Registro: {{ $empleado['incidenciasInfo'][$fecha]['fechaIn'] }} <br/>
                                                Nombre: {{ $empleado['incidenciasInfo'][$fecha]['nombre'] }} <br/>
                                                Clave: {{ $empleado['incidenciasInfo'][$fecha]['clave'] }} <br/>
                                                Afecta Nomina: @if ($empleado['incidenciasInfo'][$fecha]['afectaNomina'] == 1) si @elseif($empleado['incidenciasInfo'][$fecha]['afectaNomina'] == 0) No @endif
                                            </div>
                                        @endif
                                    @endif
                                @else
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    {{-- @include('Reportes.incidenciasview') --}}
@endsection

@section('js-scripts')
    @vite('resources/js/datatables.js')
    {{-- <script>
        $(document).ready(function() {
            $('#miTabla').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ],
                columnDefs: [{
                    targets: '_all',
                    className: "w-96",
                    width: "18rem"
                }]
            });
        });
    </script> --}}
@endsection
