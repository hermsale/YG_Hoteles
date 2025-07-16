<x-app-layout>

    <section class="px-8 py-12 bg-gray-500">

        <div class="flex items-center justify-center min-h-screen bg-gradient-to-r from-gray-100 to-gray-200">
            <div class="bg-white px-10 py-12 p-10 rounded-2xl shadow-xl text-center animate-fade-in">
                <div class="text-red-600 text-6xl font-extrabold mb-2">403</div>
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Acceso no autorizado</h2>

                    <p class="text-gray-600 mb-6">
                        No tenés permisos para acceder a esta página.<br>
                        Por favor, contactá al administrador si creés que esto es un error.
                    </p>
                    <a href="{{ route('welcome') }}"
                        class="inline-block px-6 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-full transition duration-200">
                        Volver al inicio
                    </a>
                </div>

        </div>
    </section>


    <!-- Agregá esto al final si querés una animación sutil al cargar -->
    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.5s ease-out;
        }
    </style>
</x-app-layout>
