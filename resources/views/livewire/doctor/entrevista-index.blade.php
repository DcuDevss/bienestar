<div class="w-full px-4">
    <h1 class="text-2xl font-semibold mb-6 text-center mt-2">Entrevistas del Paciente</h1>

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
                                        <p >
                                            <strong>Actitud del Paciente:</strong>
                                            {{ $entrevista->actitudEntrevista->name ?? 'Sin Datos' }}
                                        </p>
                                        <p class="{{ $color }}">
                                            <strong>El paciente se encuentra:</strong>
                                            {{ $entrevista->estadoEntrevista->name ?? 'Sin Datos' }}
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

                                @if (!empty($entrevista->evolucion_tratamiento))
                                    <p><strong>Indicaciones Terapéuticas:</strong>
                                        {{ $entrevista->indicaciones_terapeuticas ?? 'Sin Datos' }}
                                    </p>
                                @endif
                            </div>

                            <!-- Sección Grupo Familiar -->
                            <div class="border-b pb-4 mb-4">
                                <h4 class="text-xl font-semibold mb-2">Grupo Familiar</h4>
                                @foreach ($entrevista->grupoFamiliar as $miembro)
                                    <div class="space-y-2">
                                        <p><strong>Nombre:</strong> {{ $miembro->nombre ?? 'Sin Datos' }}</p>
                                        <p><strong>Edad:</strong> {{ $miembro->edad ?? 'Sin Datos' }}</p>
                                        <p><strong>Ocupación:</strong> {{ $miembro->ocupacion ?? 'Sin Datos' }}</p>
                                        <p><strong>Parentesco:</strong> {{ $miembro->parentesco ?? 'Sin Datos' }}</p>
                                        <p><strong>Antecedentes Psiquiátricos:</strong>
                                            {{ $miembro->antecedentes_psiquiatricos ?? 'Sin Datos' }}</p>
                                    </div>
                                @endforeach
                                @if ($entrevista->grupoFamiliar->isEmpty())
                                    <p>No hay miembros registrados para este grupo familiar.</p>
                                @endif
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
