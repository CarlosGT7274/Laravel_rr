@extends('layouts.one')

@section('title')
    <h1 class="text-2xl font-semibold flex-1">{{ $data['descripcion'] }}</h1>
@endsection

@section('inputs')
    @if ($errors->has('descripción'))
        {{ dd($errors) }}
    @endif

    <section class="w-5/6 md:w-2/3 xl:w-5/6 grid lg:grid-cols-2 gap-x-8 gap-y-8 mx-auto">
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="descripcion">Descripción: </label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="descripción"
                readonly value="{{ $data['descripcion'] }}" id="descripcion">
        </div>

        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="cod">Número de Percepción: </label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" readonly
                name="número_de_percepción" value="{{ $data['codexport'] }}" id="cod">
        </div>

        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="abv">Abreviatura:</label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="abreviatura"
                readonly value="{{ $data['siglas'] }}" id="abv">
        </div>

        <div class="flex flex-row items-center gap-2 p-2">
            <h2 class="w-32">Tipo: </h2>
            <div class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1 flex flex-row justify-evenly">
                @if ($data['tipo'] == -1)
                    <x-radio name="tipo" id="D" value=1 label="Percepción" checked="" readonly="yes" />
                    <x-radio name="tipo" id="P" value=-1 label="Deducción" checked="yes" readonly="yes" />
                @else
                    <x-radio name="tipo" id="D" value=1 label="Percepción" checked="yes" readonly="yes" />
                    <x-radio name="tipo" id="P" value=-1 label="Deducción" checked="" readonly="yes" />
                @endif
            </div>
        </div>
    </section>
@endsection

@section('extra-info')
    <section class="mt-8">
        <header>
            @if ($failed)
                <span class="text-danger"> No se pudo eliminar debido a que tiene empleados asignados</span>
            @endif
            <h2 class="text-xl font-semibold">Politicas de Pago Relacionadas</h2>
        </header>
        <div class="mt-3 grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-10">
            @foreach ($data['politics'] as $item)
                <a class="border-b-2 border-ldark hover:border-primary w-full text-center font-semibold cursor-pointer select-none h-16 hover:text-primary flex items-center justify-center"
                    href="{{ route('company.pay-politics.one', ['father_id' => $data['id_codigo_pago'], 'id' => $item['id_politica_pago']]) }}">
                    {{ $item['nombre'] }}
                </a>
            @endforeach
            <a class="border-b-2 border-ldark hover:border-success w-full text-center font-semibold cursor-pointer select-none h-16 hover:text-success flex items-center justify-center"
                href="{{ route('company.pay-politics.form', ['father_id' => $data['id_codigo_pago']]) }}">
                <i class="fa-solid fa-plus fa-xl"></i>
            </a>
        </div>
    </section>
@endsection
