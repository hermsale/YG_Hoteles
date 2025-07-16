
<x-app-layout>
    <!-- formulario de reserva -->
            <x-formulario-reserva />

 <!-- cito el componente de navbar -->
    <x-navbar />

    <!-- Sección de habitaciones -->
    <section class="bg-gray-900 text-white py-16">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-6">Galería de Fotos</h2>
            {{-- Galería de imágenes --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 justify-items-center">
                @foreach ($imagenes as $img)
                    <img src="{{ asset($img->url) }}"
                         alt="Foto"
                         class="w-72 h-48 object-cover rounded shadow-lg" />
                @endforeach

                @foreach (['/img/otros/imagen-1.jpg','/img/otros/imagen-2.jpg','/img/otros/imagen-3.jpg','/img/otros/imagen-4.jpg','/img/otros/imagen-5.jpg','/img/otros/imagen-6.jpg'] as $ruta)
                    <img src="{{ asset($ruta) }}"
                         alt="Foto del hotel"
                         class="w-72 h-48 object-cover rounded shadow-lg" />
                @endforeach
        </div>
        </div>
    </section>
</x-app-layout>
