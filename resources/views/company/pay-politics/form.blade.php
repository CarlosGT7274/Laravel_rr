@extends('layouts.form')

@section('inputs')
    <section class="w-5/6 md:w-2/3 lg:w-5/6 grid lg:grid-cols-2 lg:gap-x-20 gap-y-12">
        <div>
            <label for="nombre">Nombre</label>
            <x-input id="nombre" icon="" type="text" name="nombre" placeholder="Nombre de la Política" />
        </div>

        <div>
            <label for="cod">Activo</label>
            <x-input id="cod" icon="" type="number" min="0" max="1" step="" name="activo"
                placeholder="Está Activo?" />
        </div>

        <div>
            <label for="sig">Paga Días Feriados</label>
            <x-input id="sig" icon="" type="number" min="0" max="1" step=""
                name="paga_días_feriados" placeholder="Indica si se pagan Feriados" />
        </div>

        <div>
            <label for="sig">Paga horas Extras</label>
            <x-input id="sig" icon="" type="number" min="0" max="1" step=""
                name="paga_horas_extras" placeholder="Indica si se pagan Feriados" />
        </div>
    </section>
@endsection
