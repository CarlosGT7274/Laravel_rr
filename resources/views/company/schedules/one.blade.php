@extends('layouts.one')

@section('title')
    <h1 class="text-2xl font-semibold flex-1">{{ $data['descripcion'] }}</h1>
    @if ($failed)
        <span class="text-danger"> No se pudo eliminar debido a que tiene empleados asignados</span>
    @endif
@endsection

@section('inputs')
    <section class="w-5/6 md:w-2/3 xl:w-5/6 grid grid-cols-2 gap-x-8 gap-y-8 mx-auto">

        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="des">Descripción:</label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="descripción"
                readonly value="{{ $data['descripcion'] }}" id="des">
        </div>

        <div class="flex flex-row items-center gap-2 p-2">
            <h2 class="w-32">Incluye Hora de Comida: </h2>
            <div class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1 flex flex-row justify-evenly">
                @if ($data['conComida'] == 0)
                    <x-radio name="incluye_hora_de_comida" id="C" value="1" label="Incluye" checked=""
                        readonly="yes" />
                    <x-radio name="incluye_hora_de_comida" id="N" value="0" label="No Incluye" checked="yes"
                        readonly="yes" />
                @else
                    <x-radio name="incluye_hora_de_comida" id="C" value="1" label="Incluye" checked="yes"
                        readonly="yes" />
                    <x-radio name="incluye_hora_de_comida" id="N" value="0" label="No Incluye" checked=""
                        readonly="yes" />
                @endif
            </div>
        </div>

        <input hidden value="1" name="estado">

        @for ($i = 0; $i < 7; $i++)
            <div class="detalles-wrapper">
                <h2 class="text-lg font-semibold">
                    @switch($i)
                        @case(0)
                            Lunes
                        @break

                        @case(1)
                            Martes
                        @break

                        @case(2)
                            Miércoles
                        @break

                        @case(3)
                            Jueves
                        @break

                        @case(4)
                            Viernes
                        @break

                        @case(5)
                            Sábado
                        @break

                        @case(6)
                            Domingo
                        @break
                    @endswitch
                </h2>
                <input name="detalles[{{ $i }}][día]" type="number" hidden value="{{ $i + 1 }}">
                <div>
                    <h3 class="mt-3">Tipo</h3>
                    <div
                        class="mb-1 border-b-2 border-b-ldark flex flex-row gap-2 items-center justify-around hover:border-b-primary p-2">
                        @if ($data['detalles'][$i]['tipo'] == 0)
                            <x-radio name="detalles[{{ $i }}][tipo]" id="L{{ $i }}" value="1"
                                label="Laboral" checked="" readonly="yes" />
                            <x-radio name="detalles[{{ $i }}][tipo]" id="D{{ $i }}" value="0"
                                label="Descanso" checked="yes" readonly="yes" />
                        @else
                            <x-radio name="detalles[{{ $i }}][tipo]" id="L{{ $i }}" value="1"
                                label="Laboral" checked="yes" readonly="yes" />
                            <x-radio name="detalles[{{ $i }}][tipo]" id="D{{ $i }}" value="0"
                                label="Descanso" checked="" readonly="yes" />
                        @endif
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 my-3">
                    <div class="detail-input">
                        <h3>Entrada</h3>
                        <input type="time" class="border-b-2 border-ldark cursor-default p-1 text-ldark w-full"
                            step="1" name="detalles[{{ $i }}][inicio]" readonly
                            value="{{ $data['detalles'][$i]['inicio'] }}">
                    </div>
                    <div class="detail-input">
                        <h3>Tolerancia</h3>
                        <input type="number" class="border-b-2 border-ldark cursor-default p-1 text-ldark w-full"
                            name="detalles[{{ $i }}][toleranciaIn]" readonly
                            value="{{ $data['detalles'][$i]['toleranciaIn'] }}" min="0">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="detail-input">
                        <h3>Salida</h3>
                        <input type="time" class="border-b-2 border-ldark cursor-default p-1 text-ldark w-full"
                            step="1" name="detalles[{{ $i }}][fin]" readonly
                            value="{{ $data['detalles'][$i]['fin'] }}">
                    </div>
                    <div class="detail-input">
                        <h3>Tolerancia</h3>
                        <input type="number" class="border-b-2 border-ldark cursor-default p-1 text-ldark w-full"
                            name="detalles[{{ $i }}][toleranciaFin]" readonly
                            value="{{ $data['detalles'][$i]['toleranciaFin'] }}" min="0">
                    </div>
                </div>
            </div>
        @endfor

    </section>

    @vite('resources/js/scheduleInputs.js')
@endsection

@section('extra-info')
    <section class="mt-4">
        <header>
            <h2 class="text-xl font-semibold">Empleados Asignados</h2>
        </header>
        <div class="mt-3 grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-10">
            @foreach ($data['empleados'] as $item)
                <p class="border-b-2 border-ldark w-full text-center select-none h-12 flex items-center justify-center">
                    {{ $item['nombre'] . ' ' . $item['apellidoP'] . ' ' . $item['apellidoM'] }}
                </p>
            @endforeach
        </div>
    </section>
@endsection
