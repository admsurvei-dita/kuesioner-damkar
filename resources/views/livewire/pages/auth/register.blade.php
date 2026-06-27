<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $status_kepegawaian = '';
    public string $kelompok_responden = '';
    public string $unit_kerja = '';

    // Daftar 10 Pos Sektor Resmi Damkar Kabupaten Bekasi
    public $posSektorList = [
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
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'status_kepegawaian' => ['required', 'string', 'in:PNS,PPPK,TKK/Honorer'],
            'kelompok_responden' => ['required', 'string', 'in:A,B,C,D,E'],
            'unit_kerja' => ['required', 'string', 'in:' . implode(',', $this->posSektorList)],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-neutral-950">
    <!-- Header Identitas Damkar -->
    <div class="text-center mb-6 z-10">
        <div class="flex justify-center items-center space-x-4 mb-3">
            <img src="{{ asset('storage/images/logo_bekasi.png') }}" alt="Logo Kab Bekasi" class="h-16 w-auto"
                onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/f/f9/Lambang_Kabupaten_Bekasi.svg'">
            <div class="border-r border-red-700 h-16"></div>
            <div class="flex flex-col justify-center text-left">
                <h2 class="text-yellow-500 font-black text-lg tracking-wider uppercase leading-none">Registrasi
                    Responden</h2>
                <p class="text-white text-[9px] font-bold tracking-widest mt-1">DAMKAR KABUPATEN BEKASI</p>
            </div>
        </div>
        <p class="text-neutral-400 text-xs italic px-6">"Pilihlah pos sektor penugasan Anda secara presisi demi validasi
            data kajian."</p>
    </div>

    <div
        class="w-full sm:max-w-md mt-4 px-6 py-8 bg-neutral-900 border-t-4 border-red-700 shadow-2xl overflow-hidden sm:rounded-xl border border-neutral-800 z-10">
        <form wire:submit.prevent="register">
            <!-- Nama Lengkap / Inisial -->
            <div>
                <x-input-label for="name" class="text-neutral-300 font-semibold" value="Nama Lengkap / Inisial" />
                <x-text-input id="name" wire:model.blur="name"
                    class="block mt-1 w-full bg-neutral-800 text-white border-neutral-700 focus:border-red-500 focus:ring-0"
                    type="text" required autofocus />
                @error('name') <span class="text-xs text-red-500 mt-1 block font-bold">{{ $message }}</span> @enderror
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" class="text-neutral-300 font-semibold"
                    value="Alamat Email (Dinas / Pribadi)" />
                <x-text-input id="email" wire:model.blur="email"
                    class="block mt-1 w-full bg-neutral-800 text-white border-neutral-700 focus:border-red-500 focus:ring-0"
                    type="email" required />
                @error('email') <span class="text-xs text-red-500 mt-1 block font-bold">{{ $message }}</span> @enderror
            </div>

            <!-- Status Kepegawaian -->
            <div class="mt-4">
                <x-input-label for="status_kepegawaian" class="text-neutral-300 font-semibold"
                    value="Status Kepegawaian" />
                <select id="status_kepegawaian" wire:model="status_kepegawaian"
                    class="block mt-1 w-full bg-neutral-800 text-white border-neutral-700 rounded-md shadow-sm focus:border-red-500 focus:ring-0 text-sm"
                    required>
                    <option value="">-- Pilih Status --</option>
                    <option value="PNS">Pegawai Negeri Sipil (PNS)</option>
                    <option value="PPPK">Pegawai Pemerintah dengan Perjanjian Kerja (PPPK)</option>
                    <option value="TKK/Honorer">Tenaga Kerja Kontrak (TKK) / Tenaga Honorer Daerah</option>
                </select>
                @error('status_kepegawaian') <span
                class="text-xs text-red-500 mt-1 block font-bold">{{ $message }}</span> @enderror
            </div>

            <!-- Kelompok Responden -->
            <div class="mt-4">
                <x-input-label for="kelompok_responden" class="text-neutral-300 font-semibold"
                    value="Kelompok Responden" />
                <select id="kelompok_responden" wire:model="kelompok_responden"
                    class="block mt-1 w-full bg-neutral-800 text-white border-neutral-700 rounded-md shadow-sm focus:border-red-500 focus:ring-0 text-sm"
                    required>
                    <option value="">-- Pilih Kelompok --</option>
                    <option value="A">A. Petugas Lapangan Pemadam Kebakaran</option>
                    <option value="B">B. Petugas Lapangan Penyelamat (Rescue)</option>
                    <option value="E">E. Petugas Lapangan Pemadam dan Penyelamatan (Gabungan)</option>
                    <option value="C">C. Komandan Regu (Danru) / Komandan Peleton (Danton)</option>
                    <option value="D">D. Staf Kantor / Pendukung (Pusdalops, Logistik, Pencegahan, Adm)</option>
                </select>
                @error('kelompok_responden') <span
                class="text-xs text-red-500 mt-1 block font-bold">{{ $message }}</span> @enderror
            </div>

            <!-- Unit Kerja / Pos Sektor Dropdown -->
            <div class="mt-4">
                <x-input-label for="unit_kerja" class="text-neutral-300 font-semibold"
                    value="Unit Kerja / Pos Sektor Tugas" />
                <select id="unit_kerja" wire:model="unit_kerja"
                    class="block mt-1 w-full bg-neutral-800 text-white border-neutral-700 rounded-md shadow-sm focus:border-red-500 focus:ring-0 text-sm"
                    required>
                    <option value="">-- Pilih Pos Sektor --</option>
                    @foreach($posSektorList as $pos)
                        <option value="{{ $pos }}">{{ $pos }}</option>
                    @endforeach
                </select>
                @error('unit_kerja') <span class="text-xs text-red-500 mt-1 block font-bold">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" class="text-neutral-300 font-semibold" value="Kata Sandi" />
                <x-text-input id="password" wire:model="password"
                    class="block mt-1 w-full bg-neutral-800 text-white border-neutral-700 focus:border-red-500 focus:ring-0"
                    type="password" required />
                @error('password') <span class="text-xs text-red-500 mt-1 block font-bold">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" class="text-neutral-300 font-semibold"
                    value="Konfirmasi Kata Sandi" />
                <x-text-input id="password_confirmation" wire:model="password_confirmation"
                    class="block mt-1 w-full bg-neutral-800 text-white border-neutral-700 focus:border-red-500 focus:ring-0"
                    type="password" required />
            </div>

            <div class="flex flex-col space-y-4 mt-6">
                <button type="submit"
                    class="w-full inline-flex items-center justify-center px-4 py-3 bg-red-700 hover:bg-red-650 active:bg-red-900 text-white font-extrabold text-sm uppercase rounded-lg tracking-wider border border-red-500 shadow-lg transition-colors">
                    DAFTAR & LANJUT SURVEI
                </button>

                <div class="text-center text-xs">
                    <a class="underline text-neutral-400 hover:text-white" href="{{ route('login') }}">
                        Sudah memiliki akun? Masuk disini
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>