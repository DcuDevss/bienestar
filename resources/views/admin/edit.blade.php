<x-app-layout>
    <div class="flex">
        {{-- SIDE BAR --}}
        <x-side-bar></x-side-bar>
        <div class="py-5 w-full bg-white dark:bg-gray-100 mt-6">
            <div class=" mx-auto sm:px-6 lg:px-8">
                {{-- <x-slot name="header">
                    <h2 class="font-semibold text-xl text-red-500 leading-tight">
                        {{ __('EDITAR ROLES: ') }}
                    </h2>
                </x-slot> --}}
                <h2 class="text-center text-2xl pb-4 font-semibold">Editar perfil</h2>
                @if (session('info'))
                    <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
                        <p class="font-bold">Mensaje!!</p>
                        <p class="text-sm">{{ session('info') }}</p>
                    </div>
                @endif

                <div class=" flex flex-col items-center">
                    
                    <div class="bg-gray-800 text-white rounded-md mb-4 shadow-lg border w-fit mx-auto py-5 px-10">
                        <div class="mb-4 flex gap-x-4 items-center justify-start">
                            <label class="mt-2 block  font-bold mb-2" for="inline-full-name">
                                Nombre:
                            </label>
                            <input
                                class="w-fit bg-gray-200 appearance-none border-2 border-gray-200 rounded  py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                id="inline-full-name" type="text" value="{{ $user->name }}">
                        </div>
                        <form action="{{ route('users.update', $user) }}" method="post">
                            @method('put')
                            @csrf
                            <div class="grid grid-cols-2 gap-2">
                                @foreach ($roles as $role)
                                    <div>
                                        <label>
                                            <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                                {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-4">
                                <button
                                    class="mx-auto w-full bg-blue-700  hover:bg-blue-600 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                                    type="submit">
                                    Actualizar Perfil
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
