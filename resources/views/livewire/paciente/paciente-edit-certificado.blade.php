{{--   <x-dialog-modal  wire:model="modal"  >

    <x-slot name="title">
        <div class="text-xl text-gray-500 font-bold text-center mb-2 capitalize">
            {{ __('agregar afeccion/certificado al historial del paciente') }}
        </div>
        <img class="h-32 w-full object-center object-cover" src="{{ asset('assets/disases.jpg') }}"
            alt="">
    </x-slot>
    <x-slot name="content">
        <div class="grid grid-cols-2 gap-4">


            <div>
                <label for="editedDisaseName"
                    class="block text-sm font-medium text-gray-700">{{ __('Nuevo Nombre') }}</label>
                <input id="editedDisaseName" class="w-full rounded cursor-not-allowed bg-gray-200"
                    type="text" placeholder="{{ __('Nuevo nombre') }}"
                    wire:model="editedDisaseName" />
                <x-input-error for="editedDisaseName" />
            </div>

            <div>
                <label for="tipodelicencia"
                    class="block text-sm font-medium text-gray-700">{{ __('Tipo de Licencia') }}</label>
                <select id="tipodelicencia" class="w-full rounded cursor-pointer"
                    wire:model="tipodelicencia">
                    <option value="" selected>{{ __('Seleccione una opción') }}</option>
                    <option value="Enfermedad común">{{ __('Enfermedad común') }}</option>
                    <option value="Enfermedad largo tratamiento">{{ __('Enfermedad largo tratamiento') }}
                    </option>
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



            <div>
                <label for="fecha_enfermedad"
                    class="block text-sm font-medium text-gray-700">{{ __('fecha de presentacion del certificado') }}</label>
                <input id="fecha_enfermedad" class="w-full rounded cursor-pointer" type="date"
                    placeholder="{{ __(' ingrese fecha de la enfermedad') }}"
                    wire:model="fecha_enfermedad" />
                <x-input-error for="fecha_enfermedad" />
            </div>


            <div>
                <label for="fecha_atencion"
                    class="block text-sm font-medium text-gray-700">{{ __('inicio del certificado') }}</label>
                <input id="fecha_atencion" class="w-full rounded cursor-pointer" type="datetime-local"
                    placeholder="{{ __('fecha de inicio') }}" wire:model="fecha_atencion" />
                <x-input-error for="fecha_atencion" />
            </div>

            <div>
                <label for="fecha_finalizacion"
                    class="block text-sm font-medium text-gray-700">{{ __('finalización de certificado') }}</label>
                <input id="fecha_finalizacion" class="w-full rounded cursor-pointer" type="datetime-local"
                    placeholder="{{ __('fecha finalización') }}" wire:model="fecha_finalizacion" />
                <x-input-error for="fecha_finalizacion" />
            </div>

            <div>
                <label for="horas_salud"
                    class="block text-sm font-medium text-gray-700">{{ __('Horas de licencias medica') }}</label>
                <input id="horas_salud" class="w-full rounded cursor-pointer"value=""
                    type="text" placeholder="{{ __('ingrese horas de salud') }}"
                    wire:model="horas_salud" />
                <x-input-error for="horas_salud" />
            </div>

            <div>
                <label class="flex items-center">
                    <input id="activo" class="rounded cursor-pointer" type="checkbox"
                        wire:model="activo" />
                    <span class="ml-2">{{ __('Activo') }}</span>
                </label>
            </div>

            <div>
                <label for="archivo"
                    class="block text-sm font-medium text-gray-700">{{ __('Archivo') }}</label>
                <input id="archivo" class="rounded py-2 cursor-pointer" type="file"
                    wire:model="archivo" accept="image/*" />
                <x-input-error for="archivo" />
            </div>



            <div class="col-span-2">
                <label for="tipo_enfermedad"
                    class="block text-sm font-medium text-gray-700">{{ __('detalle del certificado') }}</label>
                <textarea id="tipo_enfermedad" class="w-full rounded cursor-pointer"value="" rows="5"
                    placeholder="{{ __('ingrese detalle') }}" wire:model="tipo_enfermedad"></textarea>
                <x-input-error for="tipo_enfermedad" />
            </div>
        </div>

    </x-slot>

    <x-slot name="footer">
        <button class="bg-red-500 text-white hover:bg-red-400 px-4 py-2 rounded mx-3"
            wire:click="$set('modal',false)">
            {{ __('cancelar') }}
        </button>
        <button class="bg-green-500 text-white hover:bg-green-400 px-4 py-2 rounded mx-3"
            wire:click="editDisase" wire:loading.attr="disabled">
            {{ __('editar enfermedad') }}
        </button>

    </x-slot>
</x-dialog-modal>
 --}}
















