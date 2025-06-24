<x-app-layout>

    <section class="relative h-screen bg-cover bg-center"
        style="background-image: url('{{ asset('img/otros/fondo-inicio.png') }}');">

        <div class="relative py-20 bg-white bg-opacity-90 rounded-md shadow-lg p-6 max-w-6xl mx-auto">


            <div class="relative mt-24 py-20 bg-white bg-opacity-90 rounded-md shadow-lg p-6 max-w-6xl mx-auto">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Reservas en Curso</h2>

                {{-- Tabla hardcodeada por ahora --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300 text-sm text-gray-900">
                        <thead class="bg-gray-200 text-gray-700 font-bold">
                            <tr>
                                <th class="px-4 py-2 border">Fecha de compra</th>
                                <th class="px-4 py-2 border">Estado</th>
                                <th class="px-4 py-2 border">Habitación</th>
                                <th class="px-4 py-2 border">Fecha Ingreso</th>
                                <th class="px-4 py-2 border">Fecha Egreso</th>
                                <th class="px-4 py-2 border">Importe Total</th>
                                <th class="px-4 py-2 border">Detalle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservas as $reserva)
                            <tr class="bg-white">
                                <td class="px-4 py-2 border"> {{$reserva->fecha_creacion }}</td>
                                <td class="px-4 py-2 border">{{$reserva->estado_pago }}</td>
                                <td class="px-4 py-2 border">{{$reserva->habitacion->codigo_habitacion }} - {{$reserva->habitacion->categoria->nombre }} </td>
                                <td class="px-4 py-2 border">{{$reserva->fecha_ingreso}} </td>
                                <td class="px-4 py-2 border">{{$reserva->fecha_egreso}} </td>
                                <td class="px-4 py-2 border">{{ $reserva->precio_final }}</td>
                                <td class="px-4 py-2 border text-blue-600 hover:underline cursor-pointer">
                                    <a href="{{ route('reservas.show', $reserva->id) }}" class="text-blue-600 hover:underline">
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
