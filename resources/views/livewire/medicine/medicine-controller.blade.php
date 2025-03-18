<div class="p-6 bg-gray-200" >
    <h1 class="text-center selection:px-4 py-2 border bg-white font-bold text-sm uppercase mb-4 text-gray-500">{{ __('agregar nueva medicina') }}</h1>
    <form class="space-y-2 w-full">
        <input wire:model="name" class="w-full rounded" type="text" placeholder="{{ __('ingrese nombre') }}"/>
        <x-input-error for="name"/>


        @if($create)
        <button class="w-full my-2 bg-green-500  hover:bg-green-400 text-white px-4 py-2 rounded mx-1" wire:click="add">{{ __('crear') }}</button>
        @else
        <button class="w-full my-2bg-green-500  hover:bg-green-400 text-white px-4 py-2 rounded mx-1" wire:click="update">{{ __('update') }}</button>
        @endif
    </form>
    <ul class=" w-full bg-white my-4">
        @foreach ($medicines as $m )
             <li class="w-full border shadow flex justify-between items-center">

            <a class="cursor-pointer px-4 py-2 text-gray-700 w-full flex" wire:click="edit({{ $m->id }})">

                <span class="text-green-600 mr-6">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                </span>

                  <small>
                      {{ $m->name }}
                  </small>

            </a>
            <a wire:click="del({{ $m->id }})">
                <span class="text-red-600">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l6.414 6.414a2 2 0 001.414.586H19a2 2 0 002-2V7a2 2 0 00-2-2h-8.172a2 2 0 00-1.414.586L3 12z" />
                  </svg>
                </span>
            </a>
        </li>
        @endforeach
    </ul>
</div>
