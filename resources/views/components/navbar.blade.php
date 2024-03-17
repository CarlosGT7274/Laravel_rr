<header class="flex justify-between lg:hidden p-4 bg-dark select-none w-full">
    <a class="flex justify-between items-center space-x-3">
        @include('svg.logo')
        <p class="text-2xl text-light">On the minute</p>
    </a>
    <button aria-label="open navbar" id="open" onclick="showNav(true)" class="hidden focus:outline-none focus:ring-2">
        <i class="fa-solid fa-bars fa-xl text-light"></i>
    </button>
    <button aria-label="close navbar" id="close" onclick="showNav(false)" class=" focus:outline-none focus:ring-2">
        <i class="fa-solid fa-xmark fa-xl text-light"></i>
    </button>
</header>
