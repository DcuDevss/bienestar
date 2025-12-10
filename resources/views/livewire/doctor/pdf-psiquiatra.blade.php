<div class="p-4 bg-white rounded shadow-md max-w-lg mx-auto mt-4">



    <div class="mb-4 flex justify-center">
        <img src="{{ asset('assets/guardarPdf.png') }}" alt="Descripción de la imagen"
            class="h-24 w-auto object-contain" />
    </div>

    {{-- Formulario de subida --}}
    <form wire:submit.prevent="uploadPdfs" class="mb-6" enctype="multipart/form-data">
        <label class="block mb-2 font-semibold text-center text-gray-600 w-full" for="pdfs">Adjuntar PDFs
            Psiquiatra</label>
        <input type="file" id="pdfs" wire:model="pdfs" multiple accept="application/pdf"
            class="block w-full border rounded p-2" />

        {{-- Validación --}}
        @error('pdfs.*')
            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
        @enderror

        <button type="submit" class="mt-3 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
            wire:loading.attr="disabled" wire:target="uploadPdfs">
            Subir PDFs
        </button>
    </form>

    {{-- Historial de PDFs --}}
    {{-- Historial de PDFs (psiquiatra) --}}
    <h3 class="text-lg font-semibold mb-3">Historial de PDFs</h3>

    @if ($pdfsList->isEmpty())
        <p class="text-gray-600">No hay PDFs adjuntados por el psiquiatra.</p>
    @else
        <ul class="list-disc list-inside space-y-2">
            @foreach ($pdfsList as $pdf)
                <li class="flex items-center justify-between">
                    <a href="{{ route('pdf.show', ['filename' => basename($pdf->filepath), 'pid' => $paciente->id]) }}"
                        target="_blank" class="text-blue-600 hover:text-blue-400 font-semibold">
                        {{ $pdf->filename }}
                    </a>
                    <button x-data
                        @click.prevent="
                    Swal.fire({
                    title: '¿Eliminar PDF?',
                    text: 'Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true,
                    }).then((r) => {
                    if (r.isConfirmed) { $wire.eliminarPdf({{ $pdf->id }}) }
                    })
                "
                        class="ml-4 px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition text-sm">
                        Eliminar
                    </button>
                </li>
            @endforeach
        </ul>
    @endif


    <div class="flex justify-center mb-2 mt-4">
        <button type="button" onclick="window.history.back()"
            class="px-4 py-2 bg-gray-500 text-white rounded-md shadow-md hover:bg-gray-600 focus:outline-none">
            Volver
        </button>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('livewire:init', () => {
        // Toast/alert genérico
        Livewire.on('swal', function() {
            let payload = {};
            if (arguments.length === 1 && typeof arguments[0] === 'object' && !Array.isArray(arguments[
                    0])) {
                payload = arguments[0];
            } else {
                payload = {
                    title: arguments[0] ?? '',
                    text: arguments[1] ?? '',
                    icon: arguments[2] ?? 'info'
                };
            }
            const {
                title = 'Listo', text = '', html = null, icon = 'success', timer = 3000
            } = payload;

            Swal.fire({
                title,
                text,
                html,
                icon,
                timer,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timerProgressBar: true,
            });
        });

        // Confirmación con acción -> llama directo al método Livewire del componente actual
        Livewire.on('confirm', ({
            title = '¿Estás seguro?',
            text = '',
            icon = 'warning',
            confirmText = 'Confirmar',
            cancelText = 'Cancelar',
            id = null
        } = {}) => {
            Swal.fire({
                title,
                text,
                icon,
                showCancelButton: true,
                confirmButtonText: confirmText,
                cancelButtonText: cancelText,
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed && id) {
                    // 👇 Llamada directa al método del componente
                    @this.call('eliminarPdf', id);
                }
            });
        });
    });
</script>
