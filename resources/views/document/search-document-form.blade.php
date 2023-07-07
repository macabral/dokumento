<section>
    <header>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Search your documents using filters.") }}
        </p>
    </header>

    <Link slideover href="/document">Novo Documento</Link>

    <x-splade-modal>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Filter your search") }}
        </p>
        <x-splade-form method="post" :action="route('documents.result')" class="mt-4 space-y-4" preserve-scroll>
            <x-splade-input id="titulo" name="titulo" type="text" :label="__('Title')" autofocus autocomplete="titulo" />
            <x-splade-textarea id="descricao" name="descricao" autosize :label="__('Description')" autocomplete="descricao" />
            <x-splade-input name="dataemissao" :label="__('Document´s Date')" date range />
            <x-splade-input name="criacao" :label="__('Creation´s Date')" date range />

            <div class="flex items-center gap-4">
                <x-splade-submit :label="__('Search')" />

                @if (session('status') === 'profile-updated')
                    <p class="text-sm text-gray-600">
                        {{ __('Sended.') }}
                    </p> 
                @endif
            </div>
        </x-splade-form>
    </x-splade-modal>

</section>
