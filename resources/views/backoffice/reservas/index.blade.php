<x-app-layout>
    <section class="relative min-h-screen bg-cover bg-center"
        style="background-image: url('{{ asset('img/otros/fondo-inicio.png') }}');">
        <div class="py-24 px-4 bg-black bg-opacity-50">
            <div class="w-full max-w-7xl mx-auto bg-white bg-opacity-95 rounded-2xl shadow-xl px-8 py-10">

                {{-- Título --}}
                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    🗂 Gestión de Reservas
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
                <div class="w-full rounded-lg shadow-md border border-gray-300">
                    <table class="w-full table-fixed text-[13px] text-gray-900">
                        <thead class="bg-gray-100 text-left text-gray-700 uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-2 py-2 w-14">Nro</th>
                                <th class="px-2 py-2 w-32 truncate">Cliente</th>
                                <th class="px-2 py-2 w-32">Fecha de compra</th>
                                <th class="px-2 py-2 w-28">Estado Reserva</th>
                                <th class="px-2 py-2 w-28">Estado Pago</th>
                                <th class="px-2 py-2 w-48 truncate">Habitación</th>
                                <th class="px-2 py-2 w-28">Ingreso</th>
                                <th class="px-2 py-2 w-28">Egreso</th>
                                <th class="px-2 py-2 w-24">Importe</th>
                                <th class="px-2 py-2 w-32 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($reservas as $reserva)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-2 py-2 text-center">#{{ $reserva->id ?? 'N/A' }}</td>
                                <td class="px-2 py-2 truncate">{{ $reserva->usuario->name ?? 'N/A' }}</td>
                                <td class="px-2 py-2">{{ \Carbon\Carbon::parse($reserva->fecha_creacion)->format('d/m/Y H:i') }}</td>
                                <td class="px-2 py-2">
                                    <span class="font-semibold
                                            @if($reserva->estado_reserva === 'Activa') text-green-600
                                            @elseif($reserva->estado_reserva === 'Finalizada') text-blue-600
                                            @elseif($reserva->estado_reserva === 'Cancelada') text-red-600
                                            @else text-gray-600 @endif">
                                        {{ $reserva->estado_reserva }}
                                    </span>
                                </td>
                                <td class="px-2 py-2">
                                    <span class="font-semibold px-2 py-1 rounded
                                            @if($reserva->estado_pago === 'Pagado') text-green-600
                                            @elseif($reserva->estado_pago === 'Cancelado') text-red-600
                                            @elseif($reserva->estado_pago === 'Pendiente' && $reserva->aviso_pago)
                                                text-yellow-600 animate-pulse bg-green-200
                                            @elseif($reserva->estado_pago === 'Pendiente')
                                                text-yellow-600
                                            @else
                                                text-gray-600
                                            @endif">
                                        {{ $reserva->estado_pago }}
                                    </span>
                                </td>
                                <td class="px-2 py-2 truncate">
                                    {{ $reserva->habitacion->codigo_habitacion ?? 'N/A' }} -
                                    {{ $reserva->habitacion->categoria->nombre ?? '' }}
                                </td>
                                <td class="px-2 py-2">{{ \Carbon\Carbon::parse($reserva->fecha_ingreso)->format('d/m/Y') }}</td>
                                <td class="px-2 py-2">{{ \Carbon\Carbon::parse($reserva->fecha_egreso)->format('d/m/Y') }}</td>
                                <td class="px-2 py-2 font-medium">
                                    ${{ number_format($reserva->precio_final, 2, ',', '.') }}
                                </td>
                                <td class="px-2 py-2 text-center">
                                    <div class="flex flex-col items-center space-y-1">
                                        @if($reserva->estado_pago === 'Pendiente' && $reserva->aviso_pago)
                                        <form action="{{ route('reservas.pagoConfirmado', $reserva->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                onclick="return confirm('¿Deseás confirmar el pago de esta reserva?')"
                                                class="bg-green-600 text-white px-2 py-1 m-1 rounded text-xs hover:bg-green-700">
                                                Confirmar Pago
                                            </button>
                                        </form>
                                        @endif

                                        @if($reserva->estado_reserva === 'Activa')
                                        <form method="POST" action="{{ route('backoffice.reservas.cancelarReserva', $reserva->id) }}" class="inline">
                                            @csrf
                                            <button
                                                onclick="return confirm('¿Deseás cancelar esta reserva?')"
                                                class="bg-red-600 text-white px-2 py-1 rounded text-xs hover:bg-red-700">
                                                Cancelar
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center text-gray-500 py-6">
                                    No se encontraron reservas registradas.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>

</x-app-layout>
