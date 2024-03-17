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
            <input type="hidden" name="viewName" value="Reportes.Rotacionesview">
            <input type="hidden" name="inicio" value="{{ $inicio }}">
            <input type="hidden" name="fin" value="{{ $fin }}">
            <input type="hidden" name="endpointApi" value="reportResignations">
            <button type="submit"
                class="bg-light hover:bg-ldark text-dlight border-2 border-ldark font-bold py-2 px-4 rounded inline-flex items-center">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z" />
                </svg>
                <span>Exportar</span>
            </button>
        </form>

        <form method="post" action="{{ route('reportereasignaicones.post') }}"
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
        <table id="miTabla" class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr class="bg-dark text-white">
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
                {{-- @dd($data) --}}
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

    </section>
    {{-- @include('Reportes.vacacionesview') --}}
@endsection

@section('js-scripts')
@endsection
