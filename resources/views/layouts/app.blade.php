<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    {{-- favicon --}}
    <link rel="icon" href="{{ asset('FaviconPol.png') }}?v={{ config('app.version') }}" type="image/png">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    {{-- sweetalert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    
    @livewireStyles
</head>
<style>
    /* ... Tus estilos CSS (omito por brevedad) ... */
</style>
<script>
document.addEventListener('DOMContentLoaded', () => {
  @if (session('forbidden_message'))
    Swal.fire({
      title: 'Aviso',
      text: @json(session('forbidden_message')),
      icon: 'warning',
      confirmButtonText: 'Entendido',
      confirmButtonColor: '#2d5986',
      backdrop: true,
      allowOutsideClick: false,
      allowEscapeKey: true,
      // 👇 Esto lo centra completamente
      position: 'center',
      timer: null, // sin auto cierre
    });
  @endif
});
</script>
<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    {{-- SCRIPTS FINALES --}}
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    {{-- 1. LIVEWIRE SCRIPTS --}}
    @livewireScripts 

    {{-- 2. SWEETALERT2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 

    {{-- 3. CÓDIGO JS FINAL: Solución para Livewire.emit y manejo de SweetAlert2 --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            
            // ----------------------------------------------------
            // A. FUNCIONES GLOBALES DE CONFIRMACIÓN (Livewire.emit)
            // ----------------------------------------------------
            
            // Definir y exponer al ámbito global para que los botones onclick funcionen
            window.confirmRestore = function (id, nombre) {
                Swal.fire({
                    title: `¿Restaurar a ${nombre}?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, restaurar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Aquí la llamada es segura
                        if (typeof Livewire !== 'undefined' && Livewire.emit) {
                            Livewire.emit('restore', id);
                        }
                    }
                });
            }

            window.confirmDelete = function (id, nombre) {
                Swal.fire({
                    title: `¿Eliminar permanentemente a ${nombre}?`,
                    text: "¡Esta acción no se puede deshacer!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (typeof Livewire !== 'undefined' && Livewire.emit) {
                            Livewire.emit('forceDelete', id);
                        }
                    }
                });
            }

            // ----------------------------------------------------
            // B. MANEJO DE NOTIFICACIONES DISPATCH (SweetAlert2)
            // ----------------------------------------------------
            
            // Escucha el evento 'swal' enviado por $this->dispatch() en PHP
            document.addEventListener('swal', event => {
                const data = event.detail;

                Swal.fire({
                    title: data.title, 
                    text: data.text,
                    icon: data.icon,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            });
        });
    </script>
    
</body>
<footer class="text-center py-6 bg-gray-800 font-semibold text-xs text-white shadow-lg ">
    <p>&copy; 2025 Policía de Tierra del Fuego, Antártida e Islas del Atlántico Sur.</p>
</footer>

</html>