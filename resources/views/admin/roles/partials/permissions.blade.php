<div class="bg-gray-200 p-2 my-3">
   <h3 class="font-bold capitalize">{{ __('Asignar permisos') }}</h3>
  <hr>
</div>
<input type="hidden" name="id" value={{ $role->id }}>
<div>
    <div class="grid grid-cols-1">
    @foreach($permissions as $key=>$p )
    <label for="permissions">
    <input type="checkbox" name="permissions[]" id="permissions"
    value="{{ $p->id }}"{{ in_array($p->id,$permissions_id) ? "checked": ""}}
    >{{ $p->name }}</label>
    @endforeach
   </div>
</div>
