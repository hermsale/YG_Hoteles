<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'YG-Hotel') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- esto corresponde a la barra de navegacion -->
            @include('layouts.navigation')
        </header>

        <!-- @include('layouts.navigation') -->

        <!-- Esto es lo que carga el titulo header - agregado por ale -->
        @isset($header)
            <header class="bg-orange-200 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!--  contenido principal  -->
        <main>
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
