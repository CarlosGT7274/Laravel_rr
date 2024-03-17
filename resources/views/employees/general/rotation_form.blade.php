@extends('layouts.form')

@section('inputs')
    <section class="w-full px-8 grid gap-12 md:grid-cols-2">
        <div>
            <label>Nueva Unidad</label>
            <select class="w-full h-10 border-b-2 border-ldark hover:border-primary" id="nueva_unidad" name="nueva_unidad">
                <option selected disabled>-- Seleccione una opción --</option>
                @foreach ($unidades as $unidad)
                    <option value="{{ $unidad['id_unidad'] }}" @if ($old['nueva_unidad'] == $unidad['id_unidad']) selected @endif>
                        {{ $unidad['nombre'] }} </option>
                @endforeach
            </select>
            @if ($errors->has('nueva_unidad'))
                <span class="text-danger">{{ $errors->first('nueva_unidad') }}</span>
            @endif
        </div>

        <div>
            <label>Nuevo Departamento</label>
            <select class="w-full h-10 border-b-2 border-ldark hover:border-primary" id="nuevo_departamento"
                name="nuevo_departamento">
                <option selected disabled>-- Seleccione una opción --</option>
                @foreach ($departamentos as $departamento)
                    <option value="{{ $departamento['id_departamento'] }}" @if ($old['nuevo_departamento'] == $departamento['id_departamento']) selected @endif>
                        {{ $departamento['nombre'] }} </option>
                @endforeach
            </select>
            @if ($errors->has('nuevo_departamento'))
                <span class="text-danger">{{ $errors->first('nuevo_departamento') }}</span>
            @endif
        </div>

        <div>
            <label>Nuevo puesto</label>
            <select class="w-full h-10 border-b-2 border-ldark hover:border-primary" id="nuevo_puesto" name="nuevo_puesto">
                <option selected disabled>-- Seleccione una opción --</option>
                @foreach ($puestos as $puesto)
                    <option value="{{ $puesto['id_puesto'] }}" @if ($old['nuevo_puesto'] == $puesto['id_puesto']) selected @endif>
                        {{ $puesto['nombre'] }} </option>
                @endforeach
            </select>
            @if ($errors->has('nuevo_puesto'))
                <span class="text-danger">{{ $errors->first('nuevo_puesto') }}</span>
            @endif
        </div>

        <div>
            <label for="sueldo">Nuevo sueldo</label>
            <x-input icon="" name="nuevo_sueldo" type="number" step="0.01" min="0" max=""
                id="sueldo" placeholder="Ingrse el nuevo sueldo del empleado" old="{{ $old['nuevo_sueldo'] }}" />
        </div>

        <div class="md:col-span-2">
            <label for="observaciones">Observaciones</label>
            <textarea class="border-2 border-ldark rounded-lg p-2 w-full mt-2 h-56 resize-none"
                placeholder="Escriba observaciones de ser necesario" name="observaciones">{{ $old['observaciones'] != null ? $old['observaciones'] : null  }}</textarea>

            @if ($errors->has('observaciones'))
                <span class="text-danger">{{ $errors->first('observaciones') }}</span>
            @endif
        </div>
    </section>
@endsection
