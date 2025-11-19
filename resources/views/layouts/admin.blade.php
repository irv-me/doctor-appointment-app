@props([
    'title' => config('app.name', 'Laravel'),
    'breadcrumbs' => []
])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://kit.fontawesome.com/a7de8752fc.js" crossorigin="anonymous"></script>

        <!-- sweet alert 2 -->

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        <wireui:scripts />
        {{-- Livewire Scripts --}}
        @livewireScripts

        <!-- Styles -->
        @livewireStyles
    </head>
    {{-- Este es el fondo gris de la página --}}
    <body class="font-sans antialiased bg-gray-50">
        @include('layouts.includes.admin.navigation')

        @include('layouts.includes.admin.sidebar')

        <div class="p-4 sm:ml-64">
            <!-- Margin top 14px -->
            <div class="mt-14">
                @include('layouts.includes.admin.breadcrumb')
                {{-- Aquí se carga el contenido de la página (index.blade.php) --}}
                {{ $slot }}
            </div>
        </div>

        @stack('modals')

        <!-- SweetAlert2 desde sesión -->
        @if (session('swal'))
            <script>
                Swal.fire(@json(session('swal')));
            </script>
        @endif

        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

    </body>
</html>

