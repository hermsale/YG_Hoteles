<section class="relative h-screen bg-cover bg-center"
    style="background-image: url('{{ asset('img/otros/fondo-inicio.png') }}');">
    <div class="absolute inset-0 bg-black bg-opacity-40"></div>
    <div class="relative z-10 flex justify-center items-center h-full">
        <div class="bg-white text-black p-6 rounded shadow-lg w-80">
            <h2 class="text-lg font-semibold mb-4">Reserva Online</h2>
            @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                <ul class="text-sm">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form method="GET" action="{{ route('habitaciones.disponibilidad') }}" id="formulario-filtro">
                <label class="block text-sm">Fecha de entrada</label>
                <input type="date" name="fecha_entrada" class="w-full border rounded p-1 mb-3" value="{{ request('fecha_entrada') ?? '2025-04-03' }}">

                <label class="block text-sm">Fecha de salida</label>
                <input type="date" name="fecha_salida" class="w-full border rounded p-1 mb-3" value="{{ request('fecha_salida') ?? '2025-04-04' }}">

                <label class="block text-sm">Huéspedes</label>
                <select name="huespedes" class="w-full border rounded p-1">
                    <option value="1" {{ request('huespedes') == 1 ? 'selected' : '' }}>1 Adultos</option>
                    <option value="2" {{ request('huespedes') == 2 ? 'selected' : '' }}>2 Adultos</option>
                    <option value="3" {{ request('huespedes') == 3 ? 'selected' : '' }}>3 Adultos</option>
                    <option value="4" {{ request('huespedes') == 4 ? 'selected' : '' }}>4 Adultos</option>
                </select>

                <button type="submit" class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">
                    Buscar
                </button>
            </form>
        </div>
    </div>
</section>
