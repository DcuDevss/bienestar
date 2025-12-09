<x-guest-layout>
    <style>
        /* Fondo general */
        .min-h-screen.bg-gray-100 {
            background: linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
                        url('{{ asset('assets/cambiar-contraseña.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        /* Card de autenticación (el segundo div dentro de min-h-screen) */
        .min-h-screen.bg-gray-100 > div:last-child {
            background: rgba(10, 25, 47, 0.75);      /* azul oscuro semitransparente */
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        /* Texto dentro del card más claro */
        .min-h-screen.bg-gray-100 > div:last-child * {
            color: #e2e8f0 !important;
        }

        /* Que el título y labels se vean un poquito más fuertes */
        .min-h-screen.bg-gray-100 > div:last-child label,
        .min-h-screen.bg-gray-100 > div:last-child h1,
        .min-h-screen.bg-gray-100 > div:last-child h2 {
            color: #f9fafb !important;
        }
        /* Input de Jetstream en modo oscuro */
        .min-h-screen.bg-gray-100 input {
            color: #e2e8f0 !important;          /* texto claro */
            background-color: rgba(0,0,0,0.3);  /* fondo oscuro translúcido */
            border-color: rgba(255,255,255,0.4);
        }

        /* Placeholder (las letras grises dentro del input) */
        .min-h-screen.bg-gray-100 input::placeholder {
            color: rgba(255,255,255,0.6) !important;
        }

        /* Al escribir (caracteres tipo password: ●●●●) */
        .min-h-screen.bg-gray-100 input[type=password] {
            color: #f0f0f0 !important;  /* asteriscos más suaves */
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-authentication-card>

        <x-slot name="logo">
            <div class="flex justify-center">
                <div class="p-2 rounded-full">
                    <img src="{{ asset('assets/escudo_128x128.png') }}" class="h-20 w-20 object-contain">
                </div>
            </div>
        </x-slot>

        @if (session('status'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Contraseña actualizada!',
                            text: @json(session('status')),
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        alert(@json(session('status')));
                    }
                });
            </script>
        @endif

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Cambiá tu contraseña.') }}
        </div>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.update.manual') }}">
            @csrf

            <div>
                <x-label for="current_password" value="Contraseña actual" />
                <x-input id="current_password" class="block mt-1 w-full"
                         type="password" name="current_password" required />
            </div>

            <div class="mt-4">
                <x-label for="password" value="Nueva contraseña" />
                <x-input id="password" class="block mt-1 w-full"
                         type="password" name="password" required />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="Confirmar nueva contraseña" />
                <x-input id="password_confirmation" class="block mt-1 w-full"
                         type="password" name="password_confirmation" required />
            </div>

            <div class="flex justify-end mt-4">
                <x-button class="ms-4">
                    {{ __('Actualizar contraseña') }}
                </x-button>
            </div>

            <div class="flex justify-end mt-4">
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent
                          rounded-md font-semibold text-xs text-white uppercase tracking-widest
                          hover:bg-gray-800 active:bg-gray-900 focus:outline-none focus:ring-2
                          focus:ring-offset-2 focus:ring-gray-500">
                    Volver
                </a>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
