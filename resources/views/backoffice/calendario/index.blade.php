<x-app-layout>
    {{-- Contenedor principal con padding superior para no ser tapado por el navbar --}}
    <div class="pt-28 px-4 md:px-6">

        {{-- 🔲 Sección superior con controles: menú, buscador, botones de acción --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">

            {{-- 🟫 Grupo izquierdo: Menú hamburguesa + buscador centrado --}}
            <div class="flex items-center justify-between w-full gap-3">
                
                {{-- Menú hamburguesa fijo a la izquierda --}}
                <div class="shrink-0">
                    <button class="text-gray-700 hover:text-gray-900 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 md:h-8 md:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                {{-- Buscador centrado horizontalmente usando mx-auto --}}
                <div class="mx-auto">
                    <input type="text" placeholder="Buscar reservas"
                        class="border rounded px-3 py-1 text-sm w-64 shadow-sm focus:ring focus:ring-blue-200">
                </div>
            </div>


            {{-- 🟢 Grupo derecho: botón HOY y selector de orden --}}
            <div class="flex items-center gap-2">
                {{-- Botón HOY con icono + --}}
                <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-full flex items-center gap-1 shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4" />
                    </svg>
                    HOY
                </button>

                {{-- Selector de orden (por nombre, tipo, etc.) --}}
                <select class="border text-sm rounded px-2 py-1 shadow-sm">
                    <option>Por nombre</option>
                    <option>Por tipo</option>
                </select>
            </div>
        </div>

        {{-- 🗓️ Tabla del calendario con scroll horizontal --}}
        <div class="overflow-x-auto">
            <table class="table-auto min-w-[1500px] w-full text-sm text-center border-collapse bg-white shadow rounded-lg">

                {{-- 🔝 Encabezado del mes completo --}}
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        {{-- Celda fija para habitaciones --}}
                        <th class="sticky left-0 bg-gray-200 z-10 w-36 border border-gray-300">Habitación</th>

                        {{-- Encabezado con nombre del mes, abarcando todas las fechas visibles --}}
                        <th colspan="15" class="text-lg font-semibold border border-gray-300 py-2">
                            JUNIO 2025
                        </th>
                    </tr>

                    {{-- 🗓️ Encabezado de días con % de ocupación --}}
                    <tr>
                        <th class="sticky left-0 bg-gray-100 z-10 w-36 border border-gray-300"></th>
                        @for ($i = 1; $i <= 15; $i++)
                            <th class="w-36 border border-gray-300 py-1">
                                <div class="font-medium">Martes {{ $i }}</div>
                                <div class="text-xs text-gray-500">80% ocupación</div>
                            </th>
                        @endfor
                    </tr>
                </thead>

                {{-- 🔢 Cuerpo del calendario: habitaciones × días --}}
                <tbody>
                    @for ($h = 1; $h <= 5; $h++)
                        <tr class="border-t border-gray-200">

                            {{-- Celda fija con nombre de habitación --}}
                            <td class="sticky left-0 bg-white z-10 border border-gray-200 text-left px-2 font-medium text-gray-800">
                                Habitación {{ $h }}
                            </td>

                            {{-- Celdas por día: precio, disponibilidad y ficha de reserva --}}
                            @for ($d = 1; $d <= 15; $d++)
                                <td class="relative border border-gray-200 p-1 h-24 group">

                                    {{-- 💲 Precio y disponibilidad (simulado) --}}
                                    <div class="text-[10px] text-gray-500 text-center">
                                        $15.000<br>
                                        <span class="font-bold">1</span> libre
                                    </div>

                                    {{-- 🧾 Fichas de reservas simuladas en algunas celdas --}}
                                    @if ($h == 2 && $d == 3)
                                        <div class="bg-green-500 text-white text-xs px-2 py-1 mt-2 rounded shadow cursor-pointer">
                                            nombre, apellido
                                        </div>
                                    @elseif ($h == 1 && in_array($d, [7,8,9]))
                                        <div class="bg-sky-400 text-white text-xs px-2 py-1 mt-2 rounded shadow cursor-pointer">
                                            nombre, apellido
                                        </div>
                                    @endif

                                    {{-- 🧠 Tooltip que se mostrará al pasar el mouse (simulado, futuro JS/Livewire) --}}
                                    <div class="hidden group-hover:block absolute top-full left-0 z-50 bg-white text-xs p-2 shadow rounded border mt-1 w-64">
                                        <p><strong>nombre completo</strong> - status (in house)</p>
                                        <p class="mt-1 text-gray-700">Check-in / out: 01/06 - 04/06</p>
                                        <p class="text-gray-700">Huéspedes: 2</p>
                                        <p class="text-gray-700">Saldo pendiente: $0.00</p>
                                        <hr class="my-1">
                                        <a href="#" class="text-blue-600 hover:underline">Detalles de la reserva</a><br>
                                        <a href="#" class="text-indigo-600 hover:underline">Check-out</a>
                                    </div>
                                </td>
                            @endfor
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
