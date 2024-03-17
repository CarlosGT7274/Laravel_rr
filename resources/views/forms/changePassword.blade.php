@extends('layouts.simple')

@section('content')
    <div class="w-full bg-ldark pt-28 h-[100vh]">
        <div class="mx-auto flex flex-col p-5 rounded-xl bg-light md:w-96 w-72 shadow-2xl shadow-dark">
            <form class="flex flex-col gap-3" method="post" action="{{ route('changePassword.submit') }}">
                @csrf
                <h2 class="md:text-3xl text-2xl text-center font-semibold">Cambio de Contraseña</h2>
                <div class="flex flex-col gap-4 my-4">
                    <x-input defaultValue="" id="password" icon="fa-key" autocomplete="" type="password" name="contraseña"
                        placeholder="Contraseña" />

                    <x-input defaultValue="" id="confirmation" icon="fa-key" autocomplete="" type="password"
                        name="de_confirmacion" placeholder="Confirmar Contraseña" />

                    <input hidden value="{{ $token }}" name="accessToken">

                    @if ($message)
                        <span class="text-danger">{{ $message }}</span>
                        <a class="text-decoration-none font-semibold text-primary text-base"
                            href={{ route('resetPassword.form') }}>
                            ¿Aún desea cambiar su contraseña?
                        </a>
                    @else
                        <button
                            class="border-2 text-primary border-primary rounded-lg p-2 hover:bg-primary hover:text-light font-semibold"
                            type="submit">
                            Guardar
                        </button>
                    @endif
                </div>
            </form>
            <a class="text-decoration-none font-semibold text-primary text-base" href={{ route('login.form') }}>
                @if ($message)
                    Iniciar Sesión
                @else
                    ¿No quiere cambiar la contraseña?
                @endif
            </a>
        </div>
    </div>
@endsection

@section('js-scripts')
@endsection
