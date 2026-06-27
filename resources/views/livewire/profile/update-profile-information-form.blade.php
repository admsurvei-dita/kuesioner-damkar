<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';
    public string $status_kepegawaian = '';
    public string $kelompok_responden = '';
    public string $unit_kerja = '';

    public array $posSektorList = [
        'Mako Cikarang Barat',
        'Pos Sektor Cikarang Utara',
        'Pos Sektor Cikarang Selatan',
        'Pos Sektor Cibitung',
        'Pos Sektor Tambun',
        'Pos Sektor Babelan',
        'Pos Sektor Tarumajaya',
        'Pos Sektor Setu',
        'Pos Sektor Serang Baru',
        'Pos Sektor Muaragembong'
    ];

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->status_kepegawaian = $user->status_kepegawaian ?? '';
        $this->kelompok_responden = $user->kelompok_responden ?? '';
        $this->unit_kerja = $user->unit_kerja ?? '';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'status_kepegawaian' => ['required', 'string'],
            'kelompok_responden' => ['required', 'in:A,B,C,D,E'],
            'unit_kerja' => ['required', 'string', 'in:' . implode(',', $this->posSektorList)],
        ]);

        $kelompokBerubah = $user->kelompok_responden !== $this->kelompok_responden;

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($kelompokBerubah) {
            $user->is_completed = false;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);

        if ($kelompokBerubah) {
            $this->redirect(route('dashboard'), navigate: true);
        }
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Perbarui data akun, kelompok penugasan, dan lokasi unit kerja operasional Anda.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <!-- Grid layout to arrange fields beautifully -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name Field -->
            <div>
                <x-input-label for="name" :value="__('Nama Lengkap / Inisial')" />
                <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required
                    autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Email Field -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required
                    autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                    <div class="mt-2">
                        <p class="text-sm text-gray-800 dark:text-gray-200">
                            {{ __('Your email address is unverified.') }}

                            <button wire:click.prevent="sendVerification"
                                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Status Kepegawaian Dropdown -->
            <div>
                <x-input-label for="status_kepegawaian" :value="__('Status Kepegawaian')" />
                <select id="status_kepegawaian" wire:model="status_kepegawaian"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm text-sm"
                    required>
                    <option value="">-- Pilih Status --</option>
                    <option value="PNS">Pegawai Negeri Sipil (PNS)</option>
                    <option value="PPPK">Pegawai Pemerintah dengan Perjanjian Kerja (PPPK)</option>
                    <option value="TKK/Honorer">Tenaga Kerja Kontrak (TKK) / Tenaga Honorer Daerah</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('status_kepegawaian')" />
            </div>

            <!-- Kelompok Responden Dropdown -->
            <div>
                <x-input-label for="kelompok_responden" :value="__('Kelompok Responden')" />
                <select id="kelompok_responden" wire:model="kelompok_responden"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm text-sm"
                    required>
                    <option value="">-- Pilih Kelompok --</option>
                    <option value="A">A. Petugas Lapangan Pemadam Kebakaran</option>
                    <option value="B">B. Petugas Lapangan Penyelamat (Rescue)</option>
                    <option value="E">E. Petugas Lapangan Pemadam & Penyelamatan</option>
                    <option value="C">C. Komandan Regu (Danru) / Komandan Peleton (Danton)</option>
                    <option value="D">D. Staf Kantor / Pendukung (Pusdalops, Logistik, Adm)</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('kelompok_responden')" />
            </div>

            <!-- Unit Kerja / Pos Sektor Dropdown -->
            <div>
                <x-input-label for="unit_kerja" :value="__('Unit Kerja / Pos Sektor')" />
                <select id="unit_kerja" wire:model="unit_kerja"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm text-sm"
                    required>
                    <option value="">-- Pilih Pos Sektor --</option>
                    @foreach($posSektorList as $pos)
                        <option value="{{ $pos }}">{{ $pos }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('unit_kerja')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>