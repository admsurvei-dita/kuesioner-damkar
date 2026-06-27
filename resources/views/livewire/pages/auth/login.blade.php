<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;


new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;
    public string $email = '';
    public string $password = '';
    public bool $remember_me = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $validated = $this->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!auth()->attempt($validated, $this->remember_me)) {
            $this->addError('email', trans('auth.failed'));
            return;
        }

        Session::regenerate();

        $user = auth()->user();

        // Redirect ke admin dashboard jika role adalah admin
        if ($user->role === 'admin') {
            $this->redirect(route('admin.dashboard', absolute: false), navigate: true);
            return;
        }

        // Redirect ke dashboard responden untuk user biasa
        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-neutral-950">

        <!-- Header Identitas Damkar -->
        <div class="text-center mb-6 z-10">
            <div class="flex justify-center items-center space-x-4 mb-3">
                <img src="/images/logo_bekasi.png" alt="Logo Kab Bekasi" class="h-20 w-auto"
                    onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/f/f9/Lambang_Kabupaten_Bekasi.svg'">
                <div class="border-r border-red-700 h-20"></div>
                <div class="flex flex-col justify-center text-left">
                    <h2 class="text-yellow-500 font-black text-xl tracking-wider uppercase leading-none">Dinas Pemadam
                    </h2>
                    <h2 class="text-yellow-500 font-black text-xl tracking-wider uppercase leading-none mt-1">Kebakaran
                    </h2>
                    <p class="text-white text-[10px] font-bold tracking-widest mt-1">KABUPATEN BEKASI</p>
                </div>
            </div>
            <p class="text-neutral-400 text-xs italic mt-2 px-6">"Swatantra Wibawa Mukti - Melindungi risiko kerja
                pahlawan pemadam penyelamat."</p>
        </div>

        <div
            class="w-full sm:max-w-md mt-4 px-6 py-8 bg-neutral-900 border-t-4 border-red-700 shadow-2xl overflow-hidden sm:rounded-xl border border-neutral-800 z-10">
            <h3 class="text-white text-center font-extrabold text-lg mb-6 uppercase tracking-wider">MASUK KE PANEL
                RESPONDEN</h3>

            <form wire:submit="login">

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" class="text-neutral-300 font-semibold" value="Email Terdaftar" />
                    <x-text-input wire:model="email" id="email"
                        class="block mt-1 w-full bg-neutral-800 text-white border-neutral-700 focus:border-red-500 focus:ring-red-500"
                        type="email" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" class="text-neutral-300 font-semibold"
                        value="Kata Sandi (Password)" />
                    <x-text-input wire:model="password" id="password"
                        class="block mt-1 w-full bg-neutral-800 text-white border-neutral-700 focus:border-red-500 focus:ring-red-500"
                        type="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input wire:model="remember_me" id="remember_me" type="checkbox"
                            class="rounded bg-neutral-800 border-neutral-700 text-red-700 focus:ring-0">
                        <span class="ms-2 text-sm text-neutral-400">Ingat Saya di Perangkat Ini</span>
                    </label>
                </div>

                <div class="flex flex-col space-y-4 mt-6">
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center px-4 py-3 bg-red-700 hover:bg-red-650 active:bg-red-900 text-white font-extrabold text-sm uppercase rounded-lg tracking-wider border border-red-500 shadow-lg transition-colors">
                        MASUK & ISI SURVEY
                    </button>

                    <div class="flex items-center justify-between text-xs pt-2">
                        <a class="underline text-neutral-400 hover:text-white" href="{{ route('password.request') }}">
                            Lupa kata sandi?
                        </a>

                        <a class="underline text-neutral-400 hover:text-white" href="{{ route('register') }}">
                            Belum punya akun? Registrasi disini
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>