<form wire:submit.prevent="buscar">

    <label class="block text-sm">Fecha de entrada</label>
    <input type="date" wire:model="fecha_entrada" class="w-full border rounded p-1 mb-3">

    <label class="block text-sm">Fecha de salida</label>
    <input type="date" wire:model="fecha_salida" class="w-full border rounded p-1 mb-3">

    <label class="block text-sm">Huéspedes</label>
    <select wire:model="huespedes" class="w-full border rounded p-1">
        <option value="1">1 Adulto</option>
        <option value="2">2 Adultos</option>
        <option value="3">3 Adultos</option>
        <option value="4">4 Adultos</option>
    </select>

    <button type="submit" class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">
        Buscar
    </button>
</form>
