@extends('layouts.form')

@section('inputs')
    <section class="w-5/6 md:w-2/3 lg:w-5/6 grid lg:grid-cols-2 lg:gap-x-20 gap-y-12">
        <div>
            <label for="des">Descripción</label>
            <x-input id="des" icon="" autocomplete="" type="text" name="descripción"
                placeholder="Descripción del Código" />
        </div>

        <div>
            <label for="cod">Número de Percepción</label>
            <x-input id="cod" icon="" autocomplete="" type="text" name="número_de_percepción"
                placeholder="Número de percpción para interfaz de nómina" />
        </div>

        <div>
            <label for="sig">Abreviatura</label>
            <x-input id="sig" icon="" autocomplete="" type="text" name="abreviatura"
                placeholder="Abreviatura para el código" />
        </div>

        <div>
            <h2>Tipo</h2>
            <div
                class="mb-1 border-b-2 border-b-ldark flex flex-row gap-2 items-center justify-around hover:border-b-primary p-2">
                <x-radio name="tipo" id="D" value=1 label="Percepción" checked="yes" readonly="" />
                <x-radio name="tipo" id="P" value=-1 label="Deducción" checked="" readonly="" />
            </div>
        </div>
    </section>
@endsection
