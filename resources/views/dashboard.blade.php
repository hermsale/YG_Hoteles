<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="mt-4 flex space-x-4">
                    <img src="{{ asset('img/habitacion-deluxe101-1.png') }}" alt="Imagen 1" class="w-32 h-32 object-cover rounded">
                    <!-- <img src="{{ asset('images/imagen2.jpg') }}" alt="Imagen 2" class="w-32 h-32 object-cover rounded"> -->
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
