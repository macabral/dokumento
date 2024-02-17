<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>

            <x-splade-button>
                <Link href="{{ route('documents.new') }}" class="pc-4 py-2 bg-indigo-400 hover:bg-indigo-600 text-black rounded-md">
                    {{ __('New Document') }}
                </Link>
            </x-splade-button>
        </div>
    </x-slot>

    <div class="box-border h-32 w-32 p-6 border-6 shadow-sm sm:rounded-lg">
        <h5 class="card-header text-center"><strong>{{ __('Total of Documents') }}</strong></h5>
        <div class="card-body">
            <p class="card-text text-center">{{ $painel['qtddoc'] }}</p>
        </div>
    </div>

    <div class="box-border h-32 w-32 p-6 border-6 shadow-sm sm:rounded-lg">
        <h5 class="card-header text-center"><strong>{{ __('Disk Space (MB)') }}</strong></h5>
        <div class="card-body">
            <p class="card-text text-center">{{ $painel['diskspace'] }}</p>
        </div>
    </div>

</x-app-layout>
