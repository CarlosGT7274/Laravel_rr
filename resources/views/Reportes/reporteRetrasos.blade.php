@extends('layouts.base')

@section('content')
    <style>
        td:hover>div {
            display: block;
        }
    </style>
    <div class="flex items-center justify-between mb-5">
        <form method="post" action="{{ route('pdf.general') }}">
            @csrf
            <input type="hidden" name="viewName" value="Reportes.reporteRetrasospdf">
            <input type="hidden" name="inicio" value="{{ $inicio }}">
            <input type="hidden" name="fin" value="{{ $fin }}">
            <input type="hidden" name="endpointApi" value="reportDelay">
            <button type="submit"
                class="bg-light hover:bg-ldark text-dlight border-2 border-ldark font-bold py-2 px-4 rounded inline-flex items-center">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z" />
                </svg>
                <span>Exportar</span>
            </button>
        </form>

        <form method="post" action="{{ route('retrasos.post') }}" class="grid grid-cols-8 justify-center items-center">
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

    <section class="w-full">
        @if (empty($data['empleados']))
            <h1>No se encontraron datos en las fechas seleccionadas</h1>
        @else            
        <table class="w-full">
            <tbody>
                @foreach (array_chunk(
            array_filter($data['empleados'], function ($empleado) {
                return !empty($empleado['retrasos']);
            }),
            2,
        ) as $parElementos)
                    <tr>
                        @foreach ($parElementos as $item)
                            <td class="p-4">
                                <table class="w-full border">
                                    <thead>
                                        <tr class="bg-gray-800 text-white">
                                            <th colspan="4" class="text-center py-2">
                                                {{ $item['nombre'] . ' ' . $item['apellidoP'] . ' ' . $item['apellidoM'] }}
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="text-center w-1/4 border-l border-white">Fecha entrada</th>
                                            <th class="text-center w-1/4 border-l border-white">Retraso</th>
                                            <th class="text-center w-1/4 border-l border-white">Tolerancia</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($item['retrasos'] as $key => $item)
                                            <tr>
                                                <td class="text-center border-l border-white">{{ $item['fecha'] }}</td>
                                                <td class="text-center border-l border-white">{{ $item['retraso'] }}</td>
                                                <td class="text-center border-l border-white">{{ $item['max'] }}</td>
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
        @endif
    </section>
    {{-- @include('Reportes.vacacionesview') --}}
@endsection

@section('js-scripts')
@endsection
