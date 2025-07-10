<x-app-layout>
    <section class="bg-gray-900 text-white pt-32 pb-16">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow p-6 text-black">
            <h2 class="text-2xl font-bold mb-6">Editar Habitación</h2>
            <form action="{{ route('backoffice.habitaciones.update', $habitacion) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Nombre --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $habitacion->nombre) }}"
                        class="w-full border rounded px-3 py-2">
                </div>

                {{-- Descripción --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Descripción</label>
                    <textarea name="descripcion" rows="3" class="w-full border rounded px-3 py-2">{{ old('descripcion', $habitacion->descripcion) }}</textarea>
                </div>

                {{-- Categoría --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Categoría</label>
                    <select name="categoria_id" class="w-full border rounded px-3 py-2">
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}"
                                {{ $habitacion->categoria_id == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Capacidad --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Capacidad</label>
                    <input type="number" name="capacidad" value="{{ old('capacidad', $habitacion->capacidad) }}"
                        class="w-full border rounded px-3 py-2">
                </div>

                {{-- Precio por noche --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Precio por noche (ARS)</label>
                    <input type="number" step="0.01" name="precio_noche" value="{{ old('precio_noche', $habitacion->precio_noche) }}"
                        class="w-full border rounded px-3 py-2">
                </div>

                {{-- Amenities --}}
                <div class="mb-6">
                    <label class="block font-semibold mb-2">Servicios incluidos</label>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($amenities as $amenity)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}"
                                    {{ $habitacion->amenities->contains($amenity->id) ? 'checked' : '' }}>
                                <span>{{ $amenity->nombre }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Imágenes --}}
                <div class="mb-6">
                    <label class="block font-semibold mb-1">Imágenes actuales</label>
                    <div class="flex flex-wrap gap-2 mb-2">
                        @foreach($habitacion->imagenes as $imagen)
                            <div class="relative w-32 h-20">
                                <img src="{{ asset($imagen->url) }}" class="w-full h-full object-cover rounded">
                                {{-- Opcional: botón para eliminar imagen --}}
                            </div>
                        @endforeach
                    </div>
                    <label class="block font-semibold mb-1">Agregar nuevas imágenes</label>
                    <input type="file" name="imagenes[]" multiple class="w-full border rounded px-3 py-2">
                </div>

                {{-- Botones --}}
                <div class="flex justify-between mt-6">
                    <a href="{{ route('backoffice.habitaciones.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Cancelar</a>

                    <div class="flex gap-3">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">💾 Guardar</button>

                        </div>
                    </div>
                </form>
                <form action="{{ route('habitaciones.index', $habitacion->id) }}" method="POST"
                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta habitación?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">🗑️ Eliminar</button>
                </form>
        </div>
    </section>
</x-app-layout>
