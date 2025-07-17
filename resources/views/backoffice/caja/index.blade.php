<x-app-layout>
    <section class="relative min-h-screen bg-gray-50">
        <div class="py-16 px-6 max-w-6xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg p-6">

            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <meta name="csrf-token" content="{{ csrf_token() }}">

                <title>YG Hoteles</title>
                @vite('resources/css/app.css')
            </head>

                {{-- 🔷 Título y pestañas --}}
                <div class="flex justify-start space-x-4 mb-2">
                    <button id="btn-caja" class="tab-caja bg-gray-100 text-blue-600 font-bold border-b-2 border-blue-600 px-4 py-1 rounded-t">Caja</button>
                    <button id="btn-cierres" class="tab-cierres bg-gray-100 text-gray-500 hover:text-blue-500 px-4 py-1 rounded-t">Cierres</button>

                </div>

                {{-- 📅 Fecha centrada --}}
                <div class="w-full text-center mt-4 mb-4">
                    <label for="fecha-cierre" class="block text-gray-700 text-sm mb-1 font-medium">📅 Fecha del cierre:</label>
                    <input type="date" id="fecha-cierre" name="fecha"
                        class="border border-gray-300 rounded-md px-4 py-2 text-center text-gray-800 font-semibold"
                        value="{{ \Carbon\Carbon::now()->toDateString() }}">
                </div>



                {{-- 🔹 Caja del día --}}
                <div id="caja-dia">
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-300 text-sm text-gray-800">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-3 py-2 border">Concepto</th>
                                    <th class="px-3 py-2 border">Cliente</th>
                                    <th class="px-3 py-2 border">Monto</th>
                                    <th class="px-3 py-2 border">Método de Pago</th>
                                    <th class="px-3 py-2 border">Comentario</th>
                                    <th class="px-3 py-2 border">Usuario</th>
                                    <th class="px-3 py-2 border text-center">Quitar</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-transacciones">

                    </tbody>

                        </table>
                        {{--  Botón para agregar nuevas filas --}}
                        <div class="text-center mt-3">
                            <button id="btn-agregar-fila" class="text-blue-600 hover:underline text-sm">
                                ➕ Agregar fila
                            </button>
                        </div>

                           <div class="hidden">
                                <div class="ring-2 ring-red-500 ring-offset-1 rounded-md bg-red-50"></div>
                            </div>

                    </div>

                    {{-- 🔘 Botón para cerrar caja --}}
                    <div class="flex justify-center mt-6">
                        <button id="btn-cierre" class="bg-blue-600 text-white px-6 py-2 rounded-xl hover:bg-blue-700">Hacer el cierre</button>
                        <p id="mensaje-error-validacion" class="text-sm text-red-600 mt-2 text-center hidden">
                            ⚠️ Revisá los campos en rojo: son obligatorios para cerrar la caja.
                        </p>

                    </div>
                    {{-- 📊 Total acumulado --}}
                    <div class="text-center mt-4">
                        <span class="font-semibold text-gray-700 text-xl">
                            Total acumulado del día: $
                            <span id="total-dia" class="text-green-600">0.00</span>
                        </span>
                    </div>
                </div>

                {{-- 🔒 Cierres (vacío por ahora) --}}
                {{-- 📋 Tabla de cierres --}}
                    <div id="caja-cierres" class="hidden">
                        <table class="w-full text-sm border-collapse border border-gray-300 shadow" id="tabla-cierres">
                            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                                <tr>
                                    <th class="px-4 py-2 border">Fecha</th>
                                    <th class="px-4 py-2 border">Total</th>
                                    <th class="px-4 py-2 border">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-cierres">
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-gray-500">Cargando cierres...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </section>
   
    <span id="usuario-logueado"
      data-nombre="{{ Auth::user()->name }}"
      data-id="{{ Auth::id() }}"
      class="hidden"></span>
    @vite('resources/js/caja.js')
<!-- 🧾 Modal de Detalle de Cierre -->
<div id="modal-detalle-cierre" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white w-full max-w-3xl rounded-lg shadow-lg p-6 relative">
        <button id="btn-cerrar-modal" class="absolute top-2 right-3 text-gray-600 hover:text-red-500">✖</button>

        <h2 class="text-xl font-bold text-gray-800 mb-4">🧾 Detalle del Cierre</h2>
        <div id="contenido-detalle">
            <p class="text-sm text-gray-600 mb-2">Cargando transacciones...</p>
        </div>
    </div>
</div>

</x-app-layout>
