@extends('layouts.base')

@section('content')
    <article class="w-full flex flex-col">
        <header class="h-12 border-b-2 border-primary mb-2 flex flex-row justify-between items-baseline gap-5">
            <a href="{{ route('rol.all') }}">
                <i class="fa-solid fa-arrow-left fa-xl"></i>
            </a>

            <h1 class="text-xl font-bold mb-4 text-start w-full">Editar Permisos del Rol</h1>

            @if ($permiso >= 8)
                <form method="POST" action="{{ route('rol.delete', ['id' => $data['id_rol']]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">
                        <i class="fa-solid fa-lg fa-trash-can hover:text-danger"></i>
                    </button>
                </form>
            @endif
        </header>
        @if ($delete)
            <span class="text-danger">{{ $delete }}</span>
        @endif


        <form action="{{ route('rol.update', ['id' => $data['id_rol']]) }}" method="POST">
            @method('PUT')
            @csrf
            <header class="flex flex-row">
                <h2 class="text-2xl">Atributos</h2>
                <div class="flex flex-row">
                    <button type="button" id="edtinput" class=" ps-5">
                        <i class="fa-solid fa-pencil fa-lg"></i>
                    </button>
                    <button type="submit" id="saveIcon" class=" ps-5 hidden">
                        <i class="fa-solid fa-floppy-disk fa-lg"></i>
                    </button>
                    <button type="button" id="limpiarBtn" class=" px-4 ms-4 rounded hidden">
                        <i class="fa-solid fa-xmark fa-lg"></i>
                    </button>
                </div>
            </header>

            <section class="grid grid-cols-1">
                <div class="flex flex-row space-y-2 justify-center items-center">
                    <label for="Nrol" class="font-semibold w-40">Nombre del Rol:</label>
                    <input id="Nrol" name="Nrol" type="text" value="{{ $data['nombre'] }}"
                        class="w-full border rounded-lg p-2 cursor-not-allowed pointer-events-none">
                    <input type="hidden" name="idrol" value="{{ $data['id_rol'] }}">
                </div>

                <section class=" overflow-x-auto mt-5">
                    <table class="table rounded-xl w-full">
                        <thead>
                            <tr>
                                <th class="border px-3 py-2 sticky left-0 bg-light">Nombre</th>
                                <th class="border px-3 py-2 ">Todos</th>
                                <th class="border px-3 py-2 ">Conceder</th>
                                <th class="border px-3 py-2 ">Denegar</th>
                                <th class="border px-3 py-2 ">Leer</th>
                                <th class="border px-3 py-2">Crear</th>
                                <th class="border px-3 py-2 ">Actualizar</th>
                                <th class="border px-3 py-2 ">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < count($data['permisos']); $i++)
                                <tr>
                                    <td class="border px-3 py-2 w-96 lg:w-1/3 sticky left-0 bg-light">
                                        {{ $permisosG[$i + 1]['nombre'] }}</td>
                                    <input type="hidden" name="permisos[{{ $i }}][id_permiso]"
                                        value="{{ $data['permisos'][$i]['id_permiso'] }}">
                                    <td class="border w-32 px-3 py-2">
                                        <input type="checkbox" @if ($data['permisos'][$i]['valor'] == 15) checked value="15" @endif
                                            name="permisos[{{ $i }}][todos]"
                                            class="w-full border rounded-lg p-1 cursor-not-allowed pointer-events-none ">
                                    </td>
                                    <td class="border w-32 px-3 py-2">
                                        <input type="checkbox" @if ($data['permisos'][$i]['valor'] >= 0) checked value="0" @endif
                                            name="permisos[{{ $i }}][on]"
                                            class="w-full border rounded-lg p-1 cursor-not-allowed pointer-events-none ">
                                    </td>
                                    <td class="border w-32 px-3 py-2">
                                        <input type="checkbox" @if ($data['permisos'][$i]['valor'] == -1) checked value="-1" @endif
                                            name="permisos[{{ $i }}][off]"
                                            class="w-full border rounded-lg p-1 cursor-not-allowed pointer-events-none ">
                                    </td>
                                    <td class="border w-32 px-3 py-2">
                                        <input type="checkbox" @if ($data['permisos'][$i]['valor'] % 2 == 1) checked value="1" @endif
                                            name="permisos[{{ $i }}][r]"
                                            class="w-full border rounded-lg p-1 cursor-not-allowed pointer-events-none ">
                                    </td>
                                    <td class="border w-32 px-3 py-2">
                                        <input type="checkbox" @if (
                                            $data['permisos'][$i]['valor'] >= 2 &&
                                                ($data['permisos'][$i]['valor'] - 4 >= 2 || $data['permisos'][$i]['valor'] < 4) &&
                                                (($data['permisos'][$i]['valor'] - 8 != 4 && $data['permisos'][$i]['valor'] - 8 != 5) ||
                                                    $data['permisos'][$i]['valor'] < 8)) checked value="2" @endif
                                            name="permisos[{{ $i }}][c]"
                                            class="w-full border rounded-lg p-1 cursor-not-allowed pointer-events-none ">
                                    </td>
                                    <td class="border w-32 px-3 py-2">
                                        <input type="checkbox" @if (
                                            $data['permisos'][$i]['valor'] >= 4 &&
                                                ($data['permisos'][$i]['valor'] - 8 >= 4 || $data['permisos'][$i]['valor'] < 8)) checked value="4" @endif
                                            name="permisos[{{ $i }}][u]"
                                            class="w-full border rounded-lg p-1 cursor-not-allowed pointer-events-none ">
                                    </td>
                                    <td class="border w-32 px-3 py-2">
                                        <input type="checkbox" @if ($data['permisos'][$i]['valor'] >= 8) checked value="8" @endif
                                            name="permisos[{{ $i }}][d]"
                                            class="w-full border rounded-lg p-1 cursor-not-allowed pointer-events-none ">
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </section>
            </section>
        </form>

    </article>
@endsection

@section('js-scripts')
    @vite('resources/js/edit_rol.js')
    @vite('resources/js/rols.js')
@endsection
