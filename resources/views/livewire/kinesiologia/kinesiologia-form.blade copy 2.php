<div class="padreTablas flex gap-x-2 px-6 min-h-screen bg-gray-100 py-8" x-data="{
    // Inicializa el estado de las secciones.
    // Usamos 'openAnamnesis' para la primera sección y 'openEOM' para la segunda.
    openAnamnesis: true,
    openEOM: true,
    
    // Función para alternar el estado
    toggleSection(section) {
        if (section === 'anamnesis') {
            this.openAnamnesis = !this.openAnamnesis;
        } else if (section === 'eom') {
            this.openEOM = !this.openEOM;
        }
    }
}" x-cloak>
    <section class="seccionTab xl:mx-auto lg:mx-auto w-[95%]">
        <div class="mx-auto text-[12px]">
            <div class="bg-white shadow-xl sm:rounded-lg p-6">

                <div class="flex justify-center mb-6">
                    <h2 class="text-3xl font-bold text-gray-800 text-center">
                        Ficha Kinesiológica del Paciente
                    </h2>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg shadow mb-8 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">
                        <span class="inline-block mr-2 text-blue-500">👤</span> Datos del Paciente
                    </h3>
                    <ul class="space-y-2 text-gray-700">
                        <li><span class="font-medium text-gray-600">Nombre:</span> {{ $paciente->apellido_nombre }}</li>
                        <li><span class="font-medium text-gray-600">Domicilio:</span> {{ $paciente->domicilio }}</li>
                        <li><span class="font-medium text-gray-600">Teléfono:</span> {{ $paciente->TelefonoCelular }}</li>
                        <li><span class="font-medium text-gray-600">DNI:</span> {{ $paciente->dni }}</li>
                        <li><span class="font-medium text-gray-600">Edad:</span> {{ $paciente->edad }} años</li>
                    </ul>
                </div>
                
                <form wire:submit.prevent="saveFichaKinesiologica" class="space-y-6">
                    @csrf

                    <div class="bg-white shadow-lg rounded-lg border border-gray-200">
                        <div class="p-4 cursor-pointer flex justify-between items-center bg-blue-100 rounded-t-lg hover:bg-blue-200 transition"
                            @click="toggleSection('anamnesis')">
                            <h3 class="text-xl font-bold text-blue-800">
                                📝 SECCIÓN I: Anamnesis
                            </h3>
                            <svg :class="{'rotate-180': openAnamnesis}" class="w-6 h-6 text-blue-800 transform transition-transform duration-300" 
                                fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        
                        <div x-show="openAnamnesis" x-collapse.duration.500ms class="p-6 pt-4 border-t border-gray-200 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                
                                {{-- Contenido de Anamnesis, igual que el original --}}
                                {{-- SECCIÓN DOCTOR, Obra Social, Diagnóstico, Motivo de consulta, Posturas dolorosas, etc. --}}

                                @if ($isEdit)
                                <div class="border p-4 rounded-lg bg-gray-100">
                                    <p class="font-semibold text-gray-800">Doctor Asignado:</p>
                                    <p class="text-gray-700 mt-1">{{ $doctor_name }}</p>
                                    <p class="text-sm text-gray-600">Matrícula: {{ $doctor_matricula }} | Especialidad:
                                        {{ $doctor_especialidad }}
                                    </p>
                                </div>
                                @else
                                <div class="relative">
                                    <label class="block text-sm font-semibold text-gray-700 mb-1"
                                        for="doctor_name">Doctor</label>
                                    <input type="text" id="doctor_name" wire:model.live.debounce.300ms="doctor_name"
                                        class="w-full border-gray-300 rounded-md shadow-sm"
                                        placeholder="Comienza a escribir el nombre del doctor">

                                    @error('doctor_name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror

                                    @if (!empty($doctor_name) && $doctor_id === null && !$showDoctorAlert && count($doctorsFound) > 0)
                                    <div
                                        class="absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg mt-1 max-h-48 overflow-y-auto">
                                        @foreach ($doctorsFound as $doctor)
                                        <div class="px-4 py-2 cursor-pointer hover:bg-gray-100"
                                            wire:click="selectDoctor({{ $doctor->id }})">
                                            <p class="font-medium text-gray-800">{{ $doctor->name }}</p>
                                            <p class="text-xs text-gray-500">Mat: {{ $doctor->nro_matricula }}
                                                | {{ $doctor->especialidad }}</p>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                @endif
                                
                                @if ($showDoctorAlert)
                                <div
                                    class="mt-3 p-3 bg-yellow-50 border border-yellow-400 text-yellow-800 rounded-lg md:col-span-2">
                                    <p>El doctor <strong>{{ $doctor_name }}</strong> no existe. ¿Desea agregarlo?</p>
                                    <div class="mt-2 space-y-2">
                                        {{-- Campos de Matrícula y Especialidad --}}
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1"
                                                for="new_matricula">Matrícula</label>
                                            <input type="text" wire:model.defer="doctor_matricula" id="new_matricula"
                                                class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"
                                                placeholder="Número de matrícula (requerido)">
                                            @error('doctor_matricula')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1"
                                                for="new_especialidad">Especialidad</label>
                                            <input list="especialidades" wire:model.defer="doctor_especialidad"
                                                id="new_especialidad"
                                                class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"
                                                placeholder="Seleccione o escriba una especialidad (requerido)...">
                                            <datalist id="especialidades">
                                                @foreach ($especialidades as $esp)
                                                <option value="{{ $esp }}"></option>
                                                @endforeach
                                            </datalist>
                                            @error('doctor_especialidad')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                                            @if ($showEspecialidadAlert)
                                            <div class="mt-3 p-3 bg-red-100 border border-red-400 text-red-800 rounded-lg">
                                                <p>La especialidad <strong>{{ $doctor_especialidad }}</strong> no existe.</p>
                                                <button wire:click="crearEspecialidad" type="button"
                                                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm mt-1">
                                                    Sí, agregar especialidad
                                                </button>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mt-4 flex gap-2">
                                        <button type="button" onclick="confirmarCreacionDoctor()"
                                            class="bg-green-600 text-white px-3 py-2 rounded-lg hover:bg-green-700 transition duration-150 text-sm">
                                            ✅ Agregar y Seleccionar Doctor
                                        </button>
                                        <button wire:click="$set('showDoctorAlert', false)" type="button"
                                            class="bg-gray-400 text-white px-3 py-2 rounded-lg hover:bg-gray-500 transition duration-150 text-sm">
                                            Cancelar
                                        </button>
                                    </div>
                                </div>
                                @endif

                                @if ($doctor_id)
                                <div class="mt-4 border p-3 rounded-lg bg-blue-50">
                                    <p class="font-semibold text-blue-800">Doctor Seleccionado:</p>
                                    <p class="text-blue-700">{{ $doctor_name }}</p>
                                    <p class="text-sm text-blue-600">Matrícula: {{ $doctor_matricula }} |
                                        Especialidad: {{ $doctor_especialidad }}</p>
                                    <button type="button"
                                        wire:click="$set('doctor_id', null); $set('doctor_name', ''); $set('doctor_matricula', ''); $set('doctor_especialidad', '');"
                                        class="mt-2 text-red-500 hover:text-red-700 text-sm">
                                        [Cambiar Doctor]
                                    </button>
                                </div>
                                @endif
                                <input type="hidden" wire:model="doctor_id">
                                
                                {{-- Resto de los campos de Anamnesis --}}
                                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Obra Social</label><select wire:model="obra_social_id" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"><option value="">Seleccione una obra social</option>@foreach ($obrasSociales as $obra)<option value="{{ $obra->id }}">{{ $obra->nombre }}</option>@endforeach</select>@error('obra_social_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror</div>
                                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Diagnóstico</label><textarea wire:model="diagnostico" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea></div>
                                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Motivo de consulta</label><textarea wire:model="motivo_consulta" rows="3" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400 resize-y" placeholder="Describa el motivo de consulta..."></textarea></div>
                                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Posturas dolorosas</label><textarea type="text" wire:model="posturas_dolorosas" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea></div>
                                <div><label class="block text-sm font-semibold text-gray-700 mb-1">¿Realiza actividad física?</label><select wire:model="realiza_actividad_fisica" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"><option value="">Seleccione</option><option value="1">Sí</option><option value="0">No</option></select></div>
                                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Tipo de actividad</label><input type="text" wire:model="tipo_actividad" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></div>
                                <div class="md:col-span-2"><label class="block text-sm font-semibold text-gray-700 mb-1">Antecedentes enfermedades</label><textarea wire:model="antecedentes_enfermedades" rows="2" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea></div>
                                <div class="md:col-span-2"><label class="block text-sm font-semibold text-gray-700 mb-1">Antecedentes familiares</label><textarea wire:model="antecedentes_familiares" rows="2" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea></div>
                                <div class="md:col-span-2"><label class="block text-sm font-semibold text-gray-700 mb-1">Cirugías</label><textarea wire:model="cirugias" rows="2" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea></div>
                                <div class="md:col-span-2"><label class="block text-sm font-semibold text-gray-700 mb-1">Traumatismos o accidentes</label><textarea wire:model="traumatismos_accidentes" rows="2" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea></div>
                                <div class="md:col-span-2"><label class="block text-sm font-semibold text-gray-700 mb-1">Tratamientos previos</label><textarea wire:model="tratamientos_previos" rows="2" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea></div>
                                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Estado de salud general</label><select wire:model="estado_salud_general" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"><option value="">Seleccione</option><option value="Bueno">Bueno</option><option value="Medio">Medio</option><option value="Malo">Malo</option></select></div>
                                <div><label class="block text-sm font-semibold text-gray-700 mb-1">¿Presenta alteración de peso?</label><select wire:model="alteracion_peso" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"><option value="">Seleccione</option><option value="1">Sí</option><option value="0">No</option></select></div>
                                <div class="md:col-span-2"><label class="block text-sm font-semibold text-gray-700 mb-1">Medicación actual</label><textarea wire:model="medicacion_actual" rows="2" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea></div>
                                <div class="md:col-span-2"><label class="block text-sm font-semibold text-gray-700 mb-1">Observaciones generales</label><textarea wire:model="observaciones_generales_anamnesis" rows="2" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea></div>
                                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Menarca</label><select wire:model="menarca" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"><option value="">Seleccione</option><option value="1">Sí</option><option value="0">No</option></select></div>
                                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Menopausia</label><select wire:model="menopausia" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"><option value="">Seleccione</option><option value="1">Sí</option><option value="0">No</option></select></div>
                                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Partos</label><input type="number" wire:model="partos" min="0" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow-lg rounded-lg border border-gray-200">
                        <div class="p-4 cursor-pointer flex justify-between items-center bg-green-100 rounded-t-lg hover:bg-green-200 transition"
                            @click="toggleSection('eom')">
                            <h3 class="text-xl font-bold text-green-800">
                                🔬 SECCIÓN II: Examen EOM
                            </h3>
                            <svg :class="{'rotate-180': openEOM}" class="w-6 h-6 text-green-800 transform transition-transform duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        
                        <div x-show="openEOM" x-collapse.duration.500ms class="p-6 pt-4 border-t border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                
                                {{-- Contenido de Examen EOM, igual que el original --}}
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
                    </div>
                    
                    <div class="p-6 flex justify-center space-x-4 mb-4 mt-4">
                        <button type="submit"
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 focus:outline-none transition duration-150 text-base font-semibold">
                            💾 Guardar Cambios
                        </button>

                        <a href="{{ route('fichas-kinesiologicas.index', ['paciente' => $paciente->id]) }}"
                            class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 shadow-md transition duration-150 text-base font-semibold">
                            📋 Ver Fichas
                        </a>

                        <button type="button" onclick="window.history.back()"
                            class="px-6 py-3 bg-gray-500 text-white rounded-lg shadow-md hover:bg-gray-600 focus:outline-none transition duration-150 text-base font-semibold">
                            🔙 Volver
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> 

<script>
    // Tu script de Livewire/SweetAlert existente
    document.addEventListener('livewire:init', () => {
        Livewire.on('swal', (payload) => {
            if (Array.isArray(payload)) payload = payload[0];
            const {
                title = 'Listo', text = '', html = null, icon = 'success', timer = 3000
            } = payload || {};
            const isErrorOrWarning = (icon === 'error' || icon === 'warning');
            Swal.fire({
                title,
                text,
                html,
                icon,
                toast: !isErrorOrWarning,
                position: isErrorOrWarning ? 'center' : 'top-end',
                showConfirmButton: isErrorOrWarning,
                timer: isErrorOrWarning ? null : timer,
                timerProgressBar: !isErrorOrWarning,
            });
        });
    });

    function confirmarCreacionDoctor() {
        Swal.fire({
            title: '¿Agregar nuevo doctor?',
            text: 'Se guardará en la base de datos y se seleccionará automáticamente.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, agregar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('crearDoctor');
            }
        });
    }
</script>