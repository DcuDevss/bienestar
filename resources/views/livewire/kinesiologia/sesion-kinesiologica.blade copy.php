<div class="p-6" x-data="{ modal: false }" x-cloak>

    {{-- FLASH MESSAGE --}}
    @if (session('mensaje'))
        <div 
            x-data="{show:true}"
            x-show="show"
            x-init="setTimeout(()=>show=false,2500)"
            x-transition.opacity.duration.500ms
            class="bg-green-200 text-green-800 px-4 py-2 rounded mb-4 shadow">
            {{ session('mensaje') }}
        </div>
    @endif

    {{-- BLOQUE DE DATOS DEL PACIENTE (NO COLAPSABLE) --}}
    <div class="bg-gray-50 p-4 rounded-lg shadow mb-8 border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-700 mb-3">
            <span class="inline-block mr-2 text-gray-600">Datos del Paciente</span>
        </h3>
        <ul class="space-y-2 text-gray-700">
            <li><span class="font-medium text-gray-600">Nombre:</span> {{ $paciente->apellido_nombre }}</li>
            <li><span class="font-medium text-gray-600">Domicilio:</span> {{ $paciente->domicilio }}</li>
            <li><span class="font-medium text-gray-600">Teléfono:</span> {{ $paciente->TelefonoCelular }}</li>
            <li><span class="font-medium text-gray-600">DNI:</span> {{ $paciente->dni }}</li>
            <li><span class="font-medium text-gray-600">Edad:</span> {{ $paciente->edad }} años</li>
        </ul>
    </div>

    {{-- CONTADOR + BARRA PROGRESIVA CON ALERTA VISUAL --}}
    @php
        $activas = $serieActiva->count();
        $limite = $limiteSerie;
        $porcentaje = $limite > 0 ? ($activas / $limite) * 100 : 0;
        // Clase para resaltar visualmente el contador
        $alertaClase = '';
        if ($activas === $limite - 1) { // Sesión 9/10
            $alertaClase = 'border-4 border-yellow-500 bg-yellow-50/50 shadow-md';
        } elseif ($activas >= $limite) { // Sesión 10/10 o más
            $alertaClase = 'border-4 border-red-500 bg-red-50/50 shadow-lg';
        }
    @endphp

    <div class="mb-4 p-3 rounded-lg {{ $alertaClase }}">
        <p class="font-semibold mb-1 text-lg">
            Sesiones activas: 
            <span class="{{ $activas >= $limite ? 'text-red-600 font-extrabold' : 'text-blue-600' }}">
                {{ $activas }}
            </span> / {{ $limite }}
        </p>
        <div class="w-full h-3 bg-gray-300 rounded overflow-hidden">
            <div class="h-3 bg-blue-600 transition-[width] duration-700 ease-out"
                style="width: {{ $porcentaje }}%;"></div>
        </div>
    </div>

    {{-- FILTROS --}}
    <div class="mb-6 flex gap-2">
        <button wire:click="$set('filtro','todas')"
            class="px-3 py-1 rounded shadow 
                {{ $filtro=='todas'?'bg-blue-600 text-white':'bg-gray-200 hover:bg-gray-300' }}">
            Todas
        </button>

        <button wire:click="$set('filtro','activas')"
            class="px-3 py-1 rounded shadow 
                {{ $filtro=='activas'?'bg-blue-600 text-white':'bg-gray-200 hover:bg-gray-300' }}">
            Activas
        </button>

        <button wire:click="$set('filtro','inactivas')"
            class="px-3 py-1 rounded shadow 
                {{ $filtro=='inactivas'?'bg-blue-600 text-white':'bg-gray-200 hover:bg-gray-300' }}">
            Inactivas
        </button>
    </div>

    {{-- BOTÓN REGISTRAR NUEVA SESIÓN --}}
    <div class="text-left mb-5">
        <button @click="modal = true" wire:click="resetCampos"
            class="px-4 py-2 bg-green-600 text-white rounded shadow hover:bg-green-700 transition">
            Registrar sesión
        </button>
    </div>

    {{-- MODAL --}}
    <div x-show="modal"
        x-transition.opacity
        class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-40"
        style="display:none">

        <div @click.away="modal=false"
            x-transition.scale
            class="bg-white w-full max-w-lg p-6 rounded shadow-lg">

            <h3 class="font-semibold text-lg mb-3">Registrar / Editar Sesión</h3>

            <form wire:submit.prevent="confirmarGuardarSesion" class="space-y-4">

                <div>
                    <label class="block text-sm font-medium">N° Sesión</label>
                    <input type="number" wire:model="sesion_nro"
                    readonly
                        class="border rounded w-full px-2 py-1">
                    @error('sesion_nro') 
                        <span class="text-red-600 text-sm">{{ $message }}</span> 
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Fecha</label>
                    <input type="date" wire:model="fecha_sesion"
                        class="border rounded w-full px-2 py-1">
                    @error('fecha_sesion') 
                        <span class="text-red-600 text-sm">{{ $message }}</span> 
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Tratamiento Fisiokinético</label>
                    <textarea wire:model="tratamiento_fisiokinetico"
                        class="border rounded w-full px-2 py-1"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium">Evolución</label>
                    <textarea wire:model="evolucion_sesion"
                        class="border rounded w-full px-2 py-1"></textarea>
                </div>

                <div class="flex justify-between mt-4">
                    <button type="button" @click="modal=false"
                        class="px-3 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        Cancelar
                    </button>

                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        {{ $sesionId ? 'Actualizar sesión' : 'Guardar sesión' }}
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- TABLA DE SESIONES --}}
    <div class="bg-white shadow p-4 rounded">
        <h3 class="font-semibold mb-3">Listado de Sesiones</h3>

        <table class="w-full text-left border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-2 py-1 border">#</th>
                    <th class="px-2 py-1 border">Fecha</th>
                    <th class="px-2 py-1 border">Tratamiento</th>
                    <th class="px-2 py-1 border">Evolución</th>
                    <th class="px-2 py-1 border">Estado</th>
                    <th class="px-2 py-1 border">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($this->sesionesFiltradas as $sesion)
                    <tr x-transition.opacity.duration.300ms
                        class="{{ $sesion->firma_paciente_digital == 0
                            ? 'bg-green-50'
                            : 'bg-red-50' }}">
                        <td class="border px-2 py-1">{{ $sesion->sesion_nro }}</td>
                        <td class="border px-2 py-1">{{ Carbon\Carbon::parse($sesion->fecha_sesion)->format('d/m/Y') }}</td>
                        {{-- <td class="border px-2 py-1">{{ $sesion->fecha_sesion }}</td> --}}
                        <td class="border px-2 py-1">{{ $sesion->tratamiento_fisiokinetico }}</td>
                        <td class="border px-2 py-1">{{ $sesion->evolucion_sesion }}</td>
                        <td class="border px-2 py-1">
                            @if ($sesion->firma_paciente_digital == 0)
                                <span class="flex items-center gap-1 px-2 py-0.5 text-xs bg-green-100 text-green-700 rounded-full">
                                    <span class="w-2 h-2 bg-green-600 rounded-full"></span> Activa
                                </span>
                            @else
                                <span class="flex items-center gap-1 px-2 py-0.5 text-xs bg-red-100 text-red-700 rounded-full">
                                    <span class="w-2 h-2 bg-red-600 rounded-full"></span> Inactiva
                                </span>
                            @endif
                        </td>

                        <td class="border px-2 py-1 flex gap-2">
                            {{-- EDITAR --}}
                            <button wire:click="editarSesion({{ $sesion->id }})"
                                @click="modal=true"
                                class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition text-xs">
                                Editar
                            </button>

                            {{-- ELIMINAR --}}
                            @role('super-admin')
                            <button wire:click="eliminarSesion({{ $sesion->id }})"
                                class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition text-xs">
                                Eliminar
                            </button>
                            @endrole
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- BOTONES --}}
    <div class="mt-6 flex justify-end gap-4">
        {{-- Botón Finalizar Sesión --}}
        <button wire:click="finalizarSerie"
            class="bg-blue-700 text-white px-4 py-2 rounded shadow hover:bg-blue-800 transition">
            Finalizar Sesión
        </button>

        {{-- Botón Ver Historial de Fichas --}}
        <a href="{{ route('fichas-kinesiologicas.index', ['paciente' => $paciente->id]) }}"
            class="bg-green-600 text-white px-6 py-2 rounded-xl shadow-lg hover:bg-green-700 transition duration-150 transform hover:scale-105 flex items-center">
            Ver Historial de Fichas
        </a>
    </div>

