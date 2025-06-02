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
                                <th class="px-6 py-3 text-left text-sm font-semibold">Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cursos as $curso)
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="px-6 py-4">{{ $curso->id }}</td>
                                    <td class="px-6 py-4">{{ $curso->titulo }}</td>
                                    <td class="px-6 py-4">${{ number_format($curso->precio, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">No hay cursos disponibles.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
