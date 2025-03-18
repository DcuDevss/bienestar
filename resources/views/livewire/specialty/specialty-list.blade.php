<div>
    <ul class="bg-white shadow rounded">
        @foreach ($specialties as $specialty )
            <li class="w-full px-3 py-2 items-center justify-around border-b-2 border-gray-300">
             <i class="fa-solid fa-user-doctor float-left text-gray-500 mr-3"></i>
             {{ $specialty->name }}</li>
        @endforeach
    </ul>
 </div>
