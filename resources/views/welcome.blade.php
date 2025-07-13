<!-- app-layout es el navbar  -->
<x-app-layout>

    <x-formulario-reserva />

    <!-- cito el componente de navbar -->
    <x-navbar />

    {{-- Descripción --}}
    <section class="px-8 py-12 bg-gray-900">
        <div class="max-w-6xl mx-auto px-4">

            <h2 class="text-3xl font-bold mb-4">YG Hoteles – Confort y naturaleza en Las Leñas</h2>
            <p class="mb-4">
                Ubicado en el corazón de Las Leñas, YGHoteles ofrece la combinación perfecta entre comodidad y naturaleza.
                Con 15 habitaciones, el hotel brinda un ambiente cálido y acogedor para disfrutar de la tranquilidad de la
                montaña.
            </p>
            <p class="mb-4">
                Situado a pocos minutos de los principales centros de esquí y actividades al aire libre, el hotel es ideal
                para quienes
                buscan aventura en la nieve o simplemente relajarse con vistas impresionantes.
            </p>
            <p class="mb-4">
                Las habitaciones de YGHoteles cuentan con detalles de calidad, algunas incluyen ventanales panorámicos con
                vista a la
                montaña, minibar y una zona de descanso. Todas están equipadas con ventanas insonorizadas, escritorio,
                calefacción y baño
                privado con ducha y artículos de tocador.
            </p>
            <p class="mb-6">
                Ya sea para una escapada en pareja, un viaje en familia o una aventura en la nieve, YGHoteles te ofrece el
                mejor refugio
                en Las Leñas. ¡Te esperamos!
            </p>

            <div class="flex justify-center">
                <img src="{{ asset('img/otros/descripcion-ubicacion-2.png') }}" alt="Mapa de ubicación"
                    class="rounded shadow-md w-full max-w-3xl">
            </div>
        </div>
    </section>
</x-app-layout>
