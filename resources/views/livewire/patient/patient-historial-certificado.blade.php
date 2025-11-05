<section class="w-[90%] mx-auto bg-gray-100 text-gray-600 h-screen px-4 py-4">

    <!-- REGISTROS DATA-TABLES -->
    <div class="w-full bg-white p-2">
        <div class="flex justify-between">
            <!-- HEADER -->
            <div class="flex gap-x-2">
                <!-- TITULO -->
                <h2 class="font-bold text-[#6366f1] text-2xl">{{ __('Historial de certificados medicos:') }}</h2>
                <!-- BUSCADOR -->
                <input
                    class="rounded h-[34px] bg-[#edf2f7] border-none focus:ring-2 focus:ring-[#6366f1] focus:border-transparent"
                    type="text" placeholder="{{ __('Buscar...') }}" wire:model.live="search" />
            </div>
            <!-- BOTONES OSEF & LA CAJA -->
            <div class="float-right mr-2 flex gap-x-2">
                <!-- Imagen con link (RCTA) -->
                    <a href="https://rcta.me/?utm_term=&utm_campaign=RCTA+DNU/+Pmax+/+Reconnect&utm_source=adwords&utm_medium=ppc&hsa_acc=3976412703&hsa_cam=21983270123&hsa_grp=&hsa_ad=&hsa_src=x&hsa_tgt=&hsa_kw=&hsa_mt=&hsa_net=adwords&hsa_ver=3&gad_source=1&gad_campaignid=21983271299&gbraid=0AAAAAp3bv2M-2NoWfjCKXwvQFRekKOKO3&gclid=Cj0KCQjwgIXCBhDBARIsAELC9ZhPejgMuncQuoBdXnlBKYeV4pe06k2knUoVCHSvUOPPzjFGOfIv6vgaAgpOEALw_wcB
                        " target="_blank" class="bg-white rounded-md py-1 px-3">
                        <img class="h-[34px]" src="{{ asset('assets/rctaLogo.jpg') }}" alt="">
                    </a>
                    <a href="https://prescriptorweb.ddaval.com.ar/" target="_blank">
                    <button class="bg-blue-600 rounded-md py-1 px-3">
                        <img class="h-[25px]" src="https://osef.gob.ar/assets/images/osef-logotipo.png" alt="">
                    </button>
                </a>
                <a href="https://prescriptorweb.ddaval.com.ar/" target="_blank">
                    <img class="h-[34px]" src="https://seeklogo.com/images/L/la-caja-logo-BBE553844B-seeklogo.com.png"
                        alt="">
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
                                <span class="pr-1 font-extrabold text-black">Presentación de certificado:</span>
                                {{ !empty($disase->pivot->fecha_presentacion_certificado) && $disase->pivot->fecha_presentacion_certificado !== '0000-00-00 00:00:00'
                                    ? \Carbon\Carbon::parse($disase->pivot->fecha_presentacion_certificado)->format('d-m-Y H:i:s')
                                    : '—' }}
                            </p>
                        </li>

                        <li class="mb-0">
                            <p>
                                <span class="pr-1 font-extrabold text-black">Inicio de licencia:</span>
                                {{ !empty($disase->pivot->fecha_inicio_licencia) && $disase->pivot->fecha_inicio_licencia !== '0000-00-00 00:00:00'
                                    ? \Carbon\Carbon::parse($disase->pivot->fecha_inicio_licencia)->format('d-m-Y H:i:s')
                                    : '—' }}
                            </p>
                        </li>

                        <li class="mb-0">
                            <p>
                                <span class="pr-1 font-extrabold text-black">Finalización:</span>
                                {{ !empty($disase->pivot->fecha_finalizacion_licencia) && $disase->pivot->fecha_finalizacion_licencia !== '0000-00-00 00:00:00'
                                    ? \Carbon\Carbon::parse($disase->pivot->fecha_finalizacion_licencia)->format('d-m-Y H:i:s')
                                    : '—' }}
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
                            @if ($disase->pivot->estado_certificado == 1)
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
                                {{-- <a href=" {{ Storage::url($disase->pivot->imagen_frente) }}" target="_blank">Ver PDF</a> --}}

                                <img src="{{ Storage::url($disase->pivot->imagen_frente) }}" alt="Imagen"
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
                                <div class="bottom-0 pt-2">
                                    <button
                                        wire:click="editModalDisase({{ $disase->id }}, {{ $disase->pivot->id }})"
                                        class="bg-[#667eea] text-white ...">
                                        Editar
                                    </button>
                                </div>
                            @endif

                            <!-- DORSO -->

                            <!-- <span>Dorso:</span> -->
                            @if ($disase->pivot->imagen_dorso)
                                <img src="{{ Storage::url($disase->pivot->imagen_dorso) }}" alt="Imagen"
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
                        </li>
                        <div class="bottom-2 pt-2 flex justify-center w-full absolute">
                            <button class="text-white py-1 px-2 rounded-md" style="background-color:#6366f1;"
                                wire:click="editModalDisase({{ $disase->id }}, {{ $disase->pivot->id }})">
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
                {{ __('Agregar afección/certificado al historial del paciente') }}
            </div>
            <img class="h-32 w-full object-center object-cover" src="{{ asset('assets/disases.jpg') }}" alt="">
        </x-slot>

        <x-slot name="content">
            <div class="grid grid-cols-2 gap-4">
                <!-- Nombre del Padecimiento -->
                <div class="relative" wire:click.outside="closeEditPicker" wire:keydown.escape="closeEditPicker">
                    <label for="editedDisaseName" class="block text-sm font-medium text-gray-700">
                        {{ __('Nombre del Padecimiento') }}
                    </label>

                    <input id="editedDisaseName" class="w-full rounded" type="text"
                        placeholder="{{ __('Nuevo nombre') }}" wire:model.live="editedDisaseName" x-data
                        @focus="$wire.openEditPicker()" />

                    <x-input-error for="editedDisaseName" />

                    @if ($editPickerOpen && trim($editedDisaseName) !== '')
                        <div
                            class="absolute left-0 right-0 z-50 mt-1 max-h-64 overflow-y-auto bg-white border border-slate-200 rounded-md shadow">
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

                <!-- Tipo de Licencia -->
                <div>
                    <label for="tipolicencia_id" class="block text-sm font-medium text-gray-700">
                        {{ __('Tipo de Licencia') }}
                    </label>
                    <select id="tipolicencia_id" class="w-full rounded cursor-pointer" wire:model="tipolicencia_id">
                        <option value="" selected>{{ __('Seleccione una opción') }}</option>
                        @foreach ($tipolicencias as $licencia)
                            <option value="{{ $licencia->id }}">{{ $licencia->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="tipolicencia_id" />
                </div>

                <!-- Fecha de Presentación -->
                <div>
                    <label for="fecha_presentacion_certificado" class="block text-sm font-medium text-gray-700">
                        {{ __('Fecha de presentación del certificado') }}
                    </label>
                    <input id="fecha_presentacion_certificado" type="date" class="w-full rounded"
                        wire:model.defer="fecha_presentacion_certificado" />
                    <x-input-error for="fecha_presentacion_certificado" />
                </div>

                <!-- Inicio de licencia -->
                <div>
                    <label for="fecha_inicio_licencia" class="block text-sm font-medium text-gray-700">
                        {{ __('Inicio del certificado') }}
                    </label>
                    <input id="fecha_inicio_licencia" type="datetime-local" class="w-full rounded"
                        wire:model.defer="fecha_inicio_licencia" />
                    <x-input-error for="fecha_inicio_licencia" />
                </div>

                <!-- Fin de licencia -->
                <div>
                    <label for="fecha_finalizacion_licencia" class="block text-sm font-medium text-gray-700">
                        {{ __('Finalización de certificado') }}
                    </label>
                    <input id="fecha_finalizacion_licencia" type="datetime-local" class="w-full rounded"
                        wire:model.defer="fecha_finalizacion_licencia" />
                    <x-input-error for="fecha_finalizacion_licencia" />
                </div>

                <!-- Horas de salud -->

                {{-- <div>
                    <label for="horas_salud" class="block text-sm font-medium text-gray-700">
                        {{ __('Horas de licencia médica') }}
                    </label>
                    <input id="horas_salud" type="number" class="w-full rounded" wire:model.defer="horas_salud" />
                    <x-input-error for="horas_salud" />
                </div> --}}

                <!-- Dias licencia -->
                <div>
                    <label for="suma_salud" class="block text-sm font-medium text-gray-700">
                        {{ __('Días de licencia') }}
                    </label>
                    <input id="suma_salud" type="number" class="w-full rounded" wire:model.defer="suma_salud" />
                    <x-input-error for="suma_salud" />
                </div>

                <!-- Imágenes -->
                <div class="col-span-2 grid grid-cols-2 gap-4">
                    <div>
                        <label for="imagen_frente" class="block text-sm font-medium text-gray-700">
                            {{ __('Frente certificado') }}
                        </label>
                        <input id="imagen_frente" type="file" class="rounded py-2"
                            wire:model.defer="imagen_frente" accept="image/*"/>
                        <x-input-error for="imagen_frente" />
                    </div>

                    <div>
                        <label for="imagen_dorso" class="block text-sm font-medium text-gray-700">
                            {{ __('Dorso certificado') }}
                        </label>
                        <input id="imagen_dorso" type="file" class="rounded py-2" wire:model.defer="imagen_dorso"
                            accept="image/*"/>
                        <x-input-error for="imagen_dorso" />
                    </div>
                </div>

                <!-- Detalle certificado -->
                <div class="col-span-2">
                    <label for="detalle_certificado" class="block text-sm font-medium text-gray-700">
                        {{ __('Detalle del certificado') }}
                    </label>
                    <textarea id="detalle_certificado" rows="5" class="w-full rounded" wire:model.defer="detalle_certificado"></textarea>
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

        const { title = 'Listo', text = '', html = null, icon = 'success', timer = 3000 } = payload;

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
</section>
