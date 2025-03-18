<!-- Dentro de resources/views/livewire/paciente/ver-historial.blade.php -->
<div class="mt-8">
    <!-- CONTENIDO -->
    <div class="bg-white w-[90%] mx-auto rounded-xl shadow-lg py-6 px-2">
        
        <div class="text-center">
            <h2 class="text-2xl font-bold pb-4">Historial de Archivos PDF</h2>
        </div>
        <!-- Lista paginada de PDFs -->
        <div class="grid grid-cols-10 gap-x-4 ">
            @foreach($pdfs as $pdf)
                <div class="flex flex-col items-center">
                    <a href="{{ Storage::url($pdf->file) }}" target="_blank">
                        <img src="{{ asset('assets/pdf.png') }}" alt="PDF Icon" class="w-12 h-16">
                    </a>
                    <span class="text-sm text-center">{{ pathinfo($pdf->file, PATHINFO_FILENAME) }}</span>
                </div>
            @endforeach
        </div>
        <div class="">
            <!-- Enlaces de paginación -->
            {{-- $pdfs->links() --}}
        </div>
    </div>
</div>

