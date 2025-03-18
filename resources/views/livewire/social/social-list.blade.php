<div>
    <ul class="bg-white shadow rounded">
        @foreach (auth()->user()->socials as $social )
            <li class="p-2 border-b-2 border-gray-300">
                <span>
                      <i class="{{ $social->type }} text-gray-900"></i>
                </span>
             {{ $social->name }}</li>
        @endforeach
    </ul>
 </div>

