<x-app-layout>
    <!-- el x-slot es el componente -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($titulo) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full bg-white rounded-lg shadow-md overflow-hidden">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold">ID</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Título</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Descripción</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cursos as $curso)
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="px-6 py-4">{{ $curso->id }}</td>
                                    <td class="px-6 py-4">{{ $curso->titulo }}</td>

                                    <!-- Desplegable para cambiar la descripción -->
                                    <td class="px-6 py-4">
                    <!-- HTML no permite métodos PUT, PATCH ni DELETE en los formularios. Solo permite GET y POST. por eso el method PUT oculto -->
                                        <form action="{{ route('cursos.updateDescripcion', $curso->id) }}" method="POST">
                                        <!-- El token CSRF -->
                                            @csrf
                    <!-- el metodo que queremos usar es PUT para actualizar la bd. Laravel lo camufla y lo inserta en un campo value="PUT" -->
                                            @method('PUT')
                    <!-- Entonces el backend de Laravel interpreta correctamente que aunque venga como POST, lo trata como un PUT. -->
                    <!-- se envia un formulario al hacer un cambio en el select (por eso el onchange) -->
                    <!--  El nuevo valor lo envía el select, a través de su atributo name="descripcion" y el valor lo asigna  el value=$opcion" -->
                                            <select name="descripcion" onchange="this.form.submit()" class="border-gray-300 rounded shadow-sm">
                                            <!-- opcionesDescripcion es un array enviado desde el controlado -->
                                                @foreach ($opcionesDescripcion as $opcion)
                                                    <option value="{{ $opcion }}" {{ $curso->descripcion === $opcion ? 'selected' : '' }}>
                                                        {{ $opcion }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>

                                    <td class="px-6 py-4">${{ number_format($curso->precio, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">No hay cursos disponibles.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
