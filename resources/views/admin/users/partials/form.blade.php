@csrf
<div class="grid grid-cols-5 gap-4">

<div class="mb-4 col-span-2">
   <x-label class="italic my-2 capitalize" value="{{ __('nombre y apellido del usuario') }}" for="name"/>
   <input type="text" name="name" class="w-full rounded bg-slate-100" placeholder="{{ __('ingrese nombre y apellido') }}"value="{{ old('name',$user->name) }}"/>
   <x-input-error for="name"/>
</div>

<div class="mb-4 col-span-2">
    <x-label class="italic my-2 capitalize" value="{{ __('email') }}" for="email"/>
    <input type="text" name="email" class="w-full rounded bg-slate-100" placeholder="{{ __('ingrese el email') }}"value="{{ old('email',$user->email) }}"/>
    <x-input-error for="email"/>
 </div>

 <div class="mb-4 row-span-2 my-4 bg-slate-200">
    <img src="{{ asset($user->profile_photo_url) }}" alt="{{ $user->name }}" class="object-cover object-center h-48 w-96 rounded">
</div>


 <div class="mb-4 col-span-1">
    <x-label class="italic my-2 capitalize" value="{{ __('telefono') }}" for="telefono"/>
    <input type="text" name="telefono" class="w-full rounded bg-slate-100" placeholder="{{ __('ingrese telefono') }}"value="{{ old('telefono',$user->telefono) }}"/>
    <x-input-error for="telefono"/>
 </div>
 <div class="mb-4 col-span-1">
    <x-label class="italic my-2 capitalize" value="{{ __('genero') }}" for="name"/>
    <input type="text" name="genero" class="w-full rounded bg-slate-100" placeholder="{{ __('ingrese genero') }}"value="{{ old('genero',$user->genero) }}"/>
    <x-input-error for="genero"/>
 </div>



 <div class="mb-4 col-span-1">
    <x-label class="italic my-2 capitalize" value="{{ __('fecha de nacimiento') }}" for="name"/>
    <input type="text" name="fecha_nacimiento" class="w-full rounded bg-slate-100" placeholder="{{ __('ingrese fecha nacimiento') }}"value="{{ old('fecha_nacimiento',$user->fecha_nacimiento) }}"/>
    <x-input-error for="fecha_nacimiento"/>
 </div>

 <div class="mb-4 col-span-1">
    <x-label class="italic my-2 capitalize" value="{{ __('role') }}" for="role"/>
    <select name="role" id="role" class="w-full rounded bg-slate-100">
     <option value="">{{ __('no role') }}</option>
     @foreach ($roles as $role)
     <option value="{{ $role->id }}" @if($role->id == $userRoleId) selected  @endif  >{{ $role->name }}</option>
     @endforeach
    </select>
    {{-- <input type="text" name="role" class="w-full rounded bg-slate-100" placeholder="{{ __('input role') }}"value="{{ old('role',$user->role) }}"/>
    <x-input-error for="role"/> --}}
 </div>
 <div class="mb-4 col-span-5">
    <x-label class="italic my-2 capitalize" value="{{ __('direccion') }}" for="direccion"/>
    <input type="text" name="direccion" class="w-full rounded bg-slate-100" placeholder="{{ __('ingrese la direccion') }}"value="{{ old('direccion',$user->direccion) }}"/>
    <x-input-error for="direccion"/>
 </div>

</div>
<button type="submit" class="bg-blue-700 text-white hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm text-center px-5 py-2.5">
    {{ __($btn) }}
</button>

<a type="button" href="{{ route('users.index') }}" class="bg-yellow-700 text-white hover:bg-yellow-900 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm text-center px-5 py-2.5">
    {{ __('Cancelar') }}
</a>
