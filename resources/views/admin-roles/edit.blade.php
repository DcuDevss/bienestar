
<x-app-layout>
    <div class="py-5 bg-white dark:bg-gray-100 mt-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-red-500 leading-tight">
                    {{ __('EDITAR ROLES: ') }}
                </h2>
            </x-slot>

            @if(session('info'))
                <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
                    <p class="font-bold">Mensaje!!</p>
                    <p class="text-sm">{{session('info')}}</p>
                </div>
            @endif

            <div class="mb-4">
                <form action="{{ route('admin-roles.update', $role) }}" method="post">
                    @method('put')
                    @csrf

                    <div class="mb-4">
                        <label class="block text-blue-800 font-bold mb-2" for="inline-full-name">
                            Nombre
                        </label>
                        <input name="name" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-200" id="inline-full-name" type="text" value="{{ $role->name }}">
                    </div>


                    <h1 class="text-blue-800"><strong>Lista de Permisos</strong></h1>
                    @foreach($permissions as $permission)
                        <div>
                            <label>
                                <input class="mr-1 mb-2" type="checkbox" name="permissions[]" value="{{ $permission->id }}" {{ in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : '' }}>
                                {{ $permission->name}}
                            </label>
                        </div>
                    @endforeach

                    <div class="text-end">
                        <button class="bg-blue-800 hover:bg-blue-500 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
                            Actualizar Roles
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

