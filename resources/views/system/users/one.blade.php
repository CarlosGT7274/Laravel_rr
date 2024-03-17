@extends('layouts.one')

@section('title')
    <h1 class="text-2xl font-semibold flex-1">{{ $data['nombre'] . ' ' . $data['apellidoP'] . ' ' . $data['apellidoM'] }}</h1>
@endsection


@section('inputs')
    {{-- @if ($errors->has('observacion'))
        {{dd($errors)}}
    @endif --}}

    <section class="w-5/6 md:w-2/3 xl:w-5/6 grid xl:grid-cols-2 gap-x-8 gap-y-8 mx-auto">
        {{-- <input type="hidden" name="id" readonly value="{{ $data['id_usuario'] }}"> --}}

        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">Email: </label>
            <input type="email"class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                name="correo" readonly value="{{ $data['email'] }}" id="name">
        </div>
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">Nombre: </label>
            <input type="text"  class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                name="nombre" readonly value="{{ $data['nombre'] }}" id="name">
        </div>
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">Apellido Paterno: </label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="apellido_paterno"
                readonly value="{{ $data['apellidoP'] }}" id="name">
        </div>
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">Apellido Materno: </label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="apellido_materno"
                readonly value="{{ $data['apellidoM'] }}" id="name">
        </div>

        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">Activo: </label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="activo"
                readonly value="{{ $data['activo'] }}" id="name">
        </div>
        {{-- @dump($errors) --}}
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="empleados">Rol: </label>
            <select name="rol"
                class="w-full mb-1 border-b-2 border-b-ldark flex flex-row gap-2 items-center justify-around hover:border-b-primary p-2"
                id="empleados" disabled>
                @foreach ($roles as $codigo)
                    <option value="{{ $codigo['id_rol'] }}" @if ($data['id_rol'] == $codigo['id_rol']) selected @endif >
                        {{ $codigo['nombre'] }}
                    </option>
                @endforeach
            </select>
        </div>

    </section>
@endsection
