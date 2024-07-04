<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @include('notification')
            <h1 class="title-pages dark:text-white">Adicionar Transação</h1>


            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <form method="POST" action="@if(isset($transaction)) /transaction/update @else /transaction/save @endif" class="mx-auto">
                    @csrf

                    @isset($transaction)
                        <input type="hidden" name="id" id="id" value="{{$transaction->id}}">
                    @endisset

                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="mb-5">
                            <label for="value" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Valor</label>
                            <input value="{{old('value', isset($transaction) ? $transaction->value : 0)}}" type="value" name="value" id="value" class="@error('value') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 @enderror bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="100" required />
                            @error('value')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{$message}}</p>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label for="bank_account_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Conta</label>
                            <select value="{{old('bank_account_id')}}" name="bank_account_id" id="bank_account_id" class="@error('bank_account_id') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 @enderror bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="null">Outro</option>
                                @foreach ($accounts as $a)
                                    <option @if(isset($transaction) && $a->id == $transaction->bank_account_id) selected @endif value="{{$a->id}}">{{$a->name}}</option>
                                @endforeach
                            </select>

                            @error('bank_account_id')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{$message}}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-5">
                        <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Data</label>
                        <input value="{{old('date', isset($transaction) ? $transaction->date : now())}}" type="date" name="date" id="date" class="@error('date') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 @enderror bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  required />
                        @error('date')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="mb-5">
                            <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo</label>
                            <select name="type" id="type" class="@error('type') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 @enderror bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option @if(isset($transaction) && $transaction->type == "Entrada") selected @endif  value="Entrada">Entrada</option>
                                <option @if(isset($transaction) && $transaction->type == "Saída") selected @endif  value="Saída">Saída</option>
                                <option @if(isset($transaction) && $transaction->type == "Empréstimo (Entrada)") selected @endif  value="Empréstimo (Entrada)">Empréstimo (Entrada)</option>
                                <option @if(isset($transaction) && $transaction->type == "Empréstimo (Saída)") selected @endif  value="Empréstimo (Saída)">Empréstimo (Saída)</option>
                            </select>

                            @error('type')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="mb-5">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descrição</label>
                            <input value="{{old('description', isset($transaction) ? $transaction->description : '')}}" type="text" name="description" id="description" class="@error('description') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 @enderror bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="pagamento de xyz" required />

                            @error('description')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{$message}}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-start mb-5">
                        <div class="flex items-center h-5">
                            <input @if((isset($transaction) && $transaction->show) || !isset($transaction)) checked @endif id="show" value="1" name="show" type="checkbox"  class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" />
                        </div>
                        <label for="show" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Somar no dashboard</label>
                    </div>
                    <div class="flex justify-center">
                        <button type="submit" style="width: 200px" class="mt-5 m-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            @if(isset($transaction))
                                Salvar
                            @else
                                Cadastrar
                            @endif


                        </button>
                    </div>
                </form>
            </div>

            {{-- <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                </div>
            </div> --}}
        </div>
    </div>
</x-app-layout>
