<nav x-data="{ open: false }" class="bg-orange-300 border-b border-orange-400 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-800 tracking-wide hover:text-gray-900">
                    🏨 YG Hotel
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden sm:flex space-x-6 text-sm font-medium text-gray-700">
                <a href="{{ route('dashboard') }}" class="hover:text-gray-900 {{ request()->routeIs('dashboard') ? 'underline' : '' }}">Inicio</a>
                <a href="#habitaciones" class="hover:text-gray-900">Habitaciones</a>
                <a href="#galeria" class="hover:text-gray-900">Galería</a>
                <a href="#reseñas" class="hover:text-gray-900">Reseñas</a>
                <a href="#contacto" class="hover:text-gray-900">Contacto</a>
            </div>

            <!-- Reservar y Usuario -->
            <div class="hidden sm:flex items-center space-x-4">
                <a href="{{ route('reservar') }}" class="bg-white text-orange-600 font-semibold px-4 py-2 rounded hover:bg-orange-100 transition">
                    Reservar ahora
                </a>

                <!-- Usuario -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 transition">
                            <div>{{ Auth::user()->name }}</div>
                            <svg class="ml-1 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Perfil</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Cerrar sesión
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="sm:hidden flex items-center">
                <button @click="open = !open" class="p-2 rounded-md text-gray-600 hover:text-gray-800 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Nav -->
    <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden bg-orange-200 px-4 py-2 space-y-2">
        <a href="{{ route('dashboard') }}" class="block">Inicio</a>
        <a href="#habitaciones" class="block">Habitaciones</a>
        <a href="#galeria" class="block">Galería</a>
        <a href="#reseñas" class="block">Reseñas</a>
        <a href="#contacto" class="block">Contacto</a>
        <a href="{{ route('reservar') }}" class="block font-semibold text-orange-700">Reservar ahora</a>
        <hr class="border-orange-300" />
        <a href="{{ route('profile.edit') }}" class="block">Perfil</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block">Cerrar sesión</a>
        </form>
    </div>
</nav>
