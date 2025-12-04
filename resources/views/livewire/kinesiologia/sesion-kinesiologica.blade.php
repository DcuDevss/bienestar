<div class="p-6" x-data="{ modal: false }" x-cloak>

    {{-- 🔑 TÍTULO AGREGADO AQUÍ --}}
    <h1 class="text-3xl font-extrabold text-center text-gray-800 mb-6 border-b pb-2">
        Sesión Kinesiologica
    </h1>

    {{-- FLASH MESSAGE --}}
    @if (session('mensaje'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2500)" x-transition.opacity.duration.500ms
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
        $limiteBase = $limiteSerie; // El límite original de 10

        // 💡 CORRECCIÓN: El límite visible ($limite) debe ser el máximo entre las activas y el límite base (10).
        $limite = max($activas, $limiteBase);

        // Recalcula el porcentaje usando el límite dinámico ($limite)
        $porcentaje = $limite > 0 ? ($activas / $limite) * 100 : 0;

        // Clase para resaltar visualmente el contador (usa $limiteBase para la ALERTA)
        $alertaClase = '';
        if ($activas === $limiteBase - 1) {
            // Sesión 9/10
            $alertaClase = 'border-4 border-yellow-500 bg-yellow-50/50 shadow-md';
        } elseif ($activas >= $limiteBase) {
            // Sesión 10/10 o más
            $alertaClase = 'border-4 border-red-500 bg-red-50/50 shadow-lg';
        }
    @endphp

    <div class="mb-4 p-3 rounded-lg {{ $alertaClase }}">
        <p class="font-semibold mb-1 text-lg">
            Sesiones activas:
            {{-- Usamos $limiteBase para el color, que es cuando el contador pasa 10 --}}
            <span class="{{ $activas >= $limiteBase ? 'text-red-600 font-extrabold' : 'text-blue-600' }}">
                {{ $activas }}
            </span> / {{ $limite }}
            {{-- Aquí se usa $limite (que será 11 si $activas es 11) --}}
        </p>
        <div class="w-full h-3 bg-gray-300 rounded overflow-hidden">
            <div class="h-3 bg-blue-600 transition-[width] duration-700 ease-out" style="width: {{ $porcentaje }}%;">
            </div>
        </div>
    </div>

    {{-- FILTROS --}}
    <div class="mb-6 flex gap-2">
        <button wire:click="$set('filtro','todas')"
            class="px-3 py-1 rounded shadow
                {{ $filtro == 'todas' ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
            Todas
        </button>

        <button wire:click="$set('filtro','activas')"
            class="px-3 py-1 rounded shadow
                {{ $filtro == 'activas' ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
            Activas
        </button>

        <button wire:click="$set('filtro','inactivas')"
            class="px-3 py-1 rounded shadow
                {{ $filtro == 'inactivas' ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
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
    <div x-show="modal" x-transition.opacity x-on:cerrar-modal.window="modal = false"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-40" style="display:none">

        <div @mousesdown.away="modal=false" x-transition.scale class="bg-white w-full max-w-lg p-6 rounded shadow-lg">

            <h3 class="font-semibold text-lg mb-3">Registrar / Editar Sesión</h3>

            <form wire:submit.prevent="confirmarGuardarSesion" class="space-y-4">

                <div>
                    <label class="block text-sm font-medium">N° Sesión</label>
                    <input type="number" wire:model="sesion_nro" readonly class="border rounded w-full px-2 py-1">
                    @error('sesion_nro')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Fecha</label>
                    <input type="date" wire:model="fecha_sesion" class="border rounded w-full px-2 py-1">
                    @error('fecha_sesion')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Tratamiento Fisiokinético</label>
                    <textarea wire:model="tratamiento_fisiokinetico" class="border rounded w-full px-2 py-1"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium">Evolución</label>
                    <textarea wire:model="evolucion_sesion" class="border rounded w-full px-2 py-1"></textarea>
                </div>

                <div class="flex justify-between mt-4">
                    <button type="button" @click="modal=false" class="px-3 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        Cancelar
                    </button>

                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        {{ $sesionId ? 'Actualizar sesión' : 'Guardar sesión' }}
                    </button>
                </div>

            </form>

        </div>
    </div>





    <div class="flex justify-start items-center mb-4">
        <div class="flex items-center space-x-2 text-sm text-gray-700">
            {{-- Etiqueta del SELECT --}}
            <label for="perPage" class="font-medium">Mostrar</label>

            {{-- SELECT para el número de sesiones por página --}}
            <select wire:model.live="perPage" id="perPage"
                class="py-1 pl-2 pr-7 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
                {{-- Opciones restauradas --}}
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>

            <span class="text-gray-500">sesiones por página</span>
        </div>

        {{-- 🔑 INFORMACIÓN DE CONTEO TOTAL --}}
        @if ($sesionesFiltradas->total() > 0)
            <span class="ml-auto text-sm text-gray-600 font-medium">
                Mostrando
                <span class="font-bold text-blue-600">{{ $sesionesFiltradas->firstItem() }}</span>
                a
                <span class="font-bold text-blue-600">{{ $sesionesFiltradas->lastItem() }}</span>
                de
                <span class="font-bold text-blue-600">{{ $sesionesFiltradas->total() }}</span>
                sesiones totales.
                {{-- 🔑 Se agrega la información de la página actual --}}
                (Página <span class="font-bold text-blue-600">{{ $sesionesFiltradas->currentPage() }}</span>)
            </span>
        @endif
    </div>
    {{-- TABLA DE SESIONES --}}
    <div class="bg-white shadow p-4 rounded">
        <h3 class="font-semibold mb-3">Listado de Sesiones</h3>
        {{-- BOTÓN ELIMINAR SELECCIONADOS --}}
        @role('super-admin')
            @if (count($seleccionados) > 0)
                <button onclick="confirmarEliminacionMasiva()"
                    class="mb-3 px-3 py-1.5 bg-red-600 text-white text-sm rounded shadow hover:bg-red-700 transition">
                    Eliminar seleccionados ({{ count($seleccionados) }})
                </button>
            @endif
        @endrole

        <table class="w-full text-left border">
            <thead class="bg-gray-100">
                <tr>
                    {{-- CHECKBOX SELECT ALL (solo página actual) --}}
                    @role('super-admin')
                        <th class="px-2 py-1 border w-10 text-center">
                            {{-- Intenta con .live para forzar la actualización visual --}}
                            <input type="checkbox" wire:model.live="selectAll">
                        </th>
                    @endrole
                    {{-- Se añade un <th> vacío si no es super-admin para mantener la estructura de la tabla --}}
                    @unlessrole('super-admin')
                        <th class="px-2 py-1 border w-10 text-center"></th>
                    @endunlessrole

                    <th class="px-2 py-1 border">Fecha</th>
                    <th class="px-2 py-1 border">Tratamiento</th>
                    <th class="px-2 py-1 border">Evolución</th>
                    <th class="px-2 py-1 border">Estado</th>
                    <th class="px-2 py-1 border">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($sesionesFiltradas as $sesion)
                    <tr class="{{ $sesion->firma_paciente_digital == 0 ? 'bg-green-50' : 'bg-red-50' }}">

                        {{-- CHECKBOX INDIVIDUAL (Solo para Super-Admin) --}}
                        @role('super-admin')
                            <td class="border px-2 py-1 text-center">
                                <input type="checkbox" wire:model.live="seleccionados" value="{{ $sesion->id }}">
                            </td>
                        @endrole
                        {{-- Celda vacía para usuarios sin permiso, manteniendo el diseño de la tabla --}}
                        @unlessrole('super-admin')
                            <td class="border px-2 py-1 text-center"></td>
                        @endunlessrole


                        {{-- Resto de columnas (sin cambios) --}}
                        <td class="border px-2 py-1">
                            {{ Carbon\Carbon::parse($sesion->fecha_sesion)->format('d/m/Y') }}</td>
                        <td class="border px-2 py-1">{{ $sesion->tratamiento_fisiokinetico }}</td>
                        <td class="border px-2 py-1">{{ $sesion->evolucion_sesion }}</td>
                        <td class="border px-2 py-1">
                            @if ($sesion->firma_paciente_digital == 0)
                                <span
                                    class="flex items-center gap-1 px-2 py-0.5 text-xs bg-green-100 text-green-700 rounded-full">
                                    <span class="w-2 h-2 bg-green-600 rounded-full"></span> Activa
                                </span>
                            @else
                                <span
                                    class="flex items-center gap-1 px-2 py-0.5 text-xs bg-red-100 text-red-700 rounded-full">
                                    <span class="w-2 h-2 bg-red-600 rounded-full"></span> Inactiva
                                </span>
                            @endif
                        </td>
                        <td class="border px-2 py-1 flex gap-2">
                            <button wire:click="editarSesion({{ $sesion->id }})" @click="modal=true"
                                class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition text-xs">
                                Editar
                            </button>

                            {{-- BOTÓN ELIMINAR INDIVIDUAL (Ya estaba correctamente envuelto) --}}
                            @role('super-admin')
                                <button onclick="confirmarEliminarSesion({{ $sesion->id }})"
                                    class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition text-xs">
                                    Eliminar
                                </button>
                            @endrole
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- </div> --}}


        {{-- 🔑 LINKS DEL PAGINADOR: Usar la variable de las sesiones filtradas --}}
        <div class="mt-4">
            {{-- ✅ CORRECCIÓN: Añade data: ['scrollTo' => false] --}}
            {{ $this->sesionesFiltradas->links(data: ['scrollTo' => false]) }}
        </div>
    </div>

    {{-- El bloque anterior que tenías de $pdfsList era redundante y se eliminó --}}

    {{-- BOTONES --}}
    <div class="mt-6 flex justify-end gap-4">
        {{-- Botón Finalizar Sesión --}}
        <button wire:click="finalizarSerie"
            class="bg-blue-700 text-white px-4 py-2 rounded shadow hover:bg-blue-800 transition">
            Finalizar Sesión
        </button>

        {{-- Botón Ver Historial de Fichas --}}
        <a href="{{ route('kinesiologia.ficha-kinesiologica-index', ['paciente' => $paciente->id]) }}"
            class="bg-green-600 text-white px-6 py-2 rounded-xl shadow-lg hover:bg-green-700 transition duration-150 transform hover:scale-105 flex items-center">
            Ver Historial de Fichas
        </a>

        {{-- Ver PDF --}}
        <a href="{{ route('kinesiologia.sesiones', [
            'paciente' => $paciente->id,
            'estado' => request('estado', 'activas'),
            'limite' => request('limite', 10),
        ]) }}"
            class="bg-gray-700 text-white px-6 py-2 rounded-xl shadow-lg hover:bg-gray-800 transition duration-150 transform hover:scale-105 flex items-center">
            Ver Sesiones (PDF)
        </a>
        {{-- Fin PDF --}}
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

    // *** NUEVO: Confirmación para eliminar ***
    function confirmarEliminarSesion(id) {
        Swal.fire({
            title: "¿Eliminar sesión?",
            text: "Esta acción no se puede deshacer.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DC2626",
            cancelButtonColor: "#6B7280",
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('eliminarSesionConfirmada', {
                    id: id
                });
            }
        });
    }
</script>
{{-- AÑADE ESTE BLOQUE DE SCRIPT AL FINAL DE TU COMPONENTE O EN EL LAYOUT --}}
<script>
    function confirmarEliminacionMasiva() {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar sesiones',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // 🔥 Aquí llamamos al método de Livewire SOLO si el usuario confirma
                Livewire.dispatch('confirmarEliminacionMasiva');
            }
        });
    }
</script>
