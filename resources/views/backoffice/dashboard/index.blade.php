{{-- Este componente Blade usa el layout base que incluye navbar, estilos y estructura general --}}
<x-app-layout>

    {{-- Contenedor principal del dashboard con padding superior para evitar que lo tape el navbar --}}
    <div class="pt-28 px-4 md:px-6 relative">

        {{-- 🔻 CABECERA DEL DASHBOARD --}}
        <div class="flex  items-center justify-between mb-4">

            {{-- 📝 TÍTULO DEL DASHBOARD --}}
            <h2 class="text-xl text-center font-semibold text-gray-800 mt-4">
                {{ $fechaHoraActualizada }}
            </h2>
            <h2 class="text-xl text-center font-semibold text-gray-800 mt-4">
                DASHBOARD
            </h2>

            {{-- 🔳 GRUPO DE BOTONES A LA DERECHA (calendario + nueva reserva) --}}
            <div class="flex items-center gap-3">

                {{-- 📅 ÍCONO DE CALENDARIO (enlace a la vista /calendario) --}}
                <a href="{{ route('calendario.index') }}" class="text-blue-600 hover:text-blue-800 transition-all duration-200 text-4xl">
                    📅
                </a>

                {{-- ✅ BOTÓN "CREAR NUEVA RESERVA" --}}
                <a href="{{route('backoffice.reservas.crear')}} " class="bg-green-400 hover:bg-green-500 text-white font-semibold px-4 py-2 rounded-lg shadow">
                    Crear Nueva Reserva
                </a>
            </div>
        </div>

        {{-- 🔢 CARDS DE MÉTRICAS PRINCIPALES: LLEGADAS, SALIDAS, RESERVAS --}}
        <!-- <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center mb-6">

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

            {{-- 🔵 Habitaciones reservadas (alojadas con check-in) --}}
            <div class="bg-white rounded-xl p-4 shadow border">
                <p class="text-2xl font-bold text-blue-600">{{ $totalAlojados }}</p>
                <p class="text-sm text-gray-600">HABITACIONES RESERVADAS</p>
            </div>
        </div> -->

        {{-- 🗓️ CALENDARIO DE RESERVAS --}}


        {{-- 🔄 SECCIÓN PRINCIPAL: RESERVAS Y ACTIVIDAD DE HOY --}}
        <div class="grid gap-6">

            {{-- 📋 BLOQUE DE RESERVAS --}}
            {{-- 📋 BLOQUE DE RESERVAS CON LIVEWIRE --}}
            <div class="bg-white items-center  p-4 rounded-xl shadow border">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Reservas</h3>

                @livewire('dashboard-reservas')

            </div>


            {{-- 📊 BLOQUE DE ACTIVIDAD DEL DÍA --}}
            <!-- <div class="bg-white p-4 rounded-xl shadow border">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Actividad de Hoy</h3>

                {{-- Botones de filtro (Ventas / Cancelaciones) --}}
                <div class="flex gap-2 mb-2 text-sm">
                    <button class="px-2 py-1 bg-blue-100 text-blue-700 rounded">Ventas</button>
                    <button class="px-2 py-1 bg-gray-100 text-gray-700 rounded">Cancelaciones</button>
                </div>

                {{-- Métricas en formato de tarjetas dentro de grid --}}
                <div class="grid grid-cols-3 gap-2 text-center mb-4">
                    <div>
                        <p class="text-xl font-bold">0</p>
                        <p class="text-sm text-gray-600">Reservas de Hoy</p>
                    </div>
                    <div>
                        <p class="text-xl font-bold">0</p>
                        <p class="text-sm text-gray-600">Noches de Estadía</p>
                    </div>
                    <div>
                        <p class="text-xl font-bold text-blue-600">$0.00</p>
                        <p class="text-sm text-gray-600">Ingresos</p>
                    </div>
                </div>

                {{-- Tabla de ingresos simulada por huésped --}}
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-600 border-b">
                            <th>Huésped</th>
                            <th>Ingresos</th>
                            <th>Llegada</th>
                            <th>Noches</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-2 text-blue-600">Nombre, Apellido</td>
                            <td>$Monto</td>
                            <td>dd/mm/aa</td>
                            <td>3 Noches</td>
                        </tr>
                    </tbody>
                </table>
            </div> -->
        </div>
    </div>
</x-app-layout>
