<x-app-layout>
    <section class="bg-gray-200 text-black pt-32 pb-16" x-data="{ tab: 'clientes' }">
        <div class="max-w-6xl mx-auto px-4">

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold">Gestión de Usuarios</h2>
                <a href="{{ route('backoffice.usuarios.crear') }}"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                    ➕ Agregar usuario
                </a>
            </div>

            <!-- Tabs -->
            <div class="flex space-x-4 mb-8">
                <button
                    @click="tab = 'clientes'"
                    :class="tab === 'clientes'
                        ? 'bg-gray-700 text-white'
                        : 'bg-white text-gray-800 hover:bg-gray-400'"
                    class="px-4 py-2 rounded-lg font-semibold transition-colors duration-200">
                    Clientes
                </button>

                <button
                    @click="tab = 'empleados'"
                    :class="tab === 'empleados'
                        ? 'bg-gray-700 text-white'
                        : 'bg-white text-gray-800 hover:bg-gray-400'"
                    class="px-4 py-2 rounded-lg font-semibold transition-colors duration-200">
                    Empleados
                </button>

            </div>
            @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
                class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-sm text-center transition">
                <strong class="font-bold">✔️ ¡Éxito!</strong>
                <span class="ml-2">{{ session('success') }}</span>
            </div>
            @endif
            <!-- Clientes -->
            <div x-show="tab === 'clientes'" x-transition>
                @forelse ($usuarios->where('rol.nombre_rol', 'Cliente') as $usuario)
                <div class="bg-gray-100 text-black rounded-lg shadow p-6 mb-6 flex justify-between items-center">
                    <div>
                        <p class="font-bold text-lg">Nombre: {{ $usuario->name }}</p>
                        <p class="font-bold text-sm">Email: {{ $usuario->email }}</p>
                    </div>

                    <div class="flex gap-2">
                        <!-- Botón reset clave -->
                        <form action="{{ route('backoffice.usuarios.resetearClave', $usuario->id) }}" method="POST"
                            onsubmit="return confirm('¿Asignar nueva contraseña a {{ $usuario->email }}?')">
                            @csrf
                            <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded text-sm">
                                🔑 Nueva clave
                            </button>
                        </form>

                        <!-- Botón eliminar -->
                        <form action="{{ route('backoffice.usuarios.destroy', $usuario->id) }}" method="POST"
                            onsubmit="return confirm('¿Eliminar a {{ $usuario->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                🗑️ Eliminar
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-300">No hay clientes registrados aún.</p>
                @endforelse
            </div>

            <!-- Empleados -->
            <div x-show="tab === 'empleados'" x-transition>
                @forelse ($usuarios->where('rol.nombre_rol', '==', 'Recepcionista') as $usuario)
                <div class="bg-gray-100 text-black rounded-lg shadow p-6 mb-6 flex justify-between items-center">
                    <div>
                        <p class="font-bold text-lg">Nombre: {{ $usuario->name }}</p>
                        <p class="font-bold text-sm">Email: {{ $usuario->email }} - Rol: {{ $usuario->rol->nombre_rol }}</p>
                    </div>

                    <div class="flex gap-2">
                        <!-- Botón reset clave -->
                        <form action="{{ route('backoffice.usuarios.resetearClave', $usuario->id) }}" method="POST"
                            onsubmit="return confirm('¿Asignar nueva contraseña a {{ $usuario->name }}?')">
                            @csrf
                            <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded text-sm">
                                🔑 Nueva clave
                            </button>
                        </form>

                        <!-- Botón eliminar -->
                        <form action="{{ route('backoffice.usuarios.destroy', $usuario->id) }}" method="POST"
                            onsubmit="return confirm('¿Eliminar a {{ $usuario->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                🗑️ Eliminar
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-300">No hay empleados registrados aún.</p>
                @endforelse
            </div>
        </div>
    </section>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</x-app-layout>
