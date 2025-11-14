<div class="w-full px-4">
    <div class="p-3 bg-gray-100 rounded shadow mb-4 text-center">
        <h3 class="font-semibold text-lg">Entrevistas del Paciente:</h3>{{ $paciente->apellido_nombre ?? 'Nombre no disponible' }}
    </div>


    <button type="button" onclick="window.history.back()"
        class="px-4 py-2 mb-4 bg-gray-500 text-white rounded-md shadow-md hover:bg-gray-600 focus:outline-none">
        Volver
    </button>

    @if (session()->has('message'))
        <div class="alert alert-success mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('message') }}
        </div>
    @endif

    @php
        // Establecer el locale en español
        \Carbon\Carbon::setLocale('es');

        // Agrupar las entrevistas por fecha (día-mes-año)
        $entrevistasPorFecha = $entrevistas->groupBy(function ($entrevista) {
            return \Carbon\Carbon::parse($entrevista->created_at)->format('d-m-Y');
        });
    @endphp

    <!-- Contenedor principal para mostrar las entrevistas agrupadas por fecha -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($entrevistasPorFecha as $created_at => $entrevistasDelDia)
            <!-- Contenedor para cada grupo de entrevistas por fecha -->
            <div class="bg-white shadow-md rounded-lg p-6 flex flex-col mb-6">
                <!-- Titulo de la fecha -->

                <h3 class="text-xl font-bold mb-4">
                    {{ ucwords(\Carbon\Carbon::parse($created_at)->translatedFormat('l, d F Y')) }}</h3>



                <!-- Contenedor de las entrevistas de esa fecha -->
                <div class="space-y-4">
                    @foreach ($entrevistasDelDia as $entrevista)
                        <!-- Tarjeta de entrevista individual -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col mb-4">
                            <div class="font-semibold text-lg mb-2">
                                Hora de la Entrevista -
                                {{ \Carbon\Carbon::parse($entrevista->created_at)->timezone('America/Argentina/Buenos_Aires')->translatedFormat('H:i') }}
                                hrs.
                            </div>

                            <!-- Sección Entrevista -->
                            <div class="border-b pb-4 mb-4">
                                <h4 class="text-xl font-semibold mb-2">Entrevista</h4>
                                <div class="space-y-2">
                                    <p><strong>Tipo de Entrevista:</strong>
                                        {{ $entrevista->tipoEntrevista->name ?? 'Sin Datos' }}</p>
                                    @if ($entrevista->posee_arma !== null)
                                        <p><strong>Posee Arma:</strong> {{ $entrevista->posee_arma == 1 ? 'Sí' : 'No' }}
                                        </p>
                                    @endif
                                    @if ($entrevista->posee_sanciones !== null)
                                        <p><strong>Posee Sanciones:</strong>
                                            {{ $entrevista->posee_sanciones == 1 ? 'Sí' : 'No' }}</p>
                                    @endif
                                    @if ($entrevista->causas_judiciales !== null)
                                        <p><strong>Causas Judiciales:</strong>
                                            {{ $entrevista->causas_judiciales == 1 ? 'Sí' : 'No' }}</p>
                                    @endif
                                    @if ($entrevista->sosten_de_familia !== null)
                                        <p><strong>Sosten de Familia:</strong>
                                            {{ $entrevista->sosten_de_familia == 1 ? 'Sí' : 'No' }}</p>
                                    @endif
                                    @if ($entrevista->sosten_economico !== null)
                                        <p><strong>Sosten Económico:</strong>
                                            {{ $entrevista->sosten_economico == 1 ? 'Sí' : 'No' }}</p>
                                    @endif
                                    @if ($entrevista->tiene_embargos !== null)
                                        <p><strong>Tiene Embargos:</strong>
                                            {{ $entrevista->tiene_embargos == 1 ? 'Sí' : 'No' }}</p>
                                    @endif
                                    @if (!empty($entrevista->posee_vivienda_propia))
                                        <p><strong>¿Posee vivienda propia?</strong>
                                            {{ $entrevista->posee_vivienda_propia }}
                                        </p>
                                    @endif

                                    @if (!empty($entrevista->destino_anterior))
                                        <p><strong>Destino anterior:</strong>
                                            {{ $entrevista->destino_anterior }}
                                        </p>
                                    @endif

                                    @if (!empty($entrevista->tiempo_en_ultimo_destino))
                                        <p><strong>¿Hace cuánto tiempo se desempeña en su último destino?</strong>
                                            {{ $entrevista->tiempo_en_ultimo_destino }}
                                        </p>
                                    @endif

                                    @if (!empty($entrevista->fecha_ultimo_ascenso))
                                        <p><strong>Fecha de último ascenso:</strong>
                                            {{ \Carbon\Carbon::parse($entrevista->fecha_ultimo_ascenso)->format('d-m-Y') }}
                                        </p>
                                    @endif

                                    @if (!empty($entrevista->horario_laboral))
                                        <p><strong>Horario laboral:</strong>
                                            {{ $entrevista->horario_laboral }}
                                        </p>
                                    @endif

                                    @if (!empty($entrevista->hace_adicionales))
                                        <p><strong>¿Hace adicionales?</strong>
                                            {{ $entrevista->hace_adicionales }}
                                        </p>
                                    @endif

                                    @if (!empty($entrevista->anios_residencia_isla))
                                        <p><strong>Años de residencia en la isla:</strong>
                                            {{ $entrevista->anios_residencia_isla }}
                                        </p>
                                    @endif

                                    @if (!empty($entrevista->posee_oficio_profesion))
                                        <p><strong>Posee otro oficio o profesión:</strong>
                                            {{ $entrevista->posee_oficio_profesion }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Sección Datos Médicos -->
                            <div class="border-b pb-4 mb-4">
                                <h4 class="text-xl font-semibold mb-2">Datos Médicos</h4>
                                <div class="space-y-2">
                                    @if ($entrevista->enfermedad_preexistente !== null)
                                        <p><strong>Enfermedad Preexistente:</strong>
                                            {{ $entrevista->enfermedad_preexistente == 1 ? 'Sí' : 'No' }}</p>
                                    @endif
                                    @if ($entrevista->realizo_tratamiento_psicologico !== null)
                                        <p><strong>Realizó Tratamiento Psicológico:</strong>
                                            {{ $entrevista->realizo_tratamiento_psicologico == 1 ? 'Sí' : 'No' }}</p>
                                    @endif
                                    @if (!empty($entrevista->hace_cuanto_tratamiento_psicologico))
                                        <p><strong>Hace Cuánto Tratamiento Psicológico:</strong>
                                            {{ $entrevista->hace_cuanto_tratamiento_psicologico ?? 'Sin Datos' }}</p>
                                    @endif
                                    @if (!empty($entrevista->signos_y_sintomas))
                                        <p><strong>Signos y Síntomas:</strong>
                                            {{ $entrevista->signos_y_sintomas ?? 'Sin Datos' }}</p>
                                    @endif
                                    @if (!empty($entrevista->fecha))
                                        <p><strong>Fecha que lo realizó:</strong>
                                            {{ \Carbon\Carbon::parse($entrevista->fecha)->format('d-m-Y') ?? 'Sin Datos' }}
                                        </p>
                                    @endif
                                    @if (!empty($entrevista->profesional))
                                        <p><strong>Profesional que lo Atendió:</strong>
                                            {{ $entrevista->profesional ?? 'Sin Datos' }}</p>
                                    @endif
                                    @if (!empty($entrevista->duracion))
                                        <p><strong>Duración del Tratamiento:</strong>
                                            {{ $entrevista->duracion ?? 'Sin Datos' }}</p>
                                    @endif
                                    @if ($entrevista->fuma !== null)
                                        <p><strong>Fuma:</strong> {{ $entrevista->fuma == 1 ? 'Sí' : 'No' }}</p>
                                    @endif
                                    @if (!empty($entrevista->cantidad_fuma))
                                        <p><strong>Cantidad Fuma:</strong>
                                            {{ $entrevista->cantidad_fuma ?? 'Sin Datos' }}</p>
                                    @endif
                                    @if ($entrevista->consume_alcohol !== null)
                                        <p><strong>Consume Alcohol:</strong>
                                            {{ $entrevista->consume_alcohol == 1 ? 'Sí' : 'No' }}</p>
                                    @endif
                                    @if (!empty($entrevista->frecuencia_alcohol))
                                        <p><strong>Frecuencia Alcohol:</strong>
                                            {{ $entrevista->frecuencia_alcohol ?? 'Sin Datos' }}</p>
                                    @endif
                                    @if ($entrevista->consume_sustancias !== null)
                                        <p><strong>Consume Sustancias:</strong>
                                            {{ $entrevista->consume_sustancias == 1 ? 'Sí' : 'No' }}</p>
                                    @endif
                                    @if (!empty($entrevista->tipo_sustancia))
                                        <p><strong>Tipo de Sustancia:</strong>
                                            {{ $entrevista->tipo_sustancia ?? 'Sin Datos' }}</p>
                                    @endif
                                    @if (!empty($entrevista->realiza_actividades))
                                        <p><strong>Realiza Actividades:</strong>
                                            {{ $entrevista->realiza_actividades == 1 ? 'Si' : 'No' }}</p>
                                    @endif
                                    @if (!empty($entrevista->posee_oficio_profesion))
                                        <p><strong>Oficio o Profesión:</strong> {{ $entrevista->posee_oficio_profesion ?? 'Sin Datos' }}
                                        </p>
                                    @endif
                                    @if (!empty($entrevista->actividades))
                                        <p><strong>Actividades:</strong> {{ $entrevista->actividades ?? 'Sin Datos' }}
                                        </p>
                                    @endif
                                    @if (!empty($entrevista->horas_dormir))
                                        <p><strong>Horas que duerme por día:</strong>
                                            {{ $entrevista->horas_dormir ?? 'Sin Datos' }}</p>
                                    @endif
                                    @if (!empty($entrevista->horas_suficientes))
                                        <p><strong>Duerme Suficiente:</strong>
                                            {{ $entrevista->horas_suficientes == 1 ? 'Si' : 'No' }}</p>
                                    @endif
                                    @if (!empty($entrevista->pesadillas_trabajo))
                                        <p><strong>Pesadillas acerca del trabajo:</strong>
                                            <span id="pesadillas_trabajo_{{ $entrevista->id }}" class="hidden">
                                                {{ $entrevista->pesadillas_trabajo ?? 'Sin Datos' }}
                                            </span>
                                            <button type="button"
                                                onclick="openModal('pesadillas_trabajo_{{ $entrevista->id }}')"
                                                class="text-blue-500 text-sm mt-1">
                                                Ver Detalle
                                            </button>
                                        </p>
                                    @endif
                                    @if (!empty($entrevista->situacion_laboral))
                                        <p><strong>Situación laboral:</strong>
                                            <span id="situacion_laboral_{{ $entrevista->id }}" class="hidden">
                                                {{ $entrevista->situacion_laboral ?? 'Sin Datos' }}
                                            </span>
                                            <button type="button"
                                                onclick="openModal('situacion_laboral_{{ $entrevista->id }}')"
                                                class="text-blue-500 text-sm mt-1">
                                                Ver Detalle
                                            </button>
                                        </p>
                                    @endif
                                    @if (!empty($entrevista->relacion_companieros_superiores))
                                        <p><strong>Relación con compañeros y superiores:</strong>
                                            <span id="relacion_companieros_superiores_{{ $entrevista->id }}" class="hidden">
                                                {{ $entrevista->relacion_companieros_superiores ?? 'Sin Datos' }}
                                            </span>
                                            <button type="button"
                                                onclick="openModal('relacion_companieros_superiores_{{ $entrevista->id }}')"
                                                class="text-blue-500 text-sm mt-1">
                                                Ver Detalle
                                            </button>
                                        </p>
                                    @endif
                                    @if (!empty($entrevista->situacion_familiar))
                                        <p><strong>Situación familiar:</strong>
                                            <span id="situacion_familiar_{{ $entrevista->id }}" class="hidden">
                                                {{ $entrevista->situacion_familiar ?? 'Sin Datos' }}
                                            </span>
                                            <button type="button"
                                                onclick="openModal('situacion_familiar_{{ $entrevista->id }}')"
                                                class="text-blue-500 text-sm mt-1">
                                                Ver Detalle
                                            </button>
                                        </p>
                                    @endif
                                    @if (!empty($entrevista->ultimos_6_meses))
                                        <p><strong>Últimos 6 meses:</strong>
                                            <span id="ultimos_6_meses_{{ $entrevista->id }}" class="hidden">
                                                {{ $entrevista->ultimos_6_meses ?? 'Sin Datos' }}
                                            </span>
                                            <button type="button"
                                                onclick="openModal('ultimos_6_meses_{{ $entrevista->id }}')"
                                                class="text-blue-500 text-sm mt-1">
                                                Ver Detalle
                                            </button>
                                        </p>
                                    @endif
                                    @if (!empty($entrevista->ultimos_dias_semanas))
                                        <p><strong>Últimos días o semanas:</strong>
                                            <span id="ultimos_dias_semanas_{{ $entrevista->id }}" class="hidden">
                                                {{ $entrevista->ultimos_dias_semanas ?? 'Sin Datos' }}
                                            </span>
                                            <button type="button"
                                                onclick="openModal('ultimos_dias_semanas_{{ $entrevista->id }}')"
                                                class="text-blue-500 text-sm mt-1">
                                                Ver Detalle
                                            </button>
                                        </p>
                                    @endif
                                    @if (!empty($entrevista->estado_entrevista_id))
                                        @php
                                            // Define los colores basados en el id del estado de la entrevista
                                            $color = '';
                                            switch ($entrevista->estado_entrevista_id) {
                                                case 1:
                                                    $color = 'bg-green-500'; // Ejemplo de color verde(apto)
                                                    break;
                                                case 2:
                                                    $color = 'bg-red-500'; // Ejemplo de color amarillo(no apto)
                                                    break;
                                                case 3:
                                                    $color = 'bg-orange-500'; // Ejemplo de color rojo(condicional)
                                                    break;
                                                default:
                                                    $color = 'bg-gray-500'; // Color por defecto
                                                    break;
                                            }
                                        @endphp
                                        @if (!empty($entrevista->actitudEntrevista))
                                        <p >
                                            <strong>Actitud del Paciente:</strong>
                                            {{ $entrevista->actitudEntrevista->name ?? 'Sin Datos' }}
                                        </p>
                                        @endif
                                        @if (!empty($entrevista->indicacionTerapeutica))
                                        <p>
                                            <strong>Indicacion Terapéutica:</strong>
                                            {{ $entrevista->indicacionTerapeutica->name ?? 'Sin Datos' }}
                                        </p>
                                        @endif
                                         @if (!empty($entrevista->portacion_id))
                                        <p class="bg-gray-500">
                                            <strong>Continuar/Realizar Tratamiento:</strong> {{ $entrevista->recomendacion == 1 ? 'Sí' : 'No' }}
                                        </p>
                                        @endif
                                        <p class="{{ $color }}">
                                            <strong>El paciente se encuentra:</strong>
                                            {{ $entrevista->estadoEntrevista->name ?? 'Sin Datos' }}
                                        </p>
                                    @endif
                                    @if (!empty($entrevista->portacion_id))
                                        @php
                                            // Define los colores basados en el id del estado de la entrevista
                                            $color = '';
                                            switch ($entrevista->portacion_id) {
                                                case 1:
                                                    $color = 'bg-green-500'; // Ejemplo de color verde(apto)
                                                    break;
                                                case 2:
                                                    $color = 'bg-blue-500'; // Ejemplo de color amarillo(no apto)
                                                    break;
                                                case 3:
                                                    $color = 'bg-red-500'; // Ejemplo de color rojo(condicional)
                                                    break;
                                                default:
                                                    $color = 'bg-gray-500'; // Color por defecto
                                                    break;
                                            }
                                        @endphp
                                        <p class="{{ $color }}">
                                            <strong>Portación de armamento:</strong>
                                            {{ $entrevista->portacion->name ?? 'Sin Datos' }}
                                        </p>
                                    @endif
                                    @if (!empty($entrevista->salud_mentale_id))
                                     <p class="bg-red-300">
                                        <strong>Diagnóstico:</strong>
                                        {{ $entrevista->saludMentale ? $entrevista->saludMentale->name . ' (' . $entrevista->saludMentale->codigo . ')' : 'Sin Datos' }}
                                     </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Detalles de los campos con mucho contenido -->
                            <div class="space-y-2 border-b pb-4 mb-4">

                                @if (!empty($entrevista->motivo_sanciones))
                                    <p><strong>Motivo Sanciones:</strong>
                                        <span id="motivo_sanciones_{{ $entrevista->id }}"
                                            class="hidden">{{ $entrevista->motivo_sanciones ?? 'Sin Datos' }}</span>
                                        <button type="button"
                                            onclick="openModal('motivo_sanciones_{{ $entrevista->id }}')"
                                            class="text-blue-500 text-sm mt-1">Ver Detalle</button>
                                    </p>
                                @endif

                                @if (!empty($entrevista->motivo_causas_judiciales))
                                <p><strong>Motivo Causas Judiciaales:</strong>
                                    <span id="motivo_causas_judiciales_{{ $entrevista->id }}"
                                        class="hidden">{{ $entrevista->motivo_causas_judiciales ?? 'Sin Datos' }}</span>
                                    <button type="button"
                                        onclick="openModal('motivo_causas_judiciales_{{ $entrevista->id }}')"
                                        class="text-blue-500 text-sm mt-1">Ver Detalle</button>
                                </p>
                            @endif

                                @if (!empty($entrevista->medicacion))
                                    <p><strong>Medicación:</strong>
                                        <span id="medicacion_{{ $entrevista->id }}"
                                            class="hidden">{{ $entrevista->medicacion ?? 'Sin Datos' }}</span>
                                        <button type="button" onclick="openModal('medicacion_{{ $entrevista->id }}')"
                                            class="text-blue-500 text-sm mt-1">Ver Detalle</button>
                                    </p>
                                @endif

                                @if (!empty($entrevista->notas_clinicas))
                                    <p><strong>Notas Clínicas:</strong>
                                        <span id="notas_clinicas_{{ $entrevista->id }}"
                                            class="hidden">{{ $entrevista->notas_clinicas ?? 'Sin Datos' }}</span>
                                        <button type="button"
                                            onclick="openModal('notas_clinicas_{{ $entrevista->id }}')"
                                            class="text-blue-500 text-sm mt-1">Ver Detalle</button>
                                    </p>
                                @endif

                                @if (!empty($entrevista->tecnica_utilizada))
                                    <p><strong>Técnica Utilizada:</strong>
                                        <span id="tecnica_utilizada_{{ $entrevista->id }}"
                                            class="hidden">{{ $entrevista->tecnica_utilizada ?? 'Sin Datos' }}</span>
                                        <button type="button"
                                            onclick="openModal('tecnica_utilizada_{{ $entrevista->id }}')"
                                            class="text-blue-500 text-sm mt-1">Ver Detalle</button>
                                    </p>
                                @endif

                                @if (!empty($entrevista->evolucion_tratamiento))
                                    <p><strong>Evolución Tratamiento:</strong>
                                        <span id="evolucion_tratamiento_{{ $entrevista->id }}"
                                            class="hidden">{{ $entrevista->evolucion_tratamiento ?? 'Sin Datos' }}</span>
                                        <button type="button"
                                            onclick="openModal('evolucion_tratamiento_{{ $entrevista->id }}')"
                                            class="text-blue-500 text-sm mt-1">Ver Detalle</button>
                                    </p>
                                @endif

                                @if (!empty($entrevista->motivo))
                                    <p><strong>Motivo del tratamiento que realizó:</strong>
                                        <span id="motivo_{{ $entrevista->id }}"
                                            class="hidden">{{ $entrevista->motivo ?? 'Sin Datos' }}</span>
                                        <button type="button" onclick="openModal('motivo_{{ $entrevista->id }}')"
                                            class="text-blue-500 text-sm mt-1">Ver Detalle</button>
                                    </p>
                                @endif

                                <!-- Modal (para todos los campos) -->
                                <div id="modal"
                                    class="modal hidden fixed inset-0 flex justify-center items-center bg-gray-900 bg-opacity-50">
                                    <div class="modal-content bg-white p-6 rounded">
                                        <div class="modal-header flex justify-between text-blue-500 items-center">
                                            <h5 class="modal-title text-lg font-semibold" id="modalTitle">Detalle</h5>
                                            <button class="close text-xl" onclick="closeModal()">&times;</button>
                                        </div>
                                        <div id="modalBody" class="modal-body mt-2">
                                            Cargando...
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección Grupo Familiar -->
                            <div class="border-b pb-4 mb-4">
                                <h4 class="text-xl font-semibold mb-2">Grupo Familiar</h4>

                                @forelse ($entrevista->grupoFamiliar as $miembro)
                                    <div class="flex flex-wrap items-center gap-x-6 gap-y-1 mb-2 border-b border-gray-200 pb-2">
                                        <span><strong>Nombre:</strong> {{ $miembro->nombre ?? 'Sin Datos' }}</span>
                                        <span><strong>Edad:</strong> {{ $miembro->edad ?? 'Sin Datos' }}</span>
                                        <span><strong>Ocupación:</strong> {{ $miembro->ocupacion ?? 'Sin Datos' }}</span>
                                        <span><strong>Parentesco:</strong> {{ $miembro->parentesco ?? 'Sin Datos' }}</span>
                                        <span><strong>Antecedentes Psiquiátricos:</strong> {{ $miembro->antecedentes_psiquiatricos ?? 'Sin Datos' }}</span>
                                    </div>
                                @empty
                                    <p>No hay miembros registrados para este grupo familiar.</p>
                                @endforelse
                            </div>


                            <div class="mt-4 text-right text-sm text-gray-600">
                                <p><strong>Entrevista realizada por:</strong> <span
                                        class="text-red-500 font-bold">{{ $entrevista->user->name ?? 'Sin Datos' }}</span>
                                </p>
                            </div>

                            <div class="mt-6">
                                <div class="mt-4 text-right text-sm text-gray-600">
                                    @if ($entrevista['updated_at'] && $entrevista['updated_at'] != $entrevista['created_at'])
                                        <p class="text-sm font-medium">
                                            <strong>Última edición:</strong>
                                            {{ \Carbon\Carbon::parse($entrevista['updated_at'])->timezone('America/Argentina/Buenos_Aires')->translatedFormat('l, d F Y \a \l\a\s H:i') }}
                                            hrs.
                                        </p>
                                    @endif
                                </div>
                            </div>
                                    <!-- Adjuntar PDFs -->
                            <a href="{{ route('entrevistas.pdf-psiquiatra', $paciente) }}"
                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-md sm:w-auto">
                                Adjuntar PDFs
                            </a>

                            <a class="px-4 py-2 mt-4 text-center bg-purple-500 text-white rounded-md shadow-md hover:bg-purple-600 focus:outline-none"
                                href="{{ route('entrevistas.edit', ['entrevista_id' => $entrevista->id]) }}">
                                Editar entrevista
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    function openModal(fieldId) {
        // Obtiene el contenido del campo seleccionado
        let content = document.getElementById(fieldId).innerText.trim();

        // Verifica si el contenido está vacío
        if (content === "" || content === "Sin Datos") {
            content = "No hay datos disponibles"; // Muestra un mensaje si está vacío
        }

        // Actualiza el contenido del modal
        document.getElementById('modalBody').innerText = content;

        // Muestra el modal
        document.getElementById('modal').classList.remove('hidden');
    }

    function closeModal() {
        // Oculta el modal
        document.getElementById('modal').classList.add('hidden');
    }
</script>
