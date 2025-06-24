
<x-app-layout>
    <!-- Hero Section con imagen de fondo -->
    <section class="relative h-screen bg-cover bg-center"
            style="background-image: url('{{ asset('img/otros/fondo-inicio.png') }}');">
            <div class="absolute inset-0 bg-black bg-opacity-40"></div>
            <div class="relative z-10 flex justify-center items-center h-full">
                <div class="bg-white text-black p-6 rounded shadow-lg w-80">
                    <h2 class="text-lg font-semibold mb-4">Reserva Online</h2>
                    <form>
                        <label class="block text-sm">Fecha de entrada</label>
                        <input type="date" class="w-full border rounded p-1 mb-3" value="2025-04-03">

                        <label class="block text-sm">Fecha de salida</label>
                        <input type="date" class="w-full border rounded p-1 mb-3" value="2025-04-04">

                        <label class="block text-sm">Huéspedes</label>
                        <select class="w-full border rounded p-1">
                            <option>2 Adultos</option>
                            <option>3 Adultos</option>
                            <option>4 Adultos</option>
                        </select>

                        <button type="submit" class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">
                            Buscar
                        </button>
                    </form>
                </div>
            </div>
        </section>

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
