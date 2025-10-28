<div class="dadad " >
    <!-- BOTON -->
    <div class="w-full">
    <button class="bg-slate-800 text-white px-3 py-3 w-[90%] rounded-md  transform transition-transform hover:scale-105" wire:click="addNew">Adjuntar PDF</button>

    </div>
    <!-- MODAL -->
    <x-dialog-modal wire:model="modal">

        <x-slot name="title">
            <div class="text-xl text-gray-500 font-bold text-center mb-2 capitalize">
                {{ __('agregar pdf al paciente') }}
            </div>
            <img class="h-32 w-full object-center object-cover" src="{{ asset('assets/inputfile.jpg') }}" alt="">
        </x-slot>

        <x-slot name="content">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="archivos" class="block text-sm font-medium text-gray-700">Archivos PDF:</label>
                    <input type="file" id="archivos" wire:model="archivos" multiple accept=".pdf">

                    @error('archivos.*') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>


            </div>
            <input type="hidden" wire:model="pdfhistorial_id">
        </x-slot>

        <x-slot name="footer">
            <button class="bg-inherit text-black font-medium border-b-2 border-transparent hover:font-black hover:border-b-2 hover:border-black px-4 py-2 "
                wire:click="$set('modal',false)">
                {{ __('CANCELAR') }}
            </button>
            <button class="bg-inherit text-black font-medium border-b-2 border-transparent hover:font-extrabold hover:border-b-2 hover:border-black px-4 py-2 "
                wire:click="createFiles">
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

