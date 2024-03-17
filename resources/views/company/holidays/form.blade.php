@extends('layouts.form')

@section('inputs')
    <section class="w-5/6 md:w-2/3 lg:w-5/6 grid lg:grid-cols-2 lg:gap-x-20 gap-y-12">
        <div>
            <label for="name">Nombre</label>
            <x-input id="name" icon="" autocomplete="" type="text" name="nombre"
                placeholder="Nombre del Dia Feriado" />
        </div>

        <div>
            <h2>Tipo</h2>
            <div
                class="mb-1 border-b-2 border-b-ldark flex flex-row gap-2 items-center justify-around hover:border-b-primary p-2">
                <x-radio name="tipo" id="O" value=1 label="Oficial" checked="yes" readonly="" />
                <x-radio name="tipo" id="no-O" value=0 label="No Oficial" checked="" readonly="" />
            </div>
        </div>

        <div class=" 0">
            <label for="inicio">Inicio</label>
            <x-input id="inicio" icon="" type="date" name="inicio" />
        </div>

        <div>
            <label for="fin">Fin</label>
            <x-input id="fin" icon="" type="date" name="fin" />
        </div>
    </section>
@endsection
