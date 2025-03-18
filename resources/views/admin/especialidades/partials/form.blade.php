@csrf

<div class="mb-4">
   <x-label class="italic my-2 capitalize" value="{{ __('nombre de la especialidad') }}" for="name"/>
   <input type="text" name="name" class="w-full rounded" placeholder="{{ __('ingrese la especialidad') }}"value="{{ old('name',$especialidade->name) }}"/>
   <x-input-error for="name"/>
</div>


<div class="mb-4">
    <x-label class="italic my-2 capitalize" value="{{ __('descripcion') }}" for="name"/>
     <textarea name="descripcion" id="" cols="3" rows="5"class="w-full rounded"></textarea>
    {{--  <input type="text" name="descripcion" class="w-full rounded" placeholder="{{ __('ingrese la descripcion') }}"value="{{ old('descripcion',$especialidades->descripcion) }}"/>
    <x-input-error for="descripcion"/>--}}
 </div>

<button type="submit" class="bg-blue-700 text-white hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm text-center px-5 py-2.5">
    {{ __($btn) }}
</button>

<a type="button" href="{{ route('especialidades.index') }}" class="bg-yellow-700 text-white hover:bg-yellow-900 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm text-center px-5 py-2.5">
    {{ __('Cancelar') }}
</a>
