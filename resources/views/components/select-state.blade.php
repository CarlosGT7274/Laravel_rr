<div>
    <select class="w-full h-10 border-b-2 border-ldark hover:border-primary" id="estado" name="estado">
        <option selected disabled>-- Seleccione una opción --</option>
        @foreach (app('estados_mx') as $key => $estado)
            <option value="{{ $key }}"> {{ $estado }} </option>
        @endforeach
    </select>

    @if ($errors->has('estado'))
        <span class="text-danger">{{ $errors->first('estado') }}</span>
    @endif
</div>
