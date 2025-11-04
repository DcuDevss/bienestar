<div class="">
  <!-- BOTON -->
  <div class="">
    <button class="bg-slate-800 text-white px-3 py-3 rounded-md w-[90%] transform transition-transform hover:scale-105" wire:click="addNew">
      Control paciente
    </button>
  </div>

  <!-- MODAL -->
  <x-dialog-modal wire:model="modal">
    <x-slot name="title">
      <div class="text-xl text-gray-500 font-bold text-center mb-2 capitalize">
        {{ __('agregar control al paciente') }}
      </div>
      <img src="{{ asset('assets/controlEnfermero.webp') }}" class="h-32 w-full object-center object-cover">
    </x-slot>

    <x-slot name="content">
      <div class="grid grid-cols-2 gap-4">
        <!-- NUEVOS CAMPOS: antes del primer campo -->
        <div>
          <label for="peso" class="block text-sm font-medium text-gray-700">Peso</label>
          <input id="peso" type="text" class="w-full rounded cursor-pointer bg-gray-200"
                 placeholder="Ingrese el peso" wire:model="peso" />
          <x-input-error for="peso" />
        </div>

        <div>
          <label for="altura" class="block text-sm font-medium text-gray-700">Altura</label>
          <input id="altura" type="text" class="w-full rounded cursor-pointer bg-gray-200"
                 placeholder="Ingrese altura" wire:model="altura" />
          <x-input-error for="altura" />
        </div>

        <div class="col-span-2">
          <label for="talla" class="block text-sm font-medium text-gray-700">Talla</label>
          <input id="talla" type="text" class="w-full rounded cursor-pointer bg-gray-200"
                 placeholder="Ingrese talla" wire:model="talla" />
          <x-input-error for="talla" />
        </div>

        <!-- EXISTENTES -->
        <div>
          <label for="presion" class="block text-sm font-medium text-gray-700">{{ __('Presion arterial') }}</label>
          <input id="presion" class="w-full rounded cursor-pointer bg-gray-200" type="text"
                 placeholder="{{ __('presion') }}" wire:model="presion"/>
          <x-input-error for="presion" />
        </div>

        <div>
          <label for="temperatura" class="block text-sm font-medium text-gray-700">{{ __('Temperatura') }}</label>
          <input id="temperatura" class="w-full rounded cursor-pointer bg-gray-200" type="text"
                 placeholder="{{ __('temperatura') }}" wire:model="temperatura"/>
          <x-input-error for="temperatura" />
        </div>

        <div>
          <label for="fecha_atencion" class="block text-sm font-medium text-gray-700">{{ __('fecha de atencion') }}</label>
          <input id="fecha_atencion" class="w-full rounded cursor-pointer" type="datetime-local"
                 placeholder="{{ __(' ingrese fecha de atención') }}" wire:model="fecha_atencion" />
          <x-input-error for="fecha_atencion" />
        </div>

        <div>
          <label for="glucosa" class="block text-sm font-medium text-gray-700">{{ __('glucosa en sangre') }}</label>
          <input id="glucosa" class="w-full rounded cursor-pointer" type="text"
                 placeholder="{{ __('glucosa') }}" wire:model="glucosa" />
          <x-input-error for="glucosa" />
        </div>

        <div>
          <label for="inyectable" class="block text-sm font-medium text-gray-700">{{ __('nombre del inyectable') }}</label>
          <input id="inyectable" class="w-full rounded cursor-pointer" type="text"
                 placeholder="{{ __('ingrese inyectable') }}" wire:model="inyectable" />
          <x-input-error for="inyectable" />
        </div>

        <div>
          <label for="dosis" class="block text-sm font-medium text-gray-700">{{ __('Dosis') }}</label>
          <input id="dosis" class="w-full rounded cursor-pointer" type="text"
                 placeholder="{{ __('ingrese la dosis') }}" wire:model="dosis" />
          <x-input-error for="dosis" />
        </div>

        <div class="col-span-2">
          <label for="detalles" class="block text-sm font-medium text-gray-700">{{ __('detalle del control') }}</label>
          <textarea id="detalles" class="w-full rounded cursor-pointer" rows="5"
                    placeholder="{{ __('ingrese detalle') }}" wire:model="detalles"></textarea>
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
      title, text, html, icon,
      timer,
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timerProgressBar: true,
    });
  });
});
</script>
