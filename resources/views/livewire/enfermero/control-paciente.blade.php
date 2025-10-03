<div class="">
    @if (session()->has('message'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded relative mb-3">
        {{ session('message') }}
    </div>
    @endif
    <!-- BOTON -->
    <div class="">
        <button class="bg-slate-800 text-white px-3 py-3 rounded-md w-[90%] transform transition-transform hover:scale-105" wire:click="addNew">Control paciente</button>
    </div>
    <!-- MODAL -->
    <x-dialog-modal wire:model="modal">

        <x-slot name="title">
            <div class="text-xl text-gray-500 font-bold text-center mb-2 capitalize">
                {{ __('agregar control al paciente') }}
            </div>
            <img class="h-32 w-full object-center " src="https://www.universidadviu.com/sites/universidadviu.com/files/styles/img_style_19_7_480/public/images/proceso-de-atenci%C3%B3n-de-enfermer%C3%ADa2.jpg?itok=mmbDlCTJ" alt="">
        </x-slot>

        <x-slot name="content">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="presion"
                        class="block text-sm font-medium text-gray-700">{{ __('Presion arterial') }}</label>
                    <input id="presion" class="w-full rounded cursor-pointer bg-gray-200" type="text"
                        placeholder="{{ __('presion') }}" wire:model="presion"/>
                    <x-input-error for="presion" />
                </div>

                <div>
                    <label for="temperatura"
                        class="block text-sm font-medium text-gray-700">{{ __('Temperatura') }}</label>
                    <input id="temperatura" class="w-full rounded cursor-pointer bg-gray-200" type="number"
                        placeholder="{{ __('temperatura') }}" wire:model="temperatura"/>
                    <x-input-error for="temperatura" />
                </div>


                <div>
                    <label for="fecha_atencion"
                        class="block text-sm font-medium text-gray-700">{{ __('fecha de atencion') }}</label>
                    <input id="fecha_atencion" class="w-full rounded cursor-pointer" type="datetime-local"
                        placeholder="{{ __(' ingrese fecha de atención') }}" wire:model="fecha_atencion" />
                    <x-input-error for="fecha_atencion" />
                </div>


                <div>
                    <label for="glucosa"
                        class="block text-sm font-medium text-gray-700">{{ __('glucosa en sangre') }}</label>
                    <input id="glucosa" class="w-full rounded cursor-pointer" type="text"
                        placeholder="{{ __('glucosa') }}" wire:model="glucosa" />
                    <x-input-error for="glucosa" />
                </div>

                <div>
                    <label for="inyectable"
                        class="block text-sm font-medium text-gray-700">{{ __('nombre del inyectable') }}</label>
                    <input id="inyectable" class="w-full rounded cursor-pointer" type="text"
                        placeholder="{{ __('ingrese inyectable') }}" wire:model="inyectable" />
                    <x-input-error for="inyectable" />
                </div>

                <div>
                    <label for="dosis" class="block text-sm font-medium text-gray-700">{{ __('Dosis') }}</label>
                    <input id="dosis" class="w-full rounded cursor-pointer" type="number"
                        placeholder="{{ __('ingrese la dosis') }}" wire:model="dosis" />
                    <x-input-error for="dosis" />
                </div>

                <div class="col-span-2">
                    <label for="detalles"
                        class="block text-sm font-medium text-gray-700">{{ __('detalle del control') }}</label>
                    <textarea id="detalles" class="w-full rounded cursor-pointer" rows="5" placeholder="{{ __('ingrese detalle') }}"
                        wire:model="detalles"></textarea>
                    <x-input-error for="detalles" />
                </div>
            </div>

        </x-slot>

        <x-slot name="footer">
            <button class="bg-inherit text-black font-medium border-b-2 border-transparent hover:font-black hover:border-b-2 hover:border-black px-4 py-2 "
                wire:click="$set('modal',false)">
                {{ __('CANCELAR') }}
            </button>
            <button class="bg-inherit text-black font-medium border-b-2 border-transparent hover:font-extrabold hover:border-b-2 hover:border-black px-4 py-2 "
                wire:click="createControles">
                {{ __('ACEPTAR') }}
            </button>
        </x-slot>

    </x-dialog-modal>

</div>
