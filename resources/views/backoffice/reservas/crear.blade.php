<x-app-layout>
    <section class="bg-gray-200 text-black pt-32 pb-16">
        <div class="max-w-2xl mx-auto bg-white  p-4 rounded-xl shadow border">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Reservar</h3>
                @livewire('formulario-reserva')
        </div>
        {{-- Listado de habitaciones más amplio --}}
        <div class="max-w-6xl mx-auto mt-12 px-4">
           @livewire('listado-habitaciones')
           @livewire('confirmar-reserva-modal')

        </div>
    </section>
</x-app-layout>


<!-- max-w-2xl mx-auto bg-white p-4 rounded-xl shadow border" -->
