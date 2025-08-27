<div class="">
    <section class="w-full max-w-7xl mx-auto bg-gray-100 text-gray-600 h-screen px-4 py-1">
        <!-- REGISTROS DATA-TABLES -->
        <div class="w-full  bg-white p-2">
            <!-- HEADER -->
            <div class=" bg-white px-2 py-1 flex justify-between w-full">
                <div class="flex gap-x-2">
                    <!-- TITULO -->
                    <h2 class="font-bold text-[#6366f1] text-2xl">{{ __('Historial de enfermedades:') }}</h2>
                    <!-- BUSCADOR -->
                    <input
                        class="rounded h-[34px] bg-[#edf2f7] border-none focus:ring-2 focus:ring-[#6366f1] focus:border-transparent"
                        type="text" placeholder="{{ __('Buscar...') }}" wire:model.live="search" />
                </div>
                <!-- BOTONES OSEF & LA CAJA -->
                <div class="float-right mr-2 flex gap-x-2">
                    <a href="https://prescriptorweb.ddaval.com.ar/" target="_blank">
                        <button class="bg-blue-600 rounded-md py-1 px-3">
                            <img class="h-[25px]" src="https://osef.gob.ar/assets/images/osef-logotipo.png" alt="">
                        </button>
                    </a>
                    <a href="https://prescriptorweb.ddaval.com.ar/" target="_blank">
                        <img class="h-[34px]" src="https://seeklogo.com/images/L/la-caja-logo-BBE553844B-seeklogo.com.png" alt="">
                    </a>
                </div>
            </div>
            <!-- CARD -->
            <div class="flex gap-x-4 h-full">
                @if ($enfermedades->isNotEmpty())
                    @foreach ($enfermedades as $enfermedad)
                        <ul class="max-w-[28%]  h-auto shadow-2xl rounded-md px-5 py-5 mx-auto text-[14px] relative">
                            <li class="mb-0">
                                <p><span class="pr-1 font-extrabold text-black">Nombre:</span>
                                    {{ $enfermedad->name }}</p>
                            </li>
                            <li class="mb-0">
                                <p><span class="pr-1 font-extrabold text-black">Tipo de licencia:</span>
                                    {{ $enfermedad->pivot->tipodelicencia }}</p>
                            </li>

                            <li class="mb-0">
                                <p><span class="pr-1 font-extrabold text-black">motivo consulta:</span>
                                    {{ $enfermedad->pivot->motivo_consulta}} </p>
                            </li>


                            <li class="mb-0">
                                <p><span class="pr-1 font-extrabold text-black">fecha de atencion:</span>
                                    {{ $enfermedad->pivot->fecha_atencion_enfermedad }}</p>
                            </li>
{{--                             <li class="mb-0">
                                <p><span class="pr-1 font-extrabold text-black">fecha de finalizacion:</span>
                                    {{ $enfermedad->pivot->fecha_finalizacion_enfermedad }}</p>
                            </li> --}}
                            <li class="mb-0">
                                <p><span class="pr-1 font-extrabold text-black">horas de reposo:</span>
                                    {{ $enfermedad->pivot->horas_reposo }}</p>
                            </li>

                            <li class="mb-0">
                                <p><span class="pr-1 font-extrabold text-black">art:</span>
                                    {{ $enfermedad->pivot->art }}</p>
                            </li>

