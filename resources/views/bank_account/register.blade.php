<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <h1 class="title-pages dark:text-white">Cadastrar Conta</h1>


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @include('notification')

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <form method="POST" action="@if(isset($account)) /bank-account/update @else /bank-account/save @endif" class="mx-auto">
                    @csrf

                    @isset($account)
                        <input type="hidden" name="id" id="id" value="{{$account->id}}">
                    @endisset

                    <div class="mb-5">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome da Conta</label>
                        <input value="{{old('name', isset($account) ? $account->name : '')}}" type="text" name="name" id="name" class="@error('name') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 @enderror bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="nome da conta ou banco" required />
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="flex justify-center">
                        <button type="submit" style="width: 200px" class="mt-5 m-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            @if(isset($account))
                                Salvar
                            @else
                                Cadastrar
                            @endif
                        </button>
                        @if(isset($account))
                            <a href="/bank-account/transactions/{{$account->id}}" class="mt-5 m-auto text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Visualizar Transações</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
