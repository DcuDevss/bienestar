

{{--
<div>
    <h2 class="text-2xl font-bold mb-4">PDF Viewer</h2>

    <div class="grid grid-cols-3 gap-4">
        @foreach($pdfs as $pdf)
            <div class="flex flex-col items-center">

                    <img src="{{ asset('assets/pdf-icon.png') }}" alt="PDF Icon" class="w-16 h-16 mb-2">
                    <span class="text-sm">{{ $pdf->file }}</span>
                    {{-- <a href="{{ route('pdf.ver', ['paciente' => $pdf->id]) }}" target="_blank">
                </a>
            </div>
        @endforeach
    </div>
</div>--}}

<!-- resources/views/livewire/paciente/pdf-viewer.blade.php -->
{{-- <div>
    <h2 class="text-2xl font-bold mb-4">PDF Viewer</h2>

    <!-- Iterar sobre la lista de PDFs -->
    <div class="grid grid-cols-3 gap-4">
        @foreach($pdfs as $pdf)
            <div class="flex flex-col items-center">
                <a href="#" wire:click="viewPdf('{{ $pdf->id }}')" target="_blank">
                    <img src="{{ asset('assets/pdf-icon.png') }}" alt="PDF Icon" class="w-16 h-16 mb-2">
                    <span class="text-sm">{{ $pdf->file }}</span>
                </a>
            </div>
        @endforeach
    </div>
</div> --}}




<!-- resources/views/livewire/paciente/pdf-viewer.blade.php -->
<div>
    <h2 class="text-2xl font-bold mb-4">PDF Viewer</h2>

    <!-- Iterar sobre la lista de PDFs -->
    <div class="grid grid-cols-3 gap-4">
        @foreach($pdfs as $pdf)
            <div class="flex flex-col items-center">
                <a href="#" wire:click="downloadPdf('{{ $pdf->id }}')">
                    <img src="{{ asset('assets/pdf-icon.png') }}" alt="PDF Icon" class="w-16 h-16 mb-2">
                    <span class="text-sm">{{ $pdf->file }}</span>
                </a>
            </div>
        @endforeach
    </div>
</div>


