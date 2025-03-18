<div>
    <x-dialog-modal wire:model="openModal">
        <x-slot name="title">
            <div class="text-xl text-gray-500 font-bold text-center mb-2 capitalize">
                {{ __('seleccione la fecha y la hora') }}
            </div>
            <img class="h-32 w-full object-center object-cover" src="{{ asset('assets/calendario.jpg') }}" alt="">
        </x-slot>
        <x-slot name="content">
            <div class="seleccionadas">
                <div>
                    <input class="w-1/2 rounded cursor-pointer" type="date" placeholder="{{ __('selecione la fecha') }}"
                        wire:model.live="date" />
                    <x-input-error for="date" />
                </div>
                <div class="grid grid-cols-3 text-sm p-2 my-3 gap-1">
                    <ul>
                        @foreach ($morning as $m )
                          <button class="w-full cursor-pointer text-sm px-2 rounded border hover:bg-red-500 hover:text-white hover:text-bold"
                          wire:click="selecccionar('{{ $m }}')">
                              {{ $m }}</button>
                        @endforeach
                    </ul>
                    <ul>
                        @foreach ($afternoon as $m )
                          <button class="w-full cursor-pointer text-sm px-2 rounded border hover:bg-red-500 hover:text-white hover:text-bold"
                          wire:click="selecccionar('{{ $m }}')">
                              {{ $m }}</button>
                        @endforeach
                    </ul>

                    <ul>
                        @foreach ($evening as $m )
                          <button class="w-full cursor-pointer text-sm px-2 rounded border hover:bg-red-500 hover:text-white hover:text-bold"
                          wire:click="selecccionar('{{ $m }}')">
                              {{ $m }}</button>
                        @endforeach
                    </ul>

                </div>

             </div>
            {{--  <button class="bg-blue-800 text-white hover:bg-red-400 px-4 py-2 rounded mx-3"
                wire:click="$set('openModal',true)">
                {{ __('ver') }}
            </button> --}}

        </x-slot>
        <x-slot name="footer">
             <button class="bg-red-500 text-white hover:bg-red-400 px-4 py-2 rounded mx-3"
                wire:click="$set('openModal',false)">
                {{ __('cancelar') }}
            </button>

        </x-slot>
    </x-dialog-modal>
</div>
@push('script')
<script>
    window.addEventListener('store-data', event =>{
        localStorage.setItem('interval',event.detail.interval)
        localStorage.setItem('doctor_id',event.detail.doctor_id)
        localStorage.setItem('especialidade_id',event.detail.especialidade_id)
        localStorage.setItem('day',event.detail.day)
        localStorage.setItem('date',event.detail.date)
        localStorage.setItem('price',event.detail.price)
        localStorage.setItem('office',event.detail.office)

    })

    window.addEventListener('delete-data', event =>{
        localStorage.removeItem('interval')
        localStorage.removeItem('doctor_id')
        localStorage.removeItem('especialidade_id')
        localStorage.removeItem('day')
        localStorage.removeItem('date')
        localStorage.removeItem('price')
        localStorage.removeItem('office')

    })


</script>
@endpush

