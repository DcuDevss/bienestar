<div class="p-4 bg-white rounded shadow-md max-w-lg mx-auto mt-4">

    {{-- Imagen de encabezado --}}
    <div class="mb-4 flex justify-center">
        <img src="{{ asset('assets/guardarPdf.png') }}" alt="Subir PDF" class="h-24 w-auto object-contain" />
    </div>

    {{-- Formulario de subida --}}
    <form id="formSubirPdfs" wire:submit.prevent="uploadPdfs" class="mb-6" enctype="multipart/form-data">
        <label class="block mb-2 font-semibold text-center text-gray-600 w-full" for="pdfs">
            Adjuntar PDFs Kinesiología
        </label>

        <input type="file" id="pdfs" wire:model="pdfs" multiple accept="application/pdf"
               class="block w-full border rounded p-2" />

        {{-- Validación --}}
        @error('pdfs.*')
            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
        @enderror

           {{-- Imagen de encabezado --}}
<button type="button"
    class="mt-3 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
    wire:loading.attr="disabled" wire:target="uploadPdfs"
    x-data
    @click.prevent="
        const input = document.getElementById('pdfs');
        if (!input.files.length) {
            Swal.fire({
                title: 'Ningún archivo seleccionado',
                text: 'Por favor, cargá al menos un archivo PDF antes de subir.',
                icon: 'warning',
                confirmButtonText: 'Entendido',
            });
            return;
        }

        Swal.fire({
            title: '¿Subir PDFs?',
            text: '¿Deseás subir los archivos seleccionados?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, subir',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
        }).then((r) => {
            if (r.isConfirmed) { $wire.uploadPdfs() }
        });
    ">
    Subir PDFs
</button>


    </form>

    {{-- Historial de PDFs --}}
    <h3 class="text-lg font-semibold mb-3">Historial de PDFs Kinesiología</h3>

    @php
        $pdfsCollection = collect($pdfsList);
    @endphp

    @if($pdfsCollection->isEmpty())
        <p class="text-gray-600">No hay PDFs adjuntados en Kinesiología.</p>
    @else
        <ul class="list-disc list-inside space-y-2">
            @foreach ($pdfsCollection as $pdf)
                @if(!isset($pdf->filepath))
                    @continue
                @endif

                <li class="flex items-center justify-between">
                    <a href="{{ Storage::url($pdf->filepath) }}"
                       target="_blank"
                       class="text-blue-600 hover:text-blue-400 font-semibold">
                        {{ $pdf->filename }}
                    </a>

                    <button
                        x-data
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

    {{-- Botón Volver --}}
    <div class="flex justify-center mb-2 mt-4">
        <button type="button" onclick="window.history.back()"
                class="px-4 py-2 bg-gray-500 text-white rounded-md shadow-md hover:bg-gray-600 focus:outline-none">
            Volver
        </button>
    </div>
</div>

{{-- SweetAlert y hooks de Livewire --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('livewire:init', () => {

    // 🔔 Mostrar alertas tipo toast desde Livewire (this->dispatch('swal'))
    Livewire.on('swal', (payload) => {
        if (Array.isArray(payload)) payload = payload[0];
        const { title = 'Listo', text = '', html = null, icon = 'success', timer = 3000 } = payload || {};
        const isErrorOrWarning = (icon === 'error' || icon === 'warning');

        Swal.fire({
            title,
            text,
            html,
            icon,
            toast: !isErrorOrWarning,
            position: isErrorOrWarning ? 'center' : 'top-end',
            showConfirmButton: isErrorOrWarning,
            timer: isErrorOrWarning ? null : timer,
            timerProgressBar: !isErrorOrWarning,
        });
    });

    // ✅ Confirmación al subir PDFs
    const btnSubir = document.querySelector('button[wire\\:target="uploadPdfs"]');
    const input = document.getElementById('pdfs');

    if (btnSubir && input) {
        btnSubir.addEventListener('click', (e) => {
            e.preventDefault();

            // ⚠️ Si no hay archivos cargados, mostrar alerta y salir
            if (!input.files.length) {
                Swal.fire({
                    title: 'Ningún archivo seleccionado',
                    text: 'Por favor, cargá al menos un archivo PDF antes de subir.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido',
                });
                return;
            }

            // ✅ Si hay archivos, confirmar subida
            Swal.fire({
                title: '¿Subir PDFs?',
                text: '¿Estás seguro de que deseas subir los archivos seleccionados?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, subir',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    const componentId = document.querySelector('[wire\\:id]')?.getAttribute('wire:id');
                    if (componentId) {
                        Livewire.find(componentId).uploadPdfs();
                    }
                }
            });
        });
    }

    // 🔥 Confirmación para eliminar PDFs (usada desde this->dispatch('confirm', { id: ... }))
    Livewire.on('confirm', ({ 
        title = '¿Estás seguro?', 
        text = '', 
        icon = 'warning', 
        confirmText = 'Sí', 
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
                @this.call('eliminarPdf', id);
            }
        });
    });

});
</script>


