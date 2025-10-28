<div class="padreTablas flex gap-x-2 px-6 mb-8">

    <section class="seccionTab xl:mx-auto lg:mx-auto w-[95%]">
        <div class="mx-auto text-[12px]">

            <div class="bg-gray-800 shadow-md sm:rounded-lg">

                {{-- Título --}}
                <div class="px-4 py-3 border-b border-gray-700">
                    <h4 class="text-lg font-bold text-white">Pacientes Eliminados (Papelera)</h4>
                </div>

                {{-- Área de búsqueda --}}
                <div class="flex items-center justify-between d p-4">
                    <div class="w-fit relative">
                        <div class="absolute pl-2 mt-2 flex items-center pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input wire:model.live.debounce.300ms="search" type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-1 pt-1"
                            placeholder="Buscar paciente eliminado...">
                    </div>
                </div>

                {{-- Tabla --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-gray-500">
                        <thead class="text-xs text-white uppercase bg-gray-900">
                            <tr class="text-[14px]">
                                <th scope="col" class="px-4 py-3">Apellido y Nombre</th>
                                <th scope="col" class="px-4 py-3">DNI</th>
                                <th scope="col" class="px-4 py-3">Legajo</th>
                                <th scope="col" class="px-4 py-3">Jerarquía</th>
                                <th scope="col" class="px-4 py-3">Destino</th>
                                <th scope="col" class="px-4 py-3">Ciudad</th>
                                <th scope="col" class="px-4 py-3">Revista</th>
                                <th scope="col" class="px-4 py-3 text-center">Eliminado</th>
                                <th scope="col" class="px-4 py-3 text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pacientesEliminados as $paciente)
                                <tr wire:key="deleted-{{ $paciente->id }}"
                                    class="border-b border-gray-700 hover:bg-[#204060]">
                                    <th
                                        class="tiBody px-4 py-1 text-[14px] font-medium text-white whitespace-normal min-w-[200px]">
                                        {{ $paciente->apellido_nombre }}
                                    </th>
                                    <td class="tiBody px-4 py-1 text-[14px] text-gray-300">{{ $paciente->dni }}</td>
                                    <td class="tiBody px-4 py-1 text-[14px] text-gray-300">{{ $paciente->legajo }}</td>
                                    <td class="tiBody px-4 py-1 text-[14px] text-gray-300">
                                        {{ $paciente->jerarquia_id ? $paciente->jerarquias->name : 'No asignado' }}
                                    </td>
                                    <td class="tiBody px-4 py-1 text-[14px] text-gray-300">
                                        {{ $paciente->destino_actual }}</td>
                                    <td class="tiBody px-4 py-1 text-[14px] text-gray-300">{{ $paciente->ciudad }}</td>
                                    <td class="tiBody px-2 py-1 text-[14px]">
                                        @if ($paciente->estado_id == 1)
                                            <span
                                                class="bg-green-600 text-white rounded-md px-4 py-2 text-md text-center inline-block">{{ $paciente->estados->name }}</span>
                                        @elseif ($paciente->estado_id == 2)
                                            <span
                                                class="text-white bg-gray-600 rounded-md px-4 py-2 text-md text-center inline-block">{{ $paciente->estados->name }}</span>
                                        @elseif ($paciente->estado_id == 3)
                                            <span
                                                class="text-black bg-yellow-400 rounded-md px-4 py-2 text-md text-center inline-block">{{ $paciente->estados->name }}</span>
                                        @elseif ($paciente->estado_id == 4)
                                            <span
                                                class="text-white bg-red-700 rounded-md px-4 py-2 text-md text-center inline-block">{{ $paciente->estados->name }}</span>
                                        @elseif ($paciente->estado_id == 5)
                                            <span
                                                class="text-white bg-black rounded-md px-4 py-2 text-md text-center inline-block">{{ $paciente->estados->name }}</span>
                                        @else
                                            <span class=""></span>
                                        @endif
                                    </td>
                                    <td class="tiBody px-4 py-3 text-[14px] text-gray-300 text-center">
                                        {{ \Carbon\Carbon::parse($paciente->deleted_at)->format('d-m-Y') }}
                                    </td>
                                    <td class="tiBody px-4 py-1 text-[14px] text-center relative">
                                        {{-- Botón Restaurar --}}
                                        <!-- Botón Restaurar con Alpine -->
                                        <div x-data>
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
                    Swal.fire('✅ Restaurado', 'El paciente ha sido restaurado correctamente.', 'success');
                }
            });
        "
                                                class="ml-2 px-4 py-2 text-[12px] font-medium uppercase bg-gray-600 hover:bg-gray-500 text-white rounded">
                                                Restaurar
                                            </button>
                                        </div>

                                       @role('super-admin')
<div x-data>
    <button
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
                    Swal.fire('🗑️ Eliminado', 'El paciente ha sido eliminado permanentemente.', 'success');
                }
            });
        "
        class="ml-2 px-4 py-2 text-[12px] font-medium uppercase bg-red-700 hover:bg-red-600 text-white rounded"
    >
        Borrar
    </button>
</div>
@endrole

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-4 text-center text-gray-400">No hay pacientes en
                                        la papelera.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                <div class="py-4 px-5">
                    {{ $pacientesEliminados->links() }}
                </div>

            </div>

        </div>
    </section>
</div>
