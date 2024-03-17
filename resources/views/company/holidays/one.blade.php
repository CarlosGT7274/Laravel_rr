@extends('layouts.one')

@section('title')
    <h1 class="text-2xl font-semibold flex-1">{{ $data['nombre'] }}</h1>
@endsection

@section('inputs')
    <section class="w-5/6 md:w-2/3 xl:w-5/6 grid xl:grid-cols-2 gap-x-8 gap-y-8 mx-auto">
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">Nombre: </label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="nombre" readonly
                value="{{ $data['nombre'] }}" id="name">
        </div>

        <div class="flex flex-row items-center gap-2 p-2">
            <h2 class="w-32">Tipo: </h2>
            <div class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1 flex flex-row justify-evenly">
                @if ($data['tipo'] == 0)
                    <x-radio name="tipo" id="O" value=1 label="Oficial" checked="" readonly="yes" />
                    <x-radio name="tipo" id="no-O" value=0 label="No Oficial" checked="yes" readonly="yes" />
                @else
                    <x-radio name="tipo" id="O" value=1 label="Oficial" checked="yes" readonly="yes" />
                    <x-radio name="tipo" id="no-O" value=0 label="No Oficial" checked="" readonly="yes" />
                @endif
            </div>
        </div>

        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="inicio">Fecha de Inicio: </label>
            <input type="date" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="inicio"
                readonly value="{{ $data['inicio'] }}" id="inicio">
        </div>

        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="fin">Fecha de Fin:</label>
            <input type="date" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="fin"
                readonly value="{{ $data['fin'] }}" id="fin">
        </div>
        @if ($errors->has('fin'))
            <span class="text-danger">{{ $errors->first('fin') }}</span>
        @endif
    </section>
@endsection

@section('extra-info')
@endsection
