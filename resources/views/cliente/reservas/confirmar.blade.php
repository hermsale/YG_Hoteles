<x-app-layout>
    <section class="relative min-h-screen bg-cover bg-center"
        style="background-image: url('{{ asset('img/otros/fondo-inicio.png') }}');">
        <div class="py-24 bg-black bg-opacity-50">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl rounded-2xl p-8">

                    {{-- Título --}}
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">
                        📋 Confirmar Reserva
                    </h2>

                    <p class="text-gray-600 mb-4">
                        Estás a punto de reservar la siguiente habitación. Por favor, revisá los datos antes de confirmar.
                    </p>

                    {{-- Datos habitación --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start mb-8">
                        {{-- Imagen --}}
                        <div>
                            <img src="{{ asset($habitacion->imagenes->first()->url) }}"
                                 alt="Imagen habitación"
                                 class="rounded-lg shadow-md w-full h-64 object-cover">
                        </div>

                        {{-- Info --}}
                        <div class="md:col-span-2 space-y-4 text-gray-800 text-sm">
                            <div>
                                <h3 class="text-lg font-semibold italic">
                                    Habitación N° {{ $habitacion->codigo_habitacion }}
                                </h3>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <span class="text-gray-500 italic">📅 Fecha Ingreso</span>
                                    <p class="font-medium">{{ $fechaEntrada }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500 italic">📅 Fecha Egreso</span>
                                    <p class="font-medium">{{ $fechaSalida }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500 italic">🌙 Cantidad de Noches</span>
                                    <p class="font-medium">{{ $cantidadNoches }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500 italic">💳 Importe Total</span>
                                    <p class="font-medium">${{ number_format($importeTotal, 2, ',', '.') }} ARS</p>
                                </div>
                                <div>
                                    <span class="text-gray-500 italic">👤 Capacidad Máxima</span>
                                    <p class="font-medium">{{ $habitacion->capacidad }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Formulario --}}
                    <form method="POST" action="{{ route('reservas.confirmarYGuardar') }}">
                        @csrf
                        {{-- Campos ocultos --}}
                        <input type="hidden" name="habitacion_id" value="{{ $habitacion->id }}">
                        <input type="hidden" name="fecha_ingreso" value="{{ $fechaEntrada }}">
                        <input type="hidden" name="fecha_egreso" value="{{ $fechaSalida }}">
                        <input type="hidden" name="precio_total" value="{{ $importeTotal }}">

                        <div class="flex flex-col sm:flex-row gap-4">
                            <button type="submit"
                                class="px-5 py-2 rounded-xl shadow font-semibold text-white bg-green-600 hover:bg-green-700 transition">
                                ✅ Confirmar Reserva
                            </button>

                            <a href="{{ route('habitaciones.index') }}"
                               class="px-5 py-2 rounded-xl shadow text-white bg-gray-500 hover:bg-gray-600 text-center transition">
                                🔙 Volver
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
