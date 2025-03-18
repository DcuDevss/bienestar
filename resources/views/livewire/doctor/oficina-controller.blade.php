<div class="container mx-auto mt-6 rounded-md bg-sky-200 p-16">
     <button class="flex bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 border border-blue-700 rounded my-6"
        wire:click="openAddModal">
        <span class="mx-3">
            {{ __('agregar oficina') }}
        </span>

        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </button>
    <section>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-white p-6 brorder shadow-lg rounded">
            @foreach ($oficinas as $item)
            <div class="max-w-sm rounded overflow-hidden shadow-lg">
                <img class="w-full p-4 rounded-md" src="{{asset('assets/bienestar.jpg')}}" alt="Sunset in the mountains">
                <div class="px-6 py-4">
                  <div class="font-bold text-xl mb-2">{{ $item->local }}</div>
                  <p class="text-gray-700 text-base">
                   {{$item->address}}
                  </p>
                </div>
                <div class="px-6 pt-4 text-sm">
                  @if($item->phone)
                  <span class="w-1/2 inline-block bg-blue-100 rounded px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ $item->phone }}</span>
                  @endif

                  @if($item->mobil)
                  <span class="w-1/2 inline-block bg-blue-100 rounded px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ $item->mobil }}</span>
                  @endif

                  @if($item->email)
                  <span class="block bg-blue-100 rounded px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ $item->email }}</span>
                  @else
                  <span class="block bg-blue-100 rounded px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                      </svg>
                  </span>
                  @endif
                </div>

                <div class="grid grid-cols-2 gap-3 m-2">
                    <button class="bg-green-600 hover:bg-green-500 rounded-md px-4 py-2 font-bold text-white w-full mx-auto"
                    wire:click="openEditModal({{ $item->id }})"
                    >
                        edit
                    </button>
                    <button  class="bg-red-600 hover:bg-red-500 px-4 rounded-md py-2 font-bold text-white w-full mx-auto"
                    wire:click="openDeleteModal({{ $item->id }})">
                    delete
                    </button>
                </div>
              </div>
        @endforeach
    </div>
    </section>

     @include('livewire.doctor.partials.addModal')
   @include('livewire.doctor.partials.editModal')
    @include('livewire.doctor.partials.deleteModal')


    <div>
<div>
{{--@livewire('multiform')--}}
</div>
