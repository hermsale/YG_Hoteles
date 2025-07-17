<div>

    @if(count($habitaciones) > 0)
    <div class="mt-10 space-y-10">
        @foreach($habitaciones as $habitacion)
        <div class="bg-gray-100 text-black rounded-lg shadow p-6 flex flex-col md:flex-row gap-6">
            @php $imagen = $habitacion->imagenes->first(); @endphp

            
            <img src="{{ asset($imagen->url ?? asset('img/otros/no-image.png')) }}"
                class="w-full md:w-1/3 max-h-64 object-cover rounded-lg">

            <div class="md:w-2/3">
                <h3 class="text-xl font-bold mb-2">{{ $habitacion->nombre }}</h3>
                <p class="mb-4">{{ $habitacion->descripcion }}</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm mb-4">
                    <ul class="list-disc list-inside">
                        <p><strong>Servicios incluidos:</strong></p>
                        @forelse($habitacion->amenities as $amenity)
                        <li>{{ $amenity->nombre }}</li>
                        @empty
                        <li>Sin servicios listados</li>
                        @endforelse
                    </ul>
                    <div>
                        <p>Capacidad: <strong>{{ $habitacion->capacidad }}</strong></p>
                        <p>Categoría: <strong>{{ $habitacion->categoria->nombre ?? 'Sin categoría' }}</strong></p>
                        <p>Código: <strong>{{ $habitacion->codigo_habitacion }}</strong></p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <p><strong>Precio por noche:</strong>
                        <span class="text-green-700 font-semibold">
                            {{ number_format($habitacion->precio_noche, 2, ',', '.') }} ARS
                        </span>
                    </p>
                </div>
                <button onclick="Livewire.dispatch('abrir-modal-reserva', {
                        component: 'confirmar-reserva-modal',
                        nombreHabitacion: '{{ $habitacion->nombre }}',
                        capacidad: '{{ $habitacion->capacidad }}',
                        codigo_habitacion: '{{ $habitacion->codigo_habitacion }}',
                        imagenUrl: '{{ $imagen->url  }}',
                        fechaEntrada: '{{ $fechaEntrada }}',
                        fechaSalida: '{{ $fechaSalida }}',
                        precioNoche: '{{ $habitacion->precio_noche }}',
                        })" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Reservar Ahora
                </button>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p class="mt-4 text-gray-600">No hay habitaciones disponibles.</p>
    @endif
</div>
