<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Document') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl" dusk="update-profile-information">
                    <section>
                        <header>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Fill with document's properties and upload.") }}
                            </p>
                        </header>
                    
                        <x-splade-modal>
                            <x-splade-form method="post" :action="route('documents.create')" :default="$document" class="mt-4 space-y-4" preserve-scroll>
                                @csrf
                                @include('document.document-form')
                            </x-splade-form>
                        </x-splade-modal>
                        
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>