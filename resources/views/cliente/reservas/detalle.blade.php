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
                            <img src="{{ asset($reserva->habitacion->imagenes->first()->url) }}"
                                alt="Foto habitación"
                                class="rounded-md shadow-md w-full h-auto object-cover">
                        </div>

                        {{-- Detalles --}}
                        <div class="md:col-span-2 space-y-2 text-gray-800">
                            <h3 class="text-lg italic font-semibold">Habitación Nro {{ $reserva->habitacion->codigo_habitacion }} - {{ $reserva->habitacion->categoria->nombre }}</h3>
                            <p class="text-base text-gray-600">{{ $reserva->habitacion->descripcion }}</p>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4 text-sm">
                                <div>
                                    <span class="italic text-gray-500">Fecha Ingreso</span>
                                    <p class="text-gray-900 font-medium"> {{ \Carbon\Carbon::parse($reserva->fecha_ingreso)->format('d M. Y') }}</p>
                                </div>
                                <div>
                                    <span class="italic text-gray-500">Fecha Egreso</span>
                                    <p class="text-gray-900 font-medium">{{ \Carbon\Carbon::parse($reserva->fecha_egreso)->format('d M. Y') }}</p>
                                </div>
                                <div>
                                    <span class="italic text-gray-500">Importe Total</span>
                                    <p class="text-gray-900 font-medium">${{ number_format($reserva->precio_final, 2, ',', '.') }} ARS</p>
                                </div>
                                <div>
                                    <span class="italic text-gray-500">Estado</span>
                                    <p class="font-semibold
                                        @if($reserva->estado_pago === 'Pendiente') text-yellow-600
                                         @elseif($reserva->estado_pago === 'Pagado') text-green-600
                                            @else text-red-600 @endif">
                                        {{ $reserva->estado_pago }}
                                    </p>
                                </div>
                                <div>
                                    <span class="italic text-gray-500">Huéspedes</span>
                                    <p class="text-gray-900 font-medium">{{ $reserva->habitacion->capacidad ?? 'No especificado' }}</p>
                                </div>
                            </div>

                            {{-- Botones --}}
                            <div class="flex flex-col md:flex-row gap-4 mt-6">
                                {{-- Botón Aviso de Pago --}}
                                <button
                                    class="px-5 py-2 rounded shadow font-semibold text-white
                    {{ $reserva->estado_pago === 'Cancelado' || $reserva->estado_pago === 'Pagado'
                    ? 'bg-gray-400 cursor-not-allowed'
                    : 'bg-green-500 hover:bg-green-600' }}"
                                    {{ ($reserva->estado_pago === 'Cancelado' || $reserva->estado_pago === 'Pagado') ? 'disabled' : '' }}>
                                    Aviso de Pago
                                </button>

                                {{-- Botón Cancelar Reserva --}}
                                <button
                                    class="px-5 py-2 rounded shadow italic text-white
               {{ $reserva->estado_pago === 'Cancelado'
                    ? 'bg-gray-400 cursor-not-allowed'
                    : 'bg-red-600 hover:bg-red-700' }}"
                                    {{ $reserva->estado_pago === 'Cancelado' ? 'disabled' : '' }}>
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
