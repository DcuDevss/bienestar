<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataTable</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
</head>
<style>
    div.dt-container select.dt-input {
        min-width: 50px !important;
        height: 30px !important;
        font-size: 14px !important;
    }

    .dt-input {
        background-color: white !important;
        color: black !important;
    }

    div.dt-container .dt-length label {
        margin-left: 5px !important;
    }

    #dt-search-0 {
        border-radius: 10px !important;
        height: 30px !important;
    }

    .dt-paging-button {
        border: .5px solid white !important;
        margin: 0px 5px !important;
    }
</style>

<body>
    <div class="flex w-full">
        {{-- SIDE BAR --}}
        <x-side-bar></x-side-bar>
        {{-- CONTENT --}}
        <div class="w-full px-4 mx-auto pb-12">
            <h2 class="text-center text-2xl font-semibold py-6">Lista de usuarios</h2>
            <div class="bg-gray-800 mx-auto p-4 rounded-md text-[12px] text-white w-[80%]">
                {{-- <button class="btn btn-primary">Click me</button> --}}
                <div class=" border-b border-gray-200 shadow">
                    <table class="w-full text-left text-gray-500" id="miTabla">
                        <thead class="text-xs text-white uppercase bg-gray-900">
                            <tr class="teGead text-[14px]">
                                <th scope="col" class="px-4 py-3" style="text-align: center;">
                                    ID
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    Email
                                </th>

                                <th scope="col" class="px-4 py-3">
                                    Edit
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    Delete
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-800">
                            @foreach ($users as $user)
                                <tr class="border-b border-gray-700 hover:bg-[#204060]">
                                    <td style="text-align: center;"
                                        class="tiBody px-4 py-1 text-[14px] font-medium text-white whitespace-nowrap dark:text-white">
                                        {{ $user->id }}</td>
                                    <td
                                        class="tiBody px-4 py-1 text-[14px] font-medium text-white whitespace-normal min-w-[200px] dark:text-white">
                                        {{ $user->name }}</td>
                                    <td class="tiBody px-4 py-1 text-[14px] text-gray-300">{{ $user->email }}</td>
                                    <td class="tiBody px-4 py-1 text-[14px] text-gray-300">
                                        <a href="{{ route('users.edit', $user) }}" class="inline-block text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-400"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#miTabla').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
                }
            });
        });
    </script>
</body>

</html>
