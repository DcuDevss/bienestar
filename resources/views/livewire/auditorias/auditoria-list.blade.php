<div class="padreTablas flex gap-x-2 px-6 mb-8">
    <section class="seccionTab xl:mx-auto lg:mx-auto w-[95%]">
        <div class="mx-auto text-[12px]">
            <div class="bg-gray-800 shadow-md sm:rounded-lg">
                <!-- Cabecera coon buscador -->
                <div class="flex items-center justify-between p-4">
                    <div class="w-fit">
                        <div class="absolute pl-2 mt-2 flex items-center pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input wire:model.live.debounce.300ms="search" type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-1 pt-1"
                            placeholder="Buscar..." />
                    </div>
                </div>

                <!-- Tablaa -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-gray-500">
                        <thead class="text-xs text-white uppercase bg-gray-900">
                            <tr class="teGead text-[14px]">
                                <th scope="col" class="px-4 py-3">Fecha</th>
                                <th scope="col" class="px-4 py-3">Usuario</th>
                                <th scope="col" class="px-4 py-3">Acción</th>
                                <th scope="col" class="px-4 py-3">Detalle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($auditorias as $auditoria)
                                <tr class="border-b border-gray-700 hover:bg-[#204060]">
                                    <td class="tiBody px-4 py-1 text-[14px] text-gray-300">
                                        {{ $auditoria->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="tiBody px-4 py-1 text-[14px] text-gray-300">
                                        {{ $auditoria->user->name ?? 'Sistema' }}
                                    </td>
                                    <td class="tiBody px-4 py-1 text-[14px] font-medium text-white">
                                        {{ $auditoria->accion === 'reset_licencias_global' ? 'Reseteo global de licencias' : $auditoria->accion }}
                                    </td>
                                    <td class="tiBody px-4 py-1 text-[14px] text-gray-300 whitespace-normal">
                                        {{ $auditoria->detalle }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-3 text-center text-gray-400">
                                        No se encontraron registros
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="py-4 px-5">
                    <div class="flex space-x-4 items-center mb-3">
                        <label class="text-sm font-medium text-white">Mostrar</label>
                        <select wire:model.live="perPage"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block">
                            <option value="6">6</option>
                            <option value="8">8</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    {{ $auditorias->links() }}
                </div>
            </div>
        </div>
    </section>
</div>
