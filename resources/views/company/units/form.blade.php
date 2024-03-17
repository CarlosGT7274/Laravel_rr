@extends('layouts.form')

@section('inputs')
    <section class="w-5/6 md:w-2/3 lg:w-5/6 grid xl:grid-cols-9 xl:gap-x-20 gap-y-12">
        <div class="xl:col-start-1 xl:col-end-4">
            <label for="name">Nombre</label>
            <x-input id="name" icon="" autocomplete="" type="text" name="nombre"
                placeholder="Nombre de la unidad" />
        </div>

        <div class="xl:col-start-4 xl:col-end-7">
            <label for="tipo">Tipo</label>
            <x-input id="tipo" icon="" autocomplete="" type="text" name="tipo"
                placeholder="Tipo de la unidad" />
        </div>

        <div class="xl:col-start-7 xl:col-end-10">
            <label for="poblacion">Población</label>
            <x-input id="poblacion" icon="" autocomplete="" type="text" name="población"
                placeholder="Población de la unidad" />
        </div>

        <div class="xl:col-start-2 xl:col-end-5">
            <label for="region">Region</label>
            <x-input id="region" icon="" autocomplete="" type="text" name="región"
                placeholder="Región de la unidad" />
        </div>

        <div class="xl:col-start-6 xl:col-end-9">
            <label for="estado">Estado</label>
            @include('components.select-state')
        </div>
    </section>
@endsection
