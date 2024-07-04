@session('success')
    <div class="p-4 mb-4 text-sm text-green-50 rounded-lg bg-green-800 dark:bg-gray-800 dark:text-green-400" role="alert">
        {{session('success')}}
    </div>
@endsession

@session('danger')
    <div class="p-4 mb-4 text-sm text-red-50 rounded-lg bg-red-800 dark:bg-gray-800 dark:text-red-400" role="alert">
        {{session('danger')}}
    </div>
@endsession
