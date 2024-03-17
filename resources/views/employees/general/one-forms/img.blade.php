<form method="POST"
    action="{{ route($base_route . '.update.IMG', ['id_employee' => $employee['id_empleado'], 'id' => $image['id_imagen']]) }}"
    class="h-80 lg:h-full rounded-lg w-full my-3 md:m-0 xl:h-80 hidden" enctype="multipart/form-data" id="form-pic">
    @csrf
    @method('PUT')

    <div class="h-full border-2" id="drop-area">
        <label for="file-input"
            class="h-full w-full border-4 border-ldark border-dashed flex flex-col justify-center items-center rounded-lg cursor-pointer gap-4 ">
            <i class="fa-solid fa-camera text-ldark fa-2xl"></i>
            <p class="py-3 px-6 text-center">Elija una foto o arrástrela hasta aquí</p>
        </label>

        <input name="imagen" accept="image/png,image/pjp,image/jpeg,image/pjpeg,image/jpg,image/jfif" id="file-input" class="hidden" type="file">
    </div>

    <section class="relative">
        <img id="pp" alt="Foto de perfil del empleado"
            class="h-80 lg:h-full object-cover rounded-lg w-full my-3 md:m-0 xl:h-80 sm:object-[50%_80%] lg:object-[50%_50%] hidden">

        <div id="buttons" class="absolute top-[-0.8rem] right-[-0.8rem]">
            <button id="save" class="rounded-full border-success text-success border-2 h-8 w-8 bg-light hidden">
                <i class="fa-solid fa-floppy-disk"></i>
            </button>
            <button id="remove" type="button"
                class="rounded-full border-danger text-danger border-2 h-8 w-8 bg-light hidden">
                <i class="fa-solid fa-trash fa-lg"></i>
            </button>
            <button id="cancel" type="button"
                class="rounded-full border-danger text-danger border-2 h-8 w-8 bg-light">
                <i class="fa-solid fa-xmark fa-xl"></i>
            </button>
        </div>
    </section>

</form>
