<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'YG-Hotel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-blue-400 text-white font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- esto corresponde a la barra de navegacion -->
        @include('layouts.navigation')

        <!-- Esto es lo que carga el titulo header-->
        @isset($header)
        <header class="bg-orange-200 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Información de contacto --}}
                <div>
                    <h3 class="text-lg font-semibold mb-3">Contáctanos</h3>
                    <p class="text-sm">📍 RP222 123, Las Leñas</p>
                    <p class="text-sm">📞 +54 11 1234-5678</p>
                    <p class="text-sm">📧 Contacto@YGHotel.com</p>
                </div>

                {{-- Enlaces útiles (opcional) --}}
                <div>
                    <h3 class="text-lg font-semibold mb-3">Enlaces útiles</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('contacto.index') }}" class="hover:underline">Contáctanos</a></li>
                    </ul>
                </div>

                {{-- Redes sociales --}}
                <div>
                    <h3 class="text-lg font-semibold mb-3">Seguinos</h3>
                    <div class="flex space-x-4 mt-2">
                        <a href="https://instagram.com/tuhotel" target="_blank" class="hover:text-pink-500 transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2Zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5A4.25 4.25 0 0 0 20.5 16.25v-8.5A4.25 4.25 0 0 0 16.25 3.5h-8.5Zm8.75 2.25a.75.75 0 0 1 .75.75v1a.75.75 0 0 1-1.5 0v-1a.75.75 0 0 1 .75-.75Zm-5 2.5a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 1.5a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Z" />
                            </svg>
                        </a>
                        <a href="https://facebook.com/tuhotel" target="_blank" class="hover:text-blue-600 transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14 3h3a1 1 0 0 1 1 1v3h-3a2 2 0 0 0-2 2v2h5l-1 4h-4v8h-4v-8H8v-4h3V9a4 4 0 0 1 4-4Z" />
                            </svg>
                        </a>
                        <a href="https://twitter.com/tuhotel" target="_blank" class="hover:text-blue-400 transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22 5.92a8.38 8.38 0 0 1-2.36.65 4.1 4.1 0 0 0 1.8-2.27 8.2 8.2 0 0 1-2.6 1 4.1 4.1 0 0 0-7 3.74A11.63 11.63 0 0 1 3 4.79a4.07 4.07 0 0 0-.56 2.06 4.1 4.1 0 0 0 1.82 3.41 4.06 4.06 0 0 1-1.86-.5v.05a4.1 4.1 0 0 0 3.3 4 4.1 4.1 0 0 1-1.85.07 4.1 4.1 0 0 0 3.83 2.85A8.23 8.23 0 0 1 2 18.13a11.63 11.63 0 0 0 6.29 1.84c7.55 0 11.67-6.26 11.67-11.67 0-.18 0-.35-.01-.53A8.18 8.18 0 0 0 22 5.92Z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-8 text-center text-sm text-gray-400">
                © {{ date('Y') }} YGHotel. Todos los derechos reservados.
            </div>
        </div>
    </footer>

</body>

</html>
