<div class="padreTablas flex gap-x-2 px-6 mb-8">

    <section class="seccionTab xl:mx-auto lg:mx-auto w-[95%]">
        <div class="mx-auto text-[12px]">

            <div class="bg-gray-800 shadow-md sm:rounded-lg">

                {{-- Título --}}
                <div class="px-4 py-3 border-b border-gray-700">
                    <h4 class="text-lg font-bold text-white">Pacientes Eliminados (Papelera)</h4>
                </div>

                {{-- ✅ ÁREA SUPERIOR MODIFICADA: Mostrar y Búsqueda --}}
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between p-4">



                    {{-- Área de búsqueda --}}
                    <div class="w-full md:w-fit relative">
                        <div class="absolute pl-2 mt-2 flex items-center pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>

                        <input wire:model.live.debounce.300ms="search" type="text"
                            class="bg-gray-900 border border-gray-600 text-gray-200 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-1 pt-1"
                            placeholder="Buscar paciente eliminado...">
                    </div>
                </div>


                {{-- Tabla --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-gray-400">
                        <thead class="text-xs text-white uppercase bg-gray-900">
                            <tr class="text-[14px]">
                                <th class="px-4 py-3">Apellido y Nombre</th>
                                <th class="px-4 py-3">DNI</th>
                                <th class="px-4 py-3">Legajo</th>
                                <th class="px-4 py-3">Jerarquía</th>
                                <th class="px-4 py-3">Destino</th>
                                <th class="px-4 py-3 text-center">Ciudad</th>
                                <th class="px-4 py-3">Revista</th>
                                <th class="px-4 py-3 text-center">Eliminado</th>
                                <th class="px-4 py-3 text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pacientesEliminados as $paciente)
                                <tr wire:key="deleted-{{ $paciente->id }}"
                                    class="border-b border-gray-700 hover:bg-[#204060]">
                                    <td class="px-4 py-1 text-[14px] font-medium text-white">
                                        {{ $paciente->apellido_nombre }}</td>
                                    <td class="px-4 py-1 text-[14px]">{{ $paciente->dni }}</td>
                                    <td class="px-4 py-1 text-[14px]">{{ $paciente->legajo }}</td>
                                    <td class="px-4 py-1 text-[14px]">
                                        {{ $paciente->jerarquia_id ? $paciente->jerarquias->name : 'No asignado' }}
                                    </td>
                                    <td class="px-4 py-1 text-[14px]">{{ $paciente->destino_actual }}</td>
                                    <td class="px-4 py-1 text-[14px] text-center">
                                        {{ $paciente->ciudad_id ? $paciente->ciudades->nombre : 'No asignado' }}
                                    </td>
                                    <td class="px-2 py-1 text-[14px]">
                                        @if ($paciente->estado_id == 1)
                                            <span
                                                class="bg-green-600 text-white rounded-md px-4 py-1 inline-block">{{ $paciente->estados->name }}</span>
                                        @elseif ($paciente->estado_id == 2)
                                            <span
                                                class="bg-gray-600 text-white rounded-md px-4 py-1 inline-block">{{ $paciente->estados->name }}</span>
                                        @elseif ($paciente->estado_id == 3)
                                            <span
                                                class="bg-yellow-400 text-black rounded-md px-4 py-1 inline-block">{{ $paciente->estados->name }}</span>
                                        @elseif ($paciente->estado_id == 4)
                                            <span
                                                class="bg-red-700 text-white rounded-md px-4 py-1 inline-block">{{ $paciente->estados->name }}</span>
                                        @elseif ($paciente->estado_id == 5)
                                            <span
                                                class="bg-black text-white rounded-md px-4 py-1 inline-block">{{ $paciente->estados->name }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-[14px] text-center">
                                        {{ \Carbon\Carbon::parse($paciente->deleted_at)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-4 py-1 text-[14px] text-center">
                                        <div x-data
                                            x-on:swal.window="
                                            const data = $event.detail;
                                            Swal.fire({
                                                toast: true,
                                                position: 'top-end',
                                                showConfirmButton: false,
                                                timer: 3000,
                                                timerProgressBar: true,
                                                icon: data.icon,
                                                title: data.title,
                                                text: data.text,
                                            });
                                        ">
                                            <div class="flex items-center gap-2 mt-1">
                                                {{-- Botón Restaurar --}}
                                                <button
                                                    x-on:click="
            Swal.fire({
                title: '¿Restaurar paciente?',
                text: '{{ $paciente->apellido_nombre }} será restaurado.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, restaurar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.restore({{ $paciente->id }});
                }
            });
        "
                                                    class="w-24 text-[12px] px-3 py-1 bg-gray-600 hover:bg-gray-500 text-white rounded transition">
                                                    Restaurar
                                                </button>

                                                {{-- Botón Eliminar permanente (solo super-admin) --}}
                                                @role('super-admin')
                                                   {{--  <button
                                                        x-on:click="
                Swal.fire({
                    title: '¿Eliminar permanentemente?',
                    text: 'El paciente {{ $paciente->apellido_nombre }} se eliminará definitivamente.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $wire.forceDelete({{ $paciente->id }});
                    }
                });
            "
                                                        class="w-24 text-[12px] px-3 py-1 bg-red-700 hover:bg-red-600 text-white rounded transition">
                                                        Borrar
                                                    </button> --}}
                                                @endrole
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-4 text-center text-gray-400">
                                        No hay pacientes en la papelera.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- ✅ SECCIÓN INFERIOR MODIFICADA: Paginación y Conteo --}}
                <div class="p-4 bg-gray-900 border-t border-gray-700">
                    {{-- <div class="flex flex-col md:flex-row items-center justify-between text-xs text-gray-400"> --}}


                    {{-- Control Mostrar --}}
                    <div class="flex items-center mb-4 md:mb-0">
                        <label for="perPage" class="text-gray-400 mr-2 text-[14px]">Mostrar</label>
                        {{-- Propiedad perPage del componente Livewire --}}
                        <select wire:model.live="perPage" id="perPage"
                            class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-1 appearance-none cursor-pointer">
                            {{-- Paginacion --}}
                            <option value="8">8</option>
                            <option value="15">15</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                    {{-- <span class="text-sm mb-2 md:mb-0">
                            Mostrando {{ $pacientesEliminados->firstItem() ?? 0 }} a {{ $pacientesEliminados->lastItem() ?? 0 }} de {{ $pacientesEliminados->total() }} resultados
                        </span> --}}

                    {{-- Paginación --}}
                    <div class="w-full md:w-auto">
                        {{ $pacientesEliminados->links() }}
                    </div>

                </div>
            </div>
            {{-- FIN Paginación y Conteo --}}

        </div>
</div>
</section>
</div>
