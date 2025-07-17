<x-app-layout>

    {{-- ✅ Meta CSRF ya debe estar incluido en app-layout, pero por las dudas lo ponemos igual aca --}}
    @push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="offset-base" content="{{ $fechas->keys()->first() }}">
    <meta name="fecha-min-calendario" content="{{ \Carbon\Carbon::parse($rango->fecha_inicio)->format('Y-m-d') }}">
    <meta name="fecha-max-calendario" content="{{ \Carbon\Carbon::parse($rango->fecha_fin)->format('Y-m-d') }}">
    @endpush

    <div class="pt-28 px-4 md:px-6">
        <div class="calendario-container">


            {{-- 🔍 Fecha manual --}}
            @php
            $rol = Auth::check() ? Auth::user()->rol->nombre_rol : null;
            @endphp

            @if ($rol === 'Administrador' || $rol === 'Recepcionista')
            <div class="mb-4 flex items-center gap-3">
                <input type="date" id="inputFechaIr"
                    class="border px-3 py-1 rounded shadow-sm w-40"
                    value="{{ $fechaBase->format('Y-m-d') }}">

                <button type="button"
                    id="btnIrFecha"
                    class="bg-blue-500 text-white px-3 py-1 rounded">
                    Ir a fecha
                </button>

                {{--
            @if ($rol === 'Administrador')
                <button type="button"
                        onclick="mostrarFormularioCalendario()"
                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">
                    Establecer calendario
                </button>
            @endif
            --}}


            </div>
            @endif


            {{-- 🔝 Nombre del mes visible siempre (actualizado por JS) --}}
            <div id="mes-actual"
                class="text-lg font-bold uppercase text-center text-gray-800 mb-3">
                {{ mb_strtoupper($fechaBase->translatedFormat('F Y'), 'UTF-8') }}
            </div>

            {{-- 📅 Tabla del calendario --}}
            <div class="overflow-x-auto relative calendario-scroll">
                <table class="min-w-[1500px] table-auto border-collapse bg-white" id="tabla-calendario">
                    <thead>
                        {{-- Fila de días --}}
                        <tr>
                            <th id="th-habitacion" class="sticky left-0 z-10 bg-gray-100 border border-gray-300 text-left px-2">
                                Habitación
                            </th>
                            @foreach ($fechas as $fecha)
                            <th
                                class="fecha-col text-center align-top border border-gray-300 px-2 py-1 min-w-[9.5rem]"
                                data-fecha="{{ $fecha->toDateString() }}">
                                <div class="flex flex-row justify-center gap-1 text-[13px] font-semibold uppercase">
                                    <span>{{ $fecha->translatedFormat('l') }}</span>
                                    <span>{{ $fecha->translatedFormat('d') }}</span>
                                </div>
                            </th>
                            @endforeach
                        </tr>
                        {{-- Fila de ocupación --}}
                        <tr>
                            <th class="sticky left-0 bg-gray-50 text-gray-500 text-sm border border-gray-300 px-2">
                                <span class="text-[12px]">Porcentaje de ocupación</span>
                            </th>
                            @foreach ($fechas as $fecha)
                            <td class="text-gray-400 text-xs py-1 border border-gray-100">
                                {{ $ocupaciones[$fecha->toDateString()] ?? 0 }}%
                            </td>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($habitaciones as $habitacion)
                        <tr class="h-20 border-t fila-habitacion" data-habitacion-id="{{ $habitacion->id }}">

                            {{-- Nombre de habitación --}}
                            <td class="sticky left-0 bg-white border border-gray-300 text-left px-2 font-semibold">
                                {{ $habitacion->nombre }}
                            </td>

                            {{-- Celdas por fecha --}}
                            @foreach ($fechas as $fecha)
                            @php
                            $ocupada = $habitacion->reservas()
                            ->whereDate('fecha_ingreso', '<=', $fecha)
                                ->whereDate('fecha_egreso', '>', $fecha)
                                ->exists();
                                $precio = $habitacion->precio_noche ?? 100;
                                @endphp
                                <td class="relative border border-gray-200 text-[11px] text-center p-1 bg-white">
                                    ${{ number_format($precio, 0, ',', '.') }}<br>
                                    <span class="font-bold">{{ $ocupada ? 0 : 1 }}</span>
                                    <div class="overlay-reserva absolute inset-0"></div>
                                </td>
                                @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>


                {{-- 🔷 CAPA DE PASTILLAS DE RESERVAS --}}
                <div id="layer-pills-reservas" class="absolute top-0 left-0 w-full h-full z-20">

                    @foreach ($habitaciones as $habitacionIndex => $habitacion)
                    @foreach ($reservas[$habitacion->id] ?? [] as $reserva)

                    @php
                    $inicio = \Carbon\Carbon::parse($reserva->fecha_ingreso)->toDateString();
                    $fin = \Carbon\Carbon::parse($reserva->fecha_egreso)->toDateString();
                    $estado = $reserva->estado_reserva;
                    $pagada = $reserva->estado_pago === 'Pagado';
                    $usuario = $reserva->usuario->name ?? 'Cliente';

                    $colInicio = $fechas->search(fn($fecha) => $fecha->toDateString() === $inicio);
                    $colFin = $fechas->search(fn($fecha) => $fecha->toDateString() === $fin);

                    // Si la fecha de egreso no está en el array, asumimos que termina en el último día del calendario
                    if ($colFin === false) {
                    $colFin = $fechas->count(); // una columna más allá del final
                    }

                    if ($colInicio !== false && $colFin > $colInicio) {
                    $colSpan = $colFin - $colInicio;
                    // Renderizamos la pill normalmente
                    }
                    @endphp

                    @if ($colInicio !== false && $colFin !== false)
                    <div
                        class="pill-reserva"
                        data-id="{{ $reserva->id }}"
                        data-start="{{ $colInicio }}"
                        data-span="{{ $colSpan }}"
                        data-habitacion-id="{{ $habitacion->id }}"
                        data-color="{{ $estado }}"
                        data-pagada="{{ $pagada ? '1' : '0' }}"
                        data-usuario="{{ $usuario }}">
                        {{ $usuario }}
                        @unless($pagada)
                        <span class="dot-pago-pendiente"></span>
                        @endunless
                    </div>
                    @endif

                    @endforeach
                    @endforeach

                </div>
            </div>

        </div>
    </div>
    </div>

    {{-- 📆 MODAL DE RANGO DE CALENDARIO (invisible por defecto) --}}
    <div id="modalCalendario" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div class="bg-white text-gray-800 p-6 rounded shadow-lg max-w-md w-full relative">
            <h2 class="text-lg font-semibold mb-4">📅 Establecer rango de calendario</h2>

            <form id="formularioCalendario" method="POST" action="{{ route('calendario.actualizar-rango') }}">
                @csrf
                @if(session('error'))
                <div id="alerta-error-calendario" class="bg-red-100 border border-red-400 text-red-800 px-4 py-2 rounded mb-4 text-sm shadow">
                    ⚠️ {{ session('error') }}
                </div>
                @endif

                <label class="block mb-2 font-medium">Fecha desde:</label>
                <input type="date" name="fecha_inicio" class="border px-3 py-2 rounded w-full mb-4" required>

                <label class="block mb-2 font-medium">Fecha hasta:</label>
                <input type="date" name="fecha_fin" class="border px-3 py-2 rounded w-full mb-4" required>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" onclick="cerrarFormularioCalendario()"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
    @if (session('error'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            if (typeof mostrarFormularioCalendario === 'function') {
                mostrarFormularioCalendario();
            }
        });
    </script>
    @endif
    {{-- MENU CONTEXTUAL DE LAS PILLS --}}
    <div id="menu-contextual-reserva"
        class="hidden absolute bg-white border rounded shadow-lg text-sm z-50 w-48"
        style="display: none">
        <ul>
            <li><a href="#" class="px-4 py-2 block text-black hover:bg-gray-100" id="btn-detalle">Ver Detalles</a></li>
            <li><button class="w-full text-left px-4 py-2 text-black hover:bg-gray-100" id="btn-checkin">Hacer Check-in</button></li>
            <li><button class="w-full text-left px-4 py-2 text-black hover:bg-gray-100" id="btn-checkout">Hacer Check-out</button></li>
            <li><button class="w-full text-left px-4 py-2 text-black text-red-600 hover:bg-red-100" id="btn-cancelar">Cancelar</button></li>
            <li><button class="w-full text-left px-4 py-2 text-black hover:bg-gray-100" id="btn-dejar-pendiente">Dejar Pendiente</button></li>
        </ul>
    </div>
</x-app-layout>
