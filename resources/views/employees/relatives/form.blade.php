@extends('layouts.form')

@section('inputs')
    <section class="w-5/6 md:w-2/3 lg:w-5/6 grid lg:grid-cols-2 lg:gap-x-20 gap-y-12">
        <div>
            <label for="nombre">Nombre:</label>
            <x-input id="nombre" icon="" type="text" name="nombre" placeholder="Ingresa un nombre"
                defaultValue="Nada" />
        </div>

        <div>
            <label for="apellido_paterno">Apellido Paterno:</label>
            <x-input id="apellido_paterno" icon="" autocomplete="" type="text" name="apellido_paterno"
                placeholder="Ingresa el apellido paterno" />
        </div>

        <div>
            <label for="apellido_materno">Apellido Materno: </label>
            <x-input id="apellido_materno" icon="" type="text" name="apellido_materno"
                placeholder="Ingresa el apellido materno" />
        </div>

        <div>
            <label for="teléfono">Teléfono</label>
            <x-input id="teléfono" icon="" type="tel" name="teléfono" placeholder="Añade un teléfono" />
        </div>

        <div>
            <label for="teléfono_de_respaldo">Teléfono de respaldo</label>
            <x-input id="teléfono_de_respaldo" icon="" type="tel" name="teléfono_de_respaldo"
                placeholder="Añade un teléfono de respaldo" />
        </div>

        <div>
            <label for="parentesco">Parentesco:</label>
            <div>
                <select class="w-full h-10 border-b-2 border-ldark hover:border-primary" id="parentesco" name="parentesco">
                    <option selected value="">-- Seleccione una opción --</option>
                    @foreach (app('parentescos') as $key => $value)
                        <option value="{{ $key }}" @if ((int) old('parentesco') === (int) $key && old('parentesco')) selected @endif>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>

                @if ($errors->has('parentesco'))
                    <span class="text-danger">{{ $errors->first('parentesco') }}</span>
                @endif
            </div>
        </div>

    </section>
@endsection
