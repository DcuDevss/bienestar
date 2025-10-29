<div class="p-4 bg-white rounded shadow-md max-w-3xl mx-auto mt-4">

    {{-- buscador --}}
    <div class="mb-4 flex items-center gap-2">
        <input wire:model.live.debounce.300ms="search" type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-1 pt-1"
                            placeholder="Buscar..."
               class="w-full border rounded p-2">
                <select wire:model="perPage" class="border rounded p-2 pr-8 min-w-[4.5rem]">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                </select>
    </div>

    <h3 class="text-lg font-semibold mb-3">Historial de PDFs</h3>

    @if($total === 0)
        <p class="text-gray-600">No hay PDFs adjuntados para este paciente.</p>
    @else
        <ul class="space-y-2">
            @foreach ($itemsPage as $item)
                <li class="flex items-center justify-between bg-gray-50 rounded px-3 py-2">
                    <div class="min-w-0">
                        <a href="{{ route('pdf.show', ['filename' => $item['filename'], 'pid' => $pacienteId]) }}"
                        target="_blank"
                        class="text-blue-600 hover:text-blue-400 font-semibold truncate block">
                        📄 {{ $item['display'] }}
                        </a>


                        <span class="text-xs text-gray-500">
                            Fuente: {{ $item['source'] }}
                            @php
                                $ts = $item['modified'];
                                echo $ts ? ' · ' . \Carbon\Carbon::createFromTimestamp($ts)->format('d/m/Y H:i') : '';
                            @endphp
                        </span>
                    </div>

                    <div class="flex items-center gap-2">
                        <button wire:click="download('{{ $item['path'] }}')"
                                class="px-2 py-1 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">
                            Descargar
                        </button>
                      <button
                        x-data
                        @click.prevent="
                            Swal.fire({
                            title: '¿Eliminar archivo?',
                            text: 'Esta acción no se puede deshacer.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Sí, eliminar',
                            cancelButtonText: 'Cancelar',
                            reverseButtons: true
                            }).then((r) => {
                            if (r.isConfirmed) {
                                $wire.deleteByPath('{{ $item['path'] }}').then(() => {
                                Swal.fire({
                                    title: 'Eliminado',
                                    text: 'El archivo fue eliminado correctamente.',
                                    icon: 'success',
                                    timer: 1800,
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timerProgressBar: true
                                });
                                });
                            }
                            });
                        "
                        class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                        Eliminar
                    </button>
                    </div>
                </li>
            @endforeach
        </ul>

        {{-- paginación simple --}}
        <div class="flex items-center justify-between mt-4">
            <button wire:click="prevPage" class="px-3 py-1 bg-gray-200 rounded disabled:opacity-50"
                    @disabled($page <= 1)>
                ← Anterior
            </button>
            <span class="text-sm text-gray-600">Página {{ $page }}</span>
            <button wire:click="nextPage" class="px-3 py-1 bg-gray-200 rounded disabled:opacity-50"
                    @disabled($page * $perPage >= $total)>
                Siguiente →
            </button>
        </div>
    @endif

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('confirmDelete', (filename) => ({
            confirm() {
                Swal.fire({
                    title: '¿Eliminar archivo?',
                    text: "Esta acción no se puede deshacer.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $wire.delete(filename);
                        Swal.fire({
                            title: 'Eliminado',
                            text: 'El archivo fue eliminado correctamente.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end'
                        });
                    }
                });
            }
        }))
    });
</script>
