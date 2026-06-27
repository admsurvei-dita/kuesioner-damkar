<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-yellow-500 leading-tight">
            {{ __('Dashboard Kesiapsiagaan Kesejahteraan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-neutral-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Pesan Sukses Pengisian -->
            @if(session()->has('message'))
                <div class="mb-6 p-4 bg-green-950 border-l-4 border-green-500 text-green-200 rounded-md">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Banner Motivasi Identitas Damkar -->
            <div
                class="bg-neutral-900 rounded-xl shadow-2xl overflow-hidden border-l-4 border-red-600 mb-8 border border-neutral-800">
                <div class="p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="mb-4 md:mb-0 max-w-3xl space-y-4">
                        <h3 class="text-white text-2xl font-black tracking-wider uppercase">
                            PANTANG PULANG SEBELUM PADAM, PANTANG PENSIUN SEBELUM SEJAHTERA!
                        </h3>
                        <p class="text-neutral-300 text-xs sm:text-sm leading-relaxed">
                            Petugas Pemadam dan Penyelamat Kabupaten Bekasi adalah pelindung utama pusat industri Asia
                            Tenggara. Risiko nyawa ekstrem yang Anda pertaruhkan di lapangan merupakan fakta nyata yang
                            wajib diapresiasi dengan kompensasi dan kelas jabatan (<strong>grading</strong>) yang
                            proporsional.
                        </p>
                        <p class="text-yellow-500 font-extrabold text-xs sm:text-sm">
                            Kajian ini ditargetkan untuk mendesak pengalihan anggaran kompensasi ke dalam Pos Belanja
                            Barang & Jasa (Asuransi Komersial Tambahan, MCU Toksikologi, & Extra Fooding Detoks harian)
                            serta mengunci kelas jabatan Grading Skala Atas (Grading 7 s.d. 10) sebelum kebijakan Single
                            Salary Nasional diberlakukan penuh!
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <img src="{{ asset('storage/images/logo_bekasi.png') }}" alt="Bekasi Regency Logo"
                            class="h-28 w-auto opacity-80"
                            onerror="this.onerror=null; this.src='{{ asset('storage/images/logo_bekasi.png') }}'">
                    </div>
                </div>
            </div>

            <!-- TAMPILAN SURVEY JIKA BELUM SELESAI -->
            @if(!Auth::user()->is_completed)
                <div class="mb-6">
                    <div
                        class="p-4 bg-red-950 border border-red-800 text-red-200 rounded-lg mb-6 flex items-center space-x-3">
                        <svg class="h-6 w-6 text-red-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div>
                            <h4 class="font-bold text-sm sm:text-base">PERHATIAN: ANDA BELUM MENGISI KUESIONER</h4>
                            <p class="text-xs">Anda terdaftar sebagai kelompok responden
                                <strong>[{{ Auth::user()->kelompok_responden }}]</strong>. Sistem akan menyajikan daftar
                                kuesioner dinamis yang sesuai dengan profil risiko kerja nyata Anda di lapangan.
                            </p>
                        </div>
                    </div>

                    @livewire('questionnaire-wizard')
                </div>
            @else
                <!-- JIKA SUDAH SELESAI -->
                <div class="bg-neutral-900 p-8 rounded-xl text-center border border-neutral-800">
                    <div
                        class="w-20 h-20 bg-green-950 border border-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="h-10 w-10 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-white text-2xl font-black mb-2">TERIMA KASIH ATAS DEDIKASI ANDA</h3>
                    <p class="text-neutral-400 max-w-xl mx-auto text-xs sm:text-sm leading-relaxed mb-6">
                        Data kuesioner Anda telah terekam secara aman dalam database sistem. Tim Balitbangda akan segera
                        memformulasikan Skor Bahaya *Fine & Kinney* ini sebagai amunisi negosiasi regulasi di tingkat daerah
                        maupun pusat.
                    </p>
                    <span
                        class="px-4 py-2 bg-neutral-800 border border-neutral-700 rounded-full text-xs font-bold text-yellow-500 uppercase tracking-widest">
                        Status Kuesioner: Selesai
                    </span>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>