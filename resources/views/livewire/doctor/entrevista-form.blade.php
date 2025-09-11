<div>
    @if (session()->has('message'))
        <div class="alert alert-success bg-green-500 text-white p-4 rounded-md shadow-md mb-4">
            <strong class="font-bold"></strong>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <div class="p-3 bg-gray-100 rounded shadow mb-4 text-center">
        <div>
            <h3 class="font-semibold text-lg">Paciente:</h3>{{ $paciente->apellido_nombre ?? 'Nombre no disponible' }}
        </div>
    </div>


    <form wire:submit.prevent="submit">
        @csrf

        <!-- Card de Entrevista -->
        <div class="bg-white shadow-md rounded-lg mb-4 mt-4 mx-auto px-4 w-9/12">
            <div class="p-4 border-b cursor-pointer" onclick="toggleCard('collapseOne')">
                <h3 class="font-semibold text-lg">Entrevista</h3>
            </div>

            <div id="collapseOne" class="collapse-content p-4 hidden">
                <!-- Tipo de entrevista -->
                <div x-data="{
                    tipo_entrevista_id: @entangle('tipo_entrevista_id'),
                    portacion_id: @entangle('portacion_id'),
                    salud_mentale_id: @entangle('salud_mentale_id'),
                    posee_arma: @entangle('posee_arma'),
                    posee_sanciones: @entangle('posee_sanciones'),
                    motivo_sanciones: @entangle('motivo_sanciones'),
                    indicacionterapeutica_id: @entangle('indicacionterapeutica_id'),
                    abordaje_id: @entangle('abordaje_id'),
                    derivacion_psiquiatrica: @entangle('derivacion_psiquiatrica'),
                    evolucion_tratamiento: @entangle('evolucion_tratamiento')
                }"> <!-- Usamos x-data para manejar el estado en Alpine -->

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Tipo de Entrevista -->
                    <div class="mb-4">
                        <label for="tipo_entrevista_id" class="block text-sm font-medium text-gray-700">Tipo de
                            Entrevista:</label>
                        <select x-model="tipo_entrevista_id" class="mt-1 p-2 w-full border rounded-md">
                            <option value="">Seleccione una opción</option>
                            @foreach ($tipos_entrevista as $tipo)
                                <option value="{{ $tipo->id }}" @if ($tipo_entrevista_id == $tipo->id) selected @endif>
                                    {{ $tipo->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipo_entrevista_id')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Datos Médicos (Campos condicionales) -->

                    <!-- Mostrar si tipo_entrevista_id es 1 (por ejemplo, para "Anual") -->
                    <div x-show="!(tipo_entrevista_id == 3 || tipo_entrevista_id == 4 || tipo_entrevista_id == 6 || tipo_entrevista_id == 7)"
                        class="mb-4">
                        <label for="posee_arma" class="block text-sm font-medium text-gray-700">¿Posee arma?</label>
                        <select wire:model="posee_arma" class="mt-1 p-2 w-full border rounded-md">
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        @error('posee_arma')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>


                    <!-- Mostrar si tipo_entrevista_id es 2 (por ejemplo, para "Ascenso") -->
                    <div x-show="!(tipo_entrevista_id == 3 || tipo_entrevista_id == 4)" class="mb-4">
                        <label for="posee_sanciones" class="block text-sm font-medium text-gray-700">¿Posee
                            sanciones?</label>
                        <select wire:model="posee_sanciones" class="mt-1 p-2 w-full border rounded-md">
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        @error('posee_sanciones')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>


                    <!-- Mostrar si tipo_entrevista_id es 3 (por ejemplo, para "Postulante") -->
                    <div x-show="!(tipo_entrevista_id == 3 || tipo_entrevista_id == 4)" class="mb-4">
                        <label for="motivo_sanciones" class="block text-sm font-medium text-gray-700">Motivo de las
                            sanciones</label>
                        <textarea type="text" wire:model="motivo_sanciones" class="mt-1 p-2 w-full border rounded-md"></textarea>
                        @error('motivo_sanciones')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>


                    <!-- Mostrar si tipo_entrevista_id es 4 (por ejemplo, para "Reintegro") -->
                    <div x-show="" class="mb-4">
                        <label for="causas_judiciales" class="block text-sm font-medium text-gray-700">¿Tiene causas
                            judiciales?</label>
                        <select wire:model="causas_judiciales" class="mt-1 p-2 w-full border rounded-md">
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        @error('causas_judiciales')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Mostrar más campos condicionales aquí según el tipo de entrevista -->
                    <div x-show="" class="mb-4">
                        <label for="motivo_causas_judiciales" class="block text-sm font-medium text-gray-700">Motivo de
                            las causas judiciales</label>
                        <textarea type="text" wire:model="motivo_causas_judiciales" class="mt-1 p-2 w-full border rounded-md"></textarea>
                        @error('motivo_causas_judiciales')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Campos adicionales que quieras agregar con la misma lógica -->
                    <div x-show="" class="mb-4">
                        <label for="sosten_de_familia" class="block text-sm font-medium text-gray-700">¿Sos sosten de
                            Familia?</label>
                        <select wire:model="sosten_de_familia" class="mt-1 p-2 w-full border rounded-md">
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div x-show="" class="mb-4">
                        <label for="sosten_economico" class="block text-sm font-medium text-gray-700">¿Sos sosten
                            Económico?</label>
                        <select wire:model="sosten_economico" class="mt-1 p-2 w-full border rounded-md">
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div x-show="" class="mb-4">
                        <label for="tiene_embargos" class="block text-sm font-medium text-gray-700">¿Tiene
                            Embargos?</label>
                        <select wire:model="tiene_embargos" class="mt-1 p-2 w-full border rounded-md">
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
                </div>

            </div>
        </div>

        <!-- Card de Grupo Familiar -->
        <div class="bg-white shadow-md rounded-lg mb-4 mx-auto px-4 w-9/12">
            <div class="p-4 border-b cursor-pointer" onclick="toggleCard('collapseTwo')">
                <h3 class="font-semibold text-lg">Grupo Familiar</h3>
            </div>

            <div id="collapseTwo" class="collapse-content p-4 hidden">
                <div class="mb-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">


                            <div class="mb-4">
                                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre:</label>
                                <input type="text" wire:model="grupo_familiar.nombre"
                                    class="mt-1 p-2 w-full border rounded-md" placeholder="Nombre del familiar">
                                @error('miembros.*.nombre')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="edad" class="block text-sm font-medium text-gray-700">Edad:</label>
                                <input type="number" wire:model="grupo_familiar.edad"
                                    class="mt-1 p-2 w-full border rounded-md" placeholder="Edad del familiar">
                                @error('miembros.*.edad')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="ocupacion" class="block text-sm font-medium text-gray-700">Ocupación:</label>
                                <input type="text" wire:model="grupo_familiar.ocupacion"
                                    class="mt-1 p-2 w-full border rounded-md" placeholder="Ocupación del familiar">
                                @error('miembros.*.ocupacion')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="parentesco"
                                    class="block text-sm font-medium text-gray-700">Parentesco:</label>
                                <input type="text" wire:model="grupo_familiar.parentesco"
                                    class="mt-1 p-2 w-full border rounded-md" placeholder="Parentesco">
                                @error('miembros.*.parentesco')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="antecedentes_psiquiatricos"
                                    class="block text-sm font-medium text-gray-700">Antecedentes Psiquiatricos:</label>
                                <input type="text" wire:model="grupo_familiar.antecedentes_psiquiatricos"
                                    class="mt-1 p-2 w-full border rounded-md" placeholder="Antecedentes">
                                @error('miembros.*.antecedentes_psiquiatricos')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                    </div>
                    <div class="mt-4 flex justify-start">
                        <button type="button" wire:click="addMember" class="text-white bg-blue-500 p-2 rounded w-auto">
                            Agregar Miembro
                        </button>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-md font-semibold text-blue-500 ml-4">Miembros Agregados:</h3>
                <ul class="list-disc pl-6">
                    @foreach ($miembros as $index => $miembro)
                        <li>
                            <strong>Nombre: </strong>{{ $miembro['nombre'] }},
                            <strong>Edad: </strong>{{ $miembro['edad'] }} años,
                            <strong>Ocupación: </strong> {{ $miembro['ocupacion'] }},
                            <strong>Parentesco: </strong> {{ $miembro['parentesco'] }},
                            <strong>Antecedentes Psiquiátricos: </strong> {{ $miembro['antecedentes_psiquiatricos'] }}
                             <!-- Botón para eliminar el miembro -->
                            <button type="button" wire:click="removeMember({{ $index }})" class="px-2 mb-2 ml-2 text-center bg-red-500 text-white rounded-md shadow-md hover:bg-red-600 focus:outline-none">
                                X
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Card de Otros Campos Médicos -->
        <div class="bg-white shadow-md rounded-lg mb-4 mx-auto px-4 w-9/12">
            <div class="p-4 border-b cursor-pointer" onclick="toggleCard('collapseThree')">
                <h3 class="font-semibold text-lg">Datos Médicos</h3>
            </div>

            <div id="collapseThree" class="collapse-content p-4 hidden">

                <div x-data="{ tipo_entrevista_id: @entangle('tipo_entrevista_id') }">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="mb-4">
                        <label for="enfermedad_preexistente" class="block text-sm font-medium text-gray-700">¿Posee
                            alguna
                            enfermmedad Preexistente?</label>
                        <select wire:model="enfermedad_preexistente" class="mt-1 p-2 w-full border rounded-md">
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        @error('enfermedad_preexistente')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="medicacion" class="block text-sm font-medium text-gray-700">Medicamentos:</label>
                        <input type="text" wire:model="medicacion" class="mt-1 p-2 w-full border rounded-md"
                            placeholder="Medicamentos que toma">
                        @error('medicacion')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="realizo_tratamiento_psicologico"
                            class="block text-sm font-medium text-gray-700">¿Realizó
                            algún tratamiento psiquiatrico o psicológico?</label>
                        <select wire:model="realizo_tratamiento_psicologico" class="mt-1 p-2 w-full border rounded-md">
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        @error('realizo_tratamiento_psicologico')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="hace_cuanto_tratamiento_psicologico"
                            class="block text-sm font-medium text-gray-700">¿Hace cuánto?</label>
                        <input type="text" wire:model="hace_cuanto_tratamiento_psicologico"
                            class="mt-1 p-2 w-full border rounded-md">
                        @error('hace_cuanto_tratamiento_psicologico')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="mb-4">
                        <label for="signos_y_sintomas" class="block text-sm font-medium text-gray-700">Signos y
                            Síntomas:</label>
                        <textarea wire:model="signos_y_sintomas" class="mt-1 p-2 w-full border rounded-md"
                            placeholder="Describa los signos y síntomas"></textarea>
                        @error('signos_y_sintomas')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha que lo
                            realizó</label>
                        <input type="date" wire:model="fecha" class="mt-1 p-2 w-full border rounded-md">
                        @error('fecha')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="profesional" class="block text-sm font-medium text-gray-700">Profesional que lo
                            atendió</label>
                        <input type="text" wire:model="profesional" class="mt-1 p-2 w-full border rounded-md">
                        @error('profesional')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="duracion" class="block text-sm font-medium text-gray-700">Duracion del
                            Tratamiento</label>
                        <input type="text" wire:model="duracion" class="mt-1 p-2 w-full border rounded-md">
                        @error('duracion')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="motivo" class="block text-sm font-medium text-gray-700">Motivo del
                            Tratamiento</label>
                        <textarea type="text" wire:model="motivo" class="mt-1 p-2 w-full border rounded-md"></textarea>
                        @error('motivo')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="medicacion_recetada" class="block text-sm font-medium text-gray-700">Medicación
                            que le Recetaron</label>
                        <input type="text" wire:model="medicacion_recetada"
                            class="mt-1 p-2 w-full border rounded-md">
                        @error('medicacion_recetada')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="fuma" class="block text-sm font-medium text-gray-700">Fuma?</label>
                        <select wire:model="fuma" class="mt-1 p-2 w-full border rounded-md">
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        @error('fuma')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="cantidad_fuma" class="block text-sm font-medium text-gray-700">Cantidad por día:</label>
                        <input type="number" wire:model="cantidad_fuma" class="mt-1 p-2 w-full border rounded-md">
                        @error('cantidad_fuma')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="consume_alcohol" class="block text-sm font-medium text-gray-700">Consume
                            Alcohol?</label>
                        <select wire:model="consume_alcohol" class="mt-1 p-2 w-full border rounded-md">
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        @error('consume_alcohol')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="frecuencia_alcohol" class="block text-sm font-medium text-gray-700">Cantidad y
                            frecuencia con la que consume alcohol</label>
                        <input type="text" wire:model="frecuencia_alcohol"
                            class="mt-1 p-2 w-full border rounded-md">
                        @error('frecuencia_alcohol')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="consume_sustancias" class="block text-sm font-medium text-gray-700">Consume o
                            consumió
                            alguna sustancia psicotropica?</label>
                        <select wire:model="consume_sustancias" class="mt-1 p-2 w-full border rounded-md">
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                            @error('consume_sustancias')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="tipo_sustancia" class="block text-sm font-medium text-gray-700">Qué tipo de
                            sustancia
                            consume o consumió?</label>
                        <input type="text" wire:model="tipo_sustancia" class="mt-1 p-2 w-full border rounded-md">
                        @error('tipo_sustancia')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="realiza_actividades" class="block text-sm font-medium text-gray-700">Realiza
                            actividades
                            recreativas o posee otro empleo?</label>
                        <select wire:model="realiza_actividades" class="mt-1 p-2 w-full border rounded-md">
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                            @error('realiza_actividades')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="actividades" class="block text-sm font-medium text-gray-700">Qué actividades
                            realiza?</label>
                        <textarea type="text" wire:model="actividades" class="mt-1 p-2 w-full border rounded-md"></textarea>
                        @error('actividades')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="horas_dormir" class="block text-sm font-medium text-gray-700">Cuántas horas duerme
                            por
                            día?</label>
                        <input type="number" wire:model="horas_dormir" class="mt-1 p-2 w-full border rounded-md"
                            min="0" max="24" step="1">
                        @error('horas_dormir')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="mb-4">
                        <label for="horas_suficientes" class="block text-sm font-medium text-gray-700">Son Suficientes
                            las
                            horas que duerme?</label>
                        <select wire:model="horas_suficientes" class="mt-1 p-2 w-full border rounded-md">
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                            @error('horas_suficientes')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </select>

                    </div>


                    <div class="mb-4">
                        <label for="notas_clinicas" class="block text-sm font-medium text-gray-700">Notas
                            Clínicas:</label>
                        <textarea wire:model="notas_clinicas" class="mt-1 p-2 w-full border rounded-md" placeholder=""></textarea>
                        @error('notas_clinicas')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Actitud frente a la entrevista -->
                    <div class="mb-4">
                        <label for="actitud_entrevista_id" class="block text-sm font-medium text-gray-700">Actitud
                            frente a la entrevista:</label>
                        <select wire:model="actitud_entrevista_id" class="mt-1 p-2 w-full border rounded-md">
                            <option value="">Seleccione una opción</option>
                            @foreach ($actitudes_entrevista as $actitud)
                                <option value="{{ $actitud->id }}">{{ $actitud->name }}</option>
                            @endforeach
                        </select>
                        @error('actitud_entrevista_id')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="tecnica_utilizada" class="block text-sm font-medium text-gray-700">Técnicas
                            Utilizadas:</label>
                        <textarea wire:model="tecnica_utilizada" class="mt-1 p-2 w-full border rounded-md" placeholder=""></textarea>
                        @error('tecnica_utilizada')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>



                    <div class="mb-4">
                        <label for="estado_entrevista_id" class="block text-sm font-medium text-gray-700">Estado de la
                            Entrevista:</label>
                        <select wire:model="estado_entrevista_id" class="mt-1 p-2 w-full border rounded-md">
                            <option value="">Seleccione una opción</option>
                            @foreach ($estados_entrevista as $estado)
                                <option value="{{ $estado->id }}">{{ $estado->name }}</option>
                            @endforeach
                        </select>
                        @error('estado_entrevista_id')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div x-show="!(tipo_entrevista_id == 2 || tipo_entrevista_id == 3 || tipo_entrevista_id == 4 || tipo_entrevista_id == 6 || tipo_entrevista_id == 7 || tipo_entrevista_id == 10 || tipo_entrevista_id == 11)"
                        class="mb-4">
                        <label for="indicacionterapeutica_id"
                            class="block text-sm font-medium text-gray-700">Indicaciones
                            Terapéuticas:</label>
                        <select wire:model="indicacionterapeutica_id" class="mt-1 p-2 w-full border rounded-md">
                            <option value="">Seleccione una opción</option>
                            @foreach ($indicacionterapeuticas as $indicacion)
                                <option value="{{ $indicacion->id }}">{{ $indicacion->name }}</option>
                            @endforeach
                        </select>
                        @error('indicacionterapeutica_id')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div x-data x-init="new TomSelect($refs.selectSalud, {})"
                        x-show="!(tipo_entrevista_id == 1 || tipo_entrevista_id == 2 || tipo_entrevista_id == 3 || tipo_entrevista_id == 4 || tipo_entrevista_id == 6 || tipo_entrevista_id == 7 || tipo_entrevista_id == 11)"
                        class="mb-4">
                        <label for="salud_mentale_id" class="block text-sm font-medium text-gray-700">Diagnóstico:</label>
                        <select x-ref="selectSalud" wire:model="salud_mentale_id" class="mt-1 p-2 w-full border rounded-md">
                            <option value="">Seleccione una opción</option>
                            @foreach ($salud_mentales as $salud)
                                <option value="{{ $salud->id }}">{{ $salud->codigo }} - {{ $salud->name }}</option>
                            @endforeach
                        </select>
                        @error('salud_mentale_id')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>




                    <div x-show="!(tipo_entrevista_id == 2 || tipo_entrevista_id == 3 || tipo_entrevista_id == 4 || tipo_entrevista_id == 6 || tipo_entrevista_id == 7 || tipo_entrevista_id == 10 || tipo_entrevista_id == 11)"
                        class="mb-4">
                        <label for="abordaje_id" class="block text-sm font-medium text-gray-700">Abordaje:</label>
                        <select wire:model="abordaje_id" class="mt-1 p-2 w-full border rounded-md">
                            <option value="">Seleccione una opción</option>
                            @foreach ($abordajes as $abordaje)
                                <option value="{{ $abordaje->id }}">{{ $abordaje->name }}</option>
                            @endforeach
                        </select>
                        @error('abordaje_id')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>



                    <div x-show="!(tipo_entrevista_id == 2 || tipo_entrevista_id == 3 || tipo_entrevista_id == 4 || tipo_entrevista_id == 6 || tipo_entrevista_id == 7 || tipo_entrevista_id == 10 || tipo_entrevista_id == 11)"
                        class="mb-4">
                        <label for="derivacion_psiquiatrica"
                            class="block text-sm font-medium text-gray-700">Derivacion Psiquiatrica:</label>
                        <textarea wire:model="derivacion_psiquiatrica" class="mt-1 p-2 w-full border rounded-md" placeholder=""></textarea>
                        @error('derivacion_psiquiatrica')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>


                    <div x-show="!(tipo_entrevista_id == 2 || tipo_entrevista_id == 3 || tipo_entrevista_id == 4 || tipo_entrevista_id == 6 || tipo_entrevista_id == 7 || tipo_entrevista_id == 10 || tipo_entrevista_id == 11)"
                        class="mb-4">
                        <label for="evolucion_tratamiento" class="block text-sm font-medium text-gray-700">Evolucion
                            Tratamiento:</label>
                        <textarea wire:model="evolucion_tratamiento" class="mt-1 p-2 w-full border rounded-md"
                            placeholder="Notas adicionales"></textarea>
                        @error('evolucion_tratamiento')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Criterio de uso de arma reglamentaria -->

                    <div x-show="!(tipo_entrevista_id == 1 || tipo_entrevista_id == 2 || tipo_entrevista_id == 3 )" class="mb-4">
                        <label for="portacion_id" class="block text-sm font-medium text-gray-700">Portación de armamento:</label>
                        <select wire:model="portacion_id" class="mt-1 p-2 w-full border rounded-md">
                            <option value="">Seleccione una opción</option>
                            @foreach ($portacions as $portacion)
                                <option value="{{ $portacion->id }}">{{ $portacion->name }}</option>
                            @endforeach
                        </select>
                        @error('portacion_id')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                                        <!-- Mostrar solo si aptitud_reintegro es Sí -->
                    <div x-show="!(tipo_entrevista_id == 1|| tipo_entrevista_id == 2 || tipo_entrevista_id == 3 || tipo_entrevista_id == 4 )" class="mb-4">
                        <label for="recomendacion" class="block text-sm font-medium text-gray-700">Se recomienda realizar/continuar tratamiento:</label>
                         <select wire:model="recomendacion" class="mt-1 p-2 w-full border rounded-md">
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        @error('recomendacion')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>


                </div>
            </div>
        </div>
        <input type="hidden" wire:model="salud_mentale_id" :value="salud_mentale_id ?? null">
        <input type="hidden" wire:model="portacion_id" :value="portacion_id ?? null">
        <input type="hidden" wire:model="posee_arma" :value="posee_arma ?? null">
        <input type="hidden" wire:model="posee_sanciones" :value="posee_sanciones ?? null">
        <input type="hidden" wire:model="motivo_sanciones" :value="motivo_sanciones ?? null">
        <input type="hidden" wire:model="derivacion_psiquiatrica" :value="derivacion_psiquiatrica ?? null">
        <input type="hidden" wire:model="evolucion_tratamiento" :value="evolucion_tratamiento ?? null">
        <input type="hidden" wire:model="abordaje_id" :value="abordaje_id ?? null">
        <input type="hidden" wire:model="indicacionterapeutica_id" :value="indicacionterapeutica_id ?? null">

        <div class="mt-4 w-full flex justify-between items-center ml-4">
    <!-- Grupo Izquierdo: 3 botones -->
    <div class="flex gap-4 items-center">
        <!-- Botón Guardar -->
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md sm:w-auto">
            Guardar
        </button>

        <!-- Ver entrevistas paciente -->
        @if ($paciente)
            <a href="{{ route('entrevistas.index', ['paciente_id' => $paciente->id]) }}"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md sm:w-auto">
                Ver entrevistas del paciente
            </a>
        @else
            <p>No se encontró el paciente.</p>
        @endif
    </div>

    <!-- Grupo Derecho: 2 elementos -->
    <div class="flex gap-4 items-center mr-6 mb-4">
        <!-- Imagen con link (BCRA) -->
        <a href="https://rcta.me/?utm_term=&utm_campaign=RCTA+DNU/+Pmax+/+Reconnect&utm_source=adwords&utm_medium=ppc&hsa_acc=3976412703&hsa_cam=21983270123&hsa_grp=&hsa_ad=&hsa_src=x&hsa_tgt=&hsa_kw=&hsa_mt=&hsa_net=adwords&hsa_ver=3&gad_source=1&gad_campaignid=21983271299&gbraid=0AAAAAp3bv2M-2NoWfjCKXwvQFRekKOKO3&gclid=Cj0KCQjwgIXCBhDBARIsAELC9ZhPejgMuncQuoBdXnlBKYeV4pe06k2knUoVCHSvUOPPzjFGOfIv6vgaAgpOEALw_wcB
            " target="_blank" class="bg-white rounded-md py-1 px-3 inline-flex items-center justify-center"">
            <img class="h-[50px]" src="{{ asset('assets/rctaLogo.jpg') }}" alt="">
        </a>

        <!-- Botón con imagen OSEF -->
        <a href="https://prescriptorweb.ddaval.com.ar/" target="_blank" class="bg-blue-600 rounded-md py-1 px-3 inline-flex items-center justify-center">
            <img class="h-[25px]" src="https://osef.gob.ar/assets/images/osef-logotipo.png" alt="">
        </a>

    </div>
</div>

    </form>
    <div>
</div>

</div>
 {{-- Botón para abrir el modal --}}






<script>
    function toggleCard(id) {
        const card = document.getElementById(id);
        card.classList.toggle('hidden');
    }
</script>
