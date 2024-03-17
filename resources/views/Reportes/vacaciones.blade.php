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
            <input type="hidden" name="viewName" value="Reportes.vacacionesview">
            <input type="hidden" name="inicio" value="{{ $inicio }}">
            <input type="hidden" name="fin" value="{{ $fin }}">
            <input type="hidden" name="endpointApi" value="reportVacations">
            <button type="submit"
                class="bg-light hover:bg-ldark text-dlight border-2 border-ldark font-bold py-2 px-4 rounded inline-flex items-center">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z" />
                </svg>
                <span>Exportar</span>
            </button>
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
                        Alta
                    </th>
                    <th class="py-3 px-6 text-left">
                        Antigüedad
                    </th>
                    <th class="py-3 px-6 text-left">
                        Días
                    </th>
                    <th class="py-3 px-6 text-left">
                        Días usados
                    </th>
                    <th class="py-3 px-6 text-left">
                        Días pendientes
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr class="hover:bg-gray-300">
                    <td class="py-2 px-6 text-center">
                        {{$item['id']}}
                    </td>
                    <td class="py-2 px-6 text-center">
                        {{ $item['nombre'] . ' ' . $item['apellidoP'] . ' ' . $item['apellidoM'] }}
                    </td>
                    <td class="py-2 px-6 text-center">
                        {{$item['alta']}}
                    </td>
                    <td class="py-2 px-6 text-center">
                        {{$item['antiguedad']}}
                    </td>
                    <td class="py-2 px-6 text-center">
                        {{$item['dias']}}
                    </td>
                    <td class="py-2 px-6 text-center">
                        {{$item['usados']}}
                    </td>
                    <td class="py-2 px-6 text-center">
                        {{$item['pendientes']}}
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
