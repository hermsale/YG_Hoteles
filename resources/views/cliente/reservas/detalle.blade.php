<x-app-layout>

 <section class="relative h-screen bg-cover bg-center"
            style="background-image: url('{{ asset('img/otros/fondo-inicio.png') }}');">
  <div class="py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Detalles Reserva</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
          {{-- Imagen habitación --}}
          <div>
            <img src="{{ asset('img/habitaciones/habitacion-deluxe101-1.png') }}"
                 alt="Foto habitación"
                 class="rounded-md shadow-md w-full h-auto object-cover">
          </div>

          {{-- Detalles --}}
          <div class="md:col-span-2 space-y-2 text-gray-800">
            <h3 class="text-lg italic font-semibold">Habitación</h3>
            <p class="text-base text-gray-600">Habitación Estándar con Vista Panorámica</p>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4 text-sm">
              <div>
                <span class="italic text-gray-500">Fecha Ingreso</span>
                <p class="text-gray-900 font-medium">30 Dic. 2025</p>
              </div>
              <div>
                <span class="italic text-gray-500">Fecha Egreso</span>
                <p class="text-gray-900 font-medium">4 Ene. 2026</p>
              </div>
              <div>
                <span class="italic text-gray-500">Importe Total</span>
                <p class="text-gray-900 font-medium">360,000 ARS</p>
              </div>
              <div>
                <span class="italic text-gray-500">Estado</span>
                <p class="text-yellow-600 font-semibold">Pendiente</p>
              </div>
              <div>
                <span class="italic text-gray-500">Huéspedes</span>
                <p class="text-gray-900 font-medium">2</p>
              </div>
            </div>

            {{-- Botones --}}
            <div class="flex flex-col md:flex-row gap-4 mt-6">
              <button class="bg-green-500 hover:bg-green-600 text-white font-semibold px-5 py-2 rounded shadow">
                Aviso de Pago
              </button>

              <button class="bg-red-600 hover:bg-red-700 text-white italic px-5 py-2 rounded shadow">
                Cancelar Reserva
              </button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

</section>
</x-app-layout>
