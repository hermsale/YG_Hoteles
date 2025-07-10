<nav x-data="{ open: false }" class="bg-gray-900 bg-opacity-80 fixed w-full z-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
        <!-- Logo + Marca -->
        <div class="flex items-center gap-3 text-white text-xl font-bold">
            @auth
            @if (in_array(auth()->user()->rol->nombre_rol, ['Administrador','Recepcionista']))
            {{-- 🔽 MENÚ HAMBURGUESA CON DROPDOWN --}}
            <x-dropdown align="left" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center p-2 text-sm font-medium text-white bg-gray-800 rounded-md hover:text-gray-300 focus:outline-none">
                        {{-- Ícono hamburguesa --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 md:h-8 md:w-8" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    {{-- Ítems del menú --}}
                    @if (in_array(auth()->user()->rol->nombre_rol, ['Administrador']))
                    <x-dropdown-link :href="route('backoffice.habitaciones.index')">
                        🛏 Habitaciones
                    </x-dropdown-link>
                    @endif

                    {{-- Podés agregar más entradas si querés --}}
                    <x-dropdown-link :href="route('reservas.index')">
                        📋 Reservas
                    </x-dropdown-link>
                </x-slot>
            </x-dropdown>
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('img/otros/icon-hotel.png') }}" alt="Logo del hotel"
                    class="w-10 h-10 object-contain">
            </a>
            @else
            <a href="/">
                <img src="{{ asset('img/otros/icon-hotel.png') }}" alt="Logo del hotel"
                    class="w-10 h-10 object-contain">
            </a>
            @endif
            @endauth
            <!-- en caso que haya un usuario no logueado -->
            @guest
            <a href="/">
                <img src="{{ asset('img/otros/icon-hotel.png') }}" alt="Logo del hotel"
                    class="w-10 h-10 object-contain">
            </a>
            @endguest
            <span>YG Hoteles</span>
        </div>


        <!-- Navegación -->
        <div class="hidden sm:flex items-center gap-4">
            @auth
            <input type="text" placeholder="Buscar" class="px-3 py-1 rounded text-black">

            @if (in_array(auth()->user()->rol->nombre_rol, ['Administrador', 'Recepcionista']))
            <a href="{{ route('reservas.indexBackoffice') }}" class="text-white hover:underline">
                Gestión de Reservas
            </a>
            @else
            <a href="{{ route('reservas.index') }}" class="text-white hover:underline">
                Mis reservas
            </a>
            @endif
            @endauth

            @guest
            <a href="{{ route('reservas.index') }}" class="text-white hover:underline">
                Mis reservas
            </a>
            @endguest

            <a href="{{ route('contacto.index') }}" class="text-white hover:underline">Contáctanos</a>

            @auth
            <!-- Dropdown de usuario -->
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-gray-800 rounded-md hover:text-gray-300 focus:outline-none">
                        {{ Auth::user()->name }}
                        <svg class="ms-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586 13.293 7.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <!-- valido que sea admin o recepcionista -->
                    @if (in_array(auth()->user()->rol->nombre_rol, ['Administrador','Recepcionista']))
                    <x-dropdown-link :href="route('dashboard')">
                        {{ __('Dashboard') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('welcome')">
                        {{ __('Home') }}
                    </x-dropdown-link>
                    @endif
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Perfil') }}
                    </x-dropdown-link>


                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link href="route('logout')"
                            onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            {{ __('Cerrar Sesión') }}
                        </x-dropdown-link>

                    </form>
                </x-slot>
            </x-dropdown>
            @else
            <a href="{{ route('login') }}"
                class="rounded-md px-3 py-2 text-black bg-white ring-1 ring-transparent transition hover:bg-gray-100 dark:text-white dark:bg-transparent dark:hover:text-white/80">
                Iniciar Sesión
            </a>
            @endauth
        </div>

        <!-- Botón Hamburguesa para móviles -->
        <div class="sm:hidden">
            <button @click="open = !open" class="text-white hover:text-gray-300 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" d="M4 6h16M4 12h16M4 18h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Menú móvil -->
    <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden px-4 pb-4">
        <a href="#" class="block text-white py-2">Mis reservas</a>
        <a href="#" class="block text-white py-2">Contáctanos</a>

        @auth
        <a href="{{ route('profile.edit') }}" class="block text-white py-2">Perfil</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="block text-white py-2 w-full text-left" type="submit">Cerrar sesión</button>
        </form>
        @else
        <a href="{{ route('login') }}" class="block text-white py-2">Iniciar sesión</a>
        @endauth
    </div>
</nav>