{{----}} <div class="max-w-5xl mx-auto bg-white rounded shadow-lg">
    <div class="w-full mx-auto p-6 my-10">
        <h1 class="font-bold text-2xl capitalize"><strong></strong></h1>
        <hr>
        <form wire:submit="edit">

            <div class="grid grid-cols-5 gap-4">

                @foreach($paciente->disases as $disase)
                <div class="mb-4 col-span-2">
                    <x-label class="italic my-2 capitalize" value="{{ __('Razon del certificado') }}" for="name" />
                    <input wire:model="disase.name" type="text" name="name" class="w-full rounded" placeholder=""
                        value="{{ $disase->name }}" />
                    <x-input-error for="name" />
                </div>
            @endforeach

                <div class="mb-4 col-span-2">
                    <x-label class="italic my-2 capitalize" value="{{ __('Afección') }}" for="editedDisaseName" />
                    <input wire:model="editedDisaseName" type="text" name="editedDisaseName" class="w-full rounded bg-slate-100"
                        placeholder="{{ __('Ingrese nombre de enfermedad') }}" value="{{ old('editedDisaseName') }}" />
                    <x-input-error for="editedDisaseName" />
                </div>

                <div class="mb-4 row-span-2 my-4 bg-slate-200">
                    <img src="" alt="" class="object-cover object-center h-48 w-96 rounded">
                    <input wire:model="archivo" type="file" class="w-full rounded bg-slate-100" value="{{ $archivo}}" />
                    <x-input-error for="archivo" />
                </div>

                <div class="mb-4 col-span-1">
                    <x-label class="italic my-2 capitalize" value="{{ __('Fecha de enfermedad') }}" for="fecha_enfermedad" />
                    <input wire:model="fecha_enfermedad" type="date" name="fecha_enfermedad" class="w-full rounded bg-slate-100"
                        placeholder="{{ __('Ingrese fecha de enfermedad') }}" value="{{ $fecha_enfermedad }}" />
                    <x-input-error for="fecha_enfermedad" />
                </div>

                <div class="mb-4 col-span-1">
                    <x-label class="italic my-2 capitalize" value="{{ __('Tipo de licencia') }}" for="tipodelicencia" />
                    <select id="tipodelicencia" class="w-full rounded cursor-pointer"value="{{ $tipodelicencia }}" wire:model="tipodelicencia">
                        <option value="" selected>{{ __('Seleccione una opción') }}</option>
                            <option value="Enfermedad común">{{ __('Enfermedad común') }}</option>
                            <option value="Enfermedad largo tratamiento">{{ __('Enfermedad largo tratamiento') }}
                            </option>
                            <option value="Atención familiar">{{ __('Atención familiar') }}</option>
                            <option value="Donación de sangre">{{ __('Donación de sangre') }}</option>
                            <option value="Maternidad">{{ __('Maternidad') }}</option>
                            <option value="Nacimiento trabajo">{{ __('Nacimiento trabajo') }}</option>
                            <option value="Salud embarazo">{{ __('Salud embarazo') }}</option>
                            <option value="Licencia pandemia">{{ __('Licencia pandemia') }}</option>
                            <option value="Dto. 564/18 lic. extraordinaria ley 911-art 9">
                                {{ __('Dto. 564/18 lic. extraordinaria ley 911-art 9') }}</option>
                        <!-- ... otras opciones ... -->
                    </select>
                    <x-input-error for="tipodelicencia" />
                </div>

                <div class="mb-4 col-span-1">
                    <x-label class="italic my-2 capitalize" value="{{ __('Fecha de atención') }}" for="fecha_atencion" />
                    <input wire:model="fecha_atencion" type="datetime-local" name="fecha_atencion" class="w-full rounded bg-slate-100"
                        placeholder="{{ __('Ingrese fecha de atención') }}" value="{{ $fecha_atencion }}" />
                    <x-input-error for="fecha_atencion" />
                </div>

                <div class="mb-4 col-span-1">
                    <x-label class="italic my-2 capitalize" value="{{ __('Fecha de finalización') }}" for="fecha_finalizacion" />
                    <input wire:model="fecha_finalizacion" type="datetime-local" name="fecha_finalizacion" class="w-full rounded bg-slate-100"
                        placeholder="{{ __('Ingrese fecha de finalización') }}" value="{{ $fecha_finalizacion }}" />
                    <x-input-error for="fecha_finalizacion" />
                </div>

                <div class="mb-4 col-span-1">
                    <x-label class="italic my-2 capitalize" value="{{ __('Horas de salud') }}" for="horas_salud" />
                    <input wire:model="horas_salud" type="text" name="horas_salud" class="w-full rounded bg-slate-100"
                        placeholder="{{ __('Ingrese horas de salud') }}" value="{{ $horas_salud }}" />{{ $paciente->horas_salud }}
                    <x-input-error for="horas_salud" />
                </div>

                <div class="mb-4 col-span-1">
                    <x-label class="italic my-2 capitalize" value="{{ __('Activo') }}" for="activo" />
                    <input wire:model="activo" type="checkbox" name="activo" class="form-checkbox rounded bg-slate-100"
                        value="1" {{ $activo ? 'checked' : '' }} />
                    <x-input-error for="activo" />
                </div>
            </div>

            <div class="mb-4 col-span-1">
                <x-label class="italic my-2 capitalize" value="{{ __('Detalle del certificado') }}" for="tipo_enfermedad" />
                <textarea wire:model="tipo_enfermedad" name="tipo_enfermedad" rows="5" class="w-full rounded bg-slate-100"
                    placeholder="">{{ $tipo_enfermedad }}</textarea>
                <x-input-error for="tipo_enfermedad" />
            </div>{{----}}

            <div class="flex justify-between mt-4">
                <button type="submit"
                    class="bg-blue-700 text-white float-right hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm text-center px-5 py-2.5">
                    {{ __('Guardar Cambios') }}
                </button>

                <a wire:click.prevent="cancelEdit"
                    class="bg-yellow-700 text-white hover:bg-yellow-900 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm text-center px-5 py-2.5">
                    {{ __('Cancelar') }}
                </a>
            </div>
        </form>
    </div>
