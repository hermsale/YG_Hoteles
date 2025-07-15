<div>
    @if($mostrarModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60" wire:click.self="$set('mostrarModal', false)">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl p-8 overflow-y-auto max-h-[90vh]">

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
                    <img src="{{ asset($imagenUrl ?? 'img/no-image.png') }}"
                        alt="Imagen habitación"
                        class="rounded-lg shadow-md w-full h-64 object-cover">
                </div>

                {{-- Info --}}
                <div class="md:col-span-2 space-y-4 text-gray-800 text-sm">
                    <div>
                        <h3 class="text-lg font-semibold italic">
                            Habitación N° {{ $codigo_habitacion }}
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
                            <span class="text-gray-500 italic">💳 Importe</span>
                            <p class="font-medium">${{ number_format($importe, 2, ',', '.') }} ARS</p>
                        </div>
                        <div>
                            <span class="text-gray-500 italic">👤 Capacidad Máxima</span>
                            <p class="font-medium">{{ $capacidad }}</p>
                        </div>
                        <div>
                            <label class="text-gray-500 italic block mb-1">🎁 Seleccionar Promoción</label>
                            <select wire:model="promocionSeleccionada" id="promocion"
                                class="border border-gray-300 rounded-lg p-2 w-full">
                                <option value="">-- Sin promoción --</option>
                                @foreach($promociones as $promo)
                                <option value="{{ $promo->id }}">{{ $promo->nombre }} ({{ $promo->descuento_porcentaje }}%)</option>
                                @endforeach
                            </select>
                            <button wire:click="aplicarPromocion"
                                class="mt-3 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Aplicar Promoción
                            </button>
                        </div>

                        {{-- Mostrar descuento aplicado si existe --}}
                        @if($descuento > 0)
                        <div class="bg-green-100 text-green-800 p-3 rounded-lg shadow mt-2 col-span-2">
                            <p><strong>✅ Descuento aplicado:</strong> {{ $descuento }}%</p>
                            <p><strong>💳 Total a pagar:</strong> ${{ number_format($importeTotal, 2, ',', '.') }} ARS</p>
                        </div>
                        @else
                        <div class="text-gray-600 mt-2 col-span-2">
                            <p><strong>Total sin descuento:</strong> ${{ number_format($importeTotal, 2, ',', '.') }} ARS</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Formulario --}}
            <form wire:submit.prevent="confirmarReserva">
                {{-- Campos ocultos si los necesitás --}}

                <input type="hidden" name="fecha_ingreso" value="{{ $fechaEntrada }}">
                <input type="hidden" name="fecha_egreso" value="{{ $fechaSalida }}">
                <input type="hidden" name="precio_total" value="{{ $importeTotal }}">

                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit"
                        class="px-5 py-2 rounded-xl shadow font-semibold text-white bg-green-600 hover:bg-green-700 transition">
                        ✅ Confirmar Reserva
                    </button>

                    <button type="button" wire:click="$set('mostrarModal', false)"
                        class="px-5 py-2 rounded-xl shadow text-white bg-gray-500 hover:bg-gray-600 transition">
                        ❌ Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
