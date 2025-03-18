<x-app-layout>
   {{--  <div class="card mx-auto w-full md:w-1/2"></div> --}}

    <div class="max-w-md mx-auto bg-white rounded shadow-lg">
        <div class="w-full mx-auto p-6 my-10">
            <h1 class="font-bold text-2x1 capitalize"><strong>{{ $title }}</strong></h1>
            <hr>
            <form action="{{ route('roles.show',$role->id) }}" method="POST">
               {{-- @include('admin.roles.partials.form') --}}

               <div class="mb-4">
                <x-label class="italic my-2 capitalize" value="{{ __('name of role') }}" for="name"/>
                <input type="text" name="name" class="w-full rounded" placeholder="{{ __('input name of role') }}"value="{{ old('name',$role->name) }}" readonly="true"/>
                <x-input-error for="name"/>
             </div>
               @include('admin.roles.partials.permissions')
               <a type="button" href="{{ route('roles.index') }}" class="bg-green-700 mt-3 text-white hover:bg-green-900 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm text-center px-5 py-2.5">
                {{ __('Regresar') }}
            </a>

            </form>
        </div>
    </div>
</x-app-layout>
