<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $pageTitle }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite('resources/css/app.css')
    @vite('resources/icons/css/all.min.css')
    @yield('css-styles')
</head>

<body>

    @include('components.navbar')

    <div class="flex flex-col sm:flex-row">
        @include('components.sidebar')


        <main class="p-6 w-full lg:w-[79%] xl:w-11/12">
            @yield('content')
        </main>
    </div>

    @yield('footer')

    @vite('resources/js/app.js')

    <script>
        const navbar = document.getElementById("navbar-container");
        const openBtn = document.getElementById("open");
        const closeBtn = document.getElementById("close");

        function showNav(flag) {
            if (flag) {
                navbar.classList.remove("hidden");
                openBtn.classList.add("hidden");
                closeBtn.classList.remove("hidden");
            } else {
                navbar.classList.add("hidden");
                openBtn.classList.remove("hidden");
                closeBtn.classList.add("hidden");
            }
        }

        const handleResize = () => {
            if (window.innerWidth >= 1024) {
                showNav(true);
            } else {
                showNav(false);
            }
        };

        window.addEventListener("resize", handleResize);
    </script>

    @yield('js-scripts')
</body>

</html>
