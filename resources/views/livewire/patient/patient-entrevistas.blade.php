<div class="padreTablas flex gap-x-2 px-6">
    <section class="seccionTab xl:mx-auto lg:mx-auto w-[95%]">
        <div class="mx-auto text-[12px]">
            <div class="bg-gray-800 shadow-md sm:rounded-lg">
                <!-- Búsqueda con wire:model -->
                <div class="flex items-center justify-between p-4">
                    <div class="w-fit">
                        <div class="absolute pl-2 mt-2 flex items-center pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <!-- Campo de búsqueda con wire:model directamente -->
                        <input wire:model.debounce.300ms="search" type="text"
                            class="bg-gray-50 border border-gray-300 mb-2 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-1 pt-1"
                            placeholder="Buscar..." required="" wire:keydown.enter="resetPage">
                        <input type="text" wire:model.debounce.300ms="poseeArmaFilterDisplay"
                            placeholder="'Posee arma ?'" value="{{ $poseeArmaFilterDisplay }}"
                            wire:keydown.enter="resetPage"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-1 pt-1">
                    </div>
                </div>

                @if ($entrevistas->isEmpty())
                    <div class="text-center text-xs uppercase px-4 py-3 text-white">
                        <p>No hay resultados para esta búsqueda.</p>
                    </div>
                @else
                    <!-- Tabla -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-center text-gray-500">
                            <thead class="text-xs text-white uppercase bg-gray-900">
                                <tr class="teGead text-[14px]">
                                    <th scope="col" class="px-4 py-3">N°</th>
                                    <th scope="col" class="px-4 py-3">Jerarquía</th>
                                    <th scope="col" class="px-4 py-3">Nombre</th>
                                    <th scope="col" class="px-4 py-3">Revista</th>
                                    <th scope="col" class="px-4 py-3">Fecha/hora de Entrevista</th>
                                    <th scope="col" class="px-4 py-3">Tipo de Entrevista</th>
                                    <th scope="col" class="px-4 py-3">Posee Arma</th>
                                    <th scope="col" class="px-4 py-3">Estado</th>
                                    <th scope="col" class="px-4 py-3">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entrevistas as $entrevista)
                                    <tr class="border-b border-gray-700 hover:bg-[#204060]">
                                        <td class="text-center px-4 py-3 text-white">{{ $entrevista->paciente_id }}</td>
                                        <td class="text-center px-4 py-3 text-white">
                                            {{ $entrevista->paciente->jerarquias->name ?? 'N/A' }}</td>
                                        <td class="text-center px-4 py-3 text-white">
                                            {{ $entrevista->paciente->apellido_nombre }}</td>
                                        <td class="tiBody px-2 py-1 text-[14px]">
                                            @if ($entrevista->estado_id == 1)
                                                <span class="bg-green-600 text-white rounded-md px-4 py-2 text-md text-center inline-block">
                                                    {{ $entrevista->estado_nombre }}
                                                </span>
                                            @elseif ($entrevista->estado_id == 2)
                                                <span class="text-white bg-gray-600 rounded-md px-4 py-2 text-md text-center inline-block">
                                                    {{ $entrevista->estado_nombre }}
                                                </span>
                                            @elseif ($entrevista->estado_id == 3)
                                                <span class="text-black bg-yellow-400 rounded-md px-4 py-2 text-md text-center inline-block">
                                                    {{ $entrevista->estado_nombre }}
                                                </span>
                                            @elseif ($entrevista->estado_id == 4)
                                                <span class="text-white bg-red-700 rounded-md px-4 py-2 text-md text-center inline-block">
                                                    {{ $entrevista->estado_nombre }}
                                                </span>
                                            @elseif ($entrevista->estado_id == 5)
                                                <span class="text-white bg-black rounded-md px-4 py-2 text-md text-center inline-block">
                                                    {{ $entrevista->estado_nombre }}
                                                </span>
                                            @else
                                                <span class="text-gray-500">Sin estado</span>
                                            @endif
                                        </td>
                                        <td class="text-center px-4 py-3 text-white">{{ $entrevista->created_at }}</td>
                                        <td class="text-center px-4 py-3 text-white">
                                            {{ $entrevista->tipoEntrevista->name ?? 'N/A' }}</td>
                                        <td class="text-center px-4 py-3">
                                            <span
                                                class="inline-block px-2 py-1 text-xs font-semibold
                                        {{ $entrevista->posee_arma ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                                {{ $entrevista->posee_arma ? 'Sí' : 'No' }}
                                            </span>
                                        </td>
                                        <td class="text-center px-4 py-3">
                                            @if ($entrevista->estadoEntrevista)
                                                @php
                                                    $estado = $entrevista->estadoEntrevista;
                                                    $color = match ($estado->id) {
                                                        1 => 'bg-green-500',
                                                        2 => 'bg-red-500',
                                                        3 => 'bg-orange-500',
                                                        default => 'bg-gray-500',
                                                    };
                                                @endphp
                                                <span
                                                    class="inline-block px-2 py-1 text-xs font-semibold {{ $color }} text-white">
                                                    {{ $estado->name }}
                                                </span>
                                            @else
                                                <span
                                                    class="inline-block px-2 py-1 text-xs font-semibold bg-gray-500 text-white">
                                                    No disponible
                                                </span>
                                            @endif
                                        </td>
                                        <td class="tiBody px-4 py-1 text-[14px]">
                                            <a class="ml-3 px-4 py-1 text-lg font-extrabold rounded-md bg-[#28cdd3] text-white hover:bg-[#238185]"
                                                href="{{ route('entrevistas.index', ['paciente_id' => $entrevista->paciente_id]) }}">
                                                ->
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </div>
                    @endif

                    <!-- Paginación -->
                    <div class="py-4 px-5">
                        {{ $entrevistas->links() }} <!-- Muestra la paginación de Livewire -->
                    </div>
            </div>
        </div>
    </section>
</div>
