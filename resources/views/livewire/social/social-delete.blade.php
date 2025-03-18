<div>
    <ul class="bg-white shadow rounded">
        @foreach (auth()->user()->socials as $social )
            <li class="p-2 border-b-2 border-gray-300">

                <a class="flex justify-between cursor-pointer items-center" title="{{ __('delete record') }}" wire:click="delete({{ $social->id }})">
                 <span><i class="{{ $social->type }}"></i></span>
                     {{ $social->pivot->url }}
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l6.414 6.414a2 2 0 001.414.586H19a2 2 0 002-2V7a2 2 0 00-2-2h-8.172a2 2 0 00-1.414.586L3 12z" />
                       </svg>
                </a>

             </li>
        @endforeach
    </ul>
 </div>
