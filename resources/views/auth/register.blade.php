<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @if (!is_null($invitationEmail))
            <input type="hidden" name="token" value="{{ request('token') }}"/>
        @endif
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                          autofocus autocomplete="name"/>
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')"></x-input-label>
            <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                     :value="$invitationEmail ?? old('email')"
                     required
                     :disabled="!is_null($invitationEmail)"></x-input>
            <x-input-error :messages="$errors->get('email')" class="mt-2"></x-input-error>
        </div>


        <!-- Password -->
        @livewire('register-passwords')

       @if (is_null($invitationEmail))
        <!-- Subdomain -->
            <div class="mt-4">
                <x-label for="subdomain" :value="__('Subdomain')"/>
                <x-input id="subdomain"
                         class="block mt-1 w-full"
                         type="text" name="subdomain"
                         :value="old('subdomain')"
                         required />
                </div>
        @endif
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
