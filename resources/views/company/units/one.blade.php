@extends('layouts.one')

@section('title')
    <h1 class="text-2xl font-semibold flex-1">{{ $data['nombre'] }}</h1>
@endsection

@section('inputs')
    <section class="w-5/6 md:w-2/3 xl:w-5/6 grid xl:grid-cols-9 gap-x-8 gap-y-8 mx-auto">
        <div class="xl:col-start-1 xl:col-end-4 flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">Nombre: </label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="nombre" readonly
                value="{{ $data['nombre'] }}" id="name">
        </div>

        <div class="xl:col-start-4 xl:col-end-7 flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="tipo">Tipo: </label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="tipo"
                readonly value="{{ $data['tipo'] }}" id="tipo">
        </div>

        <div class="xl:col-start-7 xl:col-end-10 flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="pob">Población: </label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="población"
                readonly value="{{ $data['poblacion'] }}" id="pob">
        </div>

        <div class="xl:col-start-2 xl:col-end-5 flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="reg">Región:</label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="región"
                readonly value="{{ $data['region'] }}" id="reg">
        </div>

        <div class="xl:col-start-6 xl:col-end-9 flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">Estado</label>
            <select disabled class="h-10 border-b-2 border-ldark flex-1" id="estado" name="estado">
                <option disabled>-- Seleccione una opción --</option>
                @foreach (app('estados_mx') as $key => $estado)
                    @if ($data['estado'] == $key)
                        <option value="{{ $key }}" selected> {{ $estado }} </option>
                    @else
                        <option value="{{ $key }}"> {{ $estado }} </option>
                    @endif
                @endforeach
            </select>
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
