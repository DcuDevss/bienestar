<section class="w-[90%] mx-auto bg-gray-100 text-gray-600 h-screen px-4 py-4">

    <!-- REGISTROS DATA-TABLES -->
    <div class="w-full bg-white p-2">
        <div class="flex justify-between">
            <!-- HEADER -->
            <div class="flex gap-x-2">
                <!-- TITULO -->
                <h2 class="font-bold text-[#6366f1] text-2xl">{{ __('Historial de certificados medicos:') }}</h2>
                <!-- BUSCADOR -->
                <input class="rounded h-[34px] bg-[#edf2f7] border-none focus:ring-2 focus:ring-[#6366f1] focus:border-transparent" type="text" placeholder="{{ __('Buscar...') }}" wire:model.live="search" />
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
        <div class="flex gap-x-4 mt-2">
            @if ($enfermedades->isNotEmpty())
                @foreach ($enfermedades as $disase)
                    <ul class="max-w-[22%] h-auto relative shadow-2xl rounded-md px-5 py-5 mx-auto text-[14px]">
                        <li class="mb-0">
                            <p><span class="pr-1 font-extrabold text-black">Nombre:</span>
                            {{ $disase->name }}</p>
                        </li>
                        <li class="mb-0">
                            <p><span class="pr-1 font-extrabold text-black">Tipo de licencia:</span>
                                {{ $tipolicencias->get($disase->pivot->tipolicencia_id)?->name ?? 'No definido' }}
                            </p>

                        </li>
                        <li class="mb-0">
                            <p>
                                <span class="pr-1 font-extrabold text-black">Presentacion de certificado:</span>
                                {{ \Carbon\Carbon::parse($disase->pivot->fecha_presentacion_certificado)->format('d-m-Y H:i:s') }}
                            </p>
                        </li>
                        <li class="mb-0">
                            <p>
                                <span class="pr-1 font-extrabold text-black">Inicio de licencia:</span>
                                {{ \Carbon\Carbon::parse($disase->pivot->fecha_inicio_licencia)->format('d-m-Y H:i:s') }}
                            </p>
                        </li>
                        <li class="mb-0">
                            <p>
                                <span class="pr-1 font-extrabold text-black">Finalizacion:</span>
                                {{ \Carbon\Carbon::parse($disase->pivot->fecha_finalizacion_licencia)->format('d-m-Y H:i:s') }}
                            </p>
                        </li>

                        {{-- <li class="mb-0">
                            <p><span class="pr-1 font-extrabold text-black">Horas salud:</span>
                            {{ $disase->pivot->horas_salud }}</p>
                        </li> --}}
                        <li class="mb-0">
                            <p><span class="pr-1 font-extrabold text-black">dias de licencia:</span>
                            {{ $disase->pivot->suma_auxiliar }}</p>
                        </li>
                        {{-- <li class="mb-0"><span class="pr-1 font-extrabold text-black">Activo:</span>
                            @if($disase->pivot->estado_certificado == 1)
                                Sí
                            @else
                                No
                            @endif
                        </li> --}}
                        <li class="mb-0">
                            <p><span class="pr-1 font-extrabold text-black">Detalle de enfermedad:</span>
                            {{ $disase->pivot->detalle_certificado }}</p>
                        </li>
                        <li class="text-center py-6 font-bold flex gap-x-3">

                            <!-- <span>Frente:</span> esto es un archivo pdf-->
                            @if ($disase->pivot->imagen_frente)

                            {{-- <a href=" {{ Storage::url($disase->pivot->imagen_frente) }}" target="_blank">Ver PDF</a>--}}

                                     <img src="{{ Storage::url($disase->pivot->imagen_frente) }}" alt="Imagen" id="image" onclick="showFullImage(this)" class="w-24 h-24 text-center">

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
                                <div class="bottom-0 pt-2">
                                    <button wire:click="editModalDisase({{ $disase->id }})"
                                            class="bg-[#667eea] text-white hover:white hover:bg-[#5a67d8] px-2 py-1 text-[13px] font-normal rounded-md cursor-pointer">
                                        Editar
                                    </button>
                                </div>
                            @endif

                        <!-- DORSO -->

                            <!-- <span>Dorso:</span> -->
                            @if ($disase->pivot->imagen_dorso)
                                    <img src="{{ Storage::url($disase->pivot->imagen_dorso) }}" alt="Imagen" id="image" onclick="showFullImage(this)" class="w-24 h-24 text-center">
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
                        </li>
                        <div class="bottom-2 pt-2 flex justify-center w-full absolute">
                                <button wire:click="editModalDisase({{ $disase->id }})"
                                        class=" bg-[#667eea] text-white hover:white hover:bg-[#5a67d8] px-2 py-1 text-[13px] font-normal rounded-md cursor-pointer">
                                    Editar
                                </button>
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
        <!-- MODAL -->
        <x-dialog-modal wire:model="modal">
            <x-slot name="title">
                <div class="text-xl text-gray-500 font-bold text-center mb-2 capitalize">
                    {{ __('agregar afeccion/certificado al historial del paciente') }}
                </div>
                <img class="h-32 w-full object-center object-cover" src="{{ asset('assets/disases.jpg') }}" alt="">
            </x-slot>
            <x-slot name="content">
       <div class="grid grid-cols-2 gap-4">
 {{--                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Nombre') }}</label>
                    <input id="name" class="w-full rounded" type="text" placeholder="{{ __('nombre') }}"
                        wire:model.defer="name" />
                    <x-input-error for="name" />
                </div> --}}

                <div class="relative"
                    wire:click.outside="closeEditPicker"
                    wire:keydown.escape="closeEditPicker">

                <label for="editedDisaseName" class="block text-sm font-medium text-gray-700">
                    {{ __('Nombre del Padecimiento') }}
                </label>

                <input id="editedDisaseName"
                        class="w-full rounded"
                        type="text"
                        placeholder="{{ __('Nuevo nombre') }}"
                        wire:model.live="editedDisaseName"
                        x-data @focus="$wire.openEditPicker()" />

                <x-input-error for="editedDisaseName" />

                @if ($editPickerOpen && trim($editedDisaseName) !== '')
                    <div class="absolute left-0 right-0 z-50 mt-1 max-h-64 overflow-y-auto bg-white border border-slate-200 rounded-md shadow">
                    <ul class="w-full">
                        @forelse($editOptions as $i => $opt)
                        <li class="cursor-pointer px-3 py-2 bg-gray-50 hover:bg-gray-100 my-1 rounded-md">
                            <button type="button" class="w-full text-left"
                                    wire:click="pickEditedDisase({{ $opt['id'] }})">
                            {{ $opt['name'] }}
                            </button>
                        </li>
                        @empty
                        <div class="px-3 py-2 text-sm text-slate-500">Sin resultados…</div>
                        @endforelse
                    </ul>
                    </div>
                @endif
                </div>

                <div>
                    <label for="fecha_presentacion_certificado"
                        class="block text-sm font-medium text-gray-700">{{ __('Tipo de Licencia') }}</label>
                    <select id="tipolicencia_id" class="w-full rounded cursor-pointer" wire:model="tipolicencia_id">
                        <option value="" selected>{{ __('Seleccione una opción') }}</option>
                        @foreach ($tipolicencias as $licencia)
                            <option value="{{ $licencia->id }}">{{ $licencia->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="tipolicencia_id" />

                </div>


                <div>
                    <label for="fecha_presentacion_certificado"
                        class="block text-sm font-medium text-gray-700">{{ __('Fecha de presentacion del certificado') }}</label>
                    <input id="fecha_presentacion_certificado" class="w-full rounded" type="date"
                        placeholder="{{ __(' ingrese fecha de la enfermedad') }}"
                        wire:model.defer="fecha_presentacion_certificado" />
                    <x-input-error for="fecha_presentacion_certificado" />
                </div>

                <div>
                    <label for="fecha_inicio_licencia"
                        class="block text-sm font-medium text-gray-700">{{ __('Inicio del certificado') }}</label>
                    <input id="fecha_inicio_licencia" class="w-full rounded" type="datetime-local"
                        placeholder="{{ __('fecha de inicio') }}" wire:model.defer="fecha_inicio_licencia" />
                    <x-input-error for="fecha_inicio_licencia" />
                </div>

                <div>
                    <label for="fecha_finalizacion_licencia"
                        class="block text-sm font-medium text-gray-700">{{ __('Finalización de certificado') }}</label>
                    <input id="fecha_finalizacion_licencia" class="w-full rounded" type="datetime-local"
                        placeholder="{{ __('fecha finalización') }}" wire:model.defer="fecha_finalizacion_licencia" />
                    <x-input-error for="fecha_finalizacion_licencia" />
                </div>

                <div>
                    <label for="horas_salud"
                        class="block text-sm font-medium text-gray-700">{{ __('Horas de licencias medica') }}</label>
                    <input id="horas_salud" class="w-full rounded" value="" type="number"
                        placeholder="{{ __('ingrese horas de salud') }}" wire:model.defer="horas_salud" />
                    <x-input-error for="horas_salud" />
                </div>

                <div>
                    <label for="suma_salud" class="block text-sm font-medium text-gray-700">{{ __('Dias licencia') }}</label>
                    <input id="suma_salud" class="w-full rounded cursor-pointer" type="number" placeholder="{{ __('ingrese dias certificado') }}" wire:model.defer="suma_salud" />
                    <x-input-error for="suma_salud" />
                </div>
{{--
                <div>
                    <label class="flex items-center">
                        <input id="estado_certificado" class="rounded" type="checkbox" wire:model.defer="estado_certificado" />
                        <span class="ml-2">{{ __('Activo') }}</span>
                    </label>
                </div> --}}
                <div class="col-span-2 grid grid-cols-2 gap-4">
                    <div>
                        <label for="imagen_frente" class="block text-sm font-medium text-gray-700">{{ __('Frente certificado') }}</label>
                        <input id="imagen_frente" class="rounded py-2" type="file" wire:model.defer="imagen_frente"
                            accept="image/*" />
                        <x-input-error for="imagen_frente" />
                    </div>
                    <div>
                        <label for="imagen_dorso" class="block text-sm font-medium text-gray-700">{{ __('Frente certificado') }}</label>
                        <input id="imagen_dorso" class="rounded py-2" type="file" wire:model.defer="imagen_dorso"
                            accept="image/*" />
                        <x-input-error for="imagen_dorso" />
                    </div>
                </div>
                <div class="col-span-2">
                    <label for="detalle_certificado"
                        class="block text-sm font-medium text-gray-700">{{ __('Detalle del certificado') }}</label>
                    <textarea id="detalle_certificado" class="w-full rounded" value="" rows="5"
                        placeholder="{{ __('ingrese detalle') }}" wire:model.defer="detalle_certificado"></textarea>
                    <x-input-error for="detalle_certificado" />
                </div>
            </div>
    </x-slot>

    <x-slot name="footer">
        <button class="bg-red-500 text-white hover:bg-red-400 px-4 py-2 rounded mx-3"
            wire:click="$set('modal', false)">
            {{ __('Cancelar') }}
        </button>
        <button class="bg-green-500 text-white hover:bg-green-400 px-4 py-2 rounded mx-3" wire:click="editDisase"
            wire:loading.attr="disabled">
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

</section>
