@extends('layouts.form')

@section('inputs')
    <section class="w-5/6 md:w-2/3 lg:w-5/6 grid lg:grid-cols-2 lg:gap-x-20 gap-y-12">

        <div>
            <label for="id">id:</label>
            <x-input id="id" icon="" autocomplete="" type="number" max="" min="0" name="id"
                step="" placeholder="id" />
        </div>

        <div>
            <label for="fecha_excep">Fecha de exepcion:</label>
            <x-input id="fecha_excep" icon="" type="datetime-local" name="fecha_excep" placeholder="fecha_excep" />
        </div>
        <div>
            <label for="tiempoini">Fecha inicio:</label>
            <x-input id="tiempoini" icon="" autocomplete="" type="number" name="tiempoini" type="datetime-local"
                placeholder="Fecha inicio" />
        </div>

        <div>
            <label for="tiempofin">Fecha termino:</label>
            <x-input id="tiempofin" icon="" type="datetime-local" name="tiempofin" placeholder="tiempofin" />
        </div>

        <div>
            <label for="observacion">Observaciones:</label>
            <x-input id="observacion" icon="" autocomplete="" type="text" step="" name="observacion"
                placeholder="observaciones" />
        </div>

        <div>
            <label for="codigopago">Codigo de pago:</label>

            <div>
                <select class="w-full h-10 border-b-2 border-ldark hover:border-primary" id="codigopago"
                    name="id_codpago">
                    <option selected value="">-- Seleccione una opción --</option>
                    @foreach ($codigos as $codigo)
                        <option value="{{ $codigo['id_codigo_pago'] }}">
                            {{ $codigo['codexport'] }}
                        </option>
                    @endforeach
                </select>

                @if ($errors->has('id_codpago'))
                    <span class="text-danger">{{ $errors->first('id_codpago') }}</span>
                @endif
            </div>
        </div>

        <div>
            <label for="empleados">Empleado</label>

            <div>
                <select class="w-full h-10 border-b-2 border-ldark hover:border-primary" id="empleados"
                    name="id_trabajador">
                    <option selected value="">-- Seleccione una opción --</option>
                    @foreach ($empleados as $empleado)
                        <option value="{{ $empleado['id_empleado'] }}">
                            {{ $empleado['nombre'] . ' ' . $empleado['apellidoP'] . ' ' . $empleado['apellidoM'] }}
                        </option>
                    @endforeach
                </select>

                @if ($errors->has('id_trabajador'))
                    <span class="text-danger">{{ $errors->first('id_trabajador') }}</span>
                @endif
            </div>
        </div>

    </section>
@endsection
