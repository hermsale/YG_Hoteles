<x-app-layout>
    <section class="relative min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('img/otros/fondo-inicio.png') }}');">
        <div class="py-24 bg-black bg-opacity-50">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-2xl shadow-xl p-8">

                    {{-- Encabezado --}}
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">
                        🛏️ Detalles de tu Reserva
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        {{-- Imagen --}}
                        <div>
                            <img src="{{ asset($reserva->habitacion->imagenes->first()->url) }}"
                                alt="Imagen habitación"
                                class="rounded-lg shadow-md w-full h-60 object-cover">
                        </div>

                        {{-- Información principal --}}
                        <div class="md:col-span-2 space-y-5 text-gray-800 text-sm">
                            <div>
                                <h3 class="text-xl font-semibold italic text-gray-800">
                                    Habitación N°{{ $reserva->habitacion->codigo_habitacion }} - {{ $reserva->habitacion->categoria->nombre }}
                                </h3>
                                <p class="text-gray-600 mt-1">{{ $reserva->habitacion->descripcion }}</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div>
                                    <span class="text-gray-500 italic">📅 Fecha Ingreso</span>
                                    <p class="font-medium">{{ \Carbon\Carbon::parse($reserva->fecha_ingreso)->format('d M. Y') }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500 italic">📅 Fecha Egreso</span>
                                    <p class="font-medium">{{ \Carbon\Carbon::parse($reserva->fecha_egreso)->format('d M. Y') }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500 italic">👤 Huéspedes</span>
                                    <p class="font-medium">{{ $reserva->habitacion->capacidad ?? 'No especificado' }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500 italic">💰 Total</span>
                                    <p class="font-medium">${{ number_format($reserva->precio_final, 2, ',', '.') }} ARS</p>
                                </div>
                                <div>
                                    <span class="text-gray-500 italic">📌 Estado de Reserva</span>
                                    <p class="font-medium">{{ $reserva->estado_reserva }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500 italic">💳 Estado de Pago</span>
                                    <p class="font-semibold
                                        @if($reserva->estado_pago === 'Pendiente') text-yellow-600
                                        @elseif($reserva->estado_pago === 'Pagado') text-green-600
                                        @else text-red-600 @endif">
                                        {{ $reserva->estado_pago }}
                                    </p>
                                </div>
                            </div>


                            {{-- Acciones --}}
                            <div class="flex flex-col sm:flex-row gap-4 mt-6">
                                @if (session('success'))
                                <div
                                    x-data="{ show: true }"
                                    x-init="setTimeout(() => show = false, 3000)"
                                    x-show="show"
                                    x-transition
                                    class="fixed top-1/2  left-1/2 z-50 transform -translate-x-1/2 bg-green-100 border border-green-400 text-green-800 px-6 py-3 rounded-lg shadow-lg"
                                    role="alert">
                                    <strong class="font-semibold">✔ ¡Aviso enviado!</strong>
                                    <span class="block mt-1">{{ session('success') }}</span>
                                </div>
                                @endif
                                <form method="POST" action="{{ route('reservas.avisoPago', $reserva->id) }}">
                                    @csrf

                                    <!-- si el estado de reserva es pendiente y todavia no se dio aviso de pago. mostrar aviso de pago verde y habilitado -->
                                    <!-- si diste aviso de pago se deshabilita la opcion y cambia de color -->
                                    <button
                                        class="px-5 py-2 rounded-xl text-white font-semibold transition
                                        @if ($reserva->estado_pago === 'Pendiente' && !$reserva->aviso_pago)
                                             bg-green-600 hover:bg-green-700
                                                @else
                                                bg-gray-400 cursor-not-allowed'
                                            @endif"
                                        {{ $reserva->estado_pago === 'Cancelado' ? 'bg-gray-400  cursor-default'  : '' }}
                                        {{ $reserva->aviso_pago ? 'disabled' : '' }}>
                                        Aviso de Pago
                                    </button>
                                </form>
                                <button
                                    class="px-5 py-2 rounded-xl text-white font-semibold
                                        {{ $reserva->estado_pago === 'Cancelado' ? 'bg-gray-400  cursor-default'  : 'bg-red-600 hover:bg-red-700' }}"
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
