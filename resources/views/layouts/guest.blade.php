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

        <!-- Styles & Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Flowbite JS -->
        <script src="https://unpkg.com/flowbite@latest/dist/flowbite.min.js" defer></script>

        <!-- Lucide Icons -->
        <script src="https://unpkg.com/lucide@latest" defer></script>
    </head>

    <body class="font-sans antialiased bg-gray-900 text-white">
        <div class="min-h-screen flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8">
            <!-- Logo -->
            <div class="mb-6">
                <a href="/" class="flex items-center space-x-2">
                    <x-application-logo class="w-16 h-16 fill-current text-white" />
                    <span class="text-xl font-bold">NepiCard</span>
                </a>
            </div>

            <!-- Auth Card -->
            <div class="w-full sm:max-w-md bg-gray-800 shadow-lg rounded-lg p-6">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <footer class="text-sm text-gray-400 mt-8 text-center">
                &copy; {{ date('Y') }} NepiCard. Tutti i diritti riservati.
            </footer>
        </div>
    </body>
</html>
