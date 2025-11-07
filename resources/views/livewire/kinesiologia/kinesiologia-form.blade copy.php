<div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="max-w-5xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">
            Ficha Kinesiológica del Paciente
        </h2>

        {{-- 🧍 DATOS DEL PACIENTE --}}
        <div class="mb-8 p-5 bg-gray-50 rounded-lg border border-gray-200">
            <h3 class="text-lg font-semibold mb-3 text-gray-700">Datos del Paciente</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-gray-600">
                <p><strong>Nombre:</strong> {{ $paciente->apellido_nombre }}</p>
                <p><strong>DNI:</strong> {{ $paciente->dni }}</p>
                <p><strong>Edad:</strong> {{ $paciente->edad }} años</p>
            </div>
        </div>

        <form wire:submit.prevent="saveFichaKinesiologica" class="space-y-10">

            {{-- SECCIÓN I --}}
            <div>
                <h3 class="text-2xl font-semibold text-gray-700 mb-6 border-b pb-2">
                    Anamnesis
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- DOCTOR --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Doctor</label>
                        <input type="text" wire:model.defer="doctor_name" wire:blur="verificarDoctor"
                               class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"
                               placeholder="Nombre del doctor">
                        @error('doctor_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                        @if ($showDoctorAlert)
                            <div class="mt-3 p-3 bg-yellow-50 border border-yellow-400 text-yellow-800 rounded-lg">
                                <p>El doctor <strong>{{ $doctor_name }}</strong> no existe en el sistema.</p>
                                <p class="text-sm mt-1">¿Desea agregarlo con los datos ingresados?</p>
                                <div class="mt-2 flex gap-2">
                                    <button wire:click="crearDoctor"
                                            class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Sí, agregar</button>
                                    <button wire:click="$set('showDoctorAlert', false)"
                                            class="bg-gray-400 text-white px-3 py-1 rounded hover:bg-gray-500">Cancelar</button>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- MATRÍCULA --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Matrícula</label>
                        <input type="text" wire:model.defer="doctor_matricula"
                               class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"
                               placeholder="Número de matrícula">
                        @error('doctor_matricula') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- ESPECIALIDAD --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Especialidad</label>
                        <input list="especialidades" wire:model.defer="doctor_especialidad"
                               wire:blur="verificarEspecialidad"
                               class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"
                               placeholder="Seleccione o escriba una especialidad...">
                        <datalist id="especialidades">
                            @foreach ($especialidades as $esp)
                                <option value="{{ $esp }}"></option>
                            @endforeach
                        </datalist>
                        @error('doctor_especialidad') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                        @if ($showEspecialidadAlert)
                            <div class="mt-3 p-3 bg-yellow-50 border border-yellow-400 text-yellow-800 rounded-lg">
                                <p>La especialidad <strong>{{ $doctor_especialidad }}</strong> no existe.</p>
                                <p class="text-sm mt-1">¿Desea agregarla al sistema?</p>
                                <div class="mt-2 flex gap-2">
                                    <button wire:click="crearEspecialidad"
                                            class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Sí, agregar</button>
                                    <button wire:click="$set('showEspecialidadAlert', false)"
                                            class="bg-gray-400 text-white px-3 py-1 rounded hover:bg-gray-500">Cancelar</button>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- OBRA SOCIAL --}}
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

                    {{-- DIAGNÓSTICO --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Diagnóstico</label>
                        <input type="text" wire:model="diagnostico"
                               class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                    </div>

                    {{-- MOTIVO DE CONSULTA --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Motivo de consulta</label>
                        <input type="text" wire:model="motivo_consulta"
                               class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                    </div>

                    {{-- POSTURAS DOLOROSAS --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Posturas dolorosas</label>
                        <input type="text" wire:model="posturas_dolorosas"
                               class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                    </div>

                    {{-- ACTIVIDAD FÍSICA --}}
                    <div>
    <label class="block text-sm font-semibold text-gray-700 mb-1">
        ¿Realiza actividad física?
    </label>
    <select wire:model="realiza_actividad_fisica"
            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
        <option value="">Seleccione</option>
        <option value="1">Sí</option>
        <option value="0">No</option>
    </select>
</div>


                    {{-- TIPO DE ACTIVIDAD --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tipo de actividad</label>
                        <input type="text" wire:model="tipo_actividad"
                               class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                    </div>

                    {{-- ANTECEDENTES --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Antecedentes personales</label>
                        <textarea wire:model="antecedentes_enfermedades" rows="2"
                                  class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Antecedentes familiares</label>
                        <textarea wire:model="antecedentes_familiares" rows="2"
                                  class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea>
                    </div>

                    {{-- CIRUGÍAS --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Cirugías</label>
                        <textarea wire:model="cirugias" rows="2"
                                  class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea>
                    </div>

                    {{-- TRAUMATISMOS Y ACCIDENTES --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Traumatismos o accidentes</label>
                        <textarea wire:model="traumatismos_accidentes" rows="2"
                                  class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea>
                    </div>

                    {{-- TRATAMIENTOS PREVIOS --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tratamientos previos</label>
                        <textarea wire:model="tratamientos_previos" rows="2"
                                  class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea>
                    </div>

                    {{-- SALUD GENERAL --}}
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

                    {{-- ALTERACIÓN DE PESO --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">¿Presenta alteración de peso?</label>
                        <select wire:model="alteracion_peso"
                                class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                            <option value="">Seleccione</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    {{-- MEDICACIÓN --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Medicación actual</label>
                        <textarea wire:model="medicacion_actual" rows="2"
                                  class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea>
                    </div>

                    {{-- OBSERVACIONES --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Observaciones generales</label>
                        <textarea wire:model="observaciones_generales_anamnesis" rows="2"
                                  class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea>
                    </div>

                    {{-- CAMPOS GINECOLÓGICOS --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Menarca</label>
                        <select wire:model="menarca"
                                class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                            <option value="">Seleccione</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Menopausia</label>
                        <select wire:model="menopausia"
                                class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
                            <option value="">Seleccione</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Partos</label>
                        <input type="number" wire:model="partos"
                               class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"
                               min="0">
                    </div>
                </div>
            </div>

            {{-- SECCIÓN II --}}
            <div>
                <h3 class="text-2xl font-semibold text-gray-700 mb-6 border-b pb-2">
                    Examen EOM
                </h3>

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

            {{-- BOTÓN GUARDAR --}}
            <div class="text-center">
                <button type="submit"
                        class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
                    Guardar ficha
                </button>
                
            </div>
        </form>
    </div>
</div>

{{-- Al final de kinesiologia-form.blade.php, después del cierre del div principal --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('livewire:init', () => {
  Livewire.on('swal', function () {
    let payload = {};
    if (arguments.length === 1 && typeof arguments[0] === 'object' && !Array.isArray(arguments[0])) {
      payload = arguments[0];
    } else {
      payload = { title: arguments[0] ?? '', text: arguments[1] ?? '', icon: arguments[2] ?? 'info' };
    }
    const { title='Listo', text='', html=null, icon='success', timer=3000 } = payload;

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

