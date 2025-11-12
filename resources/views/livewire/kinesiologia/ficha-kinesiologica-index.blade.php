<div class="max-w-6xl mx-auto mt-6">
    <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold text-gray-700">
        Fichas Kinesiológicas de {{ $paciente->apellido_nombre }}
    </h2>
    <div class="flex space-x-2">
        <a href="{{ route('kinesiologia.index', ['paciente' => $paciente->id]) }}"
            class="px-4 py-2 mb-4 bg-gray-500 text-white rounded-md shadow-md hover:bg-gray-600 focus:outline-none">
            + Nueva Ficha
        </a>

        {{-- ✅ Nuevo botón --}}
        <a href="{{ route('kinesiologia.pdfs', ['paciente' => $paciente->id]) }}"
            class="px-4 py-2 mb-4 bg-blue-600 text-white rounded-md shadow-md hover:bg-blue-700 focus:outline-none">
            📎 Adjuntar PDFs
        </a>
    </div>
</div>

    <div class="mb-4 flex items-center space-x-2">
        <input type="date" wire:model.live="fecha" class="border rounded-lg px-3 py-2 w-full md:w-64 focus:ring-indigo-500 focus:border-indigo-500">
        <button wire:click="filtrarPorFecha" class=" bg-gray-500 text-white px-4 py-2 rounded-lg shadow-sm hover:bg-gray-600 transition duration-150">
            Buscar
        </button>
    </div>


    @if ($fichas->isEmpty())
        <p class="text-gray-500 text-center py-8 border rounded-lg bg-gray-50">No hay fichas registradas para este paciente.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($fichas as $ficha)
                <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100 transition hover:shadow-2xl">
                    
                    <div class="bg-indigo-50 px-4 py-3 flex justify-between items-center border-b border-indigo-100">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">
                                Fecha: <span class="text-gray-800">{{ $ficha->created_at->format('d/m/Y') }}</span> |
                                Hora: <span class="text-gray-800">{{ $ficha->created_at->format('H:i') }}</span><br>
                                Doctor: <span class="text-gray-800">{{ $ficha->doctor->name ?? 'Sin asignar' }}</span>
                            </p>
                        </div>

                        <div>
                            <a href="{{ route('kinesiologia.edit', ['ficha' => $ficha->id]) }}"
                               class="inline-block  bg-gray-500 text-white  hover:bg-gray-600 font-bold py-1 px-3 rounded-md text-sm transition duration-150 shadow">
                                Editar Planilla
                            </a>
                        </div>
                    </div>


                    <div class="px-4 py-4 text-gray-700 space-y-3">
                        <h3 class="font-bold text-lg text-gray-600 border-b pb-2 mb-3">Planilla Kinesiológica</h3>

                        {{-- Lista completa de campos --}}
                        @foreach ([
                            'diagnostico' => 'Diagnóstico',
                            'motivo_consulta' => 'Motivo de consulta',
                            'posturas_dolorosas' => 'Posturas dolorosas',
                            'realiza_actividad_fisica' => 'Realiza actividad física',
                            'tipo_actividad' => 'Tipo de actividad',
                            'antecedentes_enfermedades' => 'Ant. de enfermedades',
                            'antecedentes_familiares' => 'Ant. familiares',
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
                            
                            {{-- 🌟 CAMBIO CLAVE: SOLO MUESTRA SI TIENE VALOR 🌟 --}}
                            @if ($ficha->$campo)
                                {{-- TODOS LOS CAMPOS SE MUESTRAN CON EL FORMATO UNIFORME --}}
                                <p class="text-sm flex justify-between items-center bg-gray-50 p-2 rounded-md">
                                    {{-- Etiqueta --}}
                                    <span class="font-semibold text-gray-700">{{ $label }}:</span>
                                    
                                    {{-- Botón "Ver Detalle" --}}
                                    <button wire:click="mostrarDetalleCampo({{ $ficha->id }}, '{{ $campo }}', '{{ $label }} Completo')"
                                            class="text-xs font-bold text-indigo-600 hover:text-indigo-800 bg-indigo-100 py-0.5 px-2 rounded transition duration-150">
                                        Ver Detalle
                                    </button>
                                </p>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $fichas->links('pagination::tailwind') }}
        </div>
    @endif

    
    {{-- MODAL FLOTANTE PARA DETALLE DE CAMPO ESPECÍFICO (Se mantiene) --}}
    @if ($modalCampoAbierto)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 z-[60] flex items-center justify-center p-4" 
             wire:click.self="cerrarModalCampo">
            
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-md"
                 @keydown.escape.window="cerrarModalCampo" x-data="{}">
                
                <div class="p-4 border-b flex justify-between items-center bg-indigo-50 rounded-t-xl">
                    <h4 class="font-bold text-lg text-indigo-800">{{ $campoSeleccionadoTitulo }}</h4>
                    <button wire:click="cerrarModalCampo" class="text-indigo-600 hover:text-indigo-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="p-6 max-h-[80vh] overflow-y-auto text-gray-600">
                    <p class="whitespace-pre-wrap text-base break-words">{{ $campoSeleccionadoContenido }}</p>
                </div>
                
                <div class="p-4 border-t flex justify-end">
                    <button wire:click="cerrarModalCampo"
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition duration-150">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    @endif
    
</div>