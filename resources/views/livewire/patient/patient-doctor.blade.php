<section class="mx-auto my-6" >
    <img class="w-full h-80 object-cover"src="{{ asset('assets/medica.jpg') }}" alt="">
    <div class="bg-gradient-to-br from-black to-blue-600 text-center py-6">
        <input placeholder="{{ __('encontrar doctor') }}" class="w-1/2 mx-auto rounded" type="text" wire:model.live="search" />
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 justify-start items-start gap-4 p-6">
        @foreach ($doctors as $doctor)
            <div class="grid grid-cols-1 md:grid-cols-2 shadow-xl border justify-start rounded-2xl bg-gradient-to-r from-blue-400 via-slate-800 to-blue-500">
                <img class="h-72 object-cover rounded-l-2xl"
                    src="{{ $doctor->profile_photo_url }}" alt="{{ $doctor->name }}">
                <div>
                    <h1 class="text-gray-400 text-2xl text-center p-2">{{ $doctor->name }}</h1>
                    @foreach ($doctor->specialties as $specialty)
                    <a class="cursor-pointer" wire:click="selectDate({{ $doctor->id }},{{ $specialty->id }})">
                        <div class="p-2">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-r-lg">
                                    <img class="h-10 w-10 rounded-full"
                                        src="{{ asset('assets/virus/v' . random_int(0, 10) . '.jpg') }}"alt="" />
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-white">{{ $specialty->name }}</div>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    {{ $doctors->links() }}
</section>
