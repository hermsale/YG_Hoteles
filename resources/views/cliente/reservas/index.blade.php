<x-app-layout>
    <section class="relative min-h-screen bg-cover bg-center"
        style="background-image: url('{{ asset('img/otros/fondo-inicio.png') }}');">

        <div class="py-24 px-4 bg-black bg-opacity-50">
            <div class="max-w-6xl mx-auto bg-white bg-opacity-95 rounded-2xl shadow-xl p-8">

                {{-- Título --}}
                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    📌 Reservas en Curso
                </h2>

                {{-- Mensaje de éxito --}}
                @if (session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
                    class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-sm"
                    role="alert">
                    <strong class="font-bold">✔️ ¡Éxito!</strong>
                    <span class="ml-2">{{ session('success') }}</span>
                </div>
                @endif

                {{-- Tabla de reservas --}}
                <div class="overflow-x-auto rounded-lg shadow-md border border-gray-300">
                    <table class="min-w-full text-sm text-gray-900">
                        <thead class="bg-gray-100 text-left text-gray-700 uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-4 py-3">Fecha de compra</th>
                                <th class="px-4 py-3">Estado Reserva</th>
                                <th class="px-4 py-3">Estado Pago</th>
                                <th class="px-4 py-3">Habitación</th>
                                <th class="px-4 py-3">Fecha Ingreso</th>
                                <th class="px-4 py-3">Fecha Egreso</th>
                                <th class="px-4 py-3">Importe Total</th>
                                <th class="px-4 py-3 text-center">Detalle</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach ($reservas as $reserva)
                            <tr class="hover:bg-gray-50 transition">
                                {{-- Fecha de compra --}}
                                <td class="px-4 py-3">
                                    {{ \Carbon\Carbon::parse($reserva->fecha_creacion)->format('d/m/Y H:i') }}
                                </td>

                                {{-- Estado de Reserva --}}
                                <td class="px-4 py-3">
                                    <span class="font-semibold
                            @if($reserva->estado_reserva === 'Activa') text-green-600
                            @elseif($reserva->estado_reserva === 'pendiente') text-yellow-600
                            @elseif($reserva->estado_reserva === 'Finalizada') text-blue-600
                            @elseif($reserva->estado_reserva === 'Cancelada') text-red-600
                            @else text-gray-600 @endif">
                                        {{ $reserva->estado_reserva }}
                                    </span>
                                </td>

                                {{-- Estado de Pago --}}
                                <td class="px-4 py-3">
                                    <span class="font-semibold
                            @if($reserva->estado_pago === 'Pagado') text-green-600
                            @elseif($reserva->estado_pago === 'Pendiente') text-yellow-600
                            @elseif($reserva->estado_pago === 'Cancelado') text-red-600
                            @else text-gray-600 @endif">
                                        {{ $reserva->estado_pago }}
                                    </span>
                                </td>

                                {{-- Habitación --}}
                                <td class="px-4 py-3">
                                    {{ $reserva->habitacion->codigo_habitacion }} - {{ $reserva->habitacion->categoria->nombre }}
                                </td>

                                {{-- Fechas --}}
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($reserva->fecha_ingreso)->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($reserva->fecha_egreso)->format('d/m/Y') }}</td>

                                {{-- Importe --}}
                                <td class="px-4 py-3 font-medium">
                                    ${{ number_format($reserva->precio_final, 2, ',', '.') }}
                                </td>

                                {{-- Detalle --}}
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('reservas.detalleReserva', $reserva->id) }}"
                                        class="text-blue-600 hover:underline font-semibold">
                                        Ver detalles
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


            </div>
        </div>


    </section>
</x-app-layout>
