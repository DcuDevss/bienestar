<div class="padreTablas flex gap-x-2 px-6 min-h-screen bg-gray-100 py-8">

    <section class="seccionTab xl:mx-auto lg:mx-auto w-[95%]">

        <div class="mx-auto text-[12px]">

            <div class="bg-white shadow-md sm:rounded-lg p-6">

                <!-- Encabezado -->
                <div class="flex justify-center mb-6">
                    <h2 class="text-3xl font-bold text-gray-800 text-center">
                        Ficha Kinesiológica del Paciente
                    </h2>
                </div>

                <!-- Datos del Paciente -->
                <div class="overflow-x-auto mb-6">
                    <table class="w-full text-left text-gray-600 border border-gray-200 rounded-lg">
                        <tbody>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-2 border-b border-gray-200">Nombre</th>
                                <td class="px-4 py-2 border-b border-gray-200">{{ $paciente->apellido_nombre }}</td>
                                <th class="px-4 py-2 border-b border-gray-200">DNI</th>
                                <td class="px-4 py-2 border-b border-gray-200">{{ $paciente->dni }}</td>
                                <th class="px-4 py-2 border-b border-gray-200">Edad</th>
                                <td class="px-4 py-2 border-b border-gray-200">{{ $paciente->edad }} años</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
