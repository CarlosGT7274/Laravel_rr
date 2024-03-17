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
            <label class="w-32" for="sueldoSug">Sueldo Sugerido: </label>
            <input type="number" step="0.01" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                name="sueldo_sugerido" readonly value="{{ $data['sueldoSug'] }}" id="sueldoSug">
        </div>

        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="sueldoMax">Sueldo Máximo: </label>
            <input type="number" step="0.01" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                name="sueldo_máximo" readonly value="{{ $data['sueldoMax'] }}" id="sueldoMax">
        </div>

        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="riesgo">Clave de Riesgo:</label>
            <input type="number" min="1" max="5"
                class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="clave" readonly
                value="{{ $data['riesgo'] }}" id="riesgo">
        </div>
    </section>
@endsection

@section('extra-info')
    <section class="mt-8">
        <header>
            @if ($failed)
                <span class="text-danger"> No se pudo eliminar debido a que tiene empleados asignados</span>
            @endif
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
