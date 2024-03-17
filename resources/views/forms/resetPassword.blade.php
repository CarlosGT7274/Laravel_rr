@extends('layouts.simple')

@section('content')
    <div class="w-full bg-ldark pt-28 h-[100vh]">
        <div class="mx-auto flex flex-col p-5 rounded-xl bg-light md:w-96 w-72 shadow-2xl shadow-dark">
            <form class="flex flex-col gap-4" method="post" action="{{ route('resetPassword.submit') }}">
                @csrf
                <h2 class="md:text-3xl text-2xl text-center font-semibold text-dark">Cambiar Contraseña</h2>
                <div class="flex flex-col gap-4 my-4">
                    <x-input defaultValue="" id="" icon="fa-at" name="correo" autocomplete="email" type="email"
                        placeholder="Correo electrónico" />

                    @if ($message)
                        <span class="text-danger">{{ $message }}</span>
                    @endif
                    <button
                        class="border-2 text-primary border-primary rounded-lg p-2 hover:bg-primary hover:text-light font-semibold"
                        type="submit">Enviar Correo</button>
                </div>
            </form>
            <a class="text-decoration-none text-primary flex flex-row items-center gap-1" href={{ route('login.form') }}>
                <i class="fa-solid fa-md fa-arrow-left pt-1 text-primary"></i>
                <p class="font-semibold text-primary text-base">Iniciar Sesión</p>
            </a>
        </div>
    </div>
@endsection
