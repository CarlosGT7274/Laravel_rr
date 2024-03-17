@extends('layouts.all')

@section('component')
    @foreach ($data as $item)
        @if ($item['nombre'] != 'Alpha')
            <a class="border-b-2 border-ldark hover:border-primary w-full text-center font-semibold cursor-pointer select-none h-16 hover:text-primary flex items-center justify-center"
                href="{{ route($base_route . '.one', ['id' => $item['id_' . $id_name]]) }}">
                <p>
                    {{ $item['nombre'] }}
                </p>
            </a>
        @endif
    @endforeach
@endsection