</div>

{{-- SweetAlert2 Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('livewire:initialized', () => {

    // 1. MANEJADOR DE ALERTA INSTANTÁNEA (swal) - Usado para "No hay activas"
    Livewire.on('swal', (event) => {
        const data = event[0];
        Swal.fire({
            title: data.title,
            text: data.text,
            icon: data.icon,
            timer: 3000, // Se cierra automáticamente
            showConfirmButton: false
        });
    });

    // 2. CONFIRMACIÓN FINALIZAR SERIE
    Livewire.on('confirmarFinalizarSerie', () => {
        Swal.fire({
            title: "¿Finalizar serie de sesiones?",
            text: "Esto marcará todas las sesiones activas como inactivas. ¿Confirmas la finalización?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DC2626", // Rojo
            cancelButtonColor: "#6B7280",
            confirmButtonText: "Sí, Finalizar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('finalizarSerieConfirmada');
            }
        });
    });
    
    // 3. CONFIRMACIÓN GUARDADO SESIÓN (Flujo normal)
    Livewire.on('confirmarGuardado', () => {
        Swal.fire({
            title: "¿Guardar sesión?",
            text: "Se registrará la sesión con los datos ingresados.",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#10B981",
            cancelButtonColor: "#6B7280",
            confirmButtonText: "Guardar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('guardarSesionConfirmada');
            }
        });
    });
    
    // 4. SESIÓN GUARDADA (Mensaje de éxito genérico)
    Livewire.on('sesionGuardada', (event) => {
        const data = event[0];
        Swal.fire({
            title: data.title,
            text: data.text,
            icon: data.icon,
            timer: 2500,
            showConfirmButton: false
        });
    });

    // ************************************************
    // 5. NUEVA ALERTA: ADVERTENCIA DE LÍMITE INMINENTE (Sesión 9/10)
    // ************************************************
    Livewire.on('alertaLimite', (event) => {
        const data = event[0];
        Swal.fire({
            title: data.title,
            text: data.text,
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#F59E0B", // Amarillo/Naranja (Continuar)
            cancelButtonColor: "#6B7280", // Gris (Cancelar)
            confirmButtonText: "Continuar y Guardar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                // Llama al método para guardar forzando el salto de la verificación
                Livewire.dispatch('continuarGuardadoForzado');
            }
        });
    });

    // ************************************************
    // 6. NUEVA ALERTA: LÍMITE ALCANZADO (Sesión 10/10 o más)
    // ************************************************
    Livewire.on('alertaContinuar', (event) => {
        const data = event[0];
        Swal.fire({
            title: data.title,
            text: data.text,
            icon: "warning",
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonColor: "#10B981", // Verde (Guardar Extra)
            cancelButtonColor: "#6B7280", // Gris (Cancelar)
            denyButtonColor: "#DC2626", // Rojo (Finalizar Serie)
            confirmButtonText: "Guardar Sesión Extra",
            denyButtonText: "Finalizar Serie Ahora",
            cancelButtonText: "Cancelar y Revisar"
        }).then((result) => {
            if (result.isConfirmed) {
                // Opción: Guardar sesión extra (Llama al guardado forzado)
                Livewire.dispatch('continuarGuardadoForzado');
            } else if (result.isDenied) {
                // Opción: Finalizar la serie actual
                Livewire.dispatch('finalizarSerieConfirmada');
            }
        });
    });
    // ************************************************

});
</script>