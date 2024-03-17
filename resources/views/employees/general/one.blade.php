@extends('layouts.base')

@section('content')
    <article class="w-full flex flex-col">
        <header class="h-12 border-b-2 border-primary mb-2 flex flex-row justify-between items-baseline gap-5">
            <a href="{{ route($base_route . '.all') }}">
                <i class="fa-solid fa-arrow-left fa-xl"></i>
            </a>

            <h1 class="flex-1 text-left text-2xl font-semibold">
                {{ $user['nombre'] . ' ' . $user['apellidoP'] . ' ' . $user['apellidoM'] }}
            </h1>

            <a class="p-1 border-2 rounded-lg border-dark hover:border-danger hover:text-danger w-36 text-center font-semibold" href="{{ route('employees.general.change_position.form', ['father_id' => $employee['id_empleado']]) }}"> Cambiar Puesto </a>
            <a class="p-1 border-2 rounded-lg border-dark hover:border-danger hover:text-danger w-36 text-center font-semibold" href="{{ route('employees.general.dismiss.form', ['father_id' => $employee['id_empleado']]) }}"> Dar de Baja </a>

            <form method="POST" action="{{ route($base_route . '.delete', ['id' => $employee['id_' . $id_name]]) }}">
                @csrf
                @method('DELETE')
                <button type="submit">
                    <i class="fa-solid fa-lg fa-trash-can hover:text-danger"></i>
                </button>
            </form>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-[2fr_3fr] xl:grid-cols-[1fr_3fr] gap-x-8 p-2 gap-y-5 lg:gap-y-0">
            @if ($image)
                <section id="profile-pic" class="relative">
                    <img alt="Foto de perfil del empleado"
                        class="h-80 lg:h-full object-cover rounded-lg w-full my-3 md:m-0 xl:h-80 sm:object-[50%_80%] lg:object-[50%_50%]"
                        src="{{ 'data:image/png;' . $image['info'] }}">

                    <div id="buttons" class="absolute top-[-0.8rem] right-[-0.8rem]">
                        <button id="edit-img" class="rounded-full border-dark border-2 h-8 w-8 bg-light">
                            <i class="fa-solid fa-pencil"></i>
                        </button>
                    </div>
                </section>
                @include('employees.general.one-forms.img')
            @else
                @include('employees.general.one-forms.img-create')
            @endif

            @include('employees.general.one-forms.sys')
        </div>

        @include('employees.general.one-forms.hr')

        @include('employees.general.one-forms.att')

        <section class="mt-6 border-b-2 border-b-ldark pb-5">
            <header class="mb-4 flex flex-row gap-5 items-center">
                <h2 class="text-xl font-semibold">Familiares</h2>
            </header>
            <section class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-10">
                @foreach ($relatives as $item)
                    <a class="border-b-2 border-ldark hover:border-primary w-full text-center font-semibold cursor-pointer select-none h-16 hover:text-primary flex flex-col items-center justify-center"
                        href="{{ route('employees.relatives.one', ['id' => $item['id_familiar'], 'father_id' => $employee['id_empleado']]) }}">
                        <p>
                            {{ $item['nombre'] . ' ' . $item['apellidoP'] . ' ' . $item['apellidoM'] }}
                        </p>
                    </a>
                @endforeach
                @if (
                    $permisos['sub_permissions'][2052]['valor'] >= 2 &&
                        ($permisos['sub_permissions'][2052]['valor'] - 4 >= 2 || $permisos['sub_permissions'][2052]['valor'] < 4) &&
                        (($permisos['sub_permissions'][2052]['valor'] - 8 != 4 &&
                            $permisos['sub_permissions'][2052]['valor'] - 8 != 5) ||
                            $permisos['sub_permissions'][2052]['valor'] < 8))
                    <a class="border-b-2 border-ldark hover:border-success w-full text-center font-semibold cursor-pointer select-none h-16 hover:text-success flex items-center justify-center"
                        href="{{ route('employees.relatives.form', ['father_id' => $employee['id_empleado']]) }}">
                        <i class="fa-solid fa-plus fa-xl"></i>
                    </a>
                @endif
            </section>
        </section>

        <section class="mt-6 border-b-2 border-b-ldark pb-5">
            <header class="mb-4 flex flex-row gap-5 items-center">
                <h2 class="text-xl font-semibold">Documentos</h2>
            </header>
            <section class="mt-4 grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-10">
                @foreach ($documents as $item)
                    <a class="border-b-2 border-ldark hover:border-primary w-full text-center font-semibold cursor-pointer select-none h-16 hover:text-primary flex flex-col items-center justify-center"
                        href="{{ route('employees.documents.one', ['id' => $item['id_documento'], 'father_id' => $employee['id_empleado']]) }}">
                        <p>
                            {{ $item['nombre'] }}
                        </p>
                    </a>
                @endforeach
                @if (
                    $permisos['sub_permissions'][2055]['valor'] >= 2 &&
                        ($permisos['sub_permissions'][2055]['valor'] - 4 >= 2 || $permisos['sub_permissions'][2055]['valor'] < 4) &&
                        (($permisos['sub_permissions'][2055]['valor'] - 8 != 4 &&
                            $permisos['sub_permissions'][2055]['valor'] - 8 != 5) ||
                            $permisos['sub_permissions'][2055]['valor'] < 8))
                    <a class="border-b-2 border-ldark hover:border-success w-full text-center font-semibold cursor-pointer select-none h-16 hover:text-success flex items-center justify-center"
                        href="{{ route('employees.documents.form', ['father_id' => $employee['id_empleado']]) }}">
                        <i class="fa-solid fa-plus fa-xl"></i>
                    </a>
                @endif
            </section>
        </section>

    </article>
@endsection


@section('js-scripts')
    @if ($image)
        @vite('resources/js/imageInputU.js')
    @else
        @vite('resources/js/imageInputC.js')
    @endif
    @vite('resources/js/dragAndDrop.js')
    @vite('resources/js/inputs.js')
@endsection