<!-- Formulario Kinesiología -->
<form wire:submit.prevent="saveFichaKinesiologica" class="space-y-10">
                <!-- SECCIÓN I: Anamnesis -->
                <div class="mt-8">
                    <h3 class="text-2xl font-semibold text-gray-700 mb-4 border-b pb-2">Anamnesis</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-gray-600 border border-gray-200 rounded-lg">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 border-b border-gray-200">Campo</th>
                                    <th class="px-4 py-2 border-b border-gray-200">Valor</th>
                                </tr>
                            </thead>
                            <tbody>

                                <!-- Doctor -->
                                <tr>
                                    <td class="px-4 py-2 border-b border-gray-200 font-medium">Doctor</td>
                                    <td class="px-4 py-2 border-b border-gray-200">
                                        <input type="text" wire:model.defer="doctor_name" wire:blur="verificarDoctor"
                                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"
                                            placeholder="Nombre del doctor">
                                        @error('doctor_name')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror

                                        @if ($showDoctorAlert)
                                            <div
                                                class="mt-3 p-3 bg-yellow-50 border border-yellow-400 text-yellow-800 rounded-lg">
                                                <p>El doctor <strong>{{ $doctor_name }}</strong> no existe en el
                                                    sistema.</p>
                                                <p class="text-sm mt-1">¿Desea agregarlo con los datos ingresados?</p>
                                                <div class="mt-2 flex gap-2">
                                                    <button wire:click="crearDoctor" type="button"
                                                        class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Sí,
                                                        agregar</button>
                                                    <button wire:click="$set('showDoctorAlert', false)" type="button"
                                                        class="bg-gray-400 text-white px-3 py-1 rounded hover:bg-gray-500">Cancelar</button>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Matrícula -->
                                <tr>
                                    <td class="px-4 py-2 border-b border-gray-200 font-medium">Matrícula</td>
                                    <td class="px-4 py-2 border-b border-gray-200">
                                        <input type="text" wire:model.defer="doctor_matricula"
                                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"
                                            placeholder="Número de matrícula">
                                        @error('doctor_matricula')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>

                                <!-- Especialidad -->
                                <tr>
                                    <td class="px-4 py-2 border-b border-gray-200 font-medium">Especialidad</td>
                                    <td class="px-4 py-2 border-b border-gray-200">
                                        <input list="especialidades" wire:model.defer="doctor_especialidad"
                                            wire:blur="verificarEspecialidad"
                                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"
                                            placeholder="Seleccione o escriba una especialidad...">
                                        <datalist id="especialidades">
                                            @foreach ($especialidades as $esp)
                                                <option value="{{ $esp }}"></option>
                                            @endforeach
                                        </datalist>
                                        @error('doctor_especialidad')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror

                                        @if ($showEspecialidadAlert)
                                            <div
                                                class="mt-3 p-3 bg-yellow-50 border border-yellow-400 text-yellow-800 rounded-lg">
                                                <p>La especialidad <strong>{{ $doctor_especialidad }}</strong> no
                                                    existe.</p>
                                                <p class="text-sm mt-1">¿Desea agregarla al sistema?</p>
                                                <div class="mt-2 flex gap-2">
                                                    <button wire:click="crearEspecialidad" type="button"
                                                        class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Sí,
                                                        agregar</button>
                                                    <button wire:click="$set('showEspecialidadAlert', false)"
                                                        type="button"
                                                        class="bg-gray-400 text-white px-3 py-1 rounded hover:bg-gray-500">Cancelar</button>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Obra Social -->
                                <tr>
                                    <td class="px-4 py-2 border-b border-gray-200 font-medium">Obra Social</td>
                                    <td class="px-4 py-2 border-b border-gray-200">
                                        <select wire:model="obra_social_id"
                                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                                            <option value="">Seleccione una obra social</option>
                                            @foreach ($obrasSociales as $obra)
                                                <option value="{{ $obra->id }}">{{ $obra->nombre }}</option>
                                            @endforeach
                                        </select>
                                        @error('obra_social_id')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>

                                <!-- Diagnóstico -->
                                <tr>
                                    <td class="px-4 py-2 border-b border-gray-200 font-medium">Diagnóstico</td>
                                    <td class="px-4 py-2 border-b border-gray-200">
                                        <input type="text" wire:model="diagnostico"
                                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                                    </td>
                                </tr>

                                <!-- Motivo de consulta -->
                                <tr>
                                    <td class="px-4 py-2 border-b border-gray-200 font-medium">Motivo de consulta</td>
                                    <td class="px-4 py-2 border-b border-gray-200">
                                        <input type="text" wire:model="motivo_consulta"
                                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                                    </td>
                                </tr>

                                <!-- Posturas dolorosas -->
                                <tr>
                                    <td class="px-4 py-2 border-b border-gray-200 font-medium">Posturas dolorosas</td>
                                    <td class="px-4 py-2 border-b border-gray-200">
                                        <input type="text" wire:model="posturas_dolorosas"
                                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                                    </td>
                                </tr>

                                <!-- Actividad física -->
                                <tr>
                                    <td class="px-4 py-2 border-b border-gray-200 font-medium">¿Realiza actividad
                                        física?</td>
                                    <td class="px-4 py-2 border-b border-gray-200">
                                        <select wire:model="realiza_actividad_fisica"
                                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                                            <option value="">Seleccione</option>
                                            <option value="1">Sí</option>
                                            <option value="0">No</option>
                                        </select>
                                    </td>
                                </tr>

                                <!-- Tipo de actividad -->
                                <tr>
                                    <td class="px-4 py-2 border-b border-gray-200 font-medium">Tipo de actividad</td>
                                    <td class="px-4 py-2 border-b border-gray-200">
                                        <input type="text" wire:model="tipo_actividad"
                                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                                    </td>
                                </tr>

                                <!-- Antecedentes personales -->
                                <tr>
                                    <td class="px-4 py-2 border-b border-gray-200 font-medium">Antecedentes personales
                                    </td>
                                    <td class="px-4 py-2 border-b border-gray-200">
                                        <textarea wire:model="antecedentes_enfermedades" rows="2"
                                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea>
                                    </td>
                                </tr>

                                <!-- Antecedentes familiares -->
                                <tr>
                                    <td class="px-4 py-2 border-b border-gray-200 font-medium">Antecedentes familiares
                                    </td>
                                    <td class="px-4 py-2 border-b border-gray-200">
                                        <textarea wire:model="antecedentes_familiares" rows="2"
                                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea>
                                    </td>
                                </tr>

                                <!-- Cirugías -->
                                <tr>
                                    <td class="px-4 py-2 border-b border-gray-200 font-medium">Cirugías</td>
                                    <td class="px-4 py-2 border-b border-gray-200">
                                        <textarea wire:model="cirugias" rows="2" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea>
                                    </td>
                                </tr>

                                <!-- Traumatismos o accidentes -->
                                <tr>
                                    <td class="px-4 py-2 border-b border-gray-200 font-medium">Traumatismos o
                                        accidentes</td>
                                    <td class="px-4 py-2 border-b border-gray-200">
                                        <textarea wire:model="traumatismos_accidentes" rows="2"
                                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea>
                                    </td>
                                </tr>

                                <!-- Tratamientos previos -->
                                <tr>
                                    <td class="px-4 py-2 border-b border-gray-200 font-medium">Tratamientos previos
                                    </td>
                                    <td class="px-4 py-2 border-b border-gray-200">
                                        <textarea wire:model="tratamientos_previos" rows="2"
                                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea>
                                    </td>
                                </tr>

                                <!-- Estado de salud general -->
                                <tr>
                                    <td class="px-4 py-2 border-b border-gray-200 font-medium">Estado de salud general
                                    </td>
                                    <td class="px-4 py-2 border-b border-gray-200">
                                        <select wire:model="estado_salud_general"
                                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                                            <option value="">Seleccione</option>
                                            <option value="Bueno">Bueno</option>
                                            <option value="Medio">Medio</option>
                                            <option value="Malo">Malo</option>
                                        </select>
                                    </td>
                                </tr>

                                <!-- Alteración de peso -->
                                <tr>
                                    <td class="px-4 py-2 border-b border-gray-200 font-medium">¿Presenta alteración de
                                        peso?</td>
                                    <td class="px-4 py-2 border-b border-gray-200">
                                        <select wire:model="alteracion_peso"
                                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                                            <option value="">Seleccione</option>
                                            <option value="1">Sí</option>
                                            <option value="0">No</option>
                                        </select>
                                    </td>
                                </tr>

                                <!-- Medicación actual -->
                                <tr>
                                    <td class="px-4 py-2 border-b border-gray-200 font-medium">Medicación actual</td>
                                    <td class="px-4 py-2 border-b border-gray-200">
                                        <textarea wire:model="medicacion_actual" rows="2"
                                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea>
                                    </td>
                                </tr>

                                <!-- Observaciones generales -->
                                <tr>
                                    <td class="px-4 py-2 border-b border-gray-200 font-medium">Observaciones generales
                                    </td>
                                    <td class="px-4 py-2 border-b border-gray-200">
                                        <textarea wire:model="observaciones_generales_anamnesis" rows="2"
                                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea>
                                    </td>
                                </tr>

                                <!-- Campos ginecológicos -->
                                <tr>
                                    <td class="px-4 py-2 border-b border-gray-200 font-medium">Menarca</td>
                                    <td class="px-4 py-2 border-b border-gray-200">
                                        <select wire:model="menarca"
                                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                                            <option value="">Seleccione</option>
                                            <option value="1">Sí</option>
                                            <option value="0">No</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="px-4 py-2 border-b border-gray-200 font-medium">Menopausia</td>
                                    <td class="px-4 py-2 border-b border-gray-200">
                                        <select wire:model="menopausia"
                                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                                            <option value="">Seleccione</option>
                                            <option value="1">Sí</option>
                                            <option value="0">No</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="px-4 py-2 border-b border-gray-200 font-medium">Partos</td>
                                    <td class="px-4 py-2 border-b border-gray-200">
                                        <input type="number" wire:model="partos" min="0"
                                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>


                <!-- SECCIÓN II: Examen EOM -->
                <div class="mt-8">
                    <h3 class="text-2xl font-semibold text-gray-700 mb-4 border-b pb-2">Examen EOM</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-gray-600 border border-gray-200 rounded-lg">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 border-b border-gray-200">Campo</th>
                                    <th class="px-4 py-2 border-b border-gray-200">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ([
        'visceral_palpacion' => 'Palpación visceral',
        'visceral_dermalgias' => 'Dermalgias',
        'visceral_triggers' => 'Triggers',
        'visceral_fijaciones' => 'Fijaciones',
        'craneal_forma' => 'Forma craneal',
        'craneal_triggers' => 'Triggers craneales',
        'craneal_fijaciones' => 'Fijaciones craneales',
        'craneal_musculos' => 'Músculos craneales',
        'tension_arterial' => 'Tensión arterial',
        'pulsos' => 'Pulsos',
        'auscultacion' => 'Auscultación',
        'ecg' => 'ECG',
        'ecodoppler' => 'Ecodoppler',
    ] as $campo => $label)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 border-b border-gray-200 font-medium">{{ $label }}
                                        </td>
                                        <td class="px-4 py-2 border-b border-gray-200">
                                            <input type="text" wire:model="{{ $campo }}"
                                                class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


                  <!-- Botón Guardar -->
    <div class="text-center mt-6">
        <button type="submit"
            class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
            Guardar ficha
        </button>
    </div>

</form>

<!-- SweetAlert2 para alertas Livewire -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('swal', function(payload) {
            // Aceptamos payload como objeto con title/text/html/icon/timer
            const { title = 'Listo', text = '', html = null, icon = 'success', timer = 3000 } = payload || {};
            Swal.fire({
                title,
                text,
                html,
                icon,
                timer,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timerProgressBar: true,
            });
        });
    });
</script>