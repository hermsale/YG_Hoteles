<section class="relative h-screen bg-cover bg-center"
    style="background-image: url('{{ asset('img/otros/fondo-inicio.png') }}');">
    <div class="absolute inset-0 bg-black bg-opacity-40"></div>
    <div class="relative z-10 flex justify-center items-center h-full">
        <div class="bg-white text-black p-6 rounded shadow-lg w-80">
            <h2 class="text-lg font-semibold mb-4">Reserva Online</h2>
            <form>
                <label class="block text-sm">Fecha de entrada</label>
                <input type="date" class="w-full border rounded p-1 mb-3" value="2025-04-03">

                <label class="block text-sm">Fecha de salida</label>
                <input type="date" class="w-full border rounded p-1 mb-3" value="2025-04-04">

                <label class="block text-sm">Huéspedes</label>
                <select class="w-full border rounded p-1">
                    <option>2 Adultos</option>
                    <option>3 Adultos</option>
                    <option>4 Adultos</option>
                </select>

                <button type="submit" class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">
                    Buscar
                </button>
            </form>
        </div>
    </div>
</section>
