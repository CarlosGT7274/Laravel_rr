@extends('layouts.form')

@section('inputs')
    <section class="w-5/6 md:w-2/3 lg:w-5/6 grid xl:grid-cols-9 xl:gap-x-20 gap-y-12">
        <div class="xl:col-start-1 xl:col-end-4">
            <label class="w-32" for="name">Razon Social: </label>
            <x-input id="name" icon="" autocomplete="" type="text" name="razón_social" placeholder="razón social"
                defaultValue="" />
        </div>

        <div class="xl:col-start-4 xl:col-end-7">
            <label for="tipo">rfc:</label>
            <x-input id="tipo" icon="" autocomplete="" type="number" max="" min="0" name="rfc" step=""
                placeholder="rfc" defaultValue="" />
        </div>

        <div class="xl:col-start-7 xl:col-end-10">
            <label for="poblacion">giroComercial:</label>
            <x-input id="poblacion" icon="" autocomplete="" type="text" name="giro_comercial"
                placeholder="giroComercial" defaultValue="" />
        </div>

        <div class="xl:col-start-2 xl:col-end-5">
            <label for="region">contacto:</label>
            <x-input id="region" icon="" autocomplete="" type="text"  step="" name="contacto"
                placeholder="contacto" defaultValue="" />
        </div>

        <div class="xl:col-start-6 xl:col-end-9">
            <label for="region">telefono:</label>
            <x-input id="region" icon="" autocomplete="" type="text"  step="" name="teléfono"
                placeholder="telefono" defaultValue="" />
        </div>

        <div class="xl:col-start-1 xl:col-end-4">
            <label for="region">email:</label>
            <x-input id="region" icon="" autocomplete="" type="text"  step="" name="email"
                placeholder="email" defaultValue="" />
        </div>
        <div class="xl:col-start-4 xl:col-end-7">
            <label for="region">fax:</label>
            <x-input id="region" icon="" autocomplete="" type="text"  step="" name="fax"
                placeholder="fax" defaultValue="" />
        </div>
        <div class="xl:col-start-7 xl:col-end-10">
            <label for="region">web:</label>
            <x-input id="region" icon="" autocomplete="" type="text"  step="" name="web"
                placeholder="web" defaultValue="" />
        </div>
        <div class="xl:col-start-2 xl:col-end-5">
            <label for="region">calle:</label>
            <x-input id="region" icon="" autocomplete="" type="text"  step="" name="calle"
                placeholder="calle" defaultValue="" />
        </div>
        <div class="xl:col-start-6 xl:col-end-9">
            <label for="region">colonia:</label>
            <x-input id="region" icon="" autocomplete="" type="text"  step="" name="colonia"
                placeholder="colonia" defaultValue="" />
        </div>
        <div class="xl:col-start-1 xl:col-end-4">
            <label for="region">poblacion:</label>
            <x-input id="region" icon="" autocomplete="" type="text"  step="" name="población"
                placeholder="poblacion" defaultValue="" />
        </div>
        <div class="xl:col-start-4 xl:col-end-7">
            <label for="estado">Estado</label>
            @include('components.select-state')
        </div>
        <div class="xl:col-start-7 xl:col-end-10">
            <label for="region">logo:</label>
            <x-input id="region" icon="" autocomplete="" type="text"  step="" name="logo"
                placeholder="logo" defaultValue="" />
        </div>

    </section>
@endsection