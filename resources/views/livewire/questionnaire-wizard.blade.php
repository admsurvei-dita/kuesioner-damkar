<div class="bg-neutral-800 text-white rounded-xl shadow-2xl overflow-hidden border border-neutral-700">
    
    <!-- Progress Bar Indikator Alur -->
    @php 
        $totalSteps = count($questions) + 2; // Soal Standar + Riwayat Medis + Custom Hazards
    @endphp
    <div class="w-full bg-neutral-700 h-2.5">
        <div class="bg-gradient-to-r from-red-600 to-yellow-500 h-2.5 transition-all duration-300" 
             style="width: {{ (($currentStep + 1) / $totalSteps) * 100 }}%">
        </div>
    </div>

    <div class="p-6 sm:p-8">
        
        <!-- KONDISI 1: SOAL KUESIONER UTAMA -->
        @if($currentStep < count($questions))
            @php $q = $questions[$currentStep]; @endphp
            
            <!-- WRAP SOAL DENGAN wire:key UNIK -->
            <div wire:key="question-step-{{ $currentStep }}-{{ $q['id'] }}">
                <div class="mb-4">
                    <span class="px-3 py-1 bg-red-950 border border-red-800 rounded-md text-xs font-black uppercase tracking-wider text-red-300">
                        Klaster: {{ $q['klaster'] }}
                    </span>
                    @if($q['sub_klaster'])
                        <span class="ml-2 px-3 py-1 bg-neutral-700 rounded-md text-xs font-bold text-neutral-300">
                            {{ $q['sub_klaster'] }}
                        </span>
                    @endif
                </div>

                <!-- TEKS SKENARIO/PERTANYAAN -->
                <h3 class="text-base sm:text-lg font-bold text-yellow-500 mb-6 leading-relaxed">
                    {{ $currentStep + 1 }}. {{ $q['text_pertanyaan'] }}
                </h3>

                <!-- SUB-KONDISI A: SOAL MATRIKS FINE & KINNEY -->
                @if($q['type'] === 'matrix')
                    <div class="space-y-6 bg-neutral-900/60 p-5 rounded-xl border border-neutral-750 mb-6">
                        <p class="text-xs text-yellow-400 font-semibold uppercase tracking-wider mb-2">Evaluasi Matriks Fine-Kinney:</p>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Dropdown Parameter E (Exposure) -->
                            <div wire:key="matrix-e-{{ $q['id'] }}">
                                <label class="block text-xs font-bold text-neutral-300 uppercase mb-2">1. Exposure / Paparan (E)</label>
                                <select wire:model="matrixAnswers.{{ $q['id'] }}.E" class="w-full bg-neutral-800 border-neutral-700 rounded-lg text-xs text-white p-2.5 focus:border-red-500 focus:ring-0">
                                    <option value="">-- Pilih Tingkat Paparan --</option>
                                    @foreach($globalExposures as $opt)
                                        <option value="{{ $opt['score_value'] }}">{{ $opt['text_pilihan'] }} [ {{ $opt['deskripsi_kriteria'] }} ]</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Dropdown Parameter P (Probability) -->
                            <div wire:key="matrix-p-{{ $q['id'] }}">
                                <label class="block text-xs font-bold text-neutral-300 uppercase mb-2">2. Probability / Peluang (P)</label>
                                <select wire:model="matrixAnswers.{{ $q['id'] }}.P" class="w-full bg-neutral-800 border-neutral-700 rounded-lg text-xs text-white p-2.5 focus:border-red-500 focus:ring-0">
                                    <option value="">-- Pilih Tingkat Peluang --</option>
                                    @foreach($globalProbabilities as $opt)
                                        <option value="{{ $opt['score_value'] }}">{{ $opt['text_pilihan'] }} [ {{ $opt['deskripsi_kriteria'] }} ]</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Dropdown Parameter C (Consequence) -->
                            <div wire:key="matrix-c-{{ $q['id'] }}">
                                <label class="block text-xs font-bold text-neutral-300 uppercase mb-2">3. Consequence / Keparahan (C)</label>
                                <select wire:model="matrixAnswers.{{ $q['id'] }}.C" class="w-full bg-neutral-800 border-neutral-700 rounded-lg text-xs text-white p-2.5 focus:border-red-500 focus:ring-0">
                                    <option value="">-- Pilih Tingkat Keparahan --</option>
                                    @foreach($globalConsequences as $opt)
                                        <option value="{{ $opt['score_value'] }}">{{ $opt['text_pilihan'] }} [ {{ $opt['deskripsi_kriteria'] }} ]</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                <!-- SUB-KONDISI B: SOAL PILIHAN GANDA NORMAL -->
                @else
                    <div class="space-y-3" wire:key="options-list-{{ $q['id'] }}">
                        @foreach($q['options'] as $option)
                            <label wire:key="option-{{ $q['id'] }}-{{ $option['id'] }}" class="flex items-start p-4 bg-neutral-900 border border-neutral-750 rounded-xl cursor-pointer hover:bg-neutral-850 hover:border-red-500 transition-colors">
                                <input type="radio" 
                                       wire:model="selectedOptions.{{ $q['id'] }}" 
                                       value="{{ $option['id'] }}" 
                                       class="mt-1 text-red-600 focus:ring-0 bg-neutral-850 border-neutral-700">
                                <span class="ml-4 text-xs sm:text-sm text-neutral-200 font-medium leading-relaxed font-semibold">
                                    {{ $option['text_pilihan'] }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                @endif

                <!-- Catatan Esai Kualitatif -->
                <div class="mt-6" wire:key="manual-answer-{{ $q['id'] }}">
                    <label class="block text-xs font-bold text-neutral-400 uppercase tracking-wide mb-2">Bukti Kejadian Nyata / Penjelasan Penunjang (Anjab-ABK Evidence):</label>
                    <textarea wire:model="manualAnswers.{{ $q['id'] }}" 
                              class="w-full bg-neutral-900 border border-neutral-700 rounded-xl p-3 text-xs text-white focus:border-red-500 focus:ring-0" 
                              rows="3" 
                              placeholder="Sebutkan contoh insiden atau detail beban operasional terkait skenario di atas..."></textarea>
                </div>
            </div>

        <!-- KONDISI 2: LANGKAH RIWAYAT KESEHATAN -->
        @elseif($currentStep === count($questions))
            <div wire:key="health-history-step">
                <div class="border-b border-neutral-700 pb-4 mb-6">
                    <h3 class="text-xl font-black text-yellow-500 tracking-wider uppercase">KLASTER KESEHATAN & RIWAYAT CEDERA KERJA</h3>
                    <p class="text-xs text-neutral-400 mt-1">Data historis kerentanan fisik ini sangat krusial sebagai dasar pengadaan asuransi komersial & MCU berkala.</p>
                </div>

                <!-- Radio Button Kondisional -->
                <div class="mb-6 p-4 bg-neutral-900 border border-neutral-750 rounded-xl">
                    <label class="block text-xs sm:text-sm font-bold text-neutral-300 mb-3 leading-relaxed">
                        Apakah Anda pernah mengalami kecelakaan kerja, luka dinas, cedera operasional, atau penyakit kronis akibat aktivitas penugasan di Damkar Bekasi?
                    </label>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" wire:model.live="pernah_cedera" value="Ya" class="text-red-600 focus:ring-0 bg-neutral-800 border-neutral-700">
                            <span class="ml-2 text-xs sm:text-sm font-bold">Ya, Pernah (Satu atau Lebih Kejadian)</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" wire:model.live="pernah_cedera" value="Tidak" class="text-red-600 focus:ring-0 bg-neutral-800 border-neutral-700">
                            <span class="ml-2 text-xs sm:text-sm font-bold">Tidak Pernah</span>
                        </label>
                    </div>
                </div>

                <!-- Form Dynamic-entry Multi Kejadian -->
                @if($pernah_cedera === 'Ya')
                    <div class="space-y-4">
                        @foreach($riwayat_kesehatan as $index => $riwayat)
                            <div wire:key="riwayat-{{ $index }}" class="p-4 bg-neutral-900 border border-neutral-750 rounded-xl relative shadow-inner">
                                @if(count($riwayat_kesehatan) > 1)
                                    <button type="button" wire:click="removeRiwayatField({{ $index }})" 
                                            class="absolute top-3 right-3 text-[10px] bg-red-600 hover:bg-red-700 text-white font-extrabold px-2 py-1 rounded transition-colors uppercase">
                                        Hapus Insiden #{{ $index + 1 }}
                                    </button>
                                @endif

                                <h4 class="text-xs font-black text-red-500 uppercase tracking-widest mb-3">Kejadian Medis #{{ $index + 1 }}</h4>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div wire:key="riwayat-kategori-{{ $index }}">
                                        <label class="block text-[10px] font-bold text-neutral-400 uppercase mb-1">Kategori Dampak</label>
                                        <select wire:model="riwayat_kesehatan.{{ $index }}.kategori_dampak" class="w-full bg-neutral-850 border border-neutral-700 rounded text-xs text-black focus:border-red-500 focus:ring-0">
                                            <option value="">-- Pilih Dampak --</option>
                                            <option value="Kecelakaan Kerja">Kecelakaan Kerja Lapangan (Luka Bakar, Patah Tulang, dll)</option>
                                            <option value="Penyakit Kerja">Penyakit Kerja Akut (ISPA/Asma, Keracunan Gas, dll)</option>
                                            <option value="Cedera Ringan">Cedera Operasional Ringan (Terkilir, Luka Sobek, dll)</option>
                                        </select>
                                        @error("riwayat_kesehatan.{$index}.kategori_dampak")
                                            <span class="text-xs text-red-500 mt-1 block font-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div wire:key="riwayat-tahun-{{ $index }}">
                                        <label class="block text-[10px] font-bold text-neutral-400 uppercase mb-1">Tahun Kejadian</label>
                                        <input type="number" wire:model="riwayat_kesehatan.{{ $index }}.tahun_kejadian" placeholder="Contoh: 2025" class="w-full bg-neutral-850 border border-neutral-700 rounded text-xs text-black focus:border-red-500 focus:ring-0">
                                        @error("riwayat_kesehatan.{$index}.tahun_kejadian")
                                            <span class="text-xs text-red-500 mt-1 block font-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mt-3" wire:key="riwayat-kronologi-{{ $index }}">
                                    <label class="block text-[10px] font-bold text-neutral-400 uppercase mb-1">Kronologi Kejadian & Cedera yang Dialami</label>
                                    <textarea wire:model="riwayat_kesehatan.{{ $index }}.deskripsi_kronologi" rows="2" placeholder="Sebutkan lokasi kejadian dan dampak medisnya..." class="w-full bg-neutral-850 border border-neutral-700 rounded text-xs text-black focus:border-red-500 focus:ring-0"></textarea>
                                    @error("riwayat_kesehatan.{$index}.deskripsi_kronologi")
                                        <span class="text-xs text-red-500 mt-1 block font-bold">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mt-3" wire:key="riwayat-dampak-{{ $index }}">
                                    <label class="block text-[10px] font-bold text-neutral-400 uppercase mb-1">Dampak Kesehatan Jangka Jauh</label>
                                    <select wire:model="riwayat_kesehatan.{{ $index }}.dampak_tugas" class="w-full bg-neutral-850 border border-neutral-700 rounded text-xs text-black focus:border-red-500 focus:ring-0">
                                        <option value="">-- Pilih Dampak --</option>
                                        <option value="Sembuh Total">Sembuh total dan dapat bertugas penuh</option>
                                        <option value="Penurunan Fisik">Sembuh, namun stamina/fisik berkurang (Gampang lelah, sesak napas)</option>
                                        <option value="Trauma">Mengalami trauma psikologis/cemas berlebih di lokasi kebakaran</option>
                                    </select>
                                    @error("riwayat_kesehatan.{$index}.dampak_tugas")
                                        <span class="text-xs text-red-500 mt-1 block font-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

                        <div class="flex justify-end mt-2">
                            <button type="button" wire:click="addRiwayatField" class="px-3 py-1.5 bg-neutral-750 hover:bg-neutral-700 text-[10px] font-bold uppercase rounded border border-neutral-600 text-yellow-500">
                                + Tambah Riwayat Kejadian Medis Lain
                            </button>
                        </div>
                    </div>
                @endif
            </div>

        <!-- KONDISI 3: LANGKAH AKHIR - TEMUAN BAHAYA BARU LAPANGAN -->
        @else
            <div wire:key="custom-hazards-step">
                <div class="text-center mb-6 border-b border-neutral-700 pb-6">
                    <h3 class="text-2xl font-extrabold text-yellow-500 mb-2">IDENTIFIKASI BAHAYA KHAS LAPANGAN BARU</h3>
                    <p class="text-neutral-350 text-xs sm:text-sm max-w-2xl mx-auto">
                        Karakteristik lapangan Bekasi sangat kompleks. Silakan definisikan skenario bahaya baru yang pernah Anda hadapi dan lakukan evaluasi kuantitatif parameter **P, E, dan C**.
                    </p>
                </div>

                <div class="space-y-6">
                    @foreach($newHazards as $index => $hazard)
                        <div wire:key="hazard-{{ $index }}" class="p-5 bg-neutral-900 border border-neutral-750 rounded-xl relative shadow-inner">

                            <!-- Tombol Hapus Baris Custom Hazard -->
                            @if(count($newHazards) > 1)
                                <button type="button" wire:click="removeHazardField({{ $index }})" class="absolute top-2 right-2 text-red-500 hover:text-white font-bold text-base">
                                    &times;
                                </button>
                            @endif

                            <h4 class="text-xs font-black text-red-500 uppercase tracking-widest mb-3">Skenario Bahaya Khas Lapangan #{{ $index + 1 }}</h4>

                            <!-- Input Judul Bahaya Baru -->
                            <div class="mb-4" wire:key="hazard-deskripsi-{{ $index }}">
                                <label class="block text-[10px] font-bold text-neutral-400 uppercase mb-1">Deskripsi Skenario Bahaya</label>
                                <input type="text" wire:model="newHazards.{{ $index }}.deskripsi" placeholder="Misal: Tersengat instalasi kabel listrik bawah tanah saat proses water rescue evakuasi banjir..."
                                       class="w-full bg-neutral-850 border border-neutral-700 rounded-lg p-2.5 text-xs text-black focus:border-red-500 focus:ring-0">
                            </div>

                            <!-- Grid Dropdown P, E, C -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-neutral-800 pt-3">
                                <!-- Dropdown Exposure -->
                                <div wire:key="hazard-e-{{ $index }}">
                                    <label class="block text-[10px] font-bold text-neutral-400 uppercase mb-1.5">Exposure / Paparan (E)</label>
                                    <select wire:model="newHazards.{{ $index }}.score_e" class="w-full bg-neutral-850 border border-neutral-700 rounded text-xs text-black p-2 focus:border-red-500 focus:ring-0">
                                        <option value="">-- Pilih Tingkat --</option>
                                        @foreach($globalExposures as $opt)
                                            <option value="{{ $opt['score_value'] }}">{{ $opt['text_pilihan'] }} [ {{ $opt['deskripsi_kriteria'] }} ]</option>
                                        @endforeach
                                    </select>
                                    @error("newHazards.{$index}.score_e")
                                        <span class="text-[10px] text-red-500 font-bold block mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Dropdown Probability -->
                                <div wire:key="hazard-p-{{ $index }}">
                                    <label class="block text-[10px] font-bold text-neutral-400 uppercase mb-1.5">Probability / Peluang (P)</label>
                                    <select wire:model="newHazards.{{ $index }}.score_p" class="w-full bg-neutral-850 border border-neutral-700 rounded text-xs text-black p-2 focus:border-red-500 focus:ring-0">
                                        <option value="">-- Pilih Tingkat --</option>
                                        @foreach($globalProbabilities as $opt)
                                            <option value="{{ $opt['score_value'] }}">{{ $opt['text_pilihan'] }} [ {{ $opt['deskripsi_kriteria'] }} ]</option>
                                        @endforeach
                                    </select>
                                    @error("newHazards.{$index}.score_p")
                                        <span class="text-[10px] text-red-500 font-bold block mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Dropdown Consequence -->
                                <div wire:key="hazard-c-{{ $index }}">
                                    <label class="block text-[10px] font-bold text-neutral-400 uppercase mb-1.5">Consequence / Keparahan (C)</label>
                                    <select wire:model="newHazards.{{ $index }}.score_c" class="w-full bg-neutral-850 border border-neutral-700 rounded text-xs text-black p-2 focus:border-red-500 focus:ring-0">
                                        <option value="">-- Pilih Tingkat --</option>
                                        @foreach($globalConsequences as $opt)
                                            <option value="{{ $opt['score_value'] }}">{{ $opt['text_pilihan'] }} [ {{ $opt['deskripsi_kriteria'] }} ]</option>
                                        @endforeach
                                    </select>
                                    @error("newHazards.{$index}.score_c")
                                        <span class="text-[10px] text-red-500 font-bold block mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="flex justify-start">
                        <button type="button" wire:click="addHazardField" class="px-3 py-1.5 bg-neutral-750 hover:bg-neutral-700 text-[10px] font-bold uppercase rounded border border-neutral-600 text-yellow-500">
                            + Tambah Temuan Bahaya Baru
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- NAVIGASI KONTROL (KEMBALI / LANJUT / KIRIM) -->
        <div class="flex items-center justify-between mt-8 border-t border-neutral-700 pt-6">
            @if($currentStep > 0)
                <button type="button" wire:click="previousStep" 
                        class="px-5 py-2.5 bg-neutral-700 hover:bg-neutral-650 text-white font-extrabold text-xs uppercase tracking-wider rounded-lg transition-colors border border-neutral-600">
                    Kembali
                </button>
            @else
                <div></div>
            @endif

            @if($currentStep < $totalSteps - 1)
                <button type="button" wire:click="nextStep" 
                        class="px-5 py-2.5 bg-yellow-500 hover:bg-yellow-400 text-neutral-900 font-extrabold text-xs uppercase tracking-wider rounded-lg transition-colors shadow-md">
                    Selanjutnya
                </button>
            @else
                <button type="button" wire:click="saveKuesioner" 
                        class="px-6 py-2.5 bg-red-700 hover:bg-red-650 text-white font-extrabold text-xs uppercase tracking-wider rounded-lg border border-red-500 shadow-xl transition-all">
                    Kirim Seluruh Jawaban
                </button>
            @endif
        </div>

    </div>
</div>