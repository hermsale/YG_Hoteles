<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'YG-Hotel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-orange-50">
    <div class="min-h-screen flex flex-col justify-center items-center">
        <!-- Logo -->
        <div class="mb-6">
            <a href="/">
                <x-application-logo class="w-24 h-24 fill-current text-orange-600" />
            </a>
            <h1 class="text-2xl font-bold mt-2 text-orange-700">Bienvenido a YG Hotel</h1>
        </div>

        <!-- Formulario de login/register -->
        <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-lg rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
