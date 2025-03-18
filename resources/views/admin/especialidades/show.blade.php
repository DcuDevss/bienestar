<x-app-layout>
    <div class="container">
        <div class="max-w-sm rounded overflow-hidden shadow-lg mx-auto my-6">
            <img class="w-full" src="{{ asset('assets/disases.jpg') }}" alt="Sunset in the mountains">
            <div class="px-6 py-4">
                <div class="font-bold text-xl mb-2">{{ $especialidade->name }}</div>
                <p class="text-gray-700 text-base">
                    {{$especialidade->descripcion}}
                </p>
            </div>
            <div class="px-6 pt-4 pb-2 mb-5">
                <a href="{{ route('especialidades.index') }}" class="bg-blue-500 px-4 py-2 rounded ">{{ __('back') }}</a>

            </div>
        </div>
    </div>
    </div>
</x-admin-layout>
