@extends('layouts.one')

@section('title')
    <h1 class="text-2xl font-semibold flex-1">{{ $data['nombre'] }}</h1>
@endsection

@section('inputs')
    <section class="w-5/6 md:w-2/3 xl:w-5/6 grid xl:grid-cols-2 gap-x-8 gap-y-8 mx-auto">
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">ID: </label>
            <input type="number" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="clave" readonly
                value="{{ $data['id_permiso'] }}" id="name" min="0">
        </div>
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">Nombre: </label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="nombre_del_permiso" readonly
                value="{{ $data['nombre'] }}" id="name">
        </div>
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">endpoint: </label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="endpoint" readonly
                value="{{ $data['endpoint'] }}" id="name">
        </div>
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">activo: </label>
            <input type="number" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="activo" readonly
                value="{{ $data['activo'] }}" id="name" max="1" min="0">
        </div>
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">padre: </label>
            <input type="number" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="clave_del_padre" readonly
                value="{{ $data['padre'] }}" id="name" min="0">
        </div>
    </section>
@endsection


