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
    <!-- Tom Select CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    {{-- favicon --}}
    <link rel="icon" href="{{ asset('favicon.png') }}?v={{ config('app.version') }}" type="image/png">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <!--  -->
    <script src="{{ asset('js/all.min.js') }}" defer></script>
    @livewireStyles
</head>
<!-- Styles -->
<style>
    body {
        /* padding-bottom: 80px; */
        /* Ajusta el tamaño según el footer */
    }

    /* LIGHTBOX */
    /* Estilos para la imagen ampliada */
    .image-container {
        position: relative;
    }

    #image {
        cursor: pointer;
    }

    .full-image-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        z-index: 9999;
        display: none;
    }

    .full-image-container {
        position: absolute;
        top: 50%;
        left: 50%;
        height: 100%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    .full-image-container img {
        max-width: 90%;
        max-height: 90%;
    }

    .action-button {
        margin-top: 10px;
        padding: 5px 10px;
        background-color: #fff;
        color: #000;
        border: none;
        cursor: pointer;
    }

    /* estilos paginacion */

    /* FORMULARIO NUEVO PERSONAL inputs */
    /* input:focus,
        select:focus {
            outline: none !important;
            border-color: #2d5986 !important;
            box-shadow: none !important;
        } */
    /* stepbar FORM NUEVO PERSONAL*/
    .stepBar {
        transition: background-color 1s ease;
    }

    .hr-transition {
        transition: background-color 2.5s;
    }

    /* step form */
    .step-transition {
        transition: opacity 4.3s ease-in-out;
        opacity: 1;
    }

    .step-active {
        opacity: 3;
    }

    /* MEDIAQUERYS TABLAS */
    @media (max-width: 1550px) {

        /* PADRETABLAS */
        .padreTablas {
            padding-left: 6px;
            padding-right: 6px;
        }

        /* TABLA 1 */
        .agre {
            color: ;
        }

        .seccionTab {
            margin: 0 auto;
        }

        .teGead {
            font-size: 12px;
        }

        .tiBody {
            font-size: 12px;
            padding-top: 4px;
            padding-bottom: 4px;
        }

        /* TABLA 2 */
        .seccionTab2 {
            font-size: 11px;
        }

        .subTab2 {
            max-height: 532px;
        }

        .teGead2 {
            font-size: 10px;
            padding-top: 2px;
            padding-bottom: 2px;
        }

        .fak {
            font-size: 10px;
            padding-top: 14px;
            padding-bottom: 14px;
        }
    }

    footer {
        /* position: fixed;
            bottom: 0;
            left: 0; */
        width: 100%;
        background-color: #2d3748;
        /* Fondo oscuro */
        color: white;
        /* Color del texto */
        font-size: 0.875rem;
        /* Tamaño de fuente más pequeño */
        padding: 1.5rem 0;
        /* Espaciado vertical */
        text-align: center;
        box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.1);
        /* Sombra sutil para separación */
        z-index: 1000;
        /* Asegura que quede por encima del contenido */
    }

    footer p {
        margin: 0;
        /* Elimina márgenes */
        font-size: 0.875rem;
        /* Tamaño de fuente ajustado */
    }



    @keyframes pulseYellow {

        0%,
        100% {
            background-color: #f6e05e;
            /* Color amarillo */
            box-shadow: 0 0 0 0px #f6e05e;
        }

        50% {
            background-color: transparent;
            box-shadow: 0 0 0 10px transparent;
        }
    }

    @keyframes pulseRed {

        0%,
        100% {
            background-color: #ef4444;
            /* Color rojo */
            box-shadow: 0 0 0 0px #ef4444;
        }

        50% {
            background-color: transparent;
            box-shadow: 0 0 0 10px transparent;
        }
    }

    .ts-wrapper {
        border: 1px solid #4b5563;
        /* gray-600 */
        border-radius: 0.375rem;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        margin-top: 0.25rem;
        width: 100%;
        background-color: white;
    }

    /* Cuando está enfocado */
    .ts-wrapper.focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 1px #3b82f6;
    }

    /* Caja visible del input */
    .ts-control {
        background-color: white;
        min-height: 2.5rem;
        border: none !important;
        box-shadow: none !important;
        font-size: 0.875rem;
        color: #111827;
        font-weight: 600;
        /* <-- más negrita */
        padding: 0.5rem 0.75rem;
    }

    /* Texto que escribís en el buscador */
    .ts-control input {
        color: #111827;
        font-weight: 600;
        /* <-- más negrita */
    }

    /* Opciones dentro del dropdown */
    .ts-dropdown .option {
        color: #111827;
        font-size: 0.875rem;
        font-weight: 600;
        /* <-- más negrita */
        padding: 0.5rem 0.75rem;
    }

    /* Hover sobre una opción */
    .ts-dropdown .option:hover {
        background-color: #e5e7eb;
        color: #000000;
        cursor: pointer;
    }
</style>

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')



    <!-- Tom Select JS -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    @livewireScripts
</body>
<footer class="text-center py-6 bg-gray-800 font-semibold text-xs text-white shadow-lg ">
    <p>&copy; 2025 Policía de Tierra del Fuego, Antártida e Islas del Atlántico Sur.</p>
</footer>


</html>
