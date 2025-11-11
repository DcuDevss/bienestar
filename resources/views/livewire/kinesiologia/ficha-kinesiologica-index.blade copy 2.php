<div class="max-w-6xl mx-auto mt-6">
    <!-- Header con título y botón -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">
            Fichas Kinesiológicas de {{ $paciente->apellido_nombre }}
        </h2>
        <a href="{{ route('kinesiologia.index', ['paciente' => $paciente->id]) }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            + Nueva Ficha
        </a>
    </div>
    <div class="mb-4 flex items-center space-x-2">
        <input type="date" wire:model="fecha" class="border rounded px-3 py-2 w-full md:w-64">
        <button wire:click="filtrarPorFecha" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Buscar
        </button>
    </div>




    @if ($fichas->isEmpty())
        <p class="text-gray-500 text-center">No hay fichas registradas para este paciente.</p>
    @else
        <!-- Grilla 3 tarjetas por fila -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($fichas as $ficha)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden transition hover:shadow-xl">
               <!-- Encabezado de la tarjeta -->
<div class="bg-blue-50 px-4 py-3 flex justify-between items-center">
    <div>
        <p class="text-gray-600 text-sm">
            Fecha: {{ $ficha->created_at->format('d/m/Y') }} |
            Hora: {{ $ficha->created_at->format('H:i') }}<br>
            Doctor: {{ $ficha->doctor->name ?? 'Sin asignar' }}
        </p>
    </div>

    <!-- Botón como enlace pero sin romper layout -->
    <div>
        <a href="{{ route('kinesiologia.edit', ['ficha' => $ficha->id]) }}"
           class="inline-block bg-purple-500 hover:bg-purple-700 text-white font-bold py-1 px-3 rounded text-sm">
            Editar Planilla
        </a>
    </div>
</div>


                    <!-- Contenido siempre visible -->
                    <div class="px-4 py-3 text-gray-700 space-y-3">
                        <h3 class="font-semibold text-gray-800 border-b pb-1">Planilla Kinesiológica</h3>

                        @foreach ([
        'diagnostico' => 'Diagnóstico',
        'motivo_consulta' => 'Motivo de consulta',
        'posturas_dolorosas' => 'Posturas dolorosas',
        'realiza_actividad_fisica' => 'Realiza actividad física',
        'tipo_actividad' => 'Tipo de actividad',
        'antecedentes_enfermedades' => 'Antecedentes de enfermedades',
        'antecedentes_familiares' => 'Antecedentes familiares',
        'cirugias' => 'Cirugías',
        'traumatismos_accidentes' => 'Traumatismos/Accidentes',
        'tratamientos_previos' => 'Tratamientos previos',
        'menarca' => 'Menarca',
        'menopausia' => 'Menopausia',
        'partos' => 'Partos',
        'estado_salud_general' => 'Estado de salud general',
        'alteracion_peso' => 'Alteración de peso',
        'medicacion_actual' => 'Medicación actual',
        'observaciones_generales_anamnesis' => 'Observaciones generales',
        'visceral_palpacion' => 'Visceral palpación',
        'visceral_dermalgias' => 'Visceral dermalgias',
        'visceral_triggers' => 'Visceral triggers',
        'visceral_fijaciones' => 'Visceral fijaciones',
        'craneal_forma' => 'Craneal forma',
        'craneal_triggers' => 'Craneal triggers',
        'craneal_fijaciones' => 'Craneal fijaciones',
        'craneal_musculos' => 'Craneal músculos',
        'tension_arterial' => 'Tensión arterial',
        'pulsos' => 'Pulsos',
        'auscultacion' => 'Auscultación',
        'ecg' => 'ECG',
        'ecodoppler' => 'Ecodoppler',
    ] as $campo => $label)
                            @if ($ficha->$campo)
                                <p><span class="font-medium">{{ $label }}:</span> {{ $ficha->$campo }}</p>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="mt-6">
            {{ $fichas->links('pagination::tailwind') }}
        </div>
    @endif

</div>
