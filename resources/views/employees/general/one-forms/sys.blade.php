<form class="my-auto border-b-2 border-b-ldark pb-6" method="POST"
    action="{{ route($base_route . '.update.SYS', ['id' => $user['id_usuario'], 'id_employee' => $employee['id_empleado']]) }}">
    @csrf
    @method('PUT')

    <header class="mb-4 flex flex-row gap-5 items-center">
        <h2 class="text-2xl font-semibold">Atributos de Usuario</h2>
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

    <section class="sm:grid sm:grid-cols-1 xl:grid-cols-2 md:gap-8 xl:gap-x-20">
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="nombre">Nombre:</label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="nombre"
                readonly value="{{ $user['nombre'] }}" id="nombre">
        </div>
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="apellidoP">Apellido Paterno:</label>
            <input id="apellidoP" type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                name="apellido_paterno" readonly value="{{ $user['apellidoP'] }}">
        </div>

        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="apellidoM">Apellido Materno:</label>
            <input id="apellidoM" type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1"
                name="apellido_materno" readonly value="{{ $user['apellidoM'] }}">
        </div>

        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="correo">Correo:</label>
            <input type="text" class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1" name="correo"
                readonly value="{{ $user['email'] }}" id="correo">
        </div>

        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="id_rol">Rol:</label>
            <select disabled class="h-10 border-b-2 border-ldark flex-1" id="id_rol" name="rol">
                <option disabled>-- Seleccione una opción --</option>
                @foreach ($roles as $rol)
                    <option value="{{ $rol['id_rol'] }}" @if ($user['id_rol'] == $rol['id_rol']) selected @endif>
                        {{ $rol['nombre'] }} </option>
                @endforeach
            </select>
        </div>

    </section>

</form>