{{--                                <td class="mb-0">
                                    @if ($enfermedad->pivot->estado_enfermedad == 1)
                                    <p><span class="pr-1 font-extrabold text-black"></span>
                                        activa</p>
                                    @else
                                    <p><span class="pr-1 font-extrabold text-black"></span>
                                        desactiva</p>
                                    @endif
                                </td> --}}

                            <li class="mb-0">
                                <p><span class="pr-1 font-extrabold text-black">medicacion:</span>
                                    {{ $enfermedad->pivot->medicacion }}</p>
                            </li>
                            <li class="mb-0">
                                <p><span class="pr-1 font-extrabold text-black">dosis:</span>
                                    {{ $enfermedad->pivot->dosis }}</p>
                            </li>
                            <li class="mb-0">
                                <p><span class="pr-1 font-extrabold text-black">nro remedio osef:</span>
                                    {{ $enfermedad->pivot->nro_osef }}</p>
                            </li>
                            <li class="mb-0">
                                <p><span class="pr-1 font-extrabold text-black">derivacion psiquiatrica:</span>
                                {{ $enfermedad->pivot->derivacion_psiquiatrica }}</p>
                            </li>
                            <li class="mb-0">
                                <p><span class="pr-1 font-extrabold text-black">detalle de la enfermedad:</span></p>
                                <div class="h-[40px] overflow-auto">{{ $enfermedad->pivot->detalle_diagnostico }}</div>
                            </li>
                            <li class="mb-0">
                                <p><span class="pr-1 font-extrabold text-black">detalle de la medicacion:</span></p>
                                <div class="h-[40px] overflow-auto">{{ $enfermedad->pivot->detalle_medicacion }}</div>
                            </li>
                            <!-- IMAGEN -->
                                <li class="text-center py-6 font-bold">
                                    <p><span class="pr-1 font-extrabold text-black">Archivo adjunto:</span></p>
                                    <div class="flex justify-center gap-x-1">
                                        <!-- IMG -->
                                        <div>
                                            @if ($enfermedad->pivot->imgen_enfermedad)
                                                <img src="{{ Storage::url($enfermedad->pivot->imgen_enfermedad) }}" alt="Imagen"
                                                    id="image" onclick="showFullImage(this)" class="w-24 h-24 text-center">
                                                <!-- Plantilla para la imagen ampliada -->
                                                <div id="full-image-overlay" class="full-image-overlay">
                                                    <div class="full-image-container">
                                                        <img id="full-image" src="" alt="Imagen Ampliada">
                                                        <button id="close-button" class="action-button"
                                                            onclick="closeFullImage()">Cerrar</button>
                                                    </div>
                                                </div>
                                            @else
                                                Sin Archivo
                                            @endif
                                        </div>
                                        <!-- PDF -->
                                        <div class="text-center font-bold">
                                            <div class="flex flex-col items-center">
                                                <a href="{{ Storage::url($enfermedad->pivot->pdf_enfermedad) }}" target="_blank">
                                                    <img src="{{ asset('assets/pdf.png') }}" alt="PDF Icon" class="w-12 h-16">
                                                </a>
                                                <span class="text-sm text-center px-2 whitespace-normal max-w-[160px] truncate">{{ pathinfo($enfermedad->pivot->pdf_enfermedad, PATHINFO_FILENAME) }}</span>

                                            </div>
                                        </div>
                                    </div>
                                </li>



                            <div class="botonEditar pt-2 flex justify-center w-full absolute bottom-2 left-0 right-0">
                                <button wire:click="editModalDisase({{ $enfermedad->id }})"
                                    class=" bg-[#667eea] text-white hover:white hover:bg-[#5a67d8] px-2 py-1 text-[13px] font-normal rounded-md cursor-pointer">
                                    Editar
                                </button>

                               {{-- <a href="{{ route('patient.patient-control-historial', ['paciente' => $paciente->id, 'enfermedade_paciente_id' => $enfermedad->pivot->id]) }}"
                                    class="bg-green-500 text-white hover:bg-green-400 px-4 py-2 rounded mx-3">
                                    Control Historial
                                </a> --}}


                                 {{--  <a href="{{ route('patient.patient-control-historial', ['paciente' => $paciente->id, 'enfermedade'=> $enfermedad->id]) }}"
                                    class="bg-green-500 text-white hover:bg-green-400 px-4 py-2 rounded mx-3">
                                    Control Historial
                                 </a>--}}




                                {{--  <td class="py-2 px-4 border-b">
                                <a href="{{ route('patient.patient-historial', ['paciente' => $tratamiento->paciente_id, 'tratamiento' => $tratamiento->id]) }}"
                                    class="text-blue-500 hover:underline">Crear</a>
                            </td> --}}

                            </div>

                        </ul>
                    @endforeach
                @else
                    <ul>
                        <li class="pl-2" colspan="8">No hay enfermedades registradas para este paciente.</td>
                    </ul>
                @endif
            </div>

            <ul class="px-2">
                <li colspan="10" class="text-white mt-4">
                    {{ $enfermedades->links() }}
                </li>
            </ul>
        </div>

    </section>
    <!-- MODAL -->
    <x-dialog-modal wire:model="modal">

        <x-slot name="title">
            <div class="text-xl text-gray-500 font-bold text-center mb-2 capitalize">
                {{ __('agregar afeccion al historial del paciente') }}
            </div>
            <img class="h-32 w-full object-center object-cover" src="{{ asset('assets/especialidades.jpg') }}"
                alt="">
        </x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="name"
                        class="block text-sm font-medium text-gray-700">{{ __('Nombre del diagnostico') }}</label>
                    <input id="name" class="w-full rounded cursor-pointer" type="text"
                        placeholder="{{ __('nombre') }}" wire:model="name"/>
                    <x-input-error for="name" />
                </div>

                <div>
                    <label for="tipodelicencia"
                        class="block text-sm font-medium text-gray-700">{{ __('Tipo de Licencia') }}</label>
                    <select id="tipodelicencia" class="w-full rounded cursor-pointer" wire:model="tipodelicencia">
                        <option value="" selected>{{ __('Seleccione una opción') }}</option>
                        <option value="Enfermedad común">{{ __('Enfermedad común') }}</option>
                        <option value="Enfermedad largo tratamiento">{{ __('Enfermedad largo tratamiento') }}</option>
                        <option value="Atención familiar">{{ __('Atención familiar') }}</option>
                        <option value="Donación de sangre">{{ __('Donación de sangre') }}</option>
                        <option value="Maternidad">{{ __('Maternidad') }}</option>
                        <option value="Nacimiento trabajo">{{ __('Nacimiento trabajo') }}</option>
                        <option value="Salud embarazo">{{ __('Salud embarazo') }}</option>
                        <option value="Licencia pandemia">{{ __('Licencia pandemia') }}</option>
                        <option value="Dto. 564/18 lic. extraordinaria ley 911-art 9">
                            {{ __('Dto. 564/18 lic. extraordinaria ley 911-art 9') }}</option>
                    </select>
                    <x-input-error for="tipodelicencia" />
                </div>

            </div>


            <div class="grid grid-cols-3 gap-4 mt-3">
                <div>
                    <label for="fecha_atencion_enfermedad"
                        class="block text-sm font-medium text-gray-700">{{ __('Fecha de atencion medica') }}</label>
                    <input id="fecha_atencion_enfermedad" class="w-full rounded cursor-pointer" type="datetime-local"
                        placeholder="{{ __('fecha atencion') }}" wire:model="fecha_atencion_enfermedad" />
                    <x-input-error for="fecha_atencion_enfermedad" />
                </div>
{{--
                <div>
                    <label for="fecha_finalizacion_enfermedad"
                        class="block text-sm font-medium text-gray-700">{{ __('finalización de enfermedad') }}</label>
                    <input id="fecha_finalizacion_enfermedad" class="w-full rounded cursor-pointer"
                        type="datetime-local" placeholder="{{ __('fecha finalización') }}"
                        wire:model="fecha_finalizacion_enfermedad" />
                    <x-input-error for="fecha_finalizacion_enfermedad" />
                </div> --}}

                <div>
                    <label for="horas_reposo"
                        class="block text-sm font-medium text-gray-700">{{ __('Horas de reposo') }}</label>
                    <input id="horas_reposo" class="w-full rounded cursor-pointer" type="number"
                        placeholder="{{ __('ingrese horas de reposo') }}" wire:model="horas_reposo" />
                    <x-input-error for="horas_reposo" />
                </div>

                <div>
                    <label for="art" class="block text-sm font-medium text-gray-700">{{ __('art') }}</label>
                    <input id="art" class="w-full rounded cursor-pointer" type="text"
                        placeholder="{{ __('ingrese art') }}" wire:model="art" />
                    <x-input-error for="art" />
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 mt-3">
                <div>
                    <label for="imgen_enfermedad"
                        class="block text-sm font-medium text-gray-700">{{ __('imagenes') }}</label>
                    <input id="imgen_enfermedad" class="rounded py-2 cursor-pointer" type="file"
                        wire:model="imgen_enfermedad" accept="image/*" />
                    <x-input-error for="imgen_enfermedad" />
                </div>

                <div>
                    <label for="pdf_enfermedad"
                        class="block text-sm font-medium text-gray-700">{{ __('pdf') }}</label>
                    <input id="pdf_enfermedad" class="rounded py-2 cursor-pointer" type="file"
                        wire:model="pdf_enfermedad" accept="image/*" />
                    <x-input-error for="pdf_enfermedad" />
                </div>
            </div>

            <div class="col-span-2 mt-3">
                <label for="detalle_diagnostico"
                    class="block text-sm font-medium text-gray-700">{{ __('detalle del diagnostico') }}</label>
                <textarea id="detalle_diagnostico" class="w-full rounded cursor-pointer" rows="5"
                    placeholder="{{ __('ingrese detalle') }}" wire:model="detalle_diagnostico"></textarea>
                <x-input-error for="detalle_diagnostico" />
            </div>

            <div class="grid grid-cols-3 gap-4 mt-3">
                <div>
                    <label for="medicacion"
                        class="block text-sm font-medium text-gray-700">{{ __('medicacion') }}</label>
                    <input id="medicacion" class="w-full rounded cursor-pointer" type="text"
                        placeholder="{{ __('ingrese medicacion') }}" wire:model="medicacion" />
                    <x-input-error for="medicacion" />
                </div>

                <div>
                    <label for="dosis" class="block text-sm font-medium text-gray-700">{{ __('dosis') }}</label>
                    <input id="dosis" class="w-full rounded cursor-pointer" type="text"
                        placeholder="{{ __('dosis') }}" wire:model="dosis" />
                    <x-input-error for="dosis" />
                </div>

                <div>
                    <label for="nro_osef"
                        class="block text-sm font-medium text-gray-700">{{ __('nro de osef') }}</label>
                    <input id="nro_osef" class="w-full rounded cursor-pointer" type="text"
                        placeholder="{{ __('ingrese nro osef') }}" wire:model="nro_osef" />
                    <x-input-error for="nro_osef" />
                </div>


            </div>

            <div class="col-span-2 mt-3">
                <label for="detalle_medicacion"
                    class="block text-sm font-medium text-gray-700">{{ __('detalle de la medicacion') }}</label>
                <textarea id="detalle_medicacion" class="w-full rounded cursor-pointer" rows="5"
                    placeholder="{{ __('ingrese detalle') }}" wire:model="detalle_medicacion"></textarea>
                <x-input-error for="detalle_medicacion" />
            </div>

            <input type="hidden" wire:model="enfermedade_id">
        </x-slot>

        <x-slot name="footer">
            <button class="bg-red-500 text-white hover:bg-red-400 px-4 py-2 rounded mx-3"
                wire:click="$set('modal',false)">
                {{ __('Cancelar') }}
            </button>
            <button class="bg-green-500 text-white hover:bg-green-400 px-4 py-2 rounded mx-3" wire:click="editDisase">
                {{ __('Editar enfermedad') }}
            </button>

        </x-slot>
    </x-dialog-modal>
        <div x-data="{ open:false, msg:'', t:null }"
            x-on:toast.window="
                clearTimeout(t);
                msg = $event.detail?.message || 'Acción realizada';
                open = true;
                t = setTimeout(() => open = false, 2500);
            "
            x-show="open"
            x-transition
            class="fixed top-4 right-4 z-50 rounded-md bg-emerald-600 text-white px-4 py-2 shadow">
            <span x-text="msg"></span>
        </div>
    <!-- LIGHTBOX -->
    <script>
        /funcionalidad para ampliar la imagen al darle click y cerrar/

        function showFullImage(image) {
            var fullImageOverlay = document.getElementById('full-image-overlay');
            var fullImage = document.getElementById('full-image');

            // Establecer la fuente de la imagen ampliada
            fullImage.src = image.src;

            // Mostrar la imagen ampliada
            fullImageOverlay.style.display = 'block';

            // Agregar el evento para cerrar la imagen al presionar la tecla Escape
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeFullImage();
                }
            });
        }

        function closeFullImage() {
            var fullImageOverlay = document.getElementById('full-image-overlay');

            // Ocultar la imagen ampliada
            fullImageOverlay.style.display = 'none';
        }

        function performAction() {
            // Acción adicional al hacer clic en el otro botón
            console.log('Acción realizada');
        }
    </script>
</div>
