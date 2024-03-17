@extends('layouts.base')

@section('content')
    <main class="w-full p-6">
        <article class="w-full flex flex-col">
            <header class="h-12 border-b-2 border-primary mb-2 flex flex-row justify-between items-baseline gap-5">
                <a href="{{ route($base_route . '.all') }}">
                    <i class="fa-solid fa-arrow-left fa-xl"></i>
                </a>

                <h1 class="text-2xl font-semibold flex-1">{{ $data['nombre'] }}</h1>

                <form method="POST" action="{{ route($base_route . '.delete', ['id' => $data['id_' . $id_name]]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">
                        <i class="fa-solid fa-lg fa-trash-can hover:text-danger"></i>
                    </button>
                </form>
            </header>

            <section class="mt-6 border-b-2 border-b-ldark pb-3">
                <header class="mb-4">
                    <h2 class="text-xl font-semibold">Atributos</h2>
                </header>
                <form class="flex flex-row justify-start gap-5" method="POST"
                    action="{{ route($base_route . '.update', ['id' => $data['id_' . $id_name]]) }}">
                    @csrf
                    @method('PUT')

                    <div class="w-80 flex gap-2 select-none">
                        <label class="w-32" for="in_{{ $data['id_' . $id_name] }}"> Nombre: </label>
                        <input type="text" name="nombre" readonly class="flex-1 cursor-default"
                            value="{{ $data['nombre'] }}" id="in_{{ $data['id_' . $id_name] }}">
                    </div>

                    <div>
                        <button type="button" onclick="habilitarEdicion({{ $data['id_' . $id_name] }})">
                            <i class="fa-solid fa-lg fa-pencil"></i>
                        </button>

                        <button class="me-4 hover:text-success" type="submit" style="display: none;">
                            <i class="fa-solid fa-lg fa-floppy-disk"></i>
                        </button>

                        <button class="hover:text-danger" type="button" style="display: none;"
                            id="cancelar_{{ $data['id_' . $id_name] }}">
                            <i class="fa-solid fa-lg fa-xmark"></i>
                        </button>
                    </div>
                </form>
            </section>


            <section class="mt-8">
                <header>
                    @if ($failed)
                        <span class="text-danger"> No se pudo eliminar debido a que tiene empleados asignados</span>
                    @endif
                    <h2 class="text-xl font-semibold">Empleados Asignados</h2>
                </header>
                <div class="mt-3 grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-10">
                    @foreach ($data['empleados'] as $item)
                        <p
                            class="border-b-2 border-ldark w-full text-center select-none h-12 flex items-center justify-center">
                            {{ $item['nombre'] . ' ' . $item['apellidoP'] . ' ' . $item['apellidoM'] }}
                        </p>
                    @endforeach
                </div>
            </section>
        </article>
    </main>
@endsection


@section('js-scripts')
    <script>
        function habilitarEdicion(id) {
            const input = document.getElementById("in_" + id);
            const initialValue = input.value;

            const edit_btn = document.querySelector(
                `button[onclick="habilitarEdicion(${id})"]`
            );
            const save_btn = input.parentElement.parentElement.querySelector('button[type="submit"]');
            const cancel_btn = document.getElementById("cancelar_" + id);

            input.removeAttribute("readonly");
            input.style.cursor = "auto";
            edit_btn.style.display = "none";
            save_btn.style.display = "inline-block";
            cancel_btn.style.display = "inline-block";


            input.selectionStart = input.value.length;
            input.focus();

            save_btn.onclick = function() {
                input.setAttribute("readonly", "readonly");
                input.style.cursor = "default";
                save_btn.style.display = "none";
                cancel_btn.style.display = "none";
                edit_btn.style.display = "inline-block";
                save_btn.parentElement.parentElement.submit();
            };

            cancel_btn.onclick = function() {
                input.setAttribute("readonly", "readonly");
                input.style.cursor = "default";
                save_btn.style.display = "none";
                cancel_btn.style.display = "none";
                edit_btn.style.display = "inline-block";
                input.value = initialValue;
            };
        }
    </script>
@endsection
