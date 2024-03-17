@extends('layouts.all')

@section('clear-btn')
    @if ($nombre)
        @include('components.clear')
    @endif
@endsection

@section('form')
    <form class="flex grow md:grow-0 flex-row gap-2" action="{{ route($base_route . '.search') }}">
        <span class="flex-1">
            <x-input icon="fa-people-arrows" name="nombre" placeholder="Buscar . . ." autocomplete="" needsUnhidden=""
                id="in_name" type="search" defaultValue="{{ $nombre }}" />
        </span>

        <button id="btn-submit" type="submit" class="w-12">
            <i
                class="fa-solid fa-lg fa-search py-4 px-2 hover:border-2 hover:border-primary rounded-lg hover:text-primary"></i>
        </button>
    </form>
@endsection

@section('component')
    @foreach ($data as $item)
        <a class="border-b-2 border-ldark hover:border-primary w-full text-center font-semibold cursor-pointer select-none h-16 hover:text-primary flex items-center justify-center"
            href="{{ route($base_route . '.one', ['id' => $item['id_' . $id_name]]) }}">
            <p>
                {{ $item['nombre'] . ' ' . $item['apellidoP'] . ' ' . $item['apellidoM'] }}
            </p>
        </a>
    @endforeach
@endsection
