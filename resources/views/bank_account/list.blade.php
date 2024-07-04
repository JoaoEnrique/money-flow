<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="mt-10 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <h1 class="title-pages dark:text-white">Visualizar Contas</h1>


        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            @include('notification')

            @if(count($accounts))
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Data/criação
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Data/atualização
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nome
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Ação
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accounts as $a)
                            @include('modal.delete.bank_account')

                            @php
                                if($a->type == 'Entrada') $color = "bg-green-700"; elseif($a->type == 'Empréstimo (Entrada)' || $a->type == 'Empréstimo (Saída)') $color = 'bg-yellow-400'; else $color = "bg-red-700";
                            @endphp

                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$a->created_at->format('d/m/Y - H:i')}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$a->updated_at->format('d/m/Y - H:i')}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$a->name}}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="/bank-account/edit/{{$a->id}}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Edit</a>
                                    <a data-modal-target="modal-delete-{{$a->id}}" data-modal-toggle="modal-delete-{{$a->id}}"  class="cursor-pointer text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Delete</a>
                                    <a href="/bank-account/transactions/{{$a->id}}" class="cursor-pointer text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Transações</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <h1>Nenhuma conta cadastrada</h1>
                    </div>
                @endif
        </div>
    </div>

</x-app-layout>
