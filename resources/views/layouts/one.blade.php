@extends('layouts.base')

@section('content')
    <article class="w-full flex flex-col">
        <header class="h-12 border-b-2 border-primary mb-2 flex flex-row justify-between items-baseline gap-5">
            <a
                href="{{ $father_url != '' ? route($father_url . '.one', ['id' => $father_id]) : route($base_route . '.all') }}">
                <i class="fa-solid fa-arrow-left fa-xl"></i>
            </a>

            @yield('title')
            @if ($permiso >= 8)    
            <form method="POST"
            @if (substr($id_name, -2) == 'id') 
                action="{{ $father_id ? route($base_route . '.delete', ['id' => $data[$id_name], 'father_id' => $father_id]) : route($base_route . '.delete', ['id' => $data[$id_name]]) }}"
            @else
                action="{{ $father_id ? route($base_route . '.delete', ['id' => $data['id_' . $id_name], 'father_id' => $father_id]) : route($base_route . '.delete', ['id' => $data['id_' . $id_name]]) }}"
            @endif
            >
                @csrf
                @method('DELETE')
                <button type="submit">
                    <i class="fa-solid fa-lg fa-trash-can hover:text-danger"></i>
            </button>
            </form>
            @endif
        </header>


        <form class="mt-6 border-b-2 border-b-ldark pb-5" method="POST"
                @if (substr($id_name, -2) == 'id') 
                    action="{{ $father_id ? route($base_route . '.update', ['id' => $data[$id_name], 'father_id' => $father_id]) : route($base_route . '.update', ['id' => $data[$id_name]]) }}"
                @else
                    action="{{ $father_id ? route($base_route . '.update', ['id' => $data['id_' . $id_name], 'father_id' => $father_id]) : route($base_route . '.update', ['id' => $data['id_' . $id_name]]) }}"
                @endif
                    >
                @csrf
                @method('PUT')

            <header class="mb-4 flex flex-row gap-5 items-center">
                <h2 class="text-xl font-semibold">Atributos</h2>
                @if ($permiso >= 4 && ($permiso - 8 >= 4 || $permiso < 8))
                <div>
                    <button name="activarBtn" type="button">
                        <i class="fa-solid fa-lg fa-pencil"></i>
                    </button>

                    <button name="enviarBtn" class="me-4 hover:text-success hidden" type="submit">
                        <i class="fa-solid fa-floppy-disk fa-lg"></i>
                    </button>

                    <button class="hover:text-danger hidden" type="button" name="cancelarBtn">
                        <i class="fa-solid fa-xmark fa-lg"></i>
                    </button>
                </div>
                @endif
            </header>

            @yield('inputs')
        </form>

        @yield('extra-info')

    </article>
@endsection


@section('js-scripts')
    @vite('resources/js/inputs.js')
@endsection
