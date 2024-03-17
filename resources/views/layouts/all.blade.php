@extends('layouts.base')

@section('content')
    <article class="w-full">
        <header class="h-12 border-b-2 border-primary mb-2">
            <h1 class="text-2xl font-semibold">{{ $pageTitle }}</h1>
        </header>

        <section class="w-full flex flex-row gap-4 items-center md:justify-end">
            @yield('clear-btn')

            @yield('form')
        </section>

        <section class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
            @yield('component')
            @if ($permiso >= 2 && ($permiso - 4 >= 2 || $permiso < 4) && (($permiso - 8 != 4 && $permiso - 8 != 5) || $permiso < 8))
                <a class="border-b-2 border-ldark hover:border-success w-full text-center font-semibold cursor-pointer select-none h-16 hover:text-success flex items-center justify-center"
                    href="{{ route($base_route . '.form') }}">
                    <i class="fa-solid fa-plus fa-xl"></i>
                </a>
            @endif
        </section>
    </article>
@endsection

@section('js-scripts')
@endsection
