<x-app-layout>
    <div class="flex">
        {{-- SIDE BAR --}}
        <x-side-bar></x-side-bar>
        <div class="pb-5 w-full bg-white dark:bg-gray-100">
            <div class=" mx-auto sm:px-6 lg:px-8">
                @if (session('info'))
                    <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
                        <p class="font-bold">Mensaje!!</p>
                        <p class="text-sm">{{ session('info') }}</p>
                    </div>
                @endif

                <div class=" flex flex-col items-center mt-6">
                    <h2 class="text-center text-2xl pb-4 font-semibold">Editar perfil</h2>
                    <div class="bg-gray-800 text-white rounded-md mb-4 shadow-lg border w-fit mx-auto py-5 px-10">
                        {{-- FORM --}}
                        <form action="{{ route('users.update', $user) }}" method="post">
                            <div class="grid grid-cols-2 gap-x-16">
                                {{-- DATOS DE CUENTA --}}
                                <div class="">
                                    <div class="py-5">
                                        <h3 class="text-center font-semibold text-xl">
                                            Datos de cuenta:
                                        </h3>
                                    </div>
                                    {{-- BLOQUEE 1 --}}
                                    <div class="px-3">
                                        {{-- NOMBRE --}}
                                        <div class="mb-4 flex gap-x-4 items-center justify-between">
                                            <label class="mt-2 block  font-bold mb-2" for="inline-full-name">
                                                Nombre:
                                            </label>
                                            <input name="name"
                                                class="w-fit bg-gray-200 appearance-none border-2 border-gray-200 rounded  py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                                id="inline-full-name" type="text" value="{{ $user->name }}">
                                        </div>
                                        {{-- EMAIL --}}
                                        <div class="mb-2 flex gap-x-4 items-center justify-between">
                                            <label class="mt-2 block  font-bold mb-2" for="inline-full-name">
                                                Correo:
                                            </label>
                                            <input name="email"
                                                class="w-fit bg-gray-200 appearance-none border-2 border-gray-200 rounded  py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                                id="inline-full-name" type="text" value="{{ $user->email }}">
                                        </div>
                                    </div>
                                    {{-- BLOQUE 2 --}}
                                    <div
                                        class="mb-4 px-3 py-4 flex flex-col  items-center justify-between border-2 border-red-800 rounded-md ">
                                        {{-- CONTRASEÑA --}}
                                        <div class="flex mb-4 gap-x-4">
                                            <label class="mt-2 block  font-bold mb-2" for="inline-full-name">
                                                Contraseña:
                                            </label>
                                            <input name="password"
                                                class="w-fit bg-gray-200 appearance-none border-2 border-gray-200 rounded  py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                                id="password" type="password" placeholder="Solo si deseas cambiarla">
                                        </div>
                                        @error('password')
                                            <p class="-mt-3 mb-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        {{-- CONFIRMAR CONTRASE:A --}}
                                        <div class="flex mb-2 gap-x-4">
                                            <label>
                                                Confirmar <br>Contraseña:
                                            </label>
                                            <input id="password_confirmation" name="password_confirmation"
                                                type="password" placeholder="Solo si deseas cambiarla"
                                                class="w-fit bg-gray-200 appearance-none border-2 border-gray-200 rounded  px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500">
                                        </div>
                                        @error('password_confirmation')
                                            <p class="-mt-3 mb-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        {{-- ADVERTENCIA --}}
                                        <p class="text-sm text-center">
                                            <i>Dejar estos campos vacíos para mantener <br> la contraseña actual.</i>
                                        </p>
                                    </div>
                                </div>
                                @method('put')
                                @csrf
                                {{-- ASIGNAR ROLES --}}
                                <div class="">
                                    <div class="py-5">
                                        <h3 class="text-center font-semibold text-xl">
                                            Asignar roles:
                                        </h3>
                                    </div>
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
                                </div>
                            </div>
                            {{-- BOTON SUBMIT --}}
                            <div class="mt-4 w-full mx-auto text-center">
                                <button
                                    class=" w-1/2 bg-blue-700  hover:bg-blue-600 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
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
