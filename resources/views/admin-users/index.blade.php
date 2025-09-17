<x-app-layout>
    <div class="flex">
        {{-- SIDE BAR --}}
        <x-side-bar></x-side-bar>
        {{-- CONTENT --}}
        <div class="w-full bg-white dark:bg-gray-100">
            <div class=" mx-auto sm:px-6 lg:px-8">

                @if (session('info'))
                    <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
                        <p class="font-bold">Mensaje!!</p>
                        <p class="text-sm">{{ session('info') }}</p>
                    </div>
                @endif
                {{-- <div class="float-right mb-3">
                    <a href="{{ route('admin-roles.create') }}"
                        class="inline-block bg-slate-700 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
                        Nuevo rol
                    </a>
                </div> --}}

                <div class="mx-auto mt-[60px]">
                    {{-- FORM --}}
                    <form action="{{ route('new-user.store') }}" method="POST" autocomplete="off" novalidate
                        class="w-[60%] mx-auto ">
                        @csrf
                        <div class="bg-gray-700 text-white rounded-lg shadow-lg p-10 w-fit mx-auto flex flex-col items-center gap-y-8">
                            <h1 class="text-2xl font-bold  mb-1">Crear nuevo usuario</h1>
                            <div class="grid grid-cols-2 gap-x-8">
                                {{-- COLUMN 1 --}}
                                <div class="flex flex-col gap-y-5">
                                    {{-- Nombre --}}
                                    <div>
                                        <label htmlFor="name" class="block text-sm font-medium ">
                                            Nombre
                                        </label>
                                        <input id="name" type="text" value="" name="name"
                                            tabindex="1"
                                            class="text-black mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            placeholder="Ingrese su nombre" />
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Contraseña --}}
                                    <div>
                                        <label htmlFor="password" class="block text-sm font-medium ">
                                            Contraseña
                                        </label>
                                        <input id="password" type="password" value="" name="password"
                                            tabindex="3"
                                            class="text-black mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            placeholder="Ingrese su contraseña" />
                                        @error('password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                </div>
                                {{-- COLUMN 2 --}}
                                <div class="flex flex-col gap-y-5">
                                    {{-- Email --}}
                                    <div>
                                        <label htmlFor="email" class="block text-sm font-medium ">
                                            Email
                                        </label>
                                        <input id="email" type="email" value="" name="email"
                                            tabindex="2"
                                            class=" text-black mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            placeholder="Ingrese su email" />
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Repetir Contraseña --}}
                                    <div>
                                        <label htmlFor="password_confirmation"
                                            class="block text-sm font-medium ">
                                            Confirmar contraseña
                                        </label>
                                        <input id="password_confirmation" type="password" value="" tabindex="4"
                                            name="password_confirmation"
                                            class="text-black mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            placeholder="Confirme su contraseña" />
                                        @error('password_confirmation')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{-- Submit --}}
                            <button type="submit"
                                class="w-fit flex justify-center mt-4 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Crear usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
