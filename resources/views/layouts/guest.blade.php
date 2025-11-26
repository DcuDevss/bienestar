<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        {{-- favicon --}}
        <link rel="icon" href="{{ asset('FaviconPol.png') }}" type="image/png">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>

        @livewireScripts
    </body>
</html>
<footer class="py-6 bg-gray-800 font-semibold text-xs text-white shadow-lg flex items-center justify-center space-x-3">
    <img src="{{ asset('assets/escudo_128x128.png') }}" alt="Escudo" class="h-8 w-auto">
    <p class="m-0">2025 Policía de la Provincia de Tierra del Fuego, Antártida e Islas del Atlántico Sur.</p>
</footer>
