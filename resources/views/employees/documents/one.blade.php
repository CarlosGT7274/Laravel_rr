@extends('layouts.one')

@section('title')
    <h1 class="text-2xl font-semibold flex-1">{{ $data['nombre'] }}</h1>
@endsection

@section('inputs')
    <section class="w-5/6 md:w-2/3 xl:w-5/6 grid grid-cols-1 gap-x-8 gap-y-8 mx-auto">
        <div class="flex flex-row items-center gap-2 p-2">
            <label class="w-32" for="name">Nombre:</label>
            <div class="border-b-2 border-ldark cursor-default p-1 text-ldark flex-1 flex flex-row">
                <input class="w-auto" type="text" name="nombre" readonly value="{{ $data['nombre'] }}" id="name">
                <p>.{{ app('file_extensions')[$data['tipo']] }}</p>
            </div>
        </div>

        {{-- <div>
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
                <button
                    class="absolute top-[-0.85rem] right-[-0.85rem] border-2 rounded-full border-danger w-7 h-7 bg-light"
                    type="button" id="remove">
                    <i class="fa-solid fa-lg fa-trash-can text-danger" id="file_icon"></i>
                </button>
            </div>
        </div> --}}
    </section>
@endsection

@section('extra-info')
    <div class="flex flex-row justify-center gap-5 flex-wrap pt-5">
        <button class="flex flex-row gap-3 p-2 items-center border-2 rounded-lg border-dark hover:border-primary hover:text-primary w-32" onclick="togglePreview()" id="visualiza">
            <i class="fa-solid fa-eye fa-lg"></i>
            <p class="text-center font-semibold">Visualizar</p>
        </button>
        <button class="hidden flex-row gap-3 p-2 items-center border-2 rounded-lg border-dark hover:border-primary hover:text-primary w-32" onclick="togglePreview()" id="oculta">
            <i class="fa-solid fa-eye-slash fa-lg"></i>
            <p class="text-center font-semibold">Ocultar</p>
        </button>
        <a class="flex flex-row gap-3 p-2 items-center border-2 rounded-lg border-dark hover:border-primary hover:text-primary w-32" href="{{ route('file', ['file_name' => $file_name ]) }}">
            <i class="fa-solid fa-arrow-down fa-lg"></i>
            <p class="text-center font-semibold">Descargar</p>
        </a>
    </div>

    <div id="preview_file" class="hidden pt-4">
        @if ($data['tipo'] > 18)
            <div class="p-8 md:w-3/4 xl:w-11/12 md:mx-auto">
                <img src="{{ $data['info'] }}" class="object-contain mx-auto">
            </div>
        @elseif ($data['tipo'] > 16)
            <video controls controlslist="nodownload" src="{{$data['info']}}" class="p-8 md:w-3/4 xl:w-11/12 md:mx-auto" />
        @elseif ($data['tipo'] > 14)
            <audio controls controlslist="nodownload" src="{{ $data['info'] }}" class="md:w-3/4 xl:w-11/12 md:mx-auto" />
        @elseif ($data['tipo'] > 10)
            <iframe src="{{ $data['info'] . "#toolbar=0" }}" width="100%"
                class="h-[400px] sm:h-[600px] md:h-[800px] xl:h-[1000px] p-8"></iframe>
        @elseif($data['tipo'] > 7)
            <p>Hola</p>
        @else
            <iframe
                src='https://view.officeapps.live.com/op/embed.aspx?src={{$file_path}}'
                width='100%' class="h-[400px] sm:h-[600px] md:h-[800px] xl:h-[1000px] p-8"
            ></iframe>
        @endif
    </div>
@endsection

@section('js-scripts')
    @vite('resources/js/inputs.js')

    <script>
        const input = document.getElementById('name')
        input.addEventListener('input', resizeInput);
        resizeInput.call(input);

        function resizeInput() {
            let contador = 0;
            let contador_ = 0;

            for (let i = 0; i < this.value.length; i++) {
                if (this.value[i] === ' ') {
                    contador++;
                } else if (this.value[i] === '_') {
                    contador_++;
                }
            }

            this.style.width = (this.value.length  - (0.44 * contador) + (0.3 * contador_)) + "ch";
        }
    </script>

    <script>
        let es_visible = false;

        function togglePreview () {
            const div = document.getElementById('preview_file')
            div.classList.toggle('hidden')
            es_visible = !es_visible;

            if(es_visible){
                document.getElementById('visualiza').classList.add('hidden')
                document.getElementById('oculta').classList.remove('hidden')
                document.getElementById('oculta').classList.add('flex')
            }
            else {
                document.getElementById('visualiza').classList.remove('hidden')
                document.getElementById('oculta').classList.add('hidden')
                document.getElementById('oculta').classList.remove('flex')
            }

        };
    </script>
@endsection