@extends('layouts.base')

@section('content')
    <article class="w-full flex flex-col">

        <header class="h-12 border-b-2 border-primary mb-2 flex flex-row items-baseline gap-5">
            <a
                href="{{ $father_url != '' ? route($father_url . '.one', ['id' => $father_id]) : route($base_route . '.all') }}">
                <i class="fa-solid fa-arrow-left fa-xl"></i>
            </a>
            <h1 class="text-2xl font-semibold">Registro de {{ $title }}</h1>
        </header>

        <form class="mt-8 flex flex-col items-center" method="POST" enctype="multipart/form-data"
            action="{{ $father_id ? route($base_route . '.submit', ['father_id' => $father_id]) : route($base_route . '.submit') }}">
            @csrf

            @yield('inputs')

            <button type="submit"
                class="border-2 text-primary border-primary rounded-lg p-2 hover:bg-primary hover:text-light font-semibold mt-8 w-32">
                Guardar
            </button>
        </form>
    </article>
@endsection
