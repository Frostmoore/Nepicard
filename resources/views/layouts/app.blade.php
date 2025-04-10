<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'NepiCard') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font Awesome CDN -->
        <script src="https://kit.fontawesome.com/11dce758f8.js" crossorigin="anonymous"></script>

        <!-- Styles & Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-900 text-white">
        <div class="min-h-screen flex flex-col">
            <header class="bg-gray-800 shadow-md">
                @include('layouts.navigation')
            </header>

            <main class="flex-1 container mx-auto p-4">
                @include('partials.alerts')
                {{ $slot }}
            </main>

            <footer class="bg-gray-800 text-gray-300 text-center py-4 text-sm">
                &copy; {{ date('Y') }} NepiCard. Tutti i diritti riservati.
            </footer>
        </div>

        <!-- Flowbite + Font Awesome -->
        <script src="https://unpkg.com/flowbite@latest/dist/flowbite.min.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const toggle = document.getElementById("userMenuButton");
                const menu = document.getElementById("userMenu");

                if (toggle && menu) {
                    toggle.addEventListener("click", () => {
                        menu.classList.toggle("hidden");
                    });

                    document.addEventListener("click", (e) => {
                        if (!toggle.contains(e.target) && !menu.contains(e.target)) {
                            menu.classList.add("hidden");
                        }
                    });
                }
            });
        </script>

    </body>
</html>
