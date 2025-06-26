<x-app-layout>

    <section class="relative h-screen bg-cover bg-center"
        style="background-image: url('{{ asset('img/otros/fondo-inicio.png') }}');">
        <div class="py-16">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white shadow-lg rounded-lg p-6">


                    <div class="md:col-span-2 space-y-2 text-gray-800">
                        <h3 class="text-lg italic font-semibold">Confirmar Reserva</h3>
                        <p class="text-base text-gray-600">Estás a punto de reservar la siguiente habitación:</p>

                        <h4 class="text-md font-semibold">Habitación Nro</h4>
                        <p class="text-sm text-gray-600">{{ $habitacion->codigo_habitacion }}</p>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4 text-sm">
                            <div>
                                <span class="italic text-gray-500">Fecha Ingreso</span>
                                <p class="text-gray-900 font-medium">{{ $fechaEntrada }}</p>
                            </div>
                            <div>
                                <span class="italic text-gray-500">Fecha Egreso</span>
                                <p class="text-gray-900 font-medium">{{ $fechaSalida }}</p>
                            </div>
                            <div>
                                <span class="italic text-gray-500">Cantidad de Noches</span>
                                <p class="text-gray-900 font-medium">{{ $cantidadNoches }}</p>
                            </div>
                            <div>
                                <span class="italic text-gray-500">Importe Total</span>
                                <p class="text-gray-900 font-medium">${{ number_format($importeTotal, 2, ',', '.') }} ARS</p>
                            </div>
                            <div>
                                <span class="italic text-gray-500">Huéspedes</span>
                                <p class="text-gray-900 font-medium">{{ $huespedes }}</p>
                            </div>
                        </div>

                        {{-- Botones --}}
                        <form method="POST" class="mt-6">
                            @csrf
                            {{-- Datos ocultos --}}
                            <input type="hidden" name="habitacion_id" value="301">
                            <input type="hidden" name="fecha_ingreso" value="22/10/2025">
                            <input type="hidden" name="fecha_egreso" value="30/10/2025">
                            <input type="hidden" name="huespedes" value="1">
                            <input type="hidden" name="precio_total" value="1000">

                            <div class="flex flex-col md:flex-row gap-4">
                                <button type="submit"
                                    class="px-5 py-2 rounded shadow font-semibold text-white bg-green-600 hover:bg-green-700">
                                    Confirmar Reserva
                                </button>

                                <a href="{{ route('habitaciones.index') }}"
                                    class="px-5 py-2 rounded shadow text-white bg-gray-500 hover:bg-gray-600 text-center">
                                    Volver
                                </a>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>

    </section>
</x-app-layout>
