<x-splade-modal :default="$document">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Delete Document?') }}
            
    
            <p class="mt-1 text-sm text-gray-600">
                {{ $document->titulo }}, {{ __('de') }} {{ date('d/m/Y', strtotime($document->datadoc)) }}
            </p>

            </h2>

        </header>

        <br><br>

    
        <x-splade-form
            method="delete"
            :default="$document"
            :action="route('documents.destroy', $document->id)"
            :confirm="__('Are you sure you want to delete your document?')"
            :confirm-text="__('Once your document is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your document.')"
            :confirm-button="__('Delete Document')"
            require-password
        >
            <x-splade-submit danger :label="__('Delete Document')" />
        </x-splade-form>
</x-splade-modal>