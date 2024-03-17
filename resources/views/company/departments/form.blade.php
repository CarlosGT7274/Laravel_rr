@extends('layouts.form')

@section('inputs')
    <section class="w-full">
        <label for="name">Nombre</label>
        <x-input id="name" icon="" type="text" name="nombre" placeholder="Nombre del Departamento" />
    </section>
@endsection
