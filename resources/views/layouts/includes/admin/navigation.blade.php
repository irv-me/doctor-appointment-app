{{-- Añadido shadow-sm para un toque de profundidad --}}
<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 shadow-sm">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 transition-colors duration-150">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                    </svg>
                </button>

                {{-- Añadida transición de opacidad al logo --}}
                <a href="/" class="flex ms-2 md:me-24 transition-opacity duration-150 hover:opacity-80">
                    <svg class="h-8 w-8 me-2 text-blue-600 dark:text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5v9m-4.5-4.5h9" />
                    </svg>
                    <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">Healthify</span>
                </a>
            </div>

            <div class="flex items-center">

                @auth
                    <!-- Settings Dropdown -->
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                {{-- Añadidos mejores estilos de focus (anillo azul) y transición --}}
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-all duration-150">
                                    @if (Auth::user()->profile_photo_url)
                                        <img class="size-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    @else
                                        <span class="inline-flex items-center justify-center size-8 rounded-full bg-blue-600 text-white font-medium">
                                            @php
                                                $names = explode(' ', Auth::user()->name);
                                                $initials = count($names) > 1
                                                    ? strtoupper(substr($names[0], 0, 1) . substr(end($names), 0, 1))
                                                    : strtoupper(substr($names[0], 0, 2));
                                            @endphp
                                            {{ $initials }}
                                        </span>
                                    @endif
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Account') }}
                                </div>

                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                @if (defined('Laravel\Jetstream\Jetstream::hasApiFeatures') && Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                        {{ __('API Tokens') }}
                                    </x-dropdown-link>
                                @endif

                                <div class="border-t border-gray-200 dark:border-gray-700"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf

                                    <x-dropdown-link href="{{ route('logout') }}"
                                                     @click.prevent="$root.submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>

                @else
                    {{-- ESTILOS MEJORADOS para botones de Login/Register --}}
                    <div class="flex items-center ms-3">
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 px-3 py-2 rounded-lg transition-colors duration-150">
                                Log in
                            </a>
                        @endif
                        @if (Route::has('register'))
                            {{-- Botón principal de "Register" --}}
                            <a href="{{ route('register') }}" class="ms-3 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 px-3 py-2 rounded-lg transition-colors duration-150">
                                Register
                            </a>
                        @endif
                    </div>
                @endauth

            </div>
        </div>
    </div>
</nav>
