<x-app-layout>
    <section class="bg-gray-200 text-black pt-32 pb-16">
        <div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-md">

            <h2 class="text-2xl font-bold mb-6 text-center">➕ Crear nuevo usuario</h2>

            <form action="{{ route('backoffice.usuarios.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Nombre -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre completo</label>
                    <input type="text" name="name" id="name" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                    <input type="email" name="email" id="email" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Contraseña -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input type="password" name="password" id="password" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <!-- Confirmar contraseña -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>


                <!-- Rol -->
                <div>
                    <label for="id_rol" class="block text-sm font-medium text-gray-700">Rol</label>
                    <select name="id_rol" id="id_rol" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 bg-white focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Seleccioná un rol</option>
                        <option value="2">Recepcionista</option>
                        <option value="3">Cliente</option>
                    </select>
                </div>

                <!-- Botón -->
                <div class="text-center">
                    <a href="{{ route('backoffice.usuarios.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">⬅️ Cancelar</a>
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                        ✅ Crear usuario
                    </button>
                </div>
            </form>

        </div>
    </section>
</x-app-layout>
