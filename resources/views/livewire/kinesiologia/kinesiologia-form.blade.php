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

                <!-- Formulario -->
                <form wire:submit.prevent="saveFichaKinesiologica" class="space-y-10">
                    @csrf

                    <!-- SECCIÓN I: Anamnesis -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-6 border-b pb-2">Anamnesis</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div class="relative"> <label class="block text-sm font-semibold text-gray-700 mb-1" for="doctor_name">Médico Derivante (Doctor) *</label>
    
    <input type="text" id="doctor_name" 
           wire:model.live.debounce.300ms="doctor_name"
           class="w-full border-gray-300 rounded-md shadow-sm" 
           placeholder="Comienza a escribir el nombre del doctor">

    @error('doctor_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

    @if (!empty($doctor_name) && $doctor_id === null && !$showDoctorAlert && $doctorsFound->count() > 0)
        <div class="absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg mt-1 max-h-48 overflow-y-auto">
            @foreach ($doctorsFound as $doctor)
                <div class="px-4 py-2 cursor-pointer hover:bg-gray-100" 
                     wire:click="selectDoctor({{ $doctor->id }})">
                    <p class="font-medium text-gray-800">{{ $doctor->name }}</p>
                    <p class="text-xs text-gray-500">Mat: {{ $doctor->nro_matricula }} | {{ $doctor->especialidad }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>

@if ($showDoctorAlert)
    <div class="mt-3 p-3 bg-yellow-50 border border-yellow-400 text-yellow-800 rounded-lg">
        <p>El doctor <strong>{{ $doctor_name }}</strong> no existe. ¿Desea agregarlo?</p>
        
        <div class="mt-2 space-y-2">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1" for="new_matricula">Matrícula</label>
                <input type="text" wire:model.defer="doctor_matricula" id="new_matricula"
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"
                        placeholder="Número de matrícula (requerido)">
                @error('doctor_matricula') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1" for="new_especialidad">Especialidad</label>
                <input list="especialidades" wire:model.defer="doctor_especialidad" id="new_especialidad"
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"
                        placeholder="Seleccione o escriba una especialidad (requerido)...">
                
                <datalist id="especialidades">
                    @foreach ($especialidades as $esp)
                        <option value="{{ $esp }}"></option>
                    @endforeach
                </datalist>
                @error('doctor_especialidad') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                @if ($showEspecialidadAlert)
                    <div class="mt-3 p-3 bg-red-100 border border-red-400 text-red-800 rounded-lg">
                        <p>La especialidad **{{ $doctor_especialidad }}** no existe.</p>
                        <button wire:click="crearEspecialidad" type="button"
                                class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm mt-1">
                            Sí, agregar especialidad
                        </button>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="mt-4 flex gap-2">
            <button wire:click="crearDoctor" type="button"
                    class="bg-green-600 text-white px-3 py-2 rounded-lg hover:bg-green-700 transition duration-150">
                ✅ Agregar y Seleccionar Doctor
            </button>
            <button wire:click="$set('showDoctorAlert', false)" type="button"
                    class="bg-gray-400 text-white px-3 py-2 rounded-lg hover:bg-gray-500 transition duration-150">
                Cancelar
            </button>
        </div>
    </div>
@endif

@if ($doctor_id)
    <div class="mt-4 border p-3 rounded-lg bg-blue-50">
        <p class="font-semibold text-blue-800">Doctor Seleccionado:</p>
        <p class="text-blue-700">{{ $doctor_name }}</p>
        <p class="text-sm text-blue-600">Matrícula: {{ $doctor_matricula }} | Especialidad: {{ $doctor_especialidad }}</p>
        
        <button type="button" wire:click="$set('doctor_id', null); $set('doctor_name', ''); $set('doctor_matricula', ''); $set('doctor_especialidad', '');"
                class="mt-2 text-red-500 hover:text-red-700 text-sm">
            [Cambiar Doctor]
        </button>
    </div>
@else
    @endif

<input type="hidden" wire:model="doctor_id">

                            <!-- Obra Social -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Obra Social</label>
                                <select wire:model="obra_social_id"
                                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                                    <option value="">Seleccione una obra social</option>
                                    @foreach ($obrasSociales as $obra)
                                        <option value="{{ $obra->id }}">{{ $obra->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('obra_social_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Diagnóstico -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Diagnóstico</label>
                                <input type="text" wire:model="diagnostico"
                                       class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                            </div>

                            <!-- Motivo de consulta -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Motivo de consulta</label>
                                <input type="text" wire:model="motivo_consulta"
                                       class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                            </div>

                            <!-- Posturas dolorosas -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Posturas dolorosas</label>
                                <input type="text" wire:model="posturas_dolorosas"
                                       class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                            </div>

                            <!-- Actividad física -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">¿Realiza actividad física?</label>
                                <select wire:model="realiza_actividad_fisica"
                                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                                    <option value="">Seleccione</option>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>

                            <!-- Tipo de actividad -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Tipo de actividad</label>
                                <input type="text" wire:model="tipo_actividad"
                                       class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                            </div>

                            <!-- Antecedentes personales -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Antecedentes enfermedades</label>
                                <textarea wire:model="antecedentes_enfermedades" rows="2"
                                          class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea>
                            </div>

                            <!-- Antecedentes familiares -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Antecedentes familiares</label>
                                <textarea wire:model="antecedentes_familiares" rows="2"
                                          class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea>
                            </div>

                            <!-- Cirugías -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Cirugías</label>
                                <textarea wire:model="cirugias" rows="2"
                                          class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea>
                            </div>

                            <!-- Traumatismos o accidentes -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Traumatismos o accidentes</label>
                                <textarea wire:model="traumatismos_accidentes" rows="2"
                                          class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea>
                            </div>

                            <!-- Tratamientos previos -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Tratamientos previos</label>
                                <textarea wire:model="tratamientos_previos" rows="2"
                                          class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea>
                            </div>

                            <!-- Estado de salud general -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Estado de salud general</label>
                                <select wire:model="estado_salud_general"
                                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                                    <option value="">Seleccione</option>
                                    <option value="Bueno">Bueno</option>
                                    <option value="Medio">Medio</option>
                                    <option value="Malo">Malo</option>
                                </select>
                            </div>

                            <!-- Alteración de peso -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">¿Presenta alteración de peso?</label>
                                <select wire:model="alteracion_peso"
                                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                                    <option value="">Seleccione</option>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>

                            <!-- Medicación actual -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Medicación actual</label>
                                <textarea wire:model="medicacion_actual" rows="2"
                                          class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea>
                            </div>

                            <!-- Observaciones generales -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Observaciones generales</label>
                                <textarea wire:model="observaciones_generales_anamnesis" rows="2"
                                          class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea>
                            </div>

                            <!-- Campos ginecológicos -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Menarca</label>
                                <select wire:model="menarca" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                                    <option value="">Seleccione</option>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Menopausia</label>
                                <select wire:model="menopausia" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                                    <option value="">Seleccione</option>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Partos</label>
                                <input type="number" wire:model="partos" min="0"
                                       class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                            </div>

                        </div>
                    </div>

                    <!-- SECCIÓN II: Examen EOM -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-6 border-b pb-2">Examen EOM</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">{{ $label }}</label>
                                    <input type="text" wire:model="{{ $campo }}"
                                           class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                                </div>
                            @endforeach
                        </div>
                    </div>

                      <!-- Botón de guardar -->
    <div class="flex justify-center mb-2 mt-4">
        <button type="submit"
            class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-md hover:bg-blue-600 focus:outline-none">Guardar
            Cambios
        </button>
  {{--        @if (session('message'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif --}}
    </div>
    <div class="flex justify-center mb-2 mt-4">
        <button type="button" onclick="window.history.back()"
            class="px-4 py-2 bg-gray-500 text-white rounded-md shadow-md hover:bg-gray-600 focus:outline-none">
            Volver
        </button>
    </div>
</form>
</div>

 {{-- SweetAlert para mensajes de sesión --}}
@if (session()->has('message'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                icon: 'success',
                title: 'Listo',
                text: @json(session('message')),
                timer: 4000,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
            });
        });
    </script>
@endif

{{-- SweetAlert para errores de validación --}}
@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                icon: 'error',
                title: 'Revisá los campos',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif

{{-- Listeners Livewire para SweetAlert --}}
@once
    <script>
        document.addEventListener('livewire:init', () => {

            // ✅ Evento genérico swal
            Livewire.on('swal', ({
                title = '',
                text = '',
                icon = 'success',
                timer = 2000,
                toast = true,
                position = 'top-end'
            } = {}) => {
                Swal.fire({
                    title,
                    text,
                    icon,
                    toast,
                    position,
                    timer,
                    showConfirmButton: !toast
                });
            });

            // ✅ Evento confirm opcional (podés descomentar si querés usar confirmaciones)
            /*
            Livewire.on('confirm', ({
                title = '¿Estás seguro?',
                text = 'Esta acción no se puede deshacer.',
                icon = 'warning',
                confirmText = 'Sí, continuar',
                cancelText = 'Cancelar',
                action = null,
                params = {}
            } = {}) => {
                Swal.fire({
                    title, text, icon,
                    showCancelButton: true,
                    confirmButtonText: confirmText,
                    cancelButtonText: cancelText,
                    reverseButtons: true,
                    focusCancel: true,
                }).then((result) => {
                    if (result.isConfirmed && action) {
                        Livewire.dispatch(action, params);
                    }
                });
            });
            */
        });
    </script>
@endonce
