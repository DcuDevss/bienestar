<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DataTable</title>
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    </head>

    <body>


{{-- cambio --}}
        <div class="container mx-auto">

            <div class="">
                <div class="">
                    <div class="p-8 border-b border-gray-200 shadow">
                        <table class="divide-y divide-gray-300" id="dataTable">
                            <thead class="bg-black">
                                <tr>
                                    <th class="px-6 py-2 text-xs text-white">
                                        ID
                                    </th>
                                    <th class="px-6 py-2 text-xs text-white">
                                        Name
                                    </th>
                                    <th class="px-6 py-2 text-xs text-white">
                                        Email
                                    </th>

                                    <th class="px-6 py-2 text-xs text-white">
                                        Edit
                                    </th>
                                    <th class="px-6 py-2 text-xs text-white">
                                        Delete
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-300">


                                  @foreach ($users as $user)
                                     <tr class="text-center whitespace-nowrap">
                                       <td class="px-6 py-4 text-sm text-gray-500">{{ $user->id }}</td>
                                       <td class="px-6 py-4">{{ $user->name }}</td>
                                       <td class="px-6 py-4">{{ $user->email }}</td>
                                       <td class="px-6 py-4">
                                          <a href="{{ route('users.edit',$user) }}" class="inline-block text-center">
                                              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400"
                                                  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                              </svg>
                                          </a>
                                      </td>

                                      <td class="px-6 py-4">
                                       <a href="" class="inline-block text-center">
                                           <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-400"
                                               fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                   d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                           </svg>
                                       </a>
                                   </td>
                                     </tr>
                                  @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                $('#dataTable').DataTable();

            });
        </script>
    </body>

</html>
