
<x-app-layout>
    <!-- formulario de reserva -->
            <!-- <x-formulario-reserva /> -->

 <!-- cito el componente de navbar -->

 <!-- Sección de reseñas -->
 <section class="bg-gray-900 text-white py-24">
    <div class="bg-gray-900 text-white py-5 my-9">
        <x-navbar />
    </div>
    <div class="max-w-xl mx-auto bg-gray-200 text-black rounded shadow-lg p-6">
        <h2 class="text-2xl font-semibold text-center mb-6">Reseña</h2>

        <form action="#" method="POST">
            @csrf

            {{-- Nombre y correo --}}
            <div class="flex flex-col sm:flex-row gap-4 mb-4">
                <div class="w-full">
                    <label class="font-semibold block mb-1">Nombre</label>
                    <input type="text" name="nombre" class="w-full border border-gray-400 rounded px-3 py-2" placeholder="Nombre">
                </div>
                <div class="w-full">
                    <label class="font-semibold block mb-1">Correo Electrónico</label>
                    <input type="email" name="correo" class="w-full border border-gray-400 rounded px-3 py-2" placeholder="Correo">
                </div>
            </div>

            {{-- Mes y Año --}}
            <div class="flex flex-col sm:flex-row gap-4 mb-4">
                <div class="w-full">
                    <label class="font-semibold block mb-1">Mes</label>
                    <select name="mes" class="w-full border border-gray-400 rounded px-3 py-2">
                        @foreach(['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] as $mes)
                            <option value="{{ $mes }}">{{ $mes }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full">
                    <label class="font-semibold block mb-1">Año</label>
                    <select name="anio" class="w-full border border-gray-400 rounded px-3 py-2">
                        @for($i = now()->year; $i >= now()->year - 10; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            {{-- Puntuación --}}
            <div class="mb-4">
                <label class="font-semibold block mb-2">Puntuación</label>
                <div class="grid grid-cols-10 gap-1">
                    @for($i = 1; $i <= 10; $i++)
                        <label class="flex flex-col items-center text-xs font-bold" style="color: white;">
                            <div class="w-full h-6" style="background-color: hsl({{ (10 - $i) * 12 }}, 80%, 50%);">{{ $i }}</div>
                            <input type="radio" name="puntuacion" value="{{ $i }}" class="mt-1">
                        </label>
                    @endfor
                </div>
            </div>

            {{-- Comentario --}}
            <div class="mb-6">
                <label class="font-semibold block mb-1">Comentario</label>
                <textarea name="comentario" rows="4" class="w-full border border-gray-400 rounded px-3 py-2"></textarea>
            </div>

            {{-- Enviar --}}
            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded font-semibold">
                Enviar
            </button>
        </form>
    </div>
</section>

</x-app-layout>
