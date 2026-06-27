<div class="min-h-screen bg-neutral-900 text-neutral-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header Dashboard Command Center -->
        <div
            class="flex flex-col md:flex-row items-start md:items-center justify-between pb-6 mb-8 border-b border-neutral-800">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-red-950 border border-red-700 rounded-lg text-red-500 shadow-inner">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-yellow-500 tracking-wider">COMMAND CENTER SURVEY</h1>
                    <p class="text-xs text-neutral-400 font-medium mt-1">Sistem Evaluasi Jaminan & Kompensasi Risiko
                        Tinggi Aparatur Damkar Bekasi</p>
                </div>
            </div>

            <!-- Switch Tab Mode -->
            <div class="mt-4 md:mt-0 flex bg-neutral-800 p-1.5 rounded-lg border border-neutral-700">
                <button wire:click="$set('viewMode', 'progress')"
                    class="px-4 py-2 rounded-md text-xs font-bold uppercase tracking-wider transition-all {{ $viewMode === 'progress' ? 'bg-red-700 text-white shadow' : 'text-neutral-400 hover:text-white' }}">
                    Monitoring Target
                </button>
                <button wire:click="$set('viewMode', 'analysis')"
                    class="px-4 py-2 rounded-lg text-xs font-bold uppercase {{ $viewMode === 'analysis' ? 'bg-red-700 text-white' : 'text-neutral-500' }}">Analisis
                    Risiko
                </button>
                <button wire:click="$set('viewMode', 'questions')"
                    class="px-4 py-2 rounded-md text-xs font-bold uppercase tracking-wider transition-all {{ $viewMode === 'questions' ? 'bg-red-700 text-white shadow' : 'text-neutral-400 hover:text-white' }}">
                    Kelola Pertanyaan
                </button>
            </div>
        </div>

        <!-- Session Message Alert -->
        @if(session()->has('message'))
            <div
                class="mb-6 p-4 bg-green-950 border-l-4 border-green-500 text-green-200 rounded-lg shadow-md flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <svg class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-semibold">{{ session('message') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-400 hover:text-white">&times;</button>
            </div>
        @endif

        <!-- TAB 1: PROGRESS MONITORING & SECTOR STATISTICS -->
        @if($viewMode === 'progress')

            <!-- Progress Target Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Target Pasukan Lapangan -->
                <div
                    class="bg-neutral-850 p-6 rounded-xl border border-neutral-800 border-t-4 border-blue-500 shadow-xl relative overflow-hidden">
                    <h3 class="text-xs font-bold text-neutral-400 uppercase tracking-widest mb-1">Target Pasukan Lapangan
                        (A+B+E)</h3>
                    <div class="flex items-baseline space-x-2 my-2">
                        <span class="text-5xl font-black text-white">{{ $lapanganCompleted }}</span>
                        <span class="text-sm text-neutral-400 font-bold">/ 65 Responden</span>
                    </div>
                    @php $p1 = min(100, ($lapanganCompleted / 65) * 100); @endphp
                    <div class="w-full bg-neutral-700 rounded-full h-3 mt-4">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-400 h-3 rounded-full transition-all duration-500"
                            style="width: {{ $p1 }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-neutral-400 mt-2 font-semibold">
                        <span>Pencapaian: {{ number_format($p1, 1) }}%</span>
                        <span>Sisa Target: {{ max(0, 65 - $lapanganCompleted) }}</span>
                    </div>
                </div>

                <!-- Target Komandan Regu -->
                <div
                    class="bg-neutral-850 p-6 rounded-xl border border-neutral-800 border-t-4 border-yellow-500 shadow-xl relative overflow-hidden">
                    <h3 class="text-xs font-bold text-neutral-400 uppercase tracking-widest mb-1">Target Komandan Regu (C)
                    </h3>
                    <div class="flex items-baseline space-x-2 my-2">
                        <span class="text-5xl font-black text-white">{{ $danruCompleted }}</span>
                        <span class="text-sm text-neutral-400 font-bold">/ 10 Responden</span>
                    </div>
                    @php $p2 = min(100, ($danruCompleted / 10) * 100); @endphp
                    <div class="w-full bg-neutral-700 rounded-full h-3 mt-4">
                        <div class="bg-gradient-to-r from-yellow-600 to-yellow-400 h-3 rounded-full transition-all duration-500"
                            style="width: {{ $p2 }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-neutral-400 mt-2 font-semibold">
                        <span>Pencapaian: {{ number_format($p2, 1) }}%</span>
                        <span>Sisa Target: {{ max(0, 10 - $danruCompleted) }}</span>
                    </div>
                </div>

                <!-- Target Staf Administrasi -->
                <div
                    class="bg-neutral-850 p-6 rounded-xl border border-neutral-800 border-t-4 border-purple-500 shadow-xl relative overflow-hidden">
                    <h3 class="text-xs font-bold text-neutral-400 uppercase tracking-widest mb-1">Target Staf Administrasi
                        (D)</h3>
                    <div class="flex items-baseline space-x-2 my-2">
                        <span class="text-5xl font-black text-white">{{ $admCompleted }}</span>
                        <span class="text-sm text-neutral-400 font-bold">/ 5 Responden</span>
                    </div>
                    @php $p3 = min(100, ($admCompleted / 5) * 100); @endphp
                    <div class="w-full bg-neutral-700 rounded-full h-3 mt-4">
                        <div class="bg-gradient-to-r from-purple-600 to-purple-400 h-3 rounded-full transition-all duration-500"
                            style="width: {{ $p3 }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-neutral-400 mt-2 font-semibold">
                        <span>Pencapaian: {{ number_format($p3, 1) }}%</span>
                        <span>Sisa Target: {{ max(0, 5 - $admCompleted) }}</span>
                    </div>
                </div>
            </div>

            <!-- REKAPITULASI PENYURVEIAN PER POS SEKTOR -->
            <div class="bg-neutral-850 border border-neutral-800 rounded-xl p-6 shadow-xl mb-8">
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-neutral-750">
                    <div>
                        <h3 class="text-lg font-bold text-yellow-500">REKAPITULASI PENYURVEIAN PER POS SEKTOR</h3>
                        <p class="text-xs text-neutral-400 font-semibold mt-1">Memantau pos sektor mana saja di wilayah
                            Kabupaten Bekasi yang anggotanya sudah mengisi kuesioner</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    @foreach($sektorMetrics as $sektorName => $stat)
                        <div class="p-4 bg-neutral-900 border border-neutral-800 rounded-lg flex flex-col justify-between">
                            <span class="text-xs font-bold text-neutral-300 block mb-2">{{ $sektorName }}</span>
                            <div class="flex items-baseline justify-between mt-auto">
                                <span class="text-lg font-black text-white">
                                    {{ $stat['completed'] }} <span class="text-[10px] text-neutral-500">selesai</span>
                                </span>
                                <span class="text-xs text-neutral-400 italic">Total: {{ $stat['total'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Temuan Bahaya Baru OOD Table -->
            <div class="bg-neutral-850 border border-neutral-800 rounded-xl p-6 shadow-xl mb-8">
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-neutral-750">
                    <div>
                        <h3 class="text-lg font-bold text-red-500">DAFTAR IDENTIFIKASI BAHAYA KHAS BARU (OOD)</h3>
                        <p class="text-xs text-neutral-400">Temuan bahasi baru yang diidentifikasi langsung oleh petugas
                            lapangan dengan penilaian P, E, dan C</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-neutral-300">
                        <thead class="bg-neutral-900 text-neutral-400 uppercase text-xs">
                            <tr>
                                <th class="p-3">Nama Responden / Sektor</th>
                                <th class="p-3">Skenario Bahaya Baru</th>
                                <th class="p-3">Exposure (E)</th>
                                <th class="p-3">Probability (P)</th>
                                <th class="p-3">Consequence (C)</th>
                                <th class="p-3">Risk Score (RS)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-850">
                            @php
                                // Ambil seluruh jawaban custom
                                $customAnswers = \App\Models\Answer::whereHas('question', function ($query) {
                                    $query->where('type', 'custom');
                                })->with(['user', 'question'])->latest()->get();
                            @endphp
                            @forelse($customAnswers as $ans)
                                <tr class="hover:bg-neutral-800 transition-colors">
                                    <td class="p-3">
                                        <div class="font-bold text-white">{{ $ans->user->name }}</div>
                                        <div class="text-[10px] text-neutral-400 font-semibold">{{ $ans->user->unit_kerja }}
                                        </div>
                                    </td>
                                    <td class="p-3 text-white font-semibold leading-relaxed max-w-xs">
                                        {{ $ans->question->text_pertanyaan }}</td>
                                    <td class="p-3 font-semibold text-neutral-100">{{ $ans->score_e }}</td>
                                    <td class="p-3 font-semibold text-neutral-100">{{ $ans->score_p }}</td>
                                    <td class="p-3 font-semibold text-neutral-100">{{ $ans->score_c }}</td>
                                    <td class="p-3">
                                        @php
                                            $rs = $ans->score_e * $ans->score_p * $ans->score_c;
                                        @endphp
                                        <span
                                            class="px-2.5 py-1 rounded text-xs font-black {{ $rs > 350 ? 'bg-red-950 text-red-400 border border-red-800' : 'bg-neutral-900 text-yellow-500' }}">
                                            {{ $rs }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-neutral-500">Belum ada responden yang
                                        menginputkan temuan bahaya baru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- LAPORAN INSIDEN RIWAYAT MEDIS -->
            <div class="bg-neutral-850 border border-neutral-800 rounded-xl p-6 shadow-xl">
                <div class="pb-4 mb-4 border-b border-neutral-750">
                    <h3 class="text-lg font-bold text-yellow-500 uppercase">Laporan Insiden & Kerusakan Fisik Terakumulasi
                    </h3>
                    <p class="text-xs text-neutral-400">Daftar riwayat kecelakaan kerja dan asfiksia gas karsinogenik yang
                        terekam pada kuesioner</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-neutral-300">
                        <thead class="bg-neutral-900 text-neutral-400 uppercase text-xs">
                            <tr>
                                <th class="p-3">Sektor / Responden</th>
                                <th class="p-3">Kategori</th>
                                <th class="p-3">Tahun</th>
                                <th class="p-3">Kronologi Dampak Cedera Kerja</th>
                                <th class="p-3">Kondisi Fisik Saat Ini</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-850">
                            @forelse(\App\Models\ResponderHealthHistory::with('user')->latest()->get() as $hh)
                                <tr class="hover:bg-neutral-800 transition-colors">
                                    <td class="p-3">
                                        <div class="font-bold text-white">{{ $hh->user->name }}</div>
                                        <div class="text-[10px] text-neutral-400">{{ $hh->user->unit_kerja }}</div>
                                    </td>
                                    <td class="p-3">
                                        <span
                                            class="px-2 py-0.5 bg-neutral-900 border border-red-800 text-red-400 text-[10px] font-bold rounded uppercase">
                                            {{ $hh->kategori_dampak }}
                                        </span>
                                    </td>
                                    <td class="p-3 font-semibold">{{ $hh->tahun_kejadian }}</td>
                                    <td class="p-3 text-neutral-200 text-xs leading-relaxed max-w-sm">
                                        {{ $hh->deskripsi_kronologi }}</td>
                                    <td class="p-3">
                                        <span
                                            class="px-2 py-0.5 bg-neutral-900 border border-neutral-700 text-yellow-500 text-[10px] font-bold rounded">
                                            {{ $hh->dampak_tugas }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-6 text-center text-neutral-500">Belum ada riwayat cedera medis yang
                                        tercatat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 2: ANALISIS RISIKO -->
        @elseif($viewMode === 'analysis')
            <!-- TAB BARU: TABEL HASIL ANALISIS FINE KINNEY -->
            <div class="space-y-8">
                <div class="bg-neutral-900 border border-neutral-800 rounded-2xl overflow-hidden shadow-2xl">
                    <div class="p-6 border-b border-neutral-800 bg-neutral-900/50">
                        <h3 class="text-xl font-black text-white uppercase tracking-wider">MATRIKS HASIL PERHITUNGAN
                            FINE-KINNEY
                        </h3>
                        <p class="text-xs text-neutral-500 mt-1 italic">*Skor RS dihitung dari rata-rata kumulatif Exposure
                            x
                            Probability x Consequence</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-neutral-800 text-[10px] font-black uppercase text-neutral-400">
                                <tr>
                                    <th class="p-4">Skenario Bahaya (Hazard)</th>
                                    <th class="p-4 text-center">Avg E</th>
                                    <th class="p-4 text-center">Avg P</th>
                                    <th class="p-4 text-center">Avg C</th>
                                    <th class="p-4 text-center">Risk Score (RS)</th>
                                    <th class="p-4">Level Risiko</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-800">
                                @foreach($riskAnalysis as $item)
                                    <tr class="hover:bg-neutral-800/40 transition-colors">
                                        <td class="p-4">
                                            <div class="text-xs font-bold text-white">{{ $item['text'] }}</div>
                                            <div class="text-[10px] text-neutral-500 mt-1 uppercase tracking-tighter">
                                                {{ $item['klaster'] }}
                                            </div>
                                            @if($item['type'] === 'custom')
                                                <span
                                                    class="text-[9px] bg-yellow-950 text-yellow-500 px-1.5 py-0.5 rounded-full font-bold">TEMUAN
                                                    BARU</span>
                                            @endif
                                        </td>
                                        <td class="p-4 text-center text-xs font-mono">{{ $item['avg_e'] }}</td>
                                        <td class="p-4 text-center text-xs font-mono">{{ $item['avg_p'] }}</td>
                                        <td class="p-4 text-center text-xs font-mono">{{ $item['avg_c'] }}</td>
                                        <td class="p-4 text-center font-black text-white">{{ $item['rs'] }}</td>
                                        <td class="p-4">
                                            <span class="text-[10px] font-black uppercase tracking-widest {{ $item['color'] }}">
                                                {{ $level = $item['level'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB 3: KELOLA SOAL & PILIHAN JAWABAN (CRUD) -->
        @elseif($viewMode === 'questions')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Panel Form Tambah/Edit (Kiri) -->
                <div class="bg-neutral-850 p-6 rounded-xl border border-neutral-800 shadow-xl h-fit">
                    <h3
                        class="text-lg font-bold text-yellow-500 mb-4 border-b border-neutral-750 pb-2 flex items-center justify-between">
                        <span>{{ $isEditMode ? 'EDIT PERTANYAAN' : 'BUAT PERTANYAAN BARU' }}</span>
                        @if($isEditMode)
                            <button type="button" wire:click="resetForm" class="text-xs text-red-400 hover:text-white">Batal
                                Edit</button>
                        @endif
                    </h3>

                    <form wire:submit.prevent="{{ $isEditMode ? 'updateQuestion' : 'storeQuestion' }}">
                        <div class="space-y-4">
                            <!-- Input Klaster -->
                            <div>
                                <label class="block text-xs font-extrabold uppercase text-neutral-400">Klaster Utama</label>
                                <input type="text" wire:model="form.klaster" placeholder="Contoh: Penanggulangan Kebakaran"
                                    class="mt-1 w-full bg-neutral-900 border border-neutral-700 rounded p-2.5 text-sm text-white focus:border-red-500 focus:ring-0">
                                @error('form.klaster') <span
                                class="text-xs text-red-500 font-semibold">{{ $message }}</span> @enderror
                            </div>

                            <!-- Input Sub-Klaster -->
                            <div>
                                <label class="block text-xs font-extrabold uppercase text-neutral-400">Sub Klaster
                                    (Opsional)</label>
                                <input type="text" wire:model="form.sub_klaster"
                                    class="mt-1 w-full bg-neutral-900 border border-neutral-700 rounded p-2.5 text-sm text-white">
                            </div>

                            <!-- Kalimat Pertanyaan -->
                            <div>
                                <label class="block text-xs font-extrabold uppercase text-neutral-400">Kalimat
                                    Pertanyaan</label>
                                <textarea wire:model="form.text_pertanyaan"
                                    class="mt-1 w-full bg-neutral-900 border border-neutral-700 rounded p-2.5 text-sm text-white"
                                    rows="3"></textarea>
                                @error('form.text_pertanyaan') <span
                                class="text-xs text-red-500 font-semibold">{{ $message }}</span> @enderror
                            </div>

                            <!-- Checkbox Target Kelompok -->
                            <div>
                                <label class="block text-xs font-extrabold uppercase text-neutral-400 mb-2">Target
                                    Responden</label>
                                <div class="grid grid-cols-2 gap-2 p-3 bg-neutral-900 border border-neutral-750 rounded-lg">
                                    <label class="flex items-center text-xs font-bold text-neutral-300 cursor-pointer">
                                        <input type="checkbox" value="A" wire:model="form.target_kelompok"
                                            class="mr-2 text-red-700 rounded bg-neutral-800 border-neutral-700 focus:ring-0">
                                        Kelompok A (Pemadam)
                                    </label>
                                    <label class="flex items-center text-xs font-bold text-neutral-300 cursor-pointer">
                                        <input type="checkbox" value="B" wire:model="form.target_kelompok"
                                            class="mr-2 text-red-700 rounded bg-neutral-800 border-neutral-700 focus:ring-0">
                                        Kelompok B (Rescue)
                                    </label>
                                    <label class="flex items-center text-xs font-bold text-neutral-300 cursor-pointer">
                                        <input type="checkbox" value="E" wire:model="form.target_kelompok"
                                            class="mr-2 text-red-700 rounded bg-neutral-800 border-neutral-700 focus:ring-0">
                                        Kelompok E (Pemadam & Rescue)
                                    </label>
                                    <label class="flex items-center text-xs font-bold text-neutral-300 cursor-pointer">
                                        <input type="checkbox" value="C" wire:model="form.target_kelompok"
                                            class="mr-2 text-red-700 rounded bg-neutral-800 border-neutral-700 focus:ring-0">
                                        Kelompok C (Danru)
                                    </label>
                                    <label class="flex items-center text-xs font-bold text-neutral-300 cursor-pointer">
                                        <input type="checkbox" value="D" wire:model="form.target_kelompok"
                                            class="mr-2 text-red-700 rounded bg-neutral-800 border-neutral-700 focus:ring-0">
                                        Kelompok D (Staf)
                                    </label>
                                </div>
                                @error('form.target_kelompok') <span
                                class="text-xs text-red-500 font-semibold block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Opsi Jawaban Dinamis (Hanya untuk normal questions, Matrix Questions ditarik global) -->
                            <div class="border-t border-neutral-750 pt-4 mt-6">
                                <div class="flex items-center justify-between mb-3">
                                    <label class="block text-xs font-extrabold uppercase text-yellow-500">Pilihan Jawaban
                                        (Normal Only)</label>
                                    <button type="button" wire:click="addOptionField"
                                        class="text-xs bg-neutral-750 border border-neutral-600 hover:border-yellow-500 px-2 py-1 rounded text-yellow-500 font-bold">
                                        + Opsi
                                    </button>
                                </div>

                                <div class="space-y-4 max-h-[350px] overflow-y-auto pr-1">
                                    @foreach($formOptions as $index => $opt)
                                        <div class="p-3 bg-neutral-900 border border-neutral-750 rounded-lg relative">
                                            <!-- Pilihan Teks -->
                                            <div class="mb-2">
                                                <input type="text" wire:model="formOptions.{{ $index }}.text_pilihan"
                                                    placeholder="Teks pilihan jawaban..."
                                                    class="w-full bg-neutral-850 border border-neutral-700 rounded p-2 text-xs text-white focus:border-red-500 focus:ring-0"
                                                    required>
                                                @error("formOptions.{$index}.text_pilihan") <span
                                                class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                                            </div>

                                            <input type="hidden" wire:model="formOptions.{{ $index }}.parameter_type"
                                                value="N/A">
                                            <input type="hidden" wire:model="formOptions.{{ $index }}.score_value" value="0.0">

                                            <!-- Hapus Opsi -->
                                            @if(count($formOptions) > 1)
                                                <button type="button" wire:click="removeOptionField({{ $index }})"
                                                    class="absolute -top-2 -right-2 bg-red-600 hover:bg-red-700 text-white rounded-full p-1 text-xs focus:outline-none">
                                                    &times;
                                                </button>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Button Eksekusi Form -->
                        <div class="mt-8 flex justify-end">
                            <button type="submit"
                                class="w-full px-5 py-2.5 bg-red-700 hover:bg-red-650 border border-red-500 shadow text-white font-extrabold text-sm rounded-lg transition-colors">
                                {{ $isEditMode ? 'SIMPAN PERUBAHAN SOAL' : 'SIMPAN PERTANYAAN BARU' }}
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Panel Daftar Pertanyaan Aktif (Kanan) -->
                <div class="lg:col-span-2 bg-neutral-850 p-6 rounded-xl border border-neutral-800 shadow-xl">
                    <h3 class="text-lg font-bold text-white mb-4 pb-2 border-b border-neutral-750">DAFTAR PERTANYAAN AKTIF
                    </h3>

                    <div class="space-y-4 max-h-[750px] overflow-y-auto pr-2">
                        @foreach($questionsList as $q)
                            <div
                                class="p-4 bg-neutral-900 border border-neutral-800 rounded-xl relative hover:border-neutral-700 transition-colors">
                                <div class="flex items-center space-x-2 mb-2">
                                    <span
                                        class="px-2 py-0.5 bg-red-950 border border-red-800 rounded text-[9px] font-extrabold text-red-200 uppercase">
                                        {{ $q['klaster'] }}
                                    </span>
                                    @if($q['sub_klaster'])
                                        <span
                                            class="px-2 py-0.5 bg-neutral-800 border border-neutral-700 rounded text-[9px] font-bold text-neutral-400 uppercase">
                                            {{ $q['sub_klaster'] }}
                                        </span>
                                    @endif
                                    <span class="text-[10px] text-neutral-400 font-semibold ml-auto">
                                        Target: {{ implode(', ', $q['target_kelompok']) }}
                                    </span>
                                </div>

                                <h4 class="text-sm font-bold text-white leading-relaxed mb-3">
                                    {{ $q['text_pertanyaan'] }}
                                </h4>

                                <!-- Preview Opsi List -->
                                <div class="space-y-2 mt-2 pl-4 border-l-2 border-red-700">
                                    @if($q['type'] === 'matrix' || $q['type'] === 'custom')
                                        <div class="text-xs text-yellow-500 font-bold">
                                            [Tipe Matriks: Dievaluasi berdasarkan 3 Parameter Fine-Kinney Global (P, E, C)]
                                        </div>
                                    @else
                                        @foreach($q['options'] as $option)
                                            <div
                                                class="text-xs flex items-center justify-between py-1 border-b border-neutral-850 last:border-b-0">
                                                <span class="text-white font-semibold leading-relaxed tracking-wide">•
                                                    {{ $option['text_pilihan'] }}</span>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="mt-4 flex items-center space-x-2 border-t border-neutral-800 pt-3">
                                    @if($q['type'] !== 'matrix')
                                        <button wire:click="editQuestion({{ $q['id'] }})"
                                            class="px-3 py-1 bg-neutral-800 hover:bg-neutral-750 text-xs font-bold text-yellow-500 rounded border border-neutral-700">
                                            Edit Soal
                                        </button>
                                    @endif
                                    <button wire:click="deleteQuestion({{ $q['id'] }})"
                                        wire:confirm="Apakah Anda yakin ingin menghapus pertanyaan ini?"
                                        class="px-3 py-1 bg-neutral-800 hover:bg-neutral-750 text-xs font-bold text-red-500 rounded border border-neutral-700">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>