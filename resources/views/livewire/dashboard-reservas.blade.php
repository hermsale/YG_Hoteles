<div>
    {{-- 🔢 MÉTRICAS SUPERIORES --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center mb-6">
        {{-- 🟢 Llegadas --}}
        <div class="bg-white rounded-xl p-4 shadow border">
            <p class="text-2xl font-bold text-green-600">{{ $totalLlegadas }}</p>
            <p class="text-sm text-gray-600">LLEGADAS</p>
        </div>

        {{-- 🔴 Salidas --}}
        <div class="bg-white rounded-xl p-4 shadow border">
            <p class="text-2xl font-bold text-red-600">{{ $totalSalidas }}</p>
            <p class="text-sm text-gray-600">SALIDAS</p>
        </div>

        {{-- 🔵 Habitaciones ocupadas --}}
        <div class="bg-white rounded-xl p-4 shadow border">
            <p class="text-2xl font-bold text-blue-600">{{ $totalAlojados }}</p>
            <p class="text-sm text-gray-600">HABITACIONES RESERVADAS</p>
        </div>
    </div>

    {{-- 🔀 Filtros --}}
    <div class="flex gap-2 text-sm mb-2">
        <button wire:click="setFiltro('llegadas')" class="px-2 py-1 rounded {{ $filtro === 'llegadas' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700' }}">
            Llegadas
        </button>
        <button wire:click="setFiltro('salidas')" class="px-2 py-1 rounded {{ $filtro === 'salidas' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700' }}">
            Salidas
        </button>
        <button wire:click="setFiltro('alojados')" class="px-2 py-1 rounded {{ $filtro === 'alojados' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700' }}">
            Huéspedes Alojados
        </button>
    </div>

    {{-- 📋 Tabla de reservas --}}
    <table class="w-full text-sm">
        <thead>
            <tr class="text-left text-gray-600 border-b">
                <th>Huésped</th>
                <th>Reserva</th>
                <th>Habitación</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservas as $reserva)
                <tr class="border-b">
                    <td class="py-2 text-blue-600">{{ $reserva->usuario->name ?? 'N/A' }}</td>
                    <td class="py-2 text-blue-600">#{{ $reserva->id }}</td>
                    <td class="py-2 text-blue-600">{{ $reserva->habitacion->nombre ?? 'N/A' }}</td>
                    <td class="flex gap-2 items-center">
                        @if ($reserva->check_in)
                            <span class="text-green-600">Check-in hecho</span>
                        @else
                            <span class="text-yellow-600">Pendiente</span>
                            <button wire:click="hacerCheckIn({{ $reserva->id }})"
                                    class="text-xs bg-blue-500 text-white rounded px-2 py-1 hover:bg-blue-600 transition">
                                Check In
                            </button>
                        @endif

                        {{-- (Opcional) botón de cancelar --}}
                       <button wire:click="cancelarCheckIn({{ $reserva->id }})"
                            class="text-xs bg-red-500 text-white rounded px-2 py-1 hover:bg-red-600 transition">
                        Cancelar
                    </button>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-gray-400 py-4">No hay reservas registradas</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
