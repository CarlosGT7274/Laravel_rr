@extends('layouts.base')

@section('content')
    <form method="POST" action="{{ route('attendance.graph') }}" class="w-full">
        @csrf
        <div class="flex flex-col items-center">
            <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 p-2 ">
                <div class="w-full flex flex-col items-center">
                    <label for="fecha" class="block text-dlight font-semibold mb-2">Fecha</label>
                    <input type="date" name="fecha" id="fecha" value="{{ $filtros['fecha'] }}"
                        class="border-b-2 border-ldark w-full py-2 px-3 text-dlight hover:border-primary">
                </div>

                <div class="w-full flex flex-col items-center">
                    <label for="Sunidad" class="block text-dlight font-semibold mb-2">Unidad</label>
                    <select name="unidad" id="Sunidad"
                        class="border-b-2 border-ldark w-full py-2 px-3 text-dlight hover:border-primary">
                        <option value="">Todos</option>
                        @foreach ($unidades as $item)
                            @if ($item['id_unidad'] == $filtros['unidad'])
                                <option selected value="{{ $item['id_unidad'] }}">{{ $item['nombre'] }}</option>
                            @else
                                <option value="{{ $item['id_unidad'] }}">{{ $item['nombre'] }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="w-full flex flex-col items-center">
                    <label for="Sregion" class="block text-dlight font-semibold mb-2">Departamento</label>
                    <select name="departamento" id="Sregion"
                        class="border-b-2 border-ldark w-full py-2 px-3 text-dlight hover:border-primary">
                        <option value="">Todos</option>
                        @foreach ($departamentos as $item)
                            @if ($item['id_departamento'] == $filtros['departamentoss'])
                                <option selected value="{{ $item['id_departamento'] }}">{{ $item['nombre'] }}</option>
                            @else
                                <option value="{{ $item['id_departamento'] }}">{{ $item['nombre'] }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="w-full flex flex-col items-center">
                    <label for="Spositions" class="block text-dlight font-semibold mb-2">Puesto</label>
                    <select name="posiciones" id="Spositions"
                        class="border-b-2 border-ldark w-full py-2 px-3 text-dlight hover:border-primary">
                        <option value="">Todos</option>
                        @foreach ($posiciones as $item)
                            @if ($item['id_puesto'] == $filtros['puesto'])
                                <option selected value="{{ $item['id_puesto'] }}">{{ $item['nombre'] }}</option>
                            @else
                                <option value="{{ $item['id_puesto'] }}">{{ $item['nombre'] }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="w-full flex flex-col items-center">
                    <label for="Sregion" class="block text-dlight font-semibold mb-2">Region</label>
                    <select name="region" id="Sregion"
                        class="border-b-2 border-ldark w-full py-2 px-3 text-dlight hover:border-primary">
                        <option value="">Todas</option>
                        @foreach ($unidades as $item)
                            @if ($item['region'] == $filtros['region'])
                                <option selected value="{{ $item['region'] }}">{{ $item['region'] }}</option>
                            @else
                                <option value="{{ $item['region'] }}">{{ $item['region'] }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>


            @if ($errors->has('fecha'))
                <p class="text-red-500 text-xs my-2">{{ $errors->first('fecha') }}</p>
            @endif

            <div class="flex flex-row gap-4">
                <button type="submit"
                    class="p-2 border-2 rounded-lg border-secondary font-bold hover:bg-secondary text-secondary hover:text-light">
                    Enviar
                </button>
                @if ($filtros['fecha'])
                    <a href="/dashboard"
                        class="p-2 hover:bg-danger rounded-lg border-2 border-danger font-bold text-danger hover:text-light">Limpiar
                        Filtros</a>
                @endif
            </div>

        </div>
    </form>


    <div id="graphics" class="grid grid-cols-1 md:grid-cols-3 gap-4 w-full px-4 md:px-8 ">

        <div class="flex flex-col  col-start-1 col-end-4 md:col-start-1 p-2">
            @if (session('permissions')[1]['sub_permissions'][102]['valor'] >= 0)
                <div class="md:col-start-1 md:col-end-4 flex flex-col shadow-lg rounded-[15px] p-2">
                    <header class="px-5 py-2 mt-2 mb-4 border-b border-dark">
                        <h2 class="text-lg font-semibold">General</h2>
                    </header>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-12 xl:flex-row">
                        <div
                            class="flex xl:flex-col justify-evenly xl:justify-around content-center px-3 py-2 xl:py-0 w-full md:col-start-1 md:col-end-2">
                            <div class="flex flex-col items-center">
                                <h3><i class="fa-solid fa-xl fa-people-group"></i></h3>
                                <span class="font-semibold">{{ $general['data']['total'] }}</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <h3><i class="fa-solid fa-xl fa-person text-secondary"></i></h3>
                                <span class="font-semibold">{{ $general['data']['hombres']['total'] }}</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <h3><i class="fa-solid fa-xl fa-person-dress text-fuchsia-400"></i></h3>
                                <span class="font-semibold">{{ $general['data']['mujeres']['total'] }}</span>
                            </div>
                        </div>

                        <div class="w-full p-3 xl:p-0 xl:col-span-4">
                            <h3>Edades</h3>
                            <div id="general" class="w-full p-3 xl:p-0 xl:col-span-3">
                                <input type="hidden" name="" id="jsonG" value="{{ json_encode($general) }}">
                            </div>
                        </div>

                        <div class="w-full p-3 xl:p-0 xl:col-span-4">
                            <h3>Trabajadores con hijos</h3>
                            <div id="childs" class="w-full p-3 xl:p-0 xl:col-span-3">
                            </div>
                        </div>

                        <div class="w-full p-3 xl:p-0 xl:col-span-3 flex flex-col items-center">
                            <h3>capacitaciones</h3>
                            <div id="capacitaciones" class="p-3 xl:p-0">
                                <input type="hidden" name="" id="jsonCa" value="{{ json_encode($general) }}">
                            </div>
                        </div>

                    </div>
                </div>
            @endif

            @if (session('permissions')[1]['sub_permissions'][103]['valor'] >= 0)
                <div class="w-full p-3 md:col-start-1 md:col-end-4 shadow-lg rounded-[15px]">
                    <header class="px-5 py-2 mt-2 mb-4 border-b border-dark ">
                        <h2 class="text-lg font-semibold">Cumpleaños del Mes</h2>
                    </header>
                    <ul class="overflow-y-auto h-36 flex flex-row flex-wrap gap-x-3 gap-y-2">
                        @foreach ($birthdays as $employee)
                            @if (is_array($employee))
                                @foreach ($employee as $key => $employeeData)
                                    <li class="p-4 shadow-md shadow-ldark rounded-md h-16">
                                        <div class="text-sm font-semibold">{{ $employeeData['nombre'] }}
                                            {{ $employeeData['apellidoP'] }} {{ $employeeData['apellidoM'] }}</div>
                                        <div class="text-dlight text-xs">{{ $employeeData['cumpleaños'] }}</div>
                                    </li>
                                @endforeach
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>


        <div class="md:col-start-1 md:col-end-4">
            @if (session('permissions')[1]['sub_permissions'][101]['valor'] >= 0)
                <div class="shadow-lg rounded-[15px] h-11/12">
                    <header class="px-5 py-4 border-b border-ldark flex items-center">
                        <h2 class="text-lg font-semibold">Asistencias</h2>
                    </header>
                    <div id="attendance" class="grow">
                        <input type="hidden" name="" id="jsonatt" value="{{ json_encode($attendance) }}">
                    </div>
                </div>
            @endif

            @if (session('permissions')[1]['sub_permissions'][105]['valor'] >= 0)
                <div class="w-full shadow-lg rounded-[15px] mt-4 md:mt-0 h-11/12">
                    <header class="px-5 py-4 border-b border-ldark">
                        <h2 class="text-lg font-semibold">Salarios</h2>
                    </header>
                    <div id="salaries" class="grow">
                        <input type="hidden" name="" id="jsonS" value="{{ json_encode($salaries) }}">
                    </div>
                </div>
            @endif

        </div>

        @if (session('permissions')[1]['sub_permissions'][104]['valor'] >= 0)
            <div class="flex flex-col shadow-lg rounded-[15px] col-start-1 col-end-4 md:col-start-1">
                <header class="px-5 py-4 border-b border-ldark">
                    <h2 class="text-lg font-semibold">Bajas</h2>
                </header>
                @if ($rotations['data']['total'] == 0)
                    <h3 class="py-12 mx-auto">Sin Bajas</h3>
                @else
                    <div class=" grid grid-col-3 ">
                        <input type="hidden" name="" id="jsonR" value="{{ json_encode($rotations) }}">


                        <div
                            class="flex xl:flex-row justify-evenly xl:justify-around content-center px-3 py-2 mt-4 xl:py-0 w-full ">
                            <div class="flex flex-col items-center">
                                <h4><i class="fa-solid fa-xl fa-people-group"></i></h4>
                                <span class="font-semibold">{{ $rotations['data']['total'] }}</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <h4><i class="fa-solid fa-xl fa-person text-secondary"></i></h4>
                                <span class="font-semibold">{{ $rotations['data']['hombres'] }}</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <h4><i class="fa-solid fa-xl fa-person-dress text-fuchsia-400"></i></h4>
                                <span class="font-semibold">{{ $rotations['data']['mujeres'] }}</span>
                            </div>
                        </div>


                        <div class="grid grid-cols-1 lg:grid-cols-3 my-4">
                            <div class="flex flex-col items-center">
                                <h4>Despidos por puesto</h4>
                                <div id="rotations" class="grow"> </div>
                            </div>
                            <div class="flex flex-col items-center">
                                <h4>Despidos por Motivo</h4>
                                <div id="rotationsM" class="grow"></div>
                            </div>
                            <div class="flex flex-col items-center">
                                <h4>Despidos por unidad</h4>
                                <div id="rotationsUnit" class="grow"> </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-4 mb-3">
                            <div class="flex flex-col items-center">
                                <h4>Recontratables</h4>
                                <div id="recontratables" class="grow"></div>
                            </div>
                            <div class="flex flex-col items-center">
                                <h4>Renuncias Firmadas</h4>
                                <div id="firmas"></div>
                            </div>
                            <div class="flex flex-col items-center">
                                <h4>Finiquitos Pagados</h4>
                                <div id="finiquitos"></div>
                            </div>

                            <div class="flex flex-col items-center">
                                <h4>Entrevistados</h4>
                                <div id="entrevistas"></div>
                            </div>
                        </div>

                    </div>
                @endif
            </div>
        @endif
        <br>
    </div>
@endsection

@section('footer')
@endsection

@section('js-scripts')
    @vite('resources/js/attendance.js')
    @vite('resources/js/general.js')
    @vite('resources/js/salaries.js')
    @vite('resources/js/rotations.js')
@endsection
