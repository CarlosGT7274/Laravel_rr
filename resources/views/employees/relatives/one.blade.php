@extends('layouts.one')

@section('title')
    <h1 class="text-2xl font-semibold flex-1">{{ $data['nombre'] }}</h1>
@endsection

@section('inputs')
    <section class="w-5/6 md:w-2/3 xl:w-5/6 grid xl:grid-cols-2 gap-x-8 gap-y-8 mx-auto">
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="nombre">Nombre:</label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="nombre" readonly
                value="{{ $data['nombre'] }}" id="name">
        </div>

        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="apellido_paterno">Apellido Paterno:</label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                name="apellido_paterno" readonly value="{{ $data['apellidoP'] }}" id="apellido_paterno">
        </div>

        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="apellido_materno">Apellido Materno: </label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                name="apellido_materno" readonly value="{{ $data['apellidoM'] }}" id="apellido_materno">
        </div>

        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="teléfono">Teléfono</label>
            <input type="tel" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="teléfono"
                readonly value="{{ $data['telefono'] }}" id="teléfono">
        </div>

        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="teléfono_de_respaldo">Teléfono de respaldo</label>
            <input type="tel" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                name="teléfono_de_respaldo" readonly value="{{ $data['telefono2'] }}" id="teléfono_de_respaldo">
        </div>

        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="parentesco">Parentesco:</label>
            <select class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" id="parentesco" name="parentesco">
                <option selected value="">-- Seleccione una opción --</option>
                @foreach (app('parentescos') as $key => $value)
                    <option value="{{ $key }}" @if ((int) $data['parentesco'] === (int) $key) selected @endif>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>
    </section>
@endsection

@section('extra-info')
@endsection
