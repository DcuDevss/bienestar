<div class="container mx-auto p-4">
    <h2 class="text-2xl font-semibold mb-4 text-center">Editar Paciente</h2>

    {{-- Si usás confirmación, podés omitir el submit del form y disparar la acción con el botón --}}
    <form wire:submit.prevent="submit" class="space-y-4">

        <!-- Información del paciente -->
        <div class="w-full px-4 mt-6">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold text-center mb-4">Información personal</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="col-span-1">
                        <label for="apellido_nombre" class="block font-medium">Apellido y Nombre</label>
                        <input type="text" id="apellido_nombre" wire:model="apellido_nombre" class="input rounded-md w-full">
                    </div>

                    <div class="col-span-1">
                        <label for="dni" class="block font-medium">DNI</label>
                        <input type="number" id="dni" wire:model="dni" class="input rounded-md w-full">
                    </div>

                    <div class="col-span-1">
                        <label for="cuil" class="block font-medium">CUIL</label>
                        <input type="number" id="cuil" wire:model="cuil" class="input rounded-md w-full">
                    </div>

                    <div class="col-span-1">
                        <label for="sexo" class="block font-medium">Sexo</label>
                        <select id="sexo" wire:model="sexo" class="input rounded-md w-full">
                            <option value="">Seleccione</option>
                            {{-- Importante: estos valores deben coincidir con el validador del componente --}}
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                    </div>

                    <div class="col-span-1">
                        <label for="domicilio" class="block font-medium">Domicilio</label>
                        <input type="text" id="domicilio" wire:model="domicilio" class="input rounded-md w-full">
                    </div>

                    <div class="col-span-1">
                        <label for="fecha_nacimiento" class="block font-medium">Fecha de Nacimiento</label>
                        <input type="date" id="fecha_nacimiento" wire:model="fecha_nacimiento" class="input rounded-md w-full">
                    </div>

                    <div class="col-span-1">
                        <label for="email" class="block font-medium">Email</label>
                        <input type="email" id="email" wire:model="email" class="input rounded-md w-full">
                    </div>

                    <div class="col-span-1">
                        <label for="TelefonoCelular" class="block font-medium">Teléfono Celular</label>
                        <input type="number" id="TelefonoCelular" wire:model="TelefonoCelular" class="input rounded-md w-full">
                    </div>

                    <div class="col-span-1">
                        <label for="FecIngreso" class="block font-medium">Fecha de Ingreso</label>
                        <input type="date" id="FecIngreso" wire:model="FecIngreso" class="input rounded-md w-full">
                    </div>
                </div>
            </div>
        </div>

        <!-- Información Laboral -->
        <div class="w-full px-4 mt-6">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold text-center mb-4">Información Laboral</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                    <div class="col-span-1">
                        <label for="legajo" class="block font-medium">Legajo</label>
                        <input type="number" id="legajo" wire:model="legajo" class="input rounded-md w-full">
                    </div>

                    <div class="col-span-1">
                        <label for="jerarquia_id" class="block font-medium">Jerarquía</label>
                        <select id="jerarquia_id" wire:model="jerarquia_id" class="input rounded-md w-full">
                            <option value="">Seleccione</option>
                            @foreach ($jerarquias as $jerarquia)
                                <option value="{{ $jerarquia->id }}">{{ $jerarquia->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1">
                        <label for="destino_actual" class="block font-medium">Destino Actual</label>
                        <input type="text" id="destino_actual" wire:model="destino_actual" class="input rounded-md w-full">
                    </div>

                    <div class="col-span-1">
                        <label for="ciudad_id" class="block font-medium">Ciudad</label>
                        <select wire:model="ciudad_id" id="ciudad_id" class="block w-full rounded-md">
                            <option value="">Seleccione una ciudad</option>
                            @foreach ($ciudades as $ciudad)
                                <option value="{{ $ciudad->id }}">{{ $ciudad->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1">
                        <label for="edad" class="block font-medium">Edad</label>
                        <input type="number" id="edad" wire:model="edad" class="input rounded-md w-full">
                    </div>

                    <div class="col-span-1">
                        <label for="estado_id" class="block font-medium">Estado</label>
                        <select id="estado_id" wire:model="estado_id" class="input rounded-md w-full">
                            <option value="">Seleccione</option>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado->id }}">{{ $estado->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1">
                        <label for="NroCredencial" class="block font-medium">Nro Credencial</label>
                        <input type="number" id="NroCredencial" wire:model="NroCredencial" class="input rounded-md w-full">
                    </div>

                    <div class="col-span-1">
                        <label for="chapa" class="block font-medium">Chapa</label>
                        <input type="number" id="chapa" wire:model="chapa" class="input rounded-md w-full">
                    </div>
                </div>
            </div>
        </div>

        <!-- Información de Salud -->
        <div class="w-full px-4 mt-6">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold text-center mb-4">Información de Salud</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                    <div class="col-span-1">
                        <label for="peso" class="block font-medium">Peso</label>
                        <input type="number" id="peso" wire:model="peso" class="input rounded-md w-full">
                    </div>

                    <div class="col-span-1">
                        <label for="altura" class="block font-medium">Altura</label>
                        <input type="text" id="altura" wire:model="altura" class="input rounded-md w-full">
                    </div>

                    <div class="col-span-1">
                        <label for="factore_id" class="block font-medium">Factor</label>
                        <select id="factore_id" wire:model="factore_id" class="input rounded-md w-full">
                            <option value="">Seleccione</option>
                            @foreach ($factores as $factore)
                                <option value="{{ $factore->id }}">{{ $factore->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1 lg:col-span-3">
                        <label for="enfermedad" class="block font-medium">Posee alguna enfermedad preexistente</label>
                        <textarea id="enfermedad" wire:model="enfermedad" class="input rounded-md w-full" rows="3"></textarea>
                    </div>

                    <div class="col-span-1 lg:col-span-3">
                        <label for="remedios" class="block font-medium">Remedios</label>
                        <textarea id="remedios" wire:model="remedios" class="input rounded-md w-full" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Botones --}}
        <div class="px-4 mt-6 flex items-center gap-3">
            {{-- Opción A: Guardar directo (usa wire:submit del form) --}}
            <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-md hover:bg-blue-600">
                Actualizar Paciente
            </button>

            {{-- Volver con confirmación --}}
            <a href="#"
               class="bg-[#42be31] text-white py-2 px-6 rounded-md hover:opacity-90"
               x-data
               x-on:click.prevent="
                   Livewire.dispatch('confirm', {
                       title: 'Salir sin guardar',
                       text: '¿Seguro? Podrías perder cambios no guardados.',
                       icon: 'warning',
                       confirmText: 'Sí, salir',
                       cancelText: 'Cancelar',
                       action: 'go-dashboard'
                   })
               ">
                Volver
            </a>
        </div>
    </form>

    {{-- SweetAlert para session flash (opcional, por compatibilidad) --}}
    @if (session()->has('message'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                Swal?.fire({
                    icon: 'success',
                    title: 'Listo',
                    text: @json(session('message')),
                    timer: 4000,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                });
            });
        </script>
    @endif

    {{-- SweetAlert para errores de validación globales (opcional) --}}
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                Swal?.fire({
                    icon: 'error',
                    title: 'Revisá los campos',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    {{-- Cargar SweetAlert2 + listeners si NO están globales --}}
    @once
        {{-- Si ya incluís @include('partials.swal') en el layout, podés borrar todo este bloque --}}
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('swal', ({
                    title = '',
                    text = '',
                    icon = 'success',
                    timer = 2000,
                    toast = true,
                    position = 'top-end'
                } = {}) => {
                    Swal.fire({ title, text, icon, toast, position, timer, showConfirmButton: !toast });
                });

                Livewire.on('confirm', ({
                    title = '¿Estás seguro?',
                    text = 'Esta acción no se puede deshacer.',
                    icon = 'warning',
                    confirmText = 'Sí, continuar',
                    cancelText = 'Cancelar',
                    action = null,
                    params = {}
                } = {}) => {
                    Swal.fire({
                        title, text, icon,
                        showCancelButton: true,
                        confirmButtonText: confirmText,
                        cancelButtonText: cancelText,
                        reverseButtons: true,
                        focusCancel: true,
                    }).then((result) => {
                        if (result.isConfirmed && action) {
                            Livewire.dispatch(action, params);
                        }
                    });
                });
            });
        </script>
    @endonce
</div>
