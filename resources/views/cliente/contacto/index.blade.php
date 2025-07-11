<x-app-layout>
    <section class="relative h-screen bg-cover bg-center" style="background-image: url('{{ asset('img/otros/fondo-inicio.png') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative z-10 flex justify-center items-center h-full">
            <div class="bg-white rounded-2xl shadow-lg p-10 w-full max-w-3xl" x-data="{ show: false }">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Contáctanos</h2>

                <form @submit.prevent="
                        if ($event.target.checkValidity()) {
                            show = true;
                            setTimeout(() => show = false, 4000);
                            $event.target.reset();
                        }
                    " class="space-y-5">

                    @csrf

                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre completo</label>
                        <input type="text" name="nombre" id="nombre" required class="mt-1 block w-full border text-black border-gray-300 rounded-lg shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                        <input type="email" name="email" id="email" required class="mt-1 block w-full border text-black border-gray-300 rounded-lg shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="mensaje" class="block text-sm font-medium text-gray-700">Mensaje</label>
                        <textarea name="mensaje" id="mensaje" rows="5" required class="mt-1 block w-full border text-black border-gray-300 rounded-lg shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>

                    <div class="flex justify-center">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-xl transition">
                            Enviar mensaje
                        </button>
                    </div>

                    <!-- Cartel de éxito -->
                    <div x-show="show" x-transition x-cloak
                        class="mt-6 mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-sm text-center"
                        role="alert">
                        <strong class="font-bold">✔️ ¡Éxito!</strong>
                        <span class="ml-2">Tu mensaje ha sido enviado con éxito.</span>
                    </div>


                    <div class="text-center mt-8">
                        <p class="text-sm text-gray-600 mb-2">Seguinos en nuestras redes:</p>
                        <div class="flex justify-center space-x-6">
                            <a href="https://instagram.com/tuhotel" target="_blank" class="text-gray-600 hover:text-pink-500 transition">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2Zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5A4.25 4.25 0 0 0 20.5 16.25v-8.5A4.25 4.25 0 0 0 16.25 3.5h-8.5Zm8.75 2.25a.75.75 0 0 1 .75.75v1a.75.75 0 0 1-1.5 0v-1a.75.75 0 0 1 .75-.75Zm-5 2.5a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 1.5a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Z" />
                                </svg>
                            </a>
                            <a href="https://facebook.com/tuhotel" target="_blank" class="text-gray-600 hover:text-blue-600 transition">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14 3h3a1 1 0 0 1 1 1v3h-3a2 2 0 0 0-2 2v2h5l-1 4h-4v8h-4v-8H8v-4h3V9a4 4 0 0 1 4-4Z" />
                                </svg>
                            </a>
                            <a href="https://twitter.com/tuhotel" target="_blank" class="text-gray-600 hover:text-blue-400 transition">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22 5.92a8.38 8.38 0 0 1-2.36.65 4.1 4.1 0 0 0 1.8-2.27 8.2 8.2 0 0 1-2.6 1 4.1 4.1 0 0 0-7 3.74A11.63 11.63 0 0 1 3 4.79a4.07 4.07 0 0 0-.56 2.06 4.1 4.1 0 0 0 1.82 3.41 4.06 4.06 0 0 1-1.86-.5v.05a4.1 4.1 0 0 0 3.3 4 4.1 4.1 0 0 1-1.85.07 4.1 4.1 0 0 0 3.83 2.85A8.23 8.23 0 0 1 2 18.13a11.63 11.63 0 0 0 6.29 1.84c7.55 0 11.67-6.26 11.67-11.67 0-.18 0-.35-.01-.53A8.18 8.18 0 0 0 22 5.92Z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</x-app-layout>
