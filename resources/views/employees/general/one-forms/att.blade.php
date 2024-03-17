<form class="mt-6 border-b-2 border-b-ldark pb-5" method="POST"
    action="{{ route($base_route . '.update.ATT', ['id' => $terminal_user['emp_id'], 'id_employee' => $employee['id_empleado']]) }}">
    @csrf
    @method('PUT')

    <header class="mb-4 flex flex-row gap-5 items-center">
        <h2 class="text-2xl font-semibold">Atributos de Terminal</h2>
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
    </header>
    <section class="sm:grid sm:grid-cols-2 xl:grid-cols-3 md:gap-8 xl:gap-x-20">
        @foreach ($terminal_user as $key => $algo)
            <div class="flex flex-row items-center gap-2 p-2">
                <label class="w-32" for="{{ $key }}">{{ $key }}:</label>
                <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                    name="{{ $key }}" readonly value="{{ $terminal_user[$key] }}" id="{{ $key }}">
            </div>
        @endforeach
    </section>
</form>
