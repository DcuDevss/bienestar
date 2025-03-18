<x-app-layout>
   {{--  <div class="card mx-auto w-full md:w-1/2"></div> --}}

    <div class="max-w-md mx-auto bg-white rounded shadow-lg">
        <div class="w-full mx-auto p-6 my-10">
            <h1 class="font-bold text-2x1 capitalize"><strong>{{ $title }}</strong></h1>
            <hr>
            <form action="{{ route('roles.store') }}" method="POST">
                @include('admin.roles.partials.form')
                @include('admin.roles.partials.permissions')
            </form>
        </div>
    </div>
</x-app-layout>
