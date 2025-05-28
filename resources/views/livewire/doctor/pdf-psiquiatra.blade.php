<div class="p-4 bg-white rounded shadow-md max-w-lg mx-auto mt-4">

    {{-- Mensaje de éxito --}}
    @if (session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('message') }}
        </div>
    @endif

    {{-- Formulario de subida --}}
    <form wire:submit.prevent="uploadPdf" class="mb-6">
        <label class="block mb-2 font-semibold text-gray-700" for="pdf">Adjuntar PDF Psiquiatra</label>
        <input type="file" id="pdf" wire:model="pdf" accept="application/pdf" class="block w-full border rounded p-2" />

        {{-- Validación --}}
        @error('pdf')
            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
        @enderror

        <button type="submit"
                class="mt-3 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                wire:loading.attr="disabled" wire:target="uploadPdf">
            Subir PDF
        </button>
    </form>

    {{-- Historial de PDFs --}}
    <h3 class="text-lg font-semibold mb-3">Historial de PDFs</h3>

    @if($pdfs->isEmpty())
        <p class="text-gray-600">No hay PDFs adjuntados para esta entrevista.</p>
    @else
        <ul class="list-disc list-inside space-y-2">
            @foreach ($pdfs as $pdf)
                <a href="{{ route('pdf.show', basename($pdf->filepath)) }}" target="_blank" class="text-blue-600 hover:text-blue-400 font-semibold">
                    {{ $pdf->filename }}
                </a>
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
