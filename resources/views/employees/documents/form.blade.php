@extends('layouts.form')

@section('inputs')
    <section class="w-5/6 md:w-2/3 lg:w-5/6 grid grid-cols-1 lg:gap-x-20 gap-y-12">
        <div>
            <label for="nombre">Nombre:</label>
            <x-input id="nombre" icon="" type="text" name="nombre" placeholder="Ingresa un nombre" />
        </div>

        <div>
            <div class="h-96" id="drop-area">
                <label for="file-input"
                    class="h-full w-full border-4 border-ldark border-dashed flex flex-col justify-center items-center rounded-lg cursor-pointer gap-4 ">
                    <i class="fa-solid fa-file text-ldark text-5xl"></i>
                    <p class="py-3 px-6 text-center text-xl">Elija un archivo o arrástrelo hasta aquí</p>
                </label>

                <input name="archivo" id="file-input" class="hidden" type="file"
                    accept=".rtf,.doc,.docx,.csv,.xls,.xlsx,.ppt,.pptx,.rar,.7z,.zip,.txt,.pdf,.xml,.json,.mp3,.wav,.mp4,.avi,.webm,.jpg,.jpeg,.png,.gif,.bmp,.svg,.webp">
            </div>

            <div id="file_container"
                class="hidden h-72 w-full border-2 border-ldark border-dashed flex-col justify-center items-center rounded-lg cursor-pointer relative">
                <i class="fa-solid text-5xl" id="file_icon"></i>
                <p class="py-2 px-6 text-center text-xl font-semibold" id="file_name"></p>
                <button class="absolute top-[-0.85rem] right-[-0.85rem] border-2 rounded-full border-danger w-8 h-8 bg-light"
                    type="button" id="remove">
                    <i class="fa-solid fa-lg fa-trash-can text-danger" id="file_icon"></i>
                </button>
            </div>

            @if ($errors->has('archivo'))
                <span class="text-danger">{{ $errors->first('archivo') }}</span>
            @endif
        </div>

        @vite('resources/js/dragAndDrop.js')
        @vite('resources/js/docsInput.js')
    </section>
@endsection
