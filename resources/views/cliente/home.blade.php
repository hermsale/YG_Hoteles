@extends('layouts.app')

@section('content')
    <!-- Hero -->
    <section class="bg-orange-100">
        <div class="max-w-7xl mx-auto px-4 py-20 text-center">
            <h1 class="text-4xl font-extrabold text-orange-700 mb-4">Bienvenido a YG Hotel</h1>
            <p class="text-lg text-gray-700 mb-6">
                Descansá con estilo y confort. Habitaciones premium, servicios exclusivos y atención personalizada.
            </p>
            <a href="#" class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-full font-semibold transition">
                Reservar ahora
            </a>
        </div>
    </section>

    <!-- Habitaciones -->
    <section class="bg-white py-16">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-orange-700 mb-10">Nuestras habitaciones</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @for ($i = 0; $i < 3; $i++)
                    <div class="bg-orange-50 rounded-lg shadow-md p-4">
                        <div class="w-full h-48 bg-gray-300 rounded-md mb-4"></div>
                        <h3 class="text-xl font-semibold text-orange-800 mb-2">Habitación {{ $i + 1 }}</h3>
                        <p class="text-gray-600 text-sm mb-2">Descripción corta de la habitación para mostrar diseño.</p>
                        <span class="text-orange-700 font-bold">$999.99 / noche</span>
                    </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- Galería -->
    <section class="bg-orange-50 py-16">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-orange-700 mb-10">Galería</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @for ($i = 0; $i < 4; $i++)
                    <div class="w-full h-48 bg-gray-300 rounded-lg shadow-sm"></div>
                @endfor
            </div>
        </div>
    </section>

    <!-- Reseñas -->
    <section class="bg-white py-16">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-orange-700 mb-10">Lo que dicen nuestros huéspedes</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @for ($i = 0; $i < 2; $i++)
                    <div class="bg-orange-50 p-6 rounded-lg shadow">
                        <p class="text-gray-700 italic">"Excelente servicio, volvería sin dudarlo."</p>
                        <div class="mt-4 text-orange-800 font-semibold">- Cliente {{ $i + 1 }}</div>
                    </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- Contacto -->
    <section class="bg-orange-100 py-16">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-orange-800 mb-6">Contacto</h2>
            <p class="text-gray-700 mb-6">
                ¿Tenés dudas o querés hacer una consulta? Completá el formulario y te responderemos a la brevedad.
            </p>
            <form action="#" method="POST" class="space-y-4 text-left">
                <input type="text" placeholder="Tu nombre" class="w-full border border-gray-300 px-4 py-2 rounded">
                <input type="email" placeholder="Tu correo" class="w-full border border-gray-300 px-4 py-2 rounded">
                <textarea rows="4" placeholder="Escribí tu mensaje" class="w-full border border-gray-300 px-4 py-2 rounded"></textarea>
                <button type="submit" class="bg-orange-600 text-white font-semibold px-6 py-2 rounded hover:bg-orange-700 transition">
                    Enviar mensaje
                </button>
            </form>
        </div>
    </section>
@endsection
