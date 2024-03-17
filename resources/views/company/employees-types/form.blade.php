@extends('layouts.form')

@section('inputs')
    <section class="w-full">
        <label for="name">Nombre</label>
        <x-input id="name" icon="" needsUnhidden="" autocomplete="" type="text" name="nombre"
            placeholder="Nombre del Tipo de Empleado" />
    </section>
@endsection
