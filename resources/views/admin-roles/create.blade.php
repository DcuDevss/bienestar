<x-app-layout>
    <div class="flex">
        {{-- SIDE BAR --}}
        <div class="w-64 min-h-screen bg-gray-800 text-white flex flex-col">
            <div class="flex-1 overflow-y-auto">
                <div class="px-4 py-6">
                    <h2 class="text-lg font-semibold mb-4">Administrar</h2>
                    <nav class="space-y-1">
                        {{-- USUARIOS --}}
                        <a href="#proyecto1"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7h18M3 12h18m-7 5h7" />
                            </svg>
                            USUARIOS
                        </a>
                        <a href="{{ route('users.index') }}"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            Lista de usuarios
                        </a>
                        <a href="{{ route('users.index') }}"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            Crear nuevo usuario
                        </a>
                        {{-- ROLES --}}
                        <a href="#proyecto1"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7h18M3 12h18m-7 5h7" />
                            </svg>
                            ROLES
                        </a>
                        <a href="{{ route('admin-roles.index') }}"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            Lista de Roles
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <div class="pt-5 pb-12 bg-white dark:bg-gray-100 mt-10 mx-auto">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
                <div class="mb-4">
                    <form action="{{ route('admin-roles.store') }}" method="post">
                        @csrf

                        <div class="mb-4">
                            <h2 class="text-2xl text-center">Crear nuevo Rol</h2>
                            <label class="block text-blue-800 font-bold mb-2" for="inline-full-name">
                                Nombre
                            </label>
                            <input name="name"
                                class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-200"
                                id="inline-full-name" type="text" value="">
                            @error('name')
                                <small class="text-red-600">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <h1 class="text-blue-800"><strong>Lista de Permisos</strong></h1>
                        <div class="grid grid-cols-2">
                            @foreach ($permissions as $permission)
                                <div>
                                    <label>
                                        <input class="mr-1 mb-2" type="checkbox" name="permissions[]"
                                            value="{{ $permission->id }}" {{-- $user->hasRole($permission->name)?'checked':'' --}}>
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="text-center mt-4">
                            <button
                                class="bg-blue-800  hover:bg-blue-500 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                                type="submit">
                                Crear Roles
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
