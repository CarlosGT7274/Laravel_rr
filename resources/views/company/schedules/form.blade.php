@extends('layouts.form')

@section('inputs')
    <section class="w-5/6 md:w-2/3 lg:w-5/6 grid grid-cols-2 xl:gap-x-20 gap-y-12">
        <div>
            <label for="des">Descripción</label>
            <x-input id="des" icon="" autocomplete="" type="text" name="descripción"
                placeholder="Descripción del Horario" />
        </div>

        <div>
            <h2>Incluye Hora de Comida</h2>
            <div
                class="mb-1 border-b-2 border-b-ldark flex flex-row gap-2 items-center justify-around hover:border-b-primary p-2">
                <x-radio name="incluye_hora_de_comida" id="C" value="1" label="Incluye" checked=""
                    readonly="" />
                <x-radio name="incluye_hora_de_comida" id="N" value="0" label="No Incluye" checked=""
                    readonly="" />
            </div>
            @if ($errors->has('incluye_hora_de_comida'))
                <span class="text-danger">{{ $errors->first('incluye_hora_de_comida') }}</span>
            @endif
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
                        <x-radio name="detalles[{{ $i }}][tipo]" id="L{{ $i }}" value="1"
                            label="Laboral" checked="yes" readonly="" />
                        <x-radio name="detalles[{{ $i }}][tipo]" id="D{{ $i }}" value="0"
                            label="Descanso" checked="" readonly="" />
                    </div>
                    @if ($errors->has('detalles.' . $i . '.tipo'))
                        <span class="text-danger">El campo Tipo</span>
                    @endif
                </div>
                <div class="grid grid-cols-2 gap-4 my-3">
                    <div class="detail-input">
                        <h3>Entrada</h3>
                        <x-input type="time" name="detalles[{{ $i }}][inicio]" icon="" />
                        @if ($errors->has('detalles.' . $i . '.inicio'))
                            <span class="text-danger">Falta un hora de entrada</span>
                        @endif
                    </div>
                    <div class="detail-input">
                        <h3>Tolerancia</h3>
                        <x-input type="number" name="detalles[{{ $i }}][toleranciaIn]" icon=""
                            min="0" step="" max="" placeholder="Tolerancia Entrada" />
                        @if ($errors->has('detalles.' . $i . '.toleranciaIn'))
                            <span class="text-danger">Falta una Tolerancia</span>
                        @endif
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="detail-input">
                        <h3>Salida</h3>
                        <x-input type="time" name="detalles[{{ $i }}][fin]" icon="" />
                        @if ($errors->has('detalles.' . $i . '.fin'))
                            <span class="text-danger">Falta un hora de salida</span>
                        @endif
                    </div>
                    <div class="detail-input">
                        <h3>Tolerancia</h3>
                        <x-input type="number" name="detalles[{{ $i }}][toleranciaFin]" icon=""
                            min="0" step="" max="" placeholder="Tolerancia Salida" />
                        @if ($errors->has('detalles.' . $i . '.toleranciaFin'))
                            <span class="text-danger">Falta una Tolerancia</span>
                        @endif
                    </div>
                </div>
            </div>
        @endfor

    </section>

    @vite('resources/js/scheduleInputs.js')
@endsection
