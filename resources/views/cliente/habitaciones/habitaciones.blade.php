
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
            <h2 class="text-3xl font-bold text-center mb-6">Detalles y Precios</h2>
            <p class="text-center max-w-6xl mx-auto mb-12">
                YGHoteles ofrece 15 exclusivas habitaciones diseñadas para brindar confort y descanso en el corazón de Las Leñas. Algunas de ellas cuentan con balcones privados con vista a las montañas, y están equipadas con minibar y zona de comedor para quienes prefieren opciones de autoservicio.
                Cada habitación ha sido cuidadosamente insonorizada e incluye un amplio escritorio, ideal tanto para el relax como para el trabajo. Los baños están equipados con bañera y ducha, además de artículos de tocador de cortesía. Algunas habitaciones también ofrecen vistas panorámicas al entorno natural de la cordillera, creando una experiencia única de conexión con la montaña.
            </p>

            <!-- Repetí este bloque por habitación -->
            <div class="bg-gray-100 text-black rounded-lg shadow p-6 mb-10 flex flex-col md:flex-row gap-6">
                <img src="/img/habitaciones/habitacion-deluxe101-1.png" alt="Habitación Deluxe" class="w-full md:w-1/3 rounded-lg object-cover">
                <div class="md:w-2/3">
                    <h3 class="text-xl font-bold mb-2">Habitación Deluxe con Vista a la Montaña</h3>
                    <p class="mb-4">Disfruta del máximo confort en nuestra Habitación Deluxe, diseñada para dos huéspedes y con un espacio de 30 m². Su elegante diseño     combina tonos cálidos y una iluminación acogedora, ideal para una estancia relajante.
                    Cuenta con una amplia ventana con vistas panorámicas a las montañas, permitiéndote disfrutar de la belleza natural de Las Leñas desde la comodidad de tu habitación.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm mb-4">
                        <ul class="list-disc list-inside">
                            <p><strong> Servicios incluidos: </strong></p>
                            <li>Cama King size</li>
                            <li>Zona de estar con sillones y mesa auxiliar</li>
                            <li>Baño privado con ducha y bañera</li>
                            <li>Smart TV</li>
                            <li>Wi-Fi de alta velocidad</li>
                            <li>Minibar y set de café/té</li>
                            <li>Escritorio para trabajo o lectura</li>
                            <li>Aire acondicionado y calefacción</li>
                            <li>Caja de seguridad</li>
                        </ul>
                        <div>
                            <p>Capacidad de huéspedes: <strong> 2 </strong></p>
                            <p>Código habitación: <strong> 01 - Deluxe </strong> </p>
                        </div>

                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <p><strong>Precio por 1 noche:</strong> <span class="text-green-700 font-semibold">90000 ARS</span></p>
                        <a href="#" class="mt-2 sm:mt-0 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Reservar Ahora</a>
                    </div>
                </div>
            </div>
            <!-- Fin de habitación -->

        </div>
    </section>
</x-app-layout>