</div>


{{--
<div class="max-w-5xl mx-auto bg-white rounded shadow-lg">
    <div class="w-full mx-auto p-6 my-10">
        <h1 class="font-bold text-2x1 capitalize"><strong></strong></h1>
        <hr>
        <form wire:submit.prevent="editModalDisase">

            <div class="grid grid-cols-5 gap-4">

                <div class="mb-4 col-span-2">
                    <x-label class="italic my-2 capitalize" value="{{ __('Razon del certificado') }}" for="name" />
                    <input wire:model="name" type="text" name="name" class="w-full rounded bg-slate-100"
                        placeholder="{{ __('nombre de la afeccion') }}" value="{{ old('name') }}" />
                    <x-input-error for="name" />
                </div>

                <div class="mb-4 col-span-2">
                    <x-label class="italic my-2 capitalize" value="{{ __('Afeccion') }}" for="editDisaseName" />
                    <input wire:model="editedDisaseName" type="text" name="editedDisaseName" class="w-full rounded bg-slate-100"
                        placeholder="{{ __('Ingrese nombre de enfermedad') }}" value="{{ old('editedDisaseName') }}" />
                    <x-input-error for="editedDisaseName" />
                </div>

                <div class="mb-4 row-span-2 my-4 bg-slate-200">
                    <img src="" alt="" class="object-cover object-center h-48 w-96 rounded">
                    <input wire:model="archivo" type="file" class="w-full rounded bg-slate-100" value="{{ old('archivo') }}" />
                    <x-input-error for="archivo" />
                </div>


                <div class="mb-4 col-span-1">
                    <x-label class="italic my-2 capitalize" value="{{ __('Fecha de enfermedad') }}" for="fecha_enfermedad" />
                    <input wire:model="fecha_enfermedad" type="date" name="fecha_enfermedad" class="w-full rounded bg-slate-100"
                        placeholder="{{ __('Ingrese fecha de enfermedad') }}" value="{{ old('fecha_enfermedad') }}" />
                    <x-input-error for="fecha_enfermedad" />
                </div>

                <div class="mb-4 col-span-1">
                    <x-label class="italic my-2 capitalize" value="{{ __('Tipo delicencia') }}" for="tipodelicencia" />

                        <select id="tipodelicencia" class="w-full rounded cursor-pointer"
                            wire:model="tipodelicencia">
                            <option value="" selected>{{ __('Seleccione una opción') }}</option>
                            <option value="Enfermedad común">{{ __('Enfermedad común') }}</option>
                            <option value="Enfermedad largo tratamiento">{{ __('Enfermedad largo tratamiento') }}
                            </option>
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



                <div class="mb-4 col-span-1">
                    <x-label class="italic my-2 capitalize" value="{{ __('Fecha de atención') }}" for="fecha_atencion" />
                    <input wire:model="fecha_atencion" type="datetime-local" name="fecha_atencion" class="w-full rounded bg-slate-100"
                        placeholder="{{ __('Ingrese fecha de atención') }}" value="{{ old('fecha_atencion') }}" />
                    <x-input-error for="fecha_atencion" />
                </div>



                <div class="mb-4 col-span-1">
                    <x-label class="italic my-2 capitalize" value="{{ __('Fecha de finalización') }}" for="fecha_finalizacion" />
                    <input wire:model="fecha_finalizacion" type="datetime-local" name="fecha_finalizacion" class="w-full rounded bg-slate-100"
                        placeholder="{{ __('Ingrese fecha de finalización') }}" value="{{ old('fecha_finalizacion') }}" />
                    <x-input-error for="fecha_finalizacion" />
                </div>

                <div class="mb-4 col-span-1">
                    <x-label class="italic my-2 capitalize" value="{{ __('Horas de salud') }}" for="horas_salud" />
                    <input wire:model="horas_salud" type="text" name="horas_salud" class="w-full rounded bg-slate-100"
                        placeholder="{{ __('Ingrese horas de salud') }}" value="{{ old('horas_salud') }}" />
                    <x-input-error for="horas_salud" />
                </div>


                <div class="mb-4 col-span-1">
                    <x-label class="italic my-2 capitalize" value="{{ __('Activo') }}" for="activo" />
                    <input wire:model="activo" type="checkbox" name="activo" class="form-checkbox rounded bg-slate-100"
                        value="1" {{ $activo ? 'checked' : '' }} />
                    <x-input-error for="activo" />
                </div>


            </div>
            <div class="mb-4 col-span-1">
                <x-label class="italic my-2 capitalize" value="{{ __('Detalle del certificado') }}" for="tipo_enfermedad" />
                <textarea wire:model="tipo_enfermedad" name="tipo_enfermedad" rows="5" class="w-full rounded bg-slate-100"
                    placeholder="{{ __('Ingrese tipo de enfermedad') }}">{{ old('tipo_enfermedad') }}</textarea>
                <x-input-error for="tipo_enfermedad" />
            </div>


            <div class="flex justify-between mt-4">
                <button type="submit"
                    class="bg-blue-700 text-white float-right hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm text-center px-5 py-2.5">
                    {{ __('Guardar Cambios') }}
                </button>

                <a wire:click.prevent="cancelEdit"
                    class="bg-yellow-700 text-white hover:bg-yellow-900 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm text-center px-5 py-2.5">
                    {{ __('Cancelar') }}
                </a>
            </div>

        </form>
    </div>
</div> --}}
