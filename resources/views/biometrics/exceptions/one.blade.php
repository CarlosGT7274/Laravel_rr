@extends('layouts.one')

@section('title')
    <h1 class="text-2xl font-semibold flex-1">{{ $data['fecha_excep'] }}</h1>
@endsection


@section('inputs')
    {{-- @if ($errors->has('observacion'))
        {{dd($errors)}}
    @endif --}}

    <section class="w-5/6 md:w-2/3 xl:w-5/6 grid xl:grid-cols-2 gap-x-8 gap-y-8 mx-auto">
        <input type="hidden" name="id" readonly value="{{ $data['id'] }}">

        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">Fecha de exepcion: </label>
            <input type="datetime-local" step="1" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                name="fecha_excep" readonly value="{{ $data['fecha_excep'] }}" id="name">
        </div>
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">Fecha inicio: </label>
            <input type="datetime-local" step="1" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                name="tiempoini" readonly value="{{ $data['tiempoini'] }}" id="name">
        </div>
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">Fecha termino: </label>
            <input type="datetime-local" step="1" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                name="tiempofin" readonly value="{{ $data['tiempofin'] }}" id="name">
        </div>
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">Observaciones: </label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="observacion"
                readonly value="{{ $data['observacion'] }}" id="name">
        </div>

        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="empleados">Código de pago: </label>
            <select name="id_codpago"
                class="w-full mb-1 border-b-2 border-b-ldark flex flex-row gap-2 items-center justify-around hover:border-b-primary p-2"
                id="empleados" disabled>
                @foreach ($codigos as $codigo)
                    <option value="{{ $codigo['id_codigo_pago'] }}" @if ($data['id_codpago'] === $codigo['id_codigo_pago']) selected @endif>
                        {{ $codigo['descripcion'] }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="empleados">Empleados:</label>
            <select name="id_trabajador"
                class="w-full mb-1 border-b-2 border-b-ldark flex flex-row gap-2 items-center justify-around hover:border-b-primary p-2"
                id="empleados" disabled>
                @foreach ($empleados as $empleado)
                    <option value="{{ $empleado['id_empleado'] }}" @if ($data['id_trabajador'] === $empleado['id_empleado']) selected @endif>
                        {{ $empleado['nombre'] . ' ' . $empleado['apellidoP'] . ' ' . $empleado['apellidoM'] }}
                    </option>
                @endforeach
            </select>
        </div>

    </section>
@endsection
