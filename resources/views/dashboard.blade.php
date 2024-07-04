<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if (isset($account))
        <h1 class="title-dashboard dark:text-white">{{$account->name}}</h1>
    @endif

    @if (isset($hidden))
        <h1 class="title-dashboard dark:text-white">Valores não mostrados</h1>
    @endif

    <div class="py-12">
        <div class="justify-center gap-5 flex flex-wrap">
            <div>
                <div onclick="window.location.href = '/transaction/view/profit'" class="card-dashboard bg-green-700  overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h1>Entrada</h1>
                        <h1>R$ {{$profit}}</h1>
                    </div>
                </div>
            </div>
            <div>
                <div onclick="window.location.href = '/transaction/view/loss'" class="card-dashboard  overflow-hidden shadow-sm sm:rounded-lg bg-red-600" >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h1>Saída</h1>
                        <h1>R$ {{$loss}}</h1>
                    </div>
                </div>
            </div>
            <div>
                <div onclick="window.location.href = '/transaction/view/all'" class="card-dashboard bg-gray-700 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h1>Total</h1>
                        <h1>R$ {{$balance}}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function formatMoney(number){
            return number.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }
    </script>
</x-app-layout>
