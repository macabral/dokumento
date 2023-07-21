<x-splade-input id="titulo" name="titulo" type="text" :label="__('Title')" required autofocus autocomplete="titulo" />
<x-splade-textarea id="descricao" name="descricao" autosize :label="__('TAGS')" autocomplete="descricao" />
<x-splade-input name="datadoc" :label="__('Date')" date required />
<x-splade-textarea id="notas" name="notas" autosize :label="__('Notes')" autocomplete="notas" />

@if ($document['id'] == 0)
    <x-splade-file name="arquivos[]" multiple filepond  />
@endif

<div class="flex items-center gap-4">

    <x-splade-submit :label="__('Save')" />

</div>