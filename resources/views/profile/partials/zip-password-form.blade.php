<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('ZIP file`s password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Set password for your zip files. Do not change your password.") }}
        </p>
    </header>

    <x-splade-form method="put" :action="route('profile.zip', $user['id'])" :default="$user" class="mt-6 space-y-6" preserve-scroll>
        <x-splade-input id="keyword" name="keyword" type="text" :label="__('Password for zip files')" required autofocus autocomplete="zippass" />

        <div class="flex items-center gap-4">
            <x-splade-submit :label="__('Save')" />
        </div>
    </x-splade-form>
</section>
