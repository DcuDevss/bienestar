<div class="max-w-6xl mx-auto mt-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-gray-700">
            Fichas Kinesiológicas de {{ $paciente->apellido_nombre }}
        </h2>
        <a href="{{ route('kinesiologia.index', ['paciente' => $paciente->id]) }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            + Nueva Ficha
        </a>
    </div>

    @if($fichas->isEmpty())
        <p class="text-gray-500 text-center">No hay fichas registradas para este paciente.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($fichas as $ficha)
                <div x-data="{ open: false }" 
                     class="bg-white shadow rounded-lg p-4 hover:shadow-lg transition duration-200">
                    <div class="flex justify-between items-center cursor-pointer" @click="open = !open">
                        <div>
                            <p class="font-semibold text-gray-700">Ficha #{{ $ficha->id }}</p>
                            <p class="text-gray-500 text-sm">
                                Fecha: {{ $ficha->created_at->format('d/m/Y') }} | 
                                Doctor: {{ $ficha->doctor->name ?? 'Sin asignar' }}
                            </p>
                        </div>
                        <svg :class="{'rotate-180': open}" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>

                    <div x-show="open" x-transition class="mt-4 text-gray-600 text-sm space-y-2">
                        @if($ficha->diagnostico)<p><strong>Diagnóstico:</strong> {{ $ficha->diagnostico }}</p>@endif
                        @if($ficha->motivo_consulta)<p><strong>Motivo de consulta:</strong> {{ $ficha->motivo_consulta }}</p>@endif
                        @if($ficha->posturas_dolorosas)<p><strong>Posturas dolorosas:</strong> {{ $ficha->posturas_dolorosas }}</p>@endif
                        @if($ficha->realiza_actividad_fisica)<p><strong>Realiza actividad física:</strong> {{ $ficha->realiza_actividad_fisica }}</p>@endif
                        @if($ficha->tipo_actividad)<p><strong>Tipo de actividad:</strong> {{ $ficha->tipo_actividad }}</p>@endif
                        @if($ficha->antecedentes_enfermedades)<p><strong>Antecedentes de enfermedades:</strong> {{ $ficha->antecedentes_enfermedades }}</p>@endif
                        @if($ficha->antecedentes_familiares)<p><strong>Antecedentes familiares:</strong> {{ $ficha->antecedentes_familiares }}</p>@endif
                        @if($ficha->cirugias)<p><strong>Cirugías:</strong> {{ $ficha->cirugias }}</p>@endif
                        @if($ficha->traumatismos_accidentes)<p><strong>Traumatismos/Accidentes:</strong> {{ $ficha->traumatismos_accidentes }}</p>@endif
                        @if($ficha->tratamientos_previos)<p><strong>Tratamientos previos:</strong> {{ $ficha->tratamientos_previos }}</p>@endif
                        @if($ficha->menarca)<p><strong>Menarca:</strong> {{ $ficha->menarca }}</p>@endif
                        @if($ficha->menopausia)<p><strong>Menopausia:</strong> {{ $ficha->menopausia }}</p>@endif
                        @if($ficha->partos)<p><strong>Partos:</strong> {{ $ficha->partos }}</p>@endif
                        @if($ficha->estado_salud_general)<p><strong>Estado de salud general:</strong> {{ $ficha->estado_salud_general }}</p>@endif
                        @if($ficha->alteracion_peso)<p><strong>Alteración de peso:</strong> {{ $ficha->alteracion_peso }}</p>@endif
                        @if($ficha->medicacion_actual)<p><strong>Medicación actual:</strong> {{ $ficha->medicacion_actual }}</p>@endif
                        @if($ficha->observaciones_generales_anamnesis)<p><strong>Observaciones generales:</strong> {{ $ficha->observaciones_generales_anamnesis }}</p>@endif
                        @if($ficha->visceral_palpacion)<p><strong>Visceral palpación:</strong> {{ $ficha->visceral_palpacion }}</p>@endif
                        @if($ficha->visceral_dermalgias)<p><strong>Visceral dermalgias:</strong> {{ $ficha->visceral_dermalgias }}</p>@endif
                        @if($ficha->visceral_triggers)<p><strong>Visceral triggers:</strong> {{ $ficha->visceral_triggers }}</p>@endif
                        @if($ficha->visceral_fijaciones)<p><strong>Visceral fijaciones:</strong> {{ $ficha->visceral_fijaciones }}</p>@endif
                        @if($ficha->craneal_forma)<p><strong>Craneal forma:</strong> {{ $ficha->craneal_forma }}</p>@endif
                        @if($ficha->craneal_triggers)<p><strong>Craneal triggers:</strong> {{ $ficha->craneal_triggers }}</p>@endif
                        @if($ficha->craneal_fijaciones)<p><strong>Craneal fijaciones:</strong> {{ $ficha->craneal_fijaciones }}</p>@endif
                        @if($ficha->craneal_musculos)<p><strong>Craneal músculos:</strong> {{ $ficha->craneal_musculos }}</p>@endif
                        @if($ficha->tension_arterial)<p><strong>Tensión arterial:</strong> {{ $ficha->tension_arterial }}</p>@endif
                        @if($ficha->pulsos)<p><strong>Pulsos:</strong> {{ $ficha->pulsos }}</p>@endif
                        @if($ficha->auscultacion)<p><strong>Auscultación:</strong> {{ $ficha->auscultacion }}</p>@endif
                        @if($ficha->ecg)<p><strong>ECG:</strong> {{ $ficha->ecg }}</p>@endif
                        @if($ficha->ecodoppler)<p><strong>Ecodoppler:</strong> {{ $ficha->ecodoppler }}</p>@endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
