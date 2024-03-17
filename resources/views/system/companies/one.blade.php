@extends('layouts.one')

@section('title')
    <h1 class="text-2xl font-semibold flex-1">{{ $data['razonSocial'] }}</h1>
@endsection

@section('inputs')
    <section class="w-5/6 md:w-2/3 xl:w-5/6 grid xl:grid-cols-2 gap-x-8 gap-y-8 mx-auto">
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">Razon Social: </label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="razón_social" readonly
                value="{{ $data['razonSocial'] }}" id="name" >
        </div>
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">rfc: </label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="rfc" readonly
                value="{{ $data['rfc'] }}" id="name">
        </div>
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">giroComercial: </label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="giro_comercial" readonly
                value="{{ $data['giroComercial'] }}" id="name">
        </div>
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">contacto: </label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="contacto" readonly
                value="{{ $data['contacto'] }}" id="name" >
        </div>
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">telefono: </label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="teléfono" readonly
                value="{{ $data['telefono'] }}" id="name" >
        </div>
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">email: </label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="email" readonly
                value="{{ $data['email'] }}" id="name">
        </div>
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">fax: </label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="fax" readonly
                value="{{ $data['fax'] }}" id="name">
        </div>
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">web: </label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="web" readonly
                value="{{ $data['web'] }}" id="name">
        </div>
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">calle: </label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="calle" readonly
                value="{{ $data['calle'] }}" id="name">
        </div>
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">colonia: </label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="colonia" readonly
                value="{{ $data['colonia'] }}" id="name">
        </div>
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">poblacion: </label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="población" readonly
                value="{{ $data['poblacion'] }}" id="name">
        </div>
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">Estado</label>
            <select disabled class="h-10 border-b-2 border-ldark flex-1" id="estado" name="estado">
                <option disabled>-- Seleccione una opción --</option>
                @foreach (app('estados_mx') as $key => $estado)
                    @if ($data['estado'] == $key)
                        <option value="{{ $key }}" selected> {{ $estado }} </option>
                    @else
                        <option value="{{ $key }}"> {{ $estado }} </option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">logo: </label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="logo" readonly
                value="{{ $data['logo'] }}" id="name">
        </div>
    </section>
@endsection


