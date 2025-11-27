<div class="padreTablas flex gap-x-2 px-6 mb-8">
    <section class="seccionTab xl:mx-auto lg:mx-auto w-[95%]">
        <div class="mx-auto text-[12px]">
            <div class="bg-gray-800 shadow-md sm:rounded-lg">

                {{-- Título --}}
                <div class="px-4 py-3 border-b border-gray-700">
                    <h4 class="text-lg font-bold text-white">Ficha Kinesiológica del Paciente</h4>
                </div>

                {{-- Área superior: Filtros y Paginación --}}
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between p-4">

                    {{-- Contenedor de Búsqueda y Filtro de Estado --}}
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-x-3 w-full md:w-auto">

                        {{-- Buscar --}}
                        <div class="w-full md:w-56 relative mb-2 md:mb-0">
                            <div class="absolute pl-2 mt-2 flex items-center pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>

                            <input wire:model.live.debounce.300ms="search" type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full pl-10 p-2"
                                placeholder="Buscar paciente o jerarquía...">
                        </div>

                        {{-- 🟢 Filtro de Estado de Sesión 🟢 --}}
                        <select wire:model.live="statusFilter" wire:change="resetPage"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2 w-full md:w-56 mb-2 md:mb-0">
                            <option value="">Todos los Estados</option>
                            <option value="activa">Activa</option>
                            <option value="inactiva">Inactiva</option>
                            <option value="sin_registro">Sin Registros</option>
                        </select>

                    </div>

                    {{-- Mostrar por página --}}
                    <div class="flex items-center gap-2 mt-2 md:mt-0">
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
                                    {{-- Jerarquía --}}
                                    <td class="px-4 py-2 text-white">
                                        {{ $planilla->paciente?->jerarquias?->name ?? 'N/D' }}
                                    </td>

                                    {{-- Nombre --}}
                                    <td class="px-4 py-2 text-white">
                                        {{ $planilla->paciente?->apellido_nombre ?? 'Paciente Eliminado' }}
                                    </td>

                                    {{-- Fecha/Hora --}}
                                    <td class="px-4 py-2 text-white">
                                        @php
                                            $created_at_local = $planilla->created_at->setTimezone('America/Argentina/Buenos_Aires');
                                        @endphp
                                        {{ $created_at_local->format('d-m-Y H:i:s') }}
                                    </td>

                                    {{-- Estado Sesión --}}
                                    <td class="px-4 py-2">
                                        @php
                                            $ultimaSesion = $planilla->paciente?->sesiones()->latest('id')->first();
                                            $estadoSesion = 'Sin Registros';
                                            $colorBg = 'bg-gray-600 text-gray-200';

                                            if($ultimaSesion) {
                                                if(intval($ultimaSesion->firma_paciente_digital) === 0){
                                                    $estadoSesion = 'Activa';
                                                    $colorBg = 'bg-green-100 text-green-700';
                                                } else {
                                                    $estadoSesion = 'Inactiva';
                                                    $colorBg = 'bg-red-100 text-red-700';
                                                }
                                            }
                                        @endphp

                                        <span class="px-2 py-0.5 text-xs rounded-full {{ $colorBg }}">
                                            {{ $estadoSesion }}
                                        </span>
                                    </td>

                                    {{-- Acción --}}
                                    <td class="px-4 py-2">
                                        <a href="{{ route('kinesiologia.ficha-kinesiologica-index', ['paciente' => $planilla->paciente?->id]) }}"
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
                        Mostrando {{ $planillas->firstItem() ?? 0 }} a {{ $planillas->lastItem() ?? 0 }} de
                        {{ $planillas->total() }} resultados
                    </span>
                    <div>
                        {{ $planillas->links() }}
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
