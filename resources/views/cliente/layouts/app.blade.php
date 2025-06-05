<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'YG-Hotel') }}</title>

    <!-- Tipografía moderna -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />

    <!-- Estilos -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Tailwind personalizado -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }
    </style>
</head>
<body class="bg-white text-gray-800 antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Header fijo con fondo naranja claro -->
        <header class="bg-orange-300 shadow-md sticky top-0 z-50">
            @include('layouts.navigation')
        </header>

        <!-- Hero / Header (opcional) -->
        @isset($header)
            <div class="bg-orange-100">
                <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </div>
        @endisset

        <!-- Contenido principal -->
        <main class="flex-1">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white text-sm py-4 mt-8">
            <div class="max-w-7xl mx-auto px-4 text-center">
                &copy; {{ date('Y') }} YG Hotel. Todos los derechos reservados.
            </div>
        </footer>
    </div>
</body>
</html>
