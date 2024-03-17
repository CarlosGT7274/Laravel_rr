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
            <input type="hidden" name="viewName" value="Reportes.reporteterminalesview">
            <input type="hidden" name="inicio" value="{{ $inicio }}">
            <input type="hidden" name="fin" value="{{ $fin }}">
            <input type="hidden" name="endpointApi" value="reportTerminals">
            <button type="submit"
                class="bg-light hover:bg-ldark text-dlight border-2 border-ldark font-bold py-2 px-4 rounded inline-flex items-center">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z" />
                </svg>
                <span>Exportar</span>
            </button>
        </form>

    </div>


    <section class="overflow-x-auto">
        <table id="miTabla" class="divide-y divide-gray-200 bg-white shadow-md rounded-md overflow-hidden">
            <thead class="bg-dark text-white">
                <tr>
                    <th class="py-3 px-4 border-b">ID Terminal</th>
                    <th class="py-3 px-4 border-b">Número de Terminal</th>
                    <th class="py-3 px-4 border-b">Estado Terminal</th>
                    <th class="py-3 px-4 border-b">Nombre Terminal</th>
                    <th class="py-3 px-4 border-b">Ubicación Terminal</th>
                    <th class="py-3 px-4 border-b">Tipo de Conexión</th>
                    <th class="py-3 px-4 border-b">Contraseña de Conexión</th>
                    <th class="py-3 px-4 border-b">Nombre de Dominio</th>
                    <th class="py-3 px-4 border-b">Dirección TCP/IP</th>
                    <th class="py-3 px-4 border-b">Puerto</th>
                    <th class="py-3 px-4 border-b">Número Serial</th>
                    <th class="py-3 px-4 border-b">Tasa de Baudios</th>
                    <th class="py-3 px-4 border-b">Tipo de Terminal</th>
                    <th class="py-3 px-4 border-b">Usuarios Permitidos</th>
                    <th class="py-3 px-4 border-b">Huellas Digitales Permitidas</th>
                    <th class="py-3 px-4 border-b">Registros de Marcajes</th>
                    <th class="py-3 px-4 border-b">Rostros Permitidos</th>
                    <th class="py-3 px-4 border-b">ZEM</th>
                    <th class="py-3 px-4 border-b">Tipo de Terminal</th>
                    <th class="py-3 px-4 border-b">Seleccionado</th>
                    <th class="py-3 px-4 border-b">Intervalo de Tiempo para Verificación</th>
                    <th class="py-3 px-4 border-b">Última Verificación</th>
                </tr>
            </thead>
    
            <tbody>
                @foreach($data as $terminal)
                <tr class="hover:bg-gray-100">
                    <td class="py-2 px-4 border-b">{{ $terminal['terminal_id'] }}</td>
                    <td class="py-2 px-4 border-b">{{ $terminal['teminal_no'] }}</td>
                    <td class="py-2 px-4 border-b">{{ $terminal['terminal_status'] }}</td>
                    <td class="py-2 px-4 border-b">{{ $terminal['terminal_name'] }}</td>
                    <td class="py-2 px-4 border-b">{{ $terminal['terminal_location'] }}</td>
                    <td class="py-2 px-4 border-b">{{ $terminal['termnal_conecttype'] }}</td>
                    <td class="py-2 px-4 border-b">{{ $terminal['terminal_conectpwd'] }}</td>
                    <td class="py-2 px-4 border-b">{{ $terminal['terminal_domainname'] }}</td>
                    <td class="py-2 px-4 border-b">{{ $terminal['terminal_tcpip'] }}</td>
                    <td class="py-2 px-4 border-b">{{ $terminal['terminal_port'] }}</td>
                    <td class="py-2 px-4 border-b">{{ $terminal['terminal_serial'] }}</td>
                    <td class="py-2 px-4 border-b">{{ $terminal['terminal_baudrate'] }}</td>
                    <td class="py-2 px-4 border-b">{{ $terminal['terminal_type'] }}</td>
                    <td class="py-2 px-4 border-b">{{ $terminal['terminal_users'] }}</td>
                    <td class="py-2 px-4 border-b">{{ $terminal['terminal_fingerprints'] }}</td>
                    <td class="py-2 px-4 border-b">{{ $terminal['terminal_punches'] }}</td>
                    <td class="py-2 px-4 border-b">{{ $terminal['terminal_faces'] }}</td>
                    <td class="py-2 px-4 border-b">{{ $terminal['terminal_zem'] }}</td>
                    <td class="py-2 px-4 border-b">{{ $terminal['terminal_kind'] }}</td>
                    <td class="py-2 px-4 border-b">{{ $terminal['IsSelect'] }}</td>
                    <td class="py-2 px-4 border-b">{{ $terminal['terminal_timechk'] }}</td>
                    <td class="py-2 px-4 border-b">{{ $terminal['terminal_lastchk'] }}</td>
                </tr>
                @endforeach
            </tbody>
    
        </table>
    </section>
    
 
    {{-- @include('Reportes.vacacionesview') --}}
@endsection

@section('js-scripts')
@endsection
