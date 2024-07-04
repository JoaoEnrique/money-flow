<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="mt-10 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <h1 class="title-pages dark:text-white">Visualizar Transações</h1>

        
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            @include('notification')



            @if(count($transactions))
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Data/criação
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Data/movimentação
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Movimento
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Descrição
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Valor
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Ação
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $t)
                            @include('modal.delete.transation')

                            @php
                                if($t->type == 'Entrada') $color = "bg-green-700"; elseif($t->type == 'Empréstimo (Entrada)' || $t->type == 'Empréstimo (Saída)') $color = 'bg-yellow-400'; else $color = "bg-red-700";
                            @endphp

                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{$t->created_at->format('d/m/Y - H:i')}}
                                </th>

                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    @php
                                        $date =  new DateTime($t->date);
                                        echo $date->format('d/m/Y');
                                    @endphp
                                </th>
                                <td class="px-6 py-4">
                                    <span class="text-white {{$color}}" style="border-radius: 7px; padding: 5px 10px" >
                                        {{$t->type}}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    {{$t->description}}
                                </td>
                                <td class="px-6 py-4">
                                    R$ {{number_format($t->value, 2, ',', '.')}}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="/transaction/edit/{{$t->id}}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Edit</a>

                                    {{-- <button data-modal-target="modal-delete-{{$t->id}}" data-modal-toggle="modal-delete-{{$t->id}}" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                        Apagar
                                    </button> --}}


                                    <a data-modal-target="modal-delete-{{$t->id}}" data-modal-toggle="modal-delete-{{$t->id}}"  class="cursor-pointer text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <h1>Nenhuma transação realizada</h1>
                    </div>
                @endif
        </div>
    </div>

</x-app-layout>
