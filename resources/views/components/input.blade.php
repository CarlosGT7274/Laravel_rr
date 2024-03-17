<div>
    <div class="my-1 border-b-2 border-ldark flex flex-row gap-2 items-center justify-around hover:border-primary px-1">

        @if ($icon != '')
            <i class="fa-solid fa-lg {{ $icon }}" style="color: var(--color-dlight)"></i>
        @endif

        <input class="w-full h-10" name="{{ $name }}" type="{{ $type }}" id="{{ $id }}"
            @if ($type == 'password' && $name == 'contraseña_de_la_terminal') 
                value="123"
            @elseif ($name == 'nuevo_sueldo')
                value="{{ $old }}"
            @else
                value="{{ old(strpos($name, '[') !== false ? str_replace(['[', ']'], ['.', ''], $name) : $name) }}" 
            @endif
            
            @if ($type == 'number') min="{{ $min }}"
                step="{{ $step }}" max="{{ $max }}" placeholder="{{ $placeholder }}"  
            @elseif ($type == 'time' || $type == 'datetime-local')
                step="1"
            @elseif ($type == 'email') 
                autocomplete="{{ $autocomplete }}" placeholder="{{ $placeholder }}" 
            @else 
                placeholder="{{ $placeholder }}" 
            @endif
        >

        @if ($type == 'password')
            <button type="button" id="{{ $id . 'preview' }}">
                <i class="fa-solid fa-lg fa-eye" style="color: var(--color-dlight)"></i>
            </button>
            <script>
                document.getElementById(`${@json($id)}preview`).addEventListener("click", function() {
                    if (document.getElementById(@json($id)).type === "password") {
                        document.getElementById(@json($id)).type = "text";
                    } else {
                        document.getElementById(@json($id)).type = "password";
                    }
                });
            </script>
        @endif

    </div>

    @if ($errors->has($name))
        <span class="text-danger">{{ $errors->first($name) }}</span>
    @endif
</div>
