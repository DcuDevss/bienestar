<div class="padreTablas flex gap-x-2 px-6 mb-8">
    <section class="seccionTab xl:mx-auto lg:mx-auto w-[95%]">
        <div class="mx-auto text-[12px]">
            <div class="bg-gray-800 shadow-md sm:rounded-lg">

                {{-- Título --}}
                <div class="px-4 py-3 border-b border-gray-700">
                    <h4 class="text-lg font-bold text-white">Ficha Kinesiológica del Paciente</h4>
                </div>

                {{-- Área superior: Buscar + Mostrar --}}
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between p-4">

                    {{-- Buscar --}}
                    <div class="w-full md:w-1/3 relative mb-2 md:mb-0">
                        <div class="absolute pl-2 mt-2 flex items-center pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>

                        <input wire:model.live.debounce.300ms="search" type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full pl-10 p-2"
                            placeholder="Buscar paciente o jerarquía...">
                    </div>

                    {{-- Mostrar por página --}}
                    <div class="flex items-center gap-2">
                        <label for="perPage" class="text-gray-400 text-[14px]">Mostrar</label>
                        <select wire:model.live="perPage" id="perPage"
                            class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg p-1 cursor-pointer">
                            <option value="8">8</option>
                            <option value="15">15</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>

                {{-- Tabla --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-center text-gray-500">
                        <thead class="text-xs text-white uppercase bg-gray-900">
                            <tr class="text-[14px]">
                                <th class="px-4 py-3">Jerarquía</th>
                                <th class="px-4 py-3">Nombre</th>
                                <th class="px-4 py-3">Fecha / Hora de Planilla</th>
                                <th class="px-4 py-3">Estado Sesión</th>
                                <th class="px-4 py-3">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($planillas as $planilla)
                                <tr class="border-b border-gray-700 hover:bg-[#204060]">
                                    <td class="px-4 py-2 text-white">
                                        {{ $planilla->paciente?->jerarquias?->name ?? 'N/D' }}
                                    </td>
                                    <td class="px-4 py-2 text-white">
                                        {{ $planilla->paciente?->apellido_nombre ?? 'Paciente Eliminado' }}
                                    </td>
                                    <td class="px-4 py-2 text-white">
                                        {{ $planilla->created_at->format('d-m-Y H:i:s') }}
                                    </td>

                                    {{-- Columna Estado Sesión - CORRECCIÓN APLICADA AQUÍ --}}
                                    <td class="px-4 py-2">
                                        @php
                                            // Asumimos que $planilla->paciente es el Paciente y tiene la relación sesiones()
                                            $ultimaSesion = $planilla->paciente?->sesiones()->latest('id')->first();
                                        @endphp

                                        @if(is_null($ultimaSesion))
                                            {{-- Caso 1: No hay ninguna sesión registrada --}}
                                            <span class="px-2 py-0.5 text-xs bg-gray-600 text-gray-200 rounded-full">
                                                Sin Registros
                                            </span>
                                        @elseif($ultimaSesion->firma_paciente_digital === 0)
                                            {{-- Caso 2: Última sesión activa (firma_paciente_digital = 0) --}}
                                            <span class="px-2 py-0.5 text-xs bg-green-100 text-green-700 rounded-full">
                                                Activa
                                            </span>
                                        @elseif($ultimaSesion->firma_paciente_digital === 1)
                                            {{-- Caso 3: Última sesión inactiva (firma_paciente_digital = 1) --}}
                                            <span class="px-2 py-0.5 text-xs bg-red-100 text-red-700 rounded-full">
                                                Inactiva
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-2">
                                        <a href="{{ route('kinesiologia.fichas-kinesiologicas-index', ['paciente' => $planilla->paciente_id]) }}"
                                            class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-500 transition">
                                            Ver Planilla
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-4 text-center text-white">
                                        No hay planillas disponibles.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                <div class="p-4 bg-gray-900 border-t border-gray-700 flex flex-col md:flex-row items-center justify-between">
                    <span class="text-gray-400 text-[14px] mb-2 md:mb-0">
                        Mostrando {{ $planillas->firstItem() ?? 0 }} a {{ $planillas->lastItem() ?? 0 }} de {{ $planillas->total() }} resultados
                    </span>
                    <div>
                        {{ $planillas->links() }}
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>