<x-app-layout>
    <section class="relative min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('img/otros/fondo-inicio.png') }}');">
        <div class="py-24 bg-black bg-opacity-50">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-2xl shadow-xl p-8">

                    {{-- Encabezado --}}
                    <h2 class="text-xl font-bold mb-4 text-gray-800">
                        Detalle de tu reserva
                        @if(auth()->check() && in_array(auth()->user()->rol->nombre_rol, ['Administrador', 'Recepcionista']))
                        <span class="text-sm font-normal text-gray-600 ml-4">
                            Cliente: {{ $reserva->usuario->name ?? 'N/A' }}
                        </span>
                        @endif
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
                                    <span class="text-gray-500 italic">🌙 Cantidad de Noches</span>
                                    <p class="font-medium">{{ $cantidadNoches ?? 'No especificado' }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500 italic">💰 Total</span>
                                    <p class="font-medium">${{ number_format($reserva->precio_final, 2, ',', '.') }} ARS</p>
                                </div>
                                @if ($reserva->promocion)
                                @php
                                $precioOriginal = $reserva->precio_final / (1 - $reserva->promocion->descuento_porcentaje / 100);
                                @endphp
                                <div class="col-span-2 bg-blue-50 text-blue-800 p-3 rounded-lg shadow mt-2">
                                    <p><strong>💸 Precio sin descuento:</strong> ${{ number_format($precioOriginal, 2, ',', '.') }} ARS</p>
                                    <p><strong>🎁 Promoción aplicada:</strong> {{ $reserva->promocion->nombre }} ({{ $reserva->promocion->descuento_porcentaje }}%)</p>
                                    <p><strong>✅ Total a pagar con descuento:</strong> ${{ number_format($reserva->precio_final, 2, ',', '.') }} ARS</p>
                                </div>
                                @else
                                <div class="col-span-2 text-gray-600 mt-2">
                                    <p><strong>💳 Total a pagar:</strong> ${{ number_format($reserva->precio_final, 2, ',', '.') }} ARS</p>
                                </div>
                                @endif
                                <div>
                                    <span class="text-gray-500 italic">📌 Estado de Reserva</span>
                                    <p class="font-semibold
                                     @if($reserva->estado_reserva === 'Activa') text-green-600
                                    @elseif($reserva->estado_reserva === 'Pendiente') text-yellow-600
                                    @elseif($reserva->estado_reserva === 'Finalizada') text-blue-600
                                     @else text-red-600 @endif">
                                        {{ $reserva->estado_reserva }}
                                    </p>
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
                                                bg-gray-400 cursor-default
                                            @endif"
                                        {{ $reserva->estado_pago === 'Cancelado' ? 'bg-gray-400  cursor-default'  : '' }}
                                        {{ $reserva->aviso_pago ? 'disabled' : '' }}>
                                        Aviso de Pago
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('reservas.cancelarReserva', $reserva->id) }}">
                                    @csrf
                                    <button
                                        class="px-5 py-2 rounded-xl text-white font-semibold
                                            {{ $reserva->estado_reserva === 'Cancelada' ? 'bg-gray-400  cursor-default'  : 'bg-red-600 hover:bg-red-700' }}"
                                        {{ $reserva->estado_reserva === 'Cancelada' ? 'disabled' : '' }}>
                                        Cancelar Reserva
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        {{-- Modificar Fechas de Reserva --}}
        @if(auth()->check() && in_array(auth()->user()->rol->nombre_rol, ['Administrador', 'Recepcionista']))
        <div class="max-w-5xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    ✏️ Modificar Fechas de la Reserva
                </h3>

                @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('reservas.actualizarFechas', $reserva->id) }}"
                    class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">📅 Nueva Fecha Ingreso</label>
                        <input type="date" name="fecha_ingreso"
                            value="{{ \Carbon\Carbon::parse($reserva->fecha_ingreso)->format('Y-m-d') }}"
                            class="w-full border-gray-300 text-black rounded px-3 py-2 shadow-sm text-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">📅 Nueva Fecha Egreso</label>
                        <input type="date" name="fecha_egreso"
                            value="{{ \Carbon\Carbon::parse($reserva->fecha_egreso)->format('Y-m-d') }}"
                            class="w-full border-gray-300 text-black rounded px-3 py-2 shadow-sm text-sm" required>
                    </div>

                    <div class="col-span-2 flex justify-center">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 mt-3 rounded shadow-sm font-medium">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif


        {{-- Modificar Total a Pagar --}}
        @if(auth()->check() && in_array(auth()->user()->rol->nombre_rol, ['Administrador', 'Recepcionista']))
        <div class="max-w-5xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    💰 Modificar Total a Pagar
                </h3>

                @if(session('success_total'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
                    {{ session('success_total') }}
                </div>
                @endif

                <form method="POST" action="{{ route('reservas.actualizarTotal', $reserva->id) }}" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @csrf
                    @method('PUT')

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-600 mb-1">💵 Nuevo Total (ARS)</label>
                        <input type="number" name="precio_final" min="0" step="0.01"
                            value="{{ $reserva->precio_final }}"
                            class="w-full border-gray-300 rounded px-3 py-2 shadow-sm text-sm text-gray-800" required>
                    </div>

                    <div class="col-span-2 flex justify-center">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 mt-3 rounded shadow-sm font-medium">
                            Guardar Total
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        {{-- Cambiar Estado de Reserva --}}
        @if(auth()->check() && in_array(auth()->user()->rol->nombre_rol, ['Administrador', 'Recepcionista']))
                <div class="max-w-5xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            📌 Cambiar Estado de la Reserva
                        </h3>

                        @if(session('success_estado'))
                            <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
                                {{ session('success_estado') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('reservas.actualizarEstado', $reserva->id) }}"
                            class="grid grid-cols-1 gap-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Nuevo Estado</label>
                                <select name="estado_reserva"
                                        class="w-full border-gray-300 rounded px-3 py-2 shadow-sm text-sm text-gray-800"
                                        required>
                                    @foreach (['Activa', 'Finalizada', 'Cancelada', 'Pendiente'] as $estado)
                                        <option value="{{ $estado }}" @if($reserva->estado_reserva === $estado) selected @endif>
                                            {{ $estado }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex justify-center">
                                <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 mt-3 rounded shadow-sm font-medium">
                                    Guardar Estado
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

        {{-- Cambiar Estado de Pago --}}
        @if(auth()->check() && in_array(auth()->user()->rol->nombre_rol, ['Administrador', 'Recepcionista']))
        <div class="max-w-5xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    💳 Cambiar Estado de Pago
                </h3>

                @if(session('success_pago'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
                    {{ session('success_pago') }}
                </div>
                @endif

                <form method="POST" action="{{ route('reservas.actualizarPago', $reserva->id) }}"
                    class="grid grid-cols-1 gap-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Nuevo Estado de Pago</label>
                        <select name="estado_pago"
                            class="w-full border-gray-300 rounded px-3 py-2 shadow-sm text-sm text-gray-800"
                            required>
                            @foreach (['Pendiente', 'Pagado', 'Cancelado'] as $estado)
                            <option value="{{ $estado }}" @if($reserva->estado_pago === $estado) selected @endif>
                                {{ $estado }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-center">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 mt-3 rounded shadow-sm font-medium">
                            Guardar Estado de Pago
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif
        {{-- Eliminar Reserva --}}
        @if(auth()->check() && in_array(auth()->user()->rol->nombre_rol, ['Administrador', 'Recepcionista']))
        <div class="max-w-5xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-red-700 mb-4 flex items-center gap-2">
                    🗑 Eliminar Reserva
                </h3>

                @if(session('success_eliminar'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
                    {{ session('success_eliminar') }}
                </div>
                @endif

                @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
                @endif
                <form method="POST" action="{{ route('reservas.eliminar', $reserva->id) }}"
                    onsubmit="return confirm('¿Estás seguro de que querés eliminar esta reserva?');">
                    @csrf
                    @method('DELETE')

                    <div class="flex justify-center">
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 mt-3 rounded shadow-sm font-medium">
                            Eliminar Reserva
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </section>

</x-app-layout>
