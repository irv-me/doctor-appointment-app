<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-sky-50 via-white to-sky-100 p-6">
        <div class="w-full max-w-md bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg border border-sky-100 p-8">
            <div class="flex items-center gap-4 mb-6">
                <div class="p-2 bg-sky-50 rounded-lg">
                    <x-authentication-card-logo class="h-11 w-11 text-sky-600" />
                </div>
                <div>
                    <h2 class="text-2xl font-semibold text-sky-800">Iniciar sesión</h2>
                    <p class="text-sm text-sky-600">Accede a tu cuenta para gestionar citas</p>
                </div>
            </div>

            <x-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 text-sm text-green-800 bg-green-50 border border-green-100 p-3 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-sky-700">Correo electrónico</label>
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-sky-400">
                            <!-- mail icon -->
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m8 0c1.657 0 3-1.567 3-3.5S25.657 5 24 5H8C6.343 5 5 6.567 5 8.5S6.343 12 8 12m8 0v6a2 2 0 01-2 2H10a2 2 0 01-2-2v-6" transform="scale(.8)"/>
                            </svg>
                        </span>
                        <x-input id="email" class="block w-full pl-10 pr-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-300" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-sky-700">Contraseña</label>
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-sky-400">
                            <!-- lock icon -->
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11v2m0-6a4 4 0 00-4 4v1h8v-1a4 4 0 00-4-4z" />
                                <rect x="3" y="11" width="18" height="10" rx="2" ry="2" />
                            </svg>
                        </span>
                        <x-input id="password" class="block w-full pl-10 pr-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-300" type="password" name="password" required autocomplete="current-password" />
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer select-none text-sm text-sky-700">
                        <x-checkbox id="remember_me" name="remember" class="h-4 w-4 text-sky-600 rounded" />
                        <span class="ml-2">Mantener sesión activa</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-sky-600 hover:text-sky-800" href="{{ route('password.request') }}">
                            ¿Olvidó su contraseña?
                        </a>
                    @endif
                </div>

                <div>
                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-300 transition">
                        Iniciar Sesión
                    </button>
                </div>

                <div class="text-center text-sm text-sky-600">
                    ¿No tienes cuenta?
                    <a href="{{ route('register') }}" class="text-sky-700 font-medium hover:underline ms-1">Regístrate</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
