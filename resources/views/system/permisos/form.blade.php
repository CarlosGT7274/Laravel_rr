@extends('layouts.form')

@section('inputs')
    <section class="w-5/6 md:w-2/3 lg:w-5/6 grid xl:grid-cols-9 xl:gap-x-20 gap-y-12">
        <div class="xl:col-start-1 xl:col-end-4">
            <label for="name">Nombre</label>
            <x-input id="name" icon="" autocomplete="" type="text" name="nombre_del_permiso" placeholder="Nombre del Permiso "
                defaultValue="" />
        </div>

        <div class="xl:col-start-4 xl:col-end-7">
            <label for="tipo">Padre</label>
            <x-input id="tipo" icon="" autocomplete="" type="number" max="" min="0" name="clave_del_padre" step=""
                placeholder="Padre del permiso" defaultValue="" />
        </div>

        <div class="xl:col-start-7 xl:col-end-10">
            <label for="poblacion">Endpoint</label>
            <x-input id="poblacion" icon="" autocomplete="" type="text" name="endpoint"
                placeholder="Endpoint" defaultValue="" />
        </div>

        <div class="xl:col-start-2 xl:col-end-5">
            <label for="region">Activo</label>
            <x-input id="region" icon="" autocomplete="" type="number" min="0" max="1" step="" name="activo"
                placeholder="¿Esta activo?" defaultValue="" />
        </div>

        <div class="xl:col-start-6 xl:col-end-9">
            <label for="region">Clave</label>
            <x-input id="region" icon="" autocomplete="" type="number" min="0" max="" step="" name="clave"
                placeholder="Clave del permiso" defaultValue="" />
        </div>

        {{-- <div class="xl:col-start-6 xl:col-end-9">
            <label for="estado">Estado</label>
            @include('components.select-state')
        </div> --}}
    </section>
@endsection