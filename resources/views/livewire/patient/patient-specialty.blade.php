<section class="mx-auto my-6" >
    <img class="w-full h-80 object-cover"src="{{ asset('assets/banner-medical.jpg') }}" alt="">
    <div class="bg-gradient-to-br from-black to-blue-600 text-center py-6">
        <input placeholder="{{ __('encontrar especialidad') }}" class="w-1/2 mx-auto rounded" type="text" wire:model="search" />
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 justify-start items-start gap-4 p-6">
        @foreach ($specialties as $specialty)
            <div class="grid grid-cols-1 md:grid-cols-2 shadow-xl border justify-start rounded-2xl bg-slate-800 text-white">
                <img class="h-72 object-cover rounded-l-2xl"
                    src="{{ asset('assets/virus/v' . random_int(0, 10) . '.jpg') }}" alt="{{ $specialty->name }}">
                <div>
                    <h1 class="text-white text-2xl text-center p-2">{{ $specialty->name }}</h1>
                    @foreach ($specialty->doctors as $doctor)
                        <div class="p-2 cursor-pointer" wire:click="selectDate({{ $doctor->id }},{{ $specialty->id }})">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-r-lg">
                                    <img class="h-10 w-10 rounded-full"
                                        src="{{ $doctor->profile_photo_url }}"
                                        alt="{{ $doctor->name }}" />
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-white">{{ $doctor->name }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        <div class="col-span-2">
                {{ $specialties->links() }}
        </div>

    </div>


</section>
