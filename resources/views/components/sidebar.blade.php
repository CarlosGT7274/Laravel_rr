<aside id="navbar-container"
    class="h-[100vh] sticky top-0 left-0 flex flex-col lg:rounded-r sm:max-w-[300px] sm:min-w-[300px] bg-dark ease-in-out transition duration-1000 z-40 flex-grow flex-shrink-0">
    <header class="hidden lg:block select-none">
        <a href="" class="hidden lg:flex justify-start py-6 ps-2 items-center">
            @include('svg.logo')
            <h1 class="text-2xl text-light ps-3">On the minute</h1>
        </a>
    </header>

    <nav class="mt-6 text-light select-none flex-1 flex flex-col">
        <ul class="flex flex-col flex-1 justify-between">
            <div class="h-[50rem] overflow-y-auto">
                @foreach (session('permissions') as $permission)
                    @if ($permission['nombre'] != 'Dashboard')
                        {{-- Dasboard --}}
                        <li class="flex flex-col items-center px-6 border-b-2 border-ldark">
                            <button onclick="showMenu({{ $loop->index }})"
                                class="flex justify-between items-center w-full py-5 hover:text-ldark">
                                <p class="text-sm uppercase">{{ $permission['nombre'] }}</p>
                                <i id="icon{{ $loop->index }}" class="fa-solid fa-angle-down"></i>
                            </button>
                            <ul id="menu{{ $loop->index }}" class="hidden flex-col pb-5 w-full">
                                @foreach ($permission['sub_permissions'] as $sub_permission)
                                    @if ($sub_permission['valor'] >= 0)
                                        <li
                                            class="hover:text-light hover:bg-dlight text-ldark rounded cursor-pointer p-0 flex">
                                            <a class="cursor-pointer ps-3 py-2 w-full"
                                                href="{{ url('/' . $sub_permission['endpoint']) }}">
                                                {{ $sub_permission['nombre'] }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @else
                        @if ($permission['valor'] >= 0)
                            <li class="sticky top-0 bg-dark z-10">
                                <a href="{{ route('dashboard.show') }}"
                                    class="flex items-center gap-6 hover:text-ldark border-ldark border-b-2 pb-5 ps-4 cursor-pointer">
                                    <object class="grid grid-cols-2 gap-1 h-6 items-center">
                                        <i class="fa-regular fa-square fa-2xs"></i>
                                        <i class="fa-regular fa-square fa-2xs"></i>
                                        <i class="fa-regular fa-square fa-2xs"></i>
                                        <i class="fa-regular fa-square fa-2xs"></i>
                                    </object>

                                    <p class="text-base"> {{ $permission['nombre'] }}</p>
                                </a>
                            </li>
                        @endif
                    @endif
                @endforeach
            </div>

            <li class="sticky bottom-0">
                <div class="w-full flex flex-row justify-between items-center p-6">
                    <a class="flex flex-col bg-dark cursor-pointer ">
                        <p class="text-sm text-light">
                            {{ session('user')['nombre'] . ' ' . session('user')['apellidoP'] . ' ' . session('user')['apellidoM'] }}
                        </p>
                        <p class="text-xs text-ldark">{{ session('user')['email'] }}</p>
                    </a>
                    <a href="{{ route('logout') }}"> Logout </a>
                </div>
            </li>
        </ul>
    </nav>

    <script>
        function showMenu(id) {
            const icon = document.getElementById(`icon${id}`);
            const menu = document.getElementById(`menu${id}`);

            icon.classList.toggle("rotate-180");
            menu.classList.toggle("hidden");
            menu.classList.toggle("flex");
        }
    </script>
</aside>
