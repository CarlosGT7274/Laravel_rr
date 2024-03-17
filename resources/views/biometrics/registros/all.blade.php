@extends('layouts.base')

@section('content')
    <div class="flex flex-col w-screen">
        <div class="flex  gap-8 ">
            <h1 class=" text-dark font-semibold text-3xl ">Registros</h1>
        </div>

        <div>
            <div class="">
                <h2 class="text-2xl font-bold mb-4"></h2>
                {{-- {{dd($data)}} --}}
                <div class="grid grid-cols-4 gap-x-12 px-4 gap-y-5">
                    @foreach ($data as $rol)
                        <a class="border-b-2 border-ldark hover:border-primary w-full text-center font-semibold select-none h-12 hover:text-primary flex items-center justify-center"
                            href="{{ route('raiz', ['id' => $rol['punch_id']]) }}">
                            <p>
                                {{ $rol['punch_time'] }}
                            </p>
                        </a>
                    @endforeach
                    <a class="border-b-2 border-ldark hover:border-primary w-full text-center font-semibold select-none h-12 hover:text-primary flex items-center justify-center"
                        href="{{ route('raiz') }}">
                        <i class="fa-solid fa-plus"></i>
                      </a>
                </div>
            </div>


        </div>



    </div>
@endsection

@section('js-scripts')
@endsection
