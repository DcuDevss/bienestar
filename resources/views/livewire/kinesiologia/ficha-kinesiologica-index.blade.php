<div class="min-h-screen bg-gray-50 py-10 px-4">
    <div class="max-w-6xl mx-auto">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
            <h2 class="text-3xl font-bold text-gray-800">
                <span class="text-xl font-semibold text-gray-600">Ficha Kinesiológica de:</span> <br>
                <span class="text-2xl font-bold text-gray-800">{{ $paciente->apellido_nombre }}</span>
            </h2>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('kinesiologia.index', ['paciente' => $paciente->id]) }}"
                    class="flex items-center gap-1 bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded-xl shadow transition transform hover:scale-105 text-sm">
                    Nueva Ficha
                </a>

                <a href="{{ route('kinesiologia.sesion-kinesiologica', ['paciente' => $paciente->id]) }}"
                    class="flex items-center gap-1 bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded-xl shadow transition transform hover:scale-105 text-sm">
                    Sesiones de Kinesiología
                </a>

                <a href="{{ route('kinesiologia.pdfs-kinesiologia', ['paciente' => $paciente->id]) }}"
                    class="flex items-center gap-1 bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded-xl shadow transition transform hover:scale-105 text-sm">
                    Adjuntar PDFs
                </a>
            </div>
        </div>

        <div
            class="flex flex-col sm:flex-row sm:items-center gap-2 mb-8 bg-white p-4 rounded-xl shadow-sm border border-gray-200">
            <input type="date" wire:model.live="fecha"
                class="border border-gray-300 rounded-lg px-3 py-2 w-full sm:w-64 focus:ring-2 focus:ring-gray-400 focus:outline-none transition">
            <button wire:click="filtrarPorFecha"
                class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded-lg shadow transition transform hover:scale-105 w-full sm:w-auto">
                Buscar
            </button>
        </div>

        @if ($fichas->isEmpty())
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm text-center py-10">
                <p class="text-gray-500 text-lg">No hay fichas registradas para este paciente.</p>
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($fichas as $ficha)
                    <div x-data="{ expand: false }" class="">

                        <div class="bg-gray-100 px-5 py-3 flex justify-between items-start border-b border-gray-300">
                            <div class="flex flex-col gap-1">
                                @php
                                    $created = \Carbon\Carbon::parse($ficha->created_at);
                                    $diaSemana = strtoupper($created->locale('es')->dayName);
                                @endphp
                                <p class="text-sm text-gray-700 font-semibold">
                                    {{ $diaSemana }} - {{ $created->format('d/m/Y') }}
                                </p>
                                <p class="text-sm text-gray-600">Hora: {{ $created->format('H:i') }}</p>
                                <p class="text-sm text-gray-600 font-medium">{{ $ficha->doctor->name ?? 'Sin asignar' }}
                                </p>
                            </div>

                            <button @click="expand = !expand"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm font-semibold px-3 py-1.5 rounded-lg transition self-start">
                                <span x-show="!expand">⬇️ Ver</span>
                                <span x-show="expand">⬆️ Ocultar</span>
                            </button>
                        </div>

                        <div class="p-5 space-y-3 text-sm text-gray-700" x-show="expand" x-transition>
                            <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">
                                Planilla Kinesiológica
                            </h3>

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
                                {{-- 🛠 INICIO DE LA LÓGICA CORREGIDA --}}
                                @php
                                    $valor = $ficha->$campo;

                                    // Muestra el campo si NO es NULO y NO es una cadena vacía.
                                    // Esto permite mostrar TRUE/1, FALSE/0, números y strings no vacíos.
                                    $mostrarCampo =
                                        !is_null($valor) && (is_string($valor) ? trim($valor) !== '' : true);

                                    // Prepara la lógica de visualización para el contenido
                                    $mostrarDirecto = is_scalar($valor) && strlen(strip_tags((string) $valor)) <= 60;
                                @endphp

                                @if ($mostrarCampo)
                                    <div
                                        class="flex justify-between items-center bg-gray-50 hover:bg-gray-100 p-2 rounded-md transition">
                                        <span class="font-medium text-gray-700">{{ $label }}</span>
                                        @if ($mostrarDirecto)
                                            <span
                                                class="text-sm text-gray-600">{{ is_bool($valor) ? ($valor ? 'Sí' : 'No') : $valor }}</span>
                                        @else
                                            <button
                                                wire:click="mostrarDetalleCampo({{ $ficha->id }}, '{{ $campo }}', '{{ $label }} Completo')"
                                                class="text-xs bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-2 py-1 rounded transition">
                                                Ver Detalle
                                            </button>
                                        @endif
                                    </div>
                                @endif
                                {{-- 🛠 FIN DE LA LÓGICA CORREGIDA --}}
                            @endforeach

                            <div class="flex gap-2 mt-3 justify-center">
                                <a href="{{ route('kinesiologia.pdfs-kinesiologia', ['paciente' => $paciente->id, 'ficha' => $ficha->id]) }}"
                                    class="bg-gray-700 hover:bg-gray-800 text-white px-3 py-1.5 rounded-md text-sm">
                                    Adjuntar PDFs
                                </a>

                                <a href="{{ route('kinesiologia.ficha-kinesiologica-edit', ['ficha' => $ficha->id]) }}"
                                    class="bg-gray-700 hover:bg-gray-800 text-white px-3 py-1.5 rounded-md text-sm">
                                    Editar Planilla
                                </a>
                                <a href="{{ route('kinesiologia.sesion-kinesiologica', ['paciente' => $paciente->id]) }}"
                                    class="bg-gray-700 hover:bg-gray-800 text-white px-3 py-1.5 rounded-md text-sm">
                                    Sesiones de Kinesiología
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ✅ Sección inferior de paginación personalizada --}}
            <div class="p-4 border-t border-gray-700 mt-6 rounded-b-lg">
                <div class="flex flex-col md:flex-row items-center justify-between text-xs">

                    {{-- Selector de cantidad + info de resultados --}}
                    <div class="flex items-center mb-4 md:mb-0 gap-4">
                        <label for="perPage" class="text-black text-[14px]">Mostrar</label>
                        <select wire:model.live="perPage" id="perPage"
                            class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-1 appearance-none cursor-pointer">
                            <option value="3">3</option>
                            <option value="8">8</option>
                            <option value="15">15</option>
                            <option value="25">25</option>
                        </select>

                        {{-- Texto de resultados solo visible en esta vista --}}
                        <span class="text-gray-800 text-sm">
                            Mostrando {{ $fichas->firstItem() }} al {{ $fichas->lastItem() }} de
                            {{ $fichas->total() }} resultados
                        </span>
                    </div>

                    {{-- Enlaces de paginación --}}
                    <div class="w-full md:w-auto mt-2 md:mt-0">
                        {{ $fichas->links() }}
                    </div>

                </div>
            </div>


            {{-- CSS local solo para esta vista --}}
            <style>
                /* Cambia el color del texto "Mostrando X al Y de Z resultados" solo aquí */
                .pagination-info p {
                    color: #1f2937 !important;
                    /* Gris oscuro (equivale a text-gray-800) */
                }
            </style>



        @endif

        @if ($modalCampoAbierto)
            <div class="fixed inset-0 bg-gray-900 bg-opacity-70 z-50 flex items-center justify-center p-4"
                wire:click.self="cerrarModalCampo" x-data="{ open: true }" x-show="open" x-transition.opacity>
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all scale-100"
                    x-transition.scale>
                    <div class="p-4 border-b bg-gray-100 rounded-t-2xl flex justify-between items-center">
                        <h4 class="font-semibold text-gray-700 text-lg">{{ $campoSeleccionadoTitulo }}</h4>
                        <button wire:click="cerrarModalCampo" class="text-gray-600 hover:text-gray-900">✖</button>
                    </div>
                    <div class="p-6 max-h-[70vh] overflow-y-auto text-gray-700">
                        <p class="whitespace-pre-wrap text-base leading-relaxed">{{ $campoSeleccionadoContenido }}</p>
                    </div>
                    <div class="p-4 border-t flex justify-end bg-gray-50 rounded-b-2xl">
                        <button wire:click="cerrarModalCampo"
                            class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded-lg shadow transition">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
