@extends('layouts.form')

@section('inputs')
    <section class="w-5/6 md:w-2/3 lg:w-5/6 grid lg:grid-cols-2 lg:gap-x-20 gap-y-12">
        <div>
            <label for="name">Nombre</label>
            <x-input id="name" icon="" autocomplete="" type="text" name="nombre"
                placeholder="Nombre del Puesto" />
        </div>

        <div>
            <label for="name">Sueldo Sugerido</label>
            <x-input id="name" icon="" type="number" name="sueldo_sugerido" min="" max=""
                step="0.01" placeholder="Sueldo Sugerido para el Puesto" />
        </div>

        <div class=" 0">
            <label for="name">Sueldo Máximo</label>
            <x-input id="name" icon="" type="number" name="sueldo_máximo" min="" max=""
                step="0.01" placeholder="Sueldo Máximo para el Puesto" />
        </div>

        <div>
            <label for="name">Clave de Riesgo</label>
            <x-input id="name" icon="" type="number" name="clave" min="1" max="5"
                step="" placeholder="Clave de Riesgo según seguro social" />
        </div>
    </section>
@endsection
