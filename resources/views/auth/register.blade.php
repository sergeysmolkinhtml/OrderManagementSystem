<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @if (!is_null($invitationEmail))
            <input type="hidden" name="token" value="{{ request('token') }}"/>
        @endif
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')"></x-input-label>
            <x-text-input id="name"
                          class="block mt-1 w-full"
                          type="text"
                          name="name"
                          :value="old('name')"
                          autofocus autocomplete="name" required></x-text-input>
            <x-input-error :messages="$errors->get('name')" class="mt-2"></x-input-error>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')"></x-input-label>
            <x-input id="email"
                     class="block mt-1 w-full"
                     type="email"
                     name="email"
                     :value="$invitationEmail ?? old('email')"
                     :disabled="!is_null($invitationEmail)" required></x-input>
            <x-input-error :messages="$errors->get('email')" class="mt-2"></x-input-error>
        </div>


        <!-- Password -->
        @livewire('register-passwords')

       @if (is_null($invitationEmail))
        <!-- Subdomain -->
            <div class="mt-4">
                <x-label for="subdomain" :value="__('Subdomain')"></x-label>
                <x-input id="subdomain"
                         class="block mt-1 w-full"
                         type="text" name="subdomain"
                         :value="old('subdomain')"
                         required></x-input>
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
