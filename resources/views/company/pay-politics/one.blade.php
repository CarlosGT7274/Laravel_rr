@extends('layouts.one')

@section('title')
    <h1 class="text-2xl font-semibold flex-1">{{ $data['nombre'] }}</h1>
@endsection

@section('inputs')
    <section class="w-5/6 md:w-2/3 xl:w-5/6 grid lg:grid-cols-2 gap-x-8 gap-y-8 mx-auto">
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-36" for="nombre">Nombre: </label>
            <input class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" readonly id="nombre" type="text"
                name="nombre" placeholder="Nombre de la Política" value="{{ $data['nombre'] }}" />
        </div>
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-36" for="cod">Activo: </label>
            <input class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" readonly id="cod"
                type="number" min="0" max="1" name="activo" placeholder="Está Activo?"
                value="{{ $data['activo'] }}" />
        </div>
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-36" for="sig">Paga Días Feriados: </label>
            <input class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" readonly id="sig"
                type="number" min="0" max="1" name="paga_días_feriados"
                placeholder="Indica si se pagan Feriados" value="{{ $data['pagaFeriados'] }}" />
        </div>
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-36" for="sig">Paga horas Extras: </label>
            <input class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" readonly id="sig"
                type="number" min="0" max="1" name="paga_horas_extras"
                placeholder="Indica si se pagan Feriados" value="{{ $data['pagaExtras'] }}" />
        </div>
    </section>
@endsection
