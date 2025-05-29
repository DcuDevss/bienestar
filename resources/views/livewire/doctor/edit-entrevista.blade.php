<div class="px-4 py-6">
    <!-- Mensajes de éxito o error -->
    @if (session()->has('success'))
        <<div class="alert alert-success bg-green-500 text-white p-4 rounded-md shadow-md mb-4">
            <strong class="font-bold"></strong>
            <span>{{ session('success') }}</span>
</div>
@endif

@if (session()->has('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<!-- Formulario de edición -->
<form wire:submit.prevent="update" class="shadow-md rounded-lg mb-4 mt-4 mx-auto px-4 py-4 w-9/12">
    <div x-data="{
        tipo_entrevista_id: @entangle('tipo_entrevista_id'),
        posee_arma: @entangle('posee_arma'),
        portacion_id: @entangle('portacion_id'),
        posee_sanciones: @entangle('posee_sanciones'),
        motivo_sanciones: @entangle('motivo_sanciones'),
        indicacionterapeutica_id: @entangle('indicacionterapeutica_id'),
        abordaje_id: @entangle('abordaje_id'),
        derivacion_psiquiatrica: @entangle('derivacion_psiquiatrica'),
        evolucion_tratamiento: @entangle('evolucion_tratamiento')
    }">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Tipo de Entrevista -->
            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="tipo_entrevista_id" class="block text-sm font-medium">Tipo de Entrevista:</label>
                <select x-model="tipo_entrevista_id" class="mt-1 p-2 w-full border rounded-md">
                    @foreach ($tipos_entrevista as $tipo)
                        <option value="{{ $tipo->id }}" @if ($tipo_entrevista_id == $tipo->id) selected @endif>
                            {{ $tipo->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Mostrar si tipo_entrevista_id es 1 (por ejemplo, para "Anual") -->
            <div x-show="!(tipo_entrevista_id == 3 || tipo_entrevista_id == 4 || tipo_entrevista_id == 6 || tipo_entrevista_id == 7)"
                class="mb-4 mx-auto px-4 w-9/12">
                <label for="posee_arma" class="block text-sm font-medium">¿Posee arma?</label>
                <select wire:model="posee_arma" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="" disabled selected>Seleccione una opción</option>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
                @error('posee_arma')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Posee Sanciones -->
            <div x-show="!(tipo_entrevista_id == 3 || tipo_entrevista_id == 4)" class="mb-4 mx-auto px-4 w-9/12">
                <label for="posee_sanciones" class="block text-sm font-medium">Posee Sanciones</label>
                <select wire:model="posee_sanciones"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
                @error('posee_sanciones')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Motivo de Sanciones -->
            <div x-show="!(tipo_entrevista_id == 3 || tipo_entrevista_id == 4)" class="mb-4 mx-auto px-4 w-9/12">
                <label for="motivo_sanciones" class="block text-sm font-medium">Motivo de Sanciones</label>
                <input type="text" wire:model="motivo_sanciones"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('motivo_sanciones')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Causas Judiciales -->
            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="causas_judiciales" class="block text-sm font-medium">Tiene Causas Judiciales</label>
                <select wire:model="causas_judiciales"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
                @error('causas_judiciales')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Motivo de Causas Judiciales -->
            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="motivo_causas_judiciales" class="block text-sm font-medium">Motivo de Causas Judiciales</label>
                <input type="text" wire:model="motivo_causas_judiciales"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('motivo_causas_judiciales')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Sosten de Familia -->
            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="sosten_de_familia" class="block text-sm font-medium">Sosten de Familia</label>
                <select wire:model="sosten_de_familia"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
                @error('sosten_de_familia')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Sosten Económico -->
            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="sosten_economico" class="block text-sm font-medium">Sosten Económico</label>
                <select wire:model="sosten_economico"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
                @error('sosten_economico')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Tiene Embargos -->
            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="tiene_embargos" class="block text-sm font-medium">Tiene Embargos</label>
                <select wire:model="tiene_embargos"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
                @error('tiene_embargos')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Enfermedad Preexistente -->
            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="enfermedad_preexistente" class="block text-sm font-medium">Enfermedad Preexistente</label>
                <select wire:model="enfermedad_preexistente"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
                @error('enfermedad_preexistente')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Medicación -->
            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="medicacion" class="block text-sm font-medium">Medicaciones</label>
                <input type="text" wire:model="medicacion"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('medicacion')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Realizó Tratamiento Psicológico -->
            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="realizo_tratamiento_psicologico" class="block text-sm font-medium">Realizó Tratamiento
                    Psicológico</label>
                <select wire:model="realizo_tratamiento_psicologico"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
                @error('realizo_tratamiento_psicologico')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Hace Cuánto Tratamiento Psicológico -->
            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="hace_cuanto_tratamiento_psicologico" class="block text-sm font-medium">Hace Cuánto Tratamiento
                    Psicológico</label>
                <input type="text" wire:model="hace_cuanto_tratamiento_psicologico"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('hace_cuanto_tratamiento_psicologico')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Fecha -->
            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="fecha" class="block text-sm font-medium">Fecha que realizo el Trataammientto</label>
                <input type="date" wire:model="fecha"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('fecha')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Signos y Síntomas -->
            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="signos_y_sintomas" class="block text-sm font-medium">Signos y Síntomas</label>
                <input type="text" wire:model="signos_y_sintomas"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('signos_y_sintomas')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>



            <!-- Profesional -->
            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="profesional" class="block text-sm font-medium">Profesional</label>
                <input type="text" wire:model="profesional"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('profesional')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Duración -->
            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="duracion" class="block text-sm font-medium">Duración</label>
                <input type="text" wire:model="duracion"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('duracion')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Motivo -->
            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="motivo" class="block text-sm font-medium">Motivo</label>
                <input type="text" wire:model="motivo"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('motivo')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Medicación Recetada -->
            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="medicacion_recetada" class="block text-sm font-medium">Medicación Recetada</label>
                <input type="text" wire:model="medicacion_recetada"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('medicacion_recetada')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div x-show="!(tipo_entrevista_id == 2 || tipo_entrevista_id == 3 || tipo_entrevista_id == 4 || tipo_entrevista_id == 6 || tipo_entrevista_id == 7 || tipo_entrevista_id == 10 || tipo_entrevista_id == 11)"
                class="mb-4 mx-auto px-4 w-9/12">
                <label for="indicacionterapeutica_id" class="block text-sm font-medium">Indicaciones Terapéuticas</label>
                <select wire:model="indicacionterapeutica_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Seleccionar tipo</option>
                    @foreach ($indicacionterapeuticas as $indicacion)
                        <option value="{{ $indicacion->id }}">{{ $indicacion->name }}</option>
                    @endforeach
                </select>
                @error('indicacionterapeutica_id')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div x-show="!(tipo_entrevista_id == 2 || tipo_entrevista_id == 3 || tipo_entrevista_id == 4 || tipo_entrevista_id == 6 || tipo_entrevista_id == 7 || tipo_entrevista_id == 10 || tipo_entrevista_id == 11)"
                class="mb-4 mx-auto px-4 w-9/12">
                <label for="abordaje_id" class="block text-sm font-medium">Abordaje</label>
                <select wire:model="abordaje_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Seleccionar tipo</option>
                    @foreach ($abordajes as $abordaje)
                        <option value="{{ $abordaje->id }}">{{ $abordaje->name }}</option>
                    @endforeach
                </select>
                @error('abordaje_id')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div x-show="!(tipo_entrevista_id == 2 || tipo_entrevista_id == 3 || tipo_entrevista_id == 4 || tipo_entrevista_id == 6 || tipo_entrevista_id == 7 || tipo_entrevista_id == 10 || tipo_entrevista_id == 11)"
                class="mb-4 mx-auto px-4 w-9/12">
                <label for="derivacion_psiquiatrica" class="block text-sm font-medium">Medicación Recetada</label>
                <input type="text" wire:model="derivacion_psiquiatrica"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('derivacion_psiquiatrica')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div x-show="!(tipo_entrevista_id == 2 || tipo_entrevista_id == 3 || tipo_entrevista_id == 4 || tipo_entrevista_id == 6 || tipo_entrevista_id == 7 || tipo_entrevista_id == 10 || tipo_entrevista_id == 11)"
                class="mb-4 mx-auto px-4 w-9/12">
                <label for="evolucion_tratamiento" class="block text-sm font-medium">Medicación Recetada</label>
                <input type="text" wire:model="evolucion_tratamiento"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('evolucion_tratamiento')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>


            <!-- Fuma -->
            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="fuma" class="block text-sm font-medium">Fuma</label>
                <select wire:model="fuma"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
                @error('fuma')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Cantidad de Fuma -->
            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="cantidad_fuma" class="block text-sm font-medium">Cantidad de Fuma</label>
                <input type="number" wire:model="cantidad_fuma"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('cantidad_fuma')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Consume Alcohol -->
            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="consume_alcohol" class="block text-sm font-medium">Consume Alcohol</label>
                <select wire:model="consume_alcohol"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
                @error('consume_alcohol')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Frecuencia de Alcohol -->
            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="frecuencia_alcohol" class="block text-sm font-medium">Frecuencia de Alcohol</label>
                <input type="text" wire:model="frecuencia_alcohol"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('frecuencia_alcohol')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Consume Sustancias -->
            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="consume_sustancias" class="block text-sm font-medium">Consume Sustancias</label>
                <select wire:model="consume_sustancias"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
                @error('consume_sustancias')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Tipo de Sustancia -->
            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="tipo_sustancia" class="block text-sm font-medium">Tipo de Sustancia</label>
                <input type="text" wire:model="tipo_sustancia"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('tipo_sustancia')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Realiza Actividades -->
            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="realiza_actividades" class="block text-sm font-medium">Realiza Actividades</label>
                <select wire:model="realiza_actividades"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
                @error('realiza_actividades')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Actividades -->
            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="actividades" class="block text-sm font-medium">Actividades</label>
                <input type="text" wire:model="actividades"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('actividades')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Horas Dormir -->
            <div class="mb-4  mx-auto px-4 w-9/12">
                <label for="horas_dormir" class="block text-sm font-medium">Horas Dormir</label>
                <input type="number" wire:model="horas_dormir"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('horas_dormir')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Horas Suficientes -->
            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="horas_suficientes" class="block text-sm font-medium">Horas Suficientes</label>
                <select wire:model="horas_suficientes"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
                @error('horas_suficientes')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="notas_clinicas" class="block text-sm font-medium">Notas Clínicas</label>
                <input type="text" wire:model="notas_clinicas"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('notas_clinicas')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

              <!-- Criterio de uso de arma reglamentaria -->

            <div x-show="!(tipo_entrevista_id == 1 || tipo_entrevista_id == 2 || tipo_entrevista_id == 3 )" class="mb-4 mx-auto px-4 w-9/12">
                <label for="portacion_id" class="block text-sm font-medium">Portación de armamento:</label>
                <select wire:model="portacion_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @foreach ($portacions as $portacion)
                         <option value="{{ $portacion->id }}">{{ $portacion->name }}</option>
                    @endforeach
                </select>
                    @error('portacion_id')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
            </div>


            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="tecnica_utilizada" class="block text-sm font-medium">Técnicas Utilizadas</label>
                <input type="text" wire:model="tecnica_utilizada"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('tecnica_utilizada')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4 mx-auto px-4 w-9/12">
                <label for="estado_entevista_id" class="block text-sm font-medium">El Paciente esta Apto</label>
                <select wire:model="estado_entevista_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Seleccionar tipo</option>
                    @foreach ($estados_entrevista as $estado)
                        <option value="{{ $estado->id }}">{{ $estado->name }}</option>
                    @endforeach
                </select>
                @error('estado_entrevista_id')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mt-4">
            <h3 class="text-md font-semibold text-blue-500 ml-4">Editar Miembro/s:</h3>
            <!-- Miembros - Lista inicial -->
            <ul class="list-disc pl-6">
                @foreach($miembros as $index => $miembro)
                    <li>
                        <strong>Nombre: </strong>{{ $miembro->nombre }},
                        <strong>Edad: </strong>{{ $miembro->edad }} años,
                        <strong>Ocupación: </strong> {{ $miembro->ocupacion }},
                        <strong>Parentesco: </strong> {{ $miembro->parentesco }},
                        <strong>Antecedentes Psiquiátricos: </strong> {{ $miembro->antecedentes_psiquiatricos }}
                        <!-- Botón de editar -->
                        <button @click="editMode = true; $wire.editMember({{ $miembro->id }})" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md mb-2">Editar</button>
                    </li>
                @endforeach
            </ul>
            <!-- Formulario de edición - Alpine.js -->
            <div x-data="{ editMode: true, miembro: @entangle('grupo_familiar') }">
            <!-- Formulario de edición del miembro seleccionado -->
                <div x-show="editMode" class="flex space-x-4">
                    <input x-model="miembro.nombre" placeholder="Nombre" class="mt-1 w-full max-w-sm h-10 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <input x-model="miembro.edad" placeholder="Edad" class="mt-1 w-full max-w-sm h-10 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <input x-model="miembro.ocupacion" placeholder="Ocupación" class="mt-1 w-full max-w-sm h-10 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <input x-model="miembro.parentesco" placeholder="Parentesco" class="mt-1 w-full max-w-sm h-10 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <input x-model="miembro.antecedentes_psiquiatricos" placeholder="Antecedentes psiquiátricos" class="mt-1 w-full max-w-sm h-10 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <button @click="editMode = true; $wire.saveMember()" class="ml-2 px-4 py-2 max-w-sm h-10 bg-blue-500 text-white rounded-md mt-2">Guardar</button>
                </div>
            </div>
        </div>





    </div>

    <input type="hidden" wire:model="posee_arma" :value="posee_arma ?? null">
    <input type="hidden" wire:model="portacion_id" :value="portacion_id ?? null">
    <input type="hidden" wire:model="posee_sanciones" :value="posee_sanciones ?? null">
    <input type="hidden" wire:model="motivo_sanciones" :value="motivo_sanciones ?? null">
    <input type="hidden" wire:model="derivacion_psiquiatrica" :value="derivacion_psiquiatrica ?? null">
    <input type="hidden" wire:model="evolucion_tratamiento" :value="evolucion_tratamiento ?? null">
    <input type="hidden" wire:model="abordaje_id" :value="abordaje_id ?? null">
    <input type="hidden" wire:model="indicacionterapeutica_id" :value="indicacionterapeutica_id ?? null">

    <!-- Botón de guardar -->
    <div class="flex justify-center mb-2 mt-4">
        <button type="submit"
            class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-md hover:bg-blue-600 focus:outline-none">Guardar
            Cambios
        </button>
    </div>
    <div class="flex justify-center mb-2 mt-4">
        <button type="button" onclick="window.history.back()"
            class="px-4 py-2 bg-gray-500 text-white rounded-md shadow-md hover:bg-gray-600 focus:outline-none">
            Volver
        </button>
    </div>



    @if (session()->has('success'))
        <div class="bg-green-100 text-green-800 p-4 mb-4 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
</form>
</div>
