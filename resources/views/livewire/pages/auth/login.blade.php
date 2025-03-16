<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        Session::flash('status', 'Login successful!');
        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        {{-- Logo / Head --}}
        <div>
            <x-input-label for="judul" :value="__('Login Admin')" class="text-center font-bold text-4xl my-8" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full !text-black" type="email"
                name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4 relative">
            <x-input-label for="Password" :value="__('Password')" />
            <x-mary-password id="password" wire:model="password" class="block mt-1 w-full pr-10 !text-black"
                type="password" name="password" required autocomplete="current-password" right />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox"
                    class="checkbox checkbox-primary checkbox-sm" name="remember" required>
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Saya setuju dengan') }}
                    <a href="{{ route('terms') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                        {{ __('syarat dan ketentuan') }}
                    </a>
                </span>
            </label>
        </div>

        <div class="flex flex-col items-center justify-end mt-4">
            <x-primary-button class="ms-3 btn mb-5" wire:loading.attr="disabled" wire:click="login">
                <span wire:loading.remove>{{ __('Masuk') }}</span>
                <span wire:loading class="loading loading-spinner text-primary"></span>
            </x-primary-button>

            <div>
                <div class="text-sm text-center text-gray-600 dark:text-gray-400">
                    Belum memiliki akun?
                    <a class="underline hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        href="{{ route('register') }}" wire:navigate>
                        {{ __('Register disini') }}
                    </a>
                </div>

                <div class="text-sm text-center text-gray-600 dark:text-gray-400 mt-1">
                    atau
                </div>

                @if (Route::has('password.request'))
                <div class="text-center">
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Lupa password anda?') }}
                    </a>
                </div>
                @endif
            </div>
        </div>
    </form>

    <!-- Script untuk toggle password visibility -->
    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const showIcon = document.getElementById('show-icon');
            const hideIcon = document.getElementById('hide-icon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                showIcon.classList.add('hidden');
                hideIcon.classList.remove('hidden');
            } else {
                passwordField.type = 'password';
                hideIcon.classList.add('hidden');
                showIcon.classList.remove('hidden');
            }
        }
    </script>
</div>