<x-app-layout>
    <section class="bg-gray-900 text-white pt-32 pb-16">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow p-6 text-black">
            <h2 class="text-2xl font-bold mb-6">Crear Nueva Habitación</h2>

            <form action="{{ route('backoffice.habitaciones.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nombre --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}"
                        class="w-full border rounded px-3 py-2" required>
                </div>

                {{-- Descripción --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Descripción</label>
                    <textarea name="descripcion" rows="3" class="w-full border rounded px-3 py-2" required>{{ old('descripcion') }}</textarea>
                </div>

                {{-- Categoría --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Categoría</label>
                    <select name="id_categoria" class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Seleccionar --</option>
                        @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ old('id_categoria') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Capacidad --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Capacidad</label>
                    <input type="number" name="capacidad" value="{{ old('capacidad') }}"
                        class="w-full border rounded px-3 py-2" required min="1">
                </div>

                {{-- Código de habitación --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Código de habitación</label>
                    <input type="text" name="codigo_habitacion" value="{{ old('codigo_habitacion') }}"
                        class="w-full border rounded px-3 py-2" required>
                </div>

                {{-- Precio por noche --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Precio por noche (ARS)</label>
                    <input type="number" step="0.01" name="precio_noche" value="{{ old('precio_noche') }}"
                        class="w-full border rounded px-3 py-2" required>
                </div>

                {{-- Amenities --}}
                <div class="mb-6">
                    <label class="block font-semibold mb-2">Servicios incluidos</label>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($amenities as $amenity)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}"
                                {{ in_array($amenity->id, old('amenities', [])) ? 'checked' : '' }}>
                            <span>{{ $amenity->nombre }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Imágenes --}}
                <div class="mb-6">
                    <label class="block font-semibold mb-1">Agregar imágenes</label>
                    <input type="file" name="imagenes[]" multiple class="w-full border rounded px-3 py-2">
                </div>

                {{-- Botones --}}
                <div class="flex justify-between mt-6">
                    <a href="{{ route('backoffice.habitaciones.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">⬅️ Cancelar</a>

                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">➕ Crear Habitación</button>
                </div>
            </form>
        </div>
    </section>
</x-app-layout>
