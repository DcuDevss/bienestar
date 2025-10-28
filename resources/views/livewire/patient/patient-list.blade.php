<div class="padreTablas  gap-x-2 px-6 mb-8">
    {{-- TABLA PACIENTES --}}
    <section class="seccionTab xl:mx-auto lg:mx-auto w-[95%]">
        <div class="mx-auto text-[12px]">
            <!-- Start coding here -->
            <div class="bg-gray-800  shadow-md sm:rounded-lg ">
                <div class="flex items-center justify-between d p-4">
                    <div class="flex flex-row items-end justify-between w-full">
                        {{-- BOTON BUSCAR --}}
                        <div class="w-fit">
                            <div class="absolute pl-2 mt-2 flex items-center pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor"
                                    viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input wire:model.live.debounce.300ms="search" type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-1 pt-1"
                                placeholder="Buscar..." required="">
                        </div>
                        {{-- BOTON RESET ALL --}}
                        @role('super-admin')
                            <div class="">
                                <livewire:interview.interview-reset-all />
                            </div>
                        @endrole
                        <!-- BOTON AGREGAR -->
                        <div class="">
                            <a href="{{ route('multiform.index') }}"
                                class="pr-3 pl-2 py-2 text-white bg-[#2d5986] rounded-md hover:text-white hover:bg-[#3973ac]">
                                <span class="text-[20px]">+ </span>
                                <span class="agre text-[13px]">AGREGAR</span>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- TABLA  --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-gray-500 ">
                        <thead class=" text-xs text-white uppercase bg-gray-900">
                            <tr class="teGead text-[14px]">
                                {{-- <th scope="col" class="px-4 py-3">N°</th> --}}
                                <th scope="col" class="px-4 py-3">Apellido y nombre</th>
                                <th scope="col" class="px-4 py-3">DNI</th>
                                <th scope="col" class="px-4 py-3">legajo</th>
                                <th scope="col" class="px-4 py-3">Jerarquia</th>
                                <th scope="col" class="px-4 py-3">Destino</th>
                                <th scope="col" class="px-4 py-3">Ciudad</th>
                                {{--                                 {{-- <th scope="col" class="px-4 py-3">Estado</th>
                                <th scope="col" class="px-4 py-3">Email</th>
                                <th scope="col" class="px-4 py-3">Celular</th> --}}
                                <th scope="col" class="px-4 py-3">Revista</th>
                                <th scope="col" class="px-4 py-3">Finalizacion licencia</th>
                                <th scope="col" class="px-4 py-3">Accion</th>
                                <th scope="col" class="px-3 py-3">Entrevista</th>
                            </tr>
                        </thead>
                        <tbody class="">
                            @foreach ($pacientes as $paciente)
                                <tr wire:key="{{ $paciente->id }}" class="border-b border-gray-700 hover:bg-[#204060]">
                                    {{-- <th class="tiBody px-4 py-1 text-[14px] font-medium text-white whitespace-nowrap dark:text-white">
                                        {{ $paciente->id }}</th> --}}
                                    <th
                                        class="tiBody px-4 py-1 text-[14px] font-medium text-white whitespace-normal min-w-[200px] dark:text-white">
                                        {{ $paciente->apellido_nombre }}</th>
                                    <td class="tiBody px-4 py-1 text-[14px] text-gray-300">{{ $paciente->dni }}</td>
                                    <td class="tiBody px-4 py-1 text-[14px] text-gray-300">{{ $paciente->legajo }}</td>
                                    <td class="tiBody px-4 py-1 text-[14px] text-gray-300">
                                        {{ $paciente->jerarquia_id ? $paciente->jerarquias->name : 'No asignado' }}</td>
                                    <td class="tiBody px-4 py-1 text-[14px] text-gray-300">
                                        {{ $paciente->destino_actual }}</td>
                                    <td class="tiBody px-4 py-1 text-[14px] text-gray-300 text-center">
                                        {{ $paciente->ciudad_id ? $paciente->ciudades->nombre : 'No asignado' }}</td>
                                    <td class="tiBody px-2 py-1 text-[14px]">
                                        @if ($paciente->estado_id == 1)
                                            <span
                                                class="bg-green-600 text-white rounded-md px-4 py-2 text-md text-center inline-block">{{ $paciente->estados->name }}</span>
                                            <!-- Color por defecto -->
                                        @elseif ($paciente->estado_id == 2)
                                            <span
                                                class="text-white bg-gray-600 rounded-md px-4 py-2 text-md text-center inline-block">{{ $paciente->estados->name }}</span>
                                            <!-- Color rojo medio -->
                                        @elseif ($paciente->estado_id == 3)
                                            <span
                                                class="text-black bg-yellow-400 rounded-md px-4 py-2 text-md text-center inline-block">{{ $paciente->estados->name }}</span>
                                            <!-- Color azul -->
                                        @elseif ($paciente->estado_id == 4)
                                            <span
                                                class="text-white bg-red-700 rounded-md px-4 py-2 text-md text-center inline-block">{{ $paciente->estados->name }}</span>
                                            <!-- Color rojo fuerte -->
                                        @elseif ($paciente->estado_id == 5)
                                            <span
                                                class="text-white bg-black rounded-md px-4 py-2 text-md text-center inline-block">{{ $paciente->estados->name }}</span>
                                            <!-- Color amarillo -->
                                        @else
                                            <span class=""></span>
                                            <!-- Color por defecto para otros casos -->
                                        @endif
                                    <td
                                        class="tiBody px-4 py-3
                                        @php $ultimaEnfermedad = $paciente->disases->last(); @endphp
                                        @if ($ultimaEnfermedad && $ultimaEnfermedad->pivot && $ultimaEnfermedad->pivot->fecha_finalizacion_licencia) @php
                                                $fechaFinalizacionLicencia = \Carbon\Carbon::parse($ultimaEnfermedad->pivot->fecha_finalizacion_licencia);
                                            @endphp
                                            @if ($fechaFinalizacionLicencia->startOfDay() == \Carbon\Carbon::now()->startOfDay())
                                                bg-yellow-200 bg-opacity-50 rounded-md animate-pulse /* Amarillo con transparencia y animación de pulso */ @endif
                                        @endif
                                        font-semibold text-xs text-white uppercase tracking-widest focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition">
                                        @if ($ultimaEnfermedad && $ultimaEnfermedad->pivot && $ultimaEnfermedad->pivot->fecha_finalizacion_licencia)
                                            {{ \Carbon\Carbon::parse($ultimaEnfermedad->pivot->fecha_finalizacion_licencia)->format('d-m-Y H:i:s') }}
                                        @else
                                            Sin fecha
                                        @endif
                                    </td>

                                    <td class="tiBody px-4 py-1 text-[14px] relative">
                                        <!-- Botón de opciones (Desplegable) -->
                                        <button onclick="toggleDropdown(event, {{ $paciente->id }})"
                                            class="ml-2 px-4 py-2 text-[12px] font-medium uppercase bg-gray-600 hover:bg-gray-500 text-white rounded">
                                            Opciones
                                        </button>

                                        <!-- Menú desplegable -->
                                        <div id="dropdown-{{ $paciente->id }}"
                                            class="hidden absolute bg-white shadow-lg rounded-lg mt-1 right-0 z-10 w-auto">
                                            <!-- Opción Editar -->
                                            <a href="{{ route('patient.edit', $paciente->id) }}"
                                                class="block px-4 py-2 text-[12px] font-medium uppercase text-white bg-gray-700 hover:bg-gray-400">
                                                Editar
                                            </a>
                                            <!-- Opción Eliminar -->
                                       @role('super-admin')
                                            <button
                                            type="button"
                                            x-data="{ nombre: @js($paciente->apellido_nombre) }"
                                            x-on:click="
                                                Swal.fire({
                                                title: '¿Eliminar paciente?',
                                                html: `Se eliminará <b>${nombre}</b>. Esta acción no se puede deshacer.`,
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonText: 'Sí, eliminar',
                                                cancelButtonText: 'Cancelar',
                                                reverseButtons: true,
                                                focusCancel: true
                                                }).then((res) => {
                                                if (res.isConfirmed) {
                                                    $wire.delete({{ $paciente->id }})
                                                    .then(() => {
                                                        Swal.fire({
                                                        icon: 'success',
                                                        title: 'Eliminado',
                                                        text: `Se eliminó ${nombre}.`,
                                                        timer: 1800,
                                                        showConfirmButton: false,
                                                        toast: true,
                                                        position: 'top-end'
                                                        });
                                                    })
                                                    .catch(() => {
                                                        Swal.fire({
                                                        icon: 'error',
                                                        title: 'Error',
                                                        text: 'No se pudo eliminar el paciente.'
                                                        });
                                                    });
                                                }
                                                });
                                            "
                                            class="block px-4 py-2 text-[12px] font-medium uppercase text-white bg-red-700 hover:bg-red-600">
                                            Eliminar
                                            </button>
                                        @endrole
                                        </div>
                                    </td>


                                    <td class="tiBody px-4 py-1 text-[14px]">
                                        <a class="ml-3 px-4 py-1 rounded-md bg-[#2d5986] text-white  hover:bg-[#3973ac]"
                                            href="{{ route('interviews.index', ['paciente' => $paciente->id]) }}">
                                            {{ __('Ir') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- PAGINATION --}}
                <div class="py-4 px-5">
                    <div class="flex">
                        <div class="flex space-x-4 items-center mb-3">
                            <label class="text-sm font-medium text-white">Mostrar</label>
                            <select wire:model.live='perPage'
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block">
                                <option value="6">6</option>
                                <option value="8">8</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    {{ $pacientes->links() }}
                </div>
            </div>
        </div>
    </section>

    <section class="seccionTab2 w-fit">@livewire('patient.patient-list-fechas')
        <div class="bg-white rounded-md shadow-md p-4 mt-4 w-full text-sm max-h-[36rem] overflow-y-auto">
            <h2 class="text-lg font-bold mb-2 text-gray-700">Pacientes por Tipo de Licencia</h2>

            @foreach ($agrupadosPorLicencia as $licencia)
                <div class="mb-3">
                    <h3 class="font-semibold text-blue-600">{{ $licencia->name }}</h3>
                    <ul class="list-disc list-inside">
                        @forelse ($licencia->disases_paciente as $dp)
                            <li class="text-gray-700">

                                {{ $dp->paciente->jerarquias->name ?? 'Sin jerarquía' }}
                                - {{ $dp->paciente->apellido_nombre ?? 'Paciente no encontrado' }}
                                - Finaliza:
                                {{ \Carbon\Carbon::parse($dp->fecha_finalizacion_licencia)->format('d/m/Y') }}
                            </li>
                        @empty
                            <li class="text-gray-500">Sin pacientes registrados</li>
                        @endforelse
                    </ul>
                </div>
            @endforeach
        </div>
    </section>
</div>


</div>
<script>
    function toggleDropdown(event, patientId) {
        // Cerrar cualquier otro dropdown abierto
        const dropdowns = document.querySelectorAll('[id^="dropdown-"]');
        dropdowns.forEach(function(dropdown) {
            if (dropdown.id !== `dropdown-${patientId}`) {
                dropdown.classList.add('hidden');
            }
        });

        // Toggle (mostrar/ocultar) el dropdown del paciente actual
        const dropdown = document.getElementById(`dropdown-${patientId}`);
        dropdown.classList.toggle('hidden');
    }
</script>
{{-- script sweet alert --}}
<script>
    document.addEventListener('livewire:init', () => {
    // Confirmación genérica (para dispatch('confirm'))
    Livewire.on('confirm', (data) => {
        Swal.fire({
        title: data.title ?? '',
        text: data.text ?? '',
        html: data.html ?? null,
        icon: data.icon ?? 'question',
        showCancelButton: true,
        confirmButtonText: data.confirmText ?? 'Confirmar',
        cancelButtonText: data.cancelText ?? 'Cancelar',
        reverseButtons: true,
        focusCancel: true,
        }).then((result) => {
        if (result.isConfirmed && data.action) {
            const p = data.params || {};
            Livewire.dispatch(data.action, p.id ?? p);
        }
        });
    });

    // Toast/alert genérico (para dispatch('swal'))
    Livewire.on('swal', (data) => {
        Swal.fire({
        title: data.title ?? '',
        text: data.text ?? '',
        html: data.html ?? null,
        icon: data.icon ?? 'info',
        timer: data.timer ?? 2000,
        toast: true,
        position: data.position ?? 'top-end',
        showConfirmButton: false,
        });
    });
    });
</script>
