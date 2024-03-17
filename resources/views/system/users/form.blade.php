@extends('layouts.form')

@section('inputs')
    <section class="w-5/6 md:w-2/3 lg:w-5/6 grid lg:grid-cols-2 lg:gap-x-20 gap-y-12">

        <div>
            <label for="id">Email:</label>
            <x-input id="id" icon="" autocomplete="mail" type="email" max="" min="0" name="correo"
                step="" placeholder="Correo" />
        </div>

        <div>
            <label for="fecha_excep">Contraseña:</label>
            <x-input id="fecha_excep" icon="" type="password" name="contraseña" placeholder="Contraseña" />
        </div>
        <div>
            <label for="tiempoini">Nombre:</label>
            <x-input id="tiempoini" icon="" autocomplete="" type="text" name="nombre"
                placeholder="Nombre" />
        </div>

        <div>
            <label for="tiempofin">Apellido Paterno:</label>
            <x-input id="tiempofin" icon="" type="text" name="apellido_paterno" placeholder="Apellido Paterno" />
        </div>

        <div>
            <label for="observacion">Apellido Materno:</label>
            <x-input id="observacion" icon="" autocomplete="" type="text" step="" name="apellido_materno"
                placeholder="Apellido Materno" />
        </div>

        <div>
            <label for="codigopago">Rol:</label>

            <div>
                <select class="w-full h-10 border-b-2 border-ldark hover:border-primary" id="codigopago"
                    name="rol">
                    <option selected value="">-- Seleccione una opción --</option>
                    @foreach ($roles as $rol)
                        <option value="{{ $rol['id_rol'] }}">
                            {{ $rol['nombre'] }}
                        </option>
                    @endforeach
                </select>

                @if ($errors->has('rol'))
                    <span class="text-danger">{{ $errors->first('rol') }}</span>
                @endif
            </div>
        </div>

        <div>
            <label for="empleados">Empresa</label>

            <div>
                <select class="w-full h-10 border-b-2 border-ldark hover:border-primary" id="empleados"
                    name="empresa">
                    <option selected value="">-- Seleccione una opción --</option>
                    @foreach ($companies as $companie)
                        <option value="{{ $companie['id_empresa'] }}">
                            {{ $companie['razonSocial'] }}
                        </option>
                    @endforeach
                </select>

                @if ($errors->has('empresa'))
                    <span class="text-danger">{{ $errors->first('empresa') }}</span>
                @endif
            </div>
        </div>

    </section>
@endsection
