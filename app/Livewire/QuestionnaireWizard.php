<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Option;
use App\Models\ResponderHealthHistory;
use Illuminate\Support\Facades\Auth;

class QuestionnaireWizard extends Component
{
    public $user;
    public $kelompok;

    public $questions = [];
    public $currentStep = 0;

    // Penampung Jawaban Pilihan Ganda Normal
    public $selectedOptions = [];
    public $manualAnswers = [];

    // Penampung Jawaban Matriks Kuantitatif Fine & Kinney (P, E, C)
    public $matrixAnswers = [];

    // Master Option Data
    public $globalExposures = [];
    public $globalProbabilities = [];
    public $globalConsequences = [];

    // Penampung Bahaya Baru Lapangan
    public $newHazards = [];

    // Penampung Modul Riwayat Kesehatan
    public $pernah_cedera = 'Tidak';
    public $riwayat_kesehatan = [];

    public function mount()
    {
        $this->user = Auth::user();
        $this->kelompok = $this->user->kelompok_responden;

        // Ambil semua parameter global Fine & Kinney untuk dropdown survey
        $this->globalExposures = Option::whereNull('question_id')->where('parameter_type', 'E')->get()->toArray();
        $this->globalProbabilities = Option::whereNull('question_id')->where('parameter_type', 'P')->get()->toArray();
        $this->globalConsequences = Option::whereNull('question_id')->where('parameter_type', 'C')->get()->toArray();

        // Ambil list pertanyaan valid
        $this->questions = Question::whereIn('type', ['matrix', 'normal'])
            ->with('options')
            ->get()
            ->filter(function ($question) {
                return in_array($this->kelompok, $question->target_kelompok);
            })->values()->toArray();

        $this->addHazardField();
        $this->addRiwayatField();
    }

    // Menambahkan baris Custom Hazard baru
    public function addHazardField()
    {
        $this->newHazards[] = [
            'deskripsi' => '',
            'score_e' => '',
            'score_p' => '',
            'score_c' => ''
        ];
    }

    public function removeHazardField($index)
    {
        unset($this->newHazards[$index]);
        $this->newHazards = array_values($this->newHazards);
    }

    // Dynamic Fields Riwayat Kesehatan
    public function addRiwayatField()
    {
        $this->riwayat_kesehatan[] = [
            'kategori_dampak' => '',
            'deskripsi_kronologi' => '',
            'tahun_kejadian' => '',
            'dampak_tugas' => ''
        ];
    }

    public function removeRiwayatField($index)
    {
        unset($this->riwayat_kesehatan[$index]);
        $this->riwayat_kesehatan = array_values($this->riwayat_kesehatan);
    }

    public function nextStep()
    {
        $this->validateStep();
        $this->currentStep++;
    }

    public function previousStep()
    {
        if ($this->currentStep > 0) {
            $this->currentStep--;
        }
    }

    public function validateStep()
    {
        // Validasi Step Riwayat Kesehatan
        if ($this->currentStep === count($this->questions) && $this->pernah_cedera === 'Ya') {
            // Filter hanya riwayat yang tidak kosong
            $filledRiwayat = array_filter($this->riwayat_kesehatan, function ($item) {
                return !empty($item['kategori_dampak']);
            });

            // Jika ada riwayat yang diisi, validasi
            if (!empty($filledRiwayat)) {
                $this->validate([
                    'riwayat_kesehatan.*.kategori_dampak' => 'required_if:riwayat_kesehatan.*.deskripsi_kronologi,*|string',
                    'riwayat_kesehatan.*.deskripsi_kronologi' => 'required_if:riwayat_kesehatan.*.kategori_dampak,*|string|min:4',
                    'riwayat_kesehatan.*.tahun_kejadian' => 'required_if:riwayat_kesehatan.*.kategori_dampak,*|numeric|digits:4|max:' . date('Y'),
                    'riwayat_kesehatan.*.dampak_tugas' => 'required_if:riwayat_kesehatan.*.kategori_dampak,*|string',
                ], [
                    'riwayat_kesehatan.*.kategori_dampak.required_if' => 'Pilih Kategori Dampak.',
                    'riwayat_kesehatan.*.deskripsi_kronologi.required_if' => 'Kronologi kejadian harus diisi.',
                    'riwayat_kesehatan.*.deskripsi_kronologi.min' => 'Isi kronologi dengan detail minimal 4 karakter.',
                    'riwayat_kesehatan.*.tahun_kejadian.required_if' => 'Masukkan tahun.',
                    'riwayat_kesehatan.*.tahun_kejadian.digits' => 'Masukkan format 4 angka (contoh: 2025).',
                    'riwayat_kesehatan.*.dampak_tugas.required_if' => 'Pilih Dampak Tugas.',
                ]);
            }
        }

        // Validasi Step Custom Hazards
        if ($this->currentStep === count($this->questions) + 1) {
            foreach ($this->newHazards as $index => $hz) {
                if (!empty($hz['deskripsi'])) {
                    $this->validate([
                        "newHazards.{$index}.score_e" => 'required|numeric',
                        "newHazards.{$index}.score_p" => 'required|numeric',
                        "newHazards.{$index}.score_c" => 'required|numeric',
                    ], [
                        "newHazards.{$index}.score_e.required" => 'Evaluasi parameter Exposure (E) wajib diisi.',
                        "newHazards.{$index}.score_p.required" => 'Evaluasi parameter Probability (P) wajib diisi.',
                        "newHazards.{$index}.score_c.required" => 'Evaluasi parameter Consequence (C) wajib diisi.',
                    ]);
                }
            }
        }
    }

    public function saveKuesioner()
    {
        // 1. Simpan Jawaban Pertanyaan Standar (Matrix & Normal)
        foreach ($this->questions as $q) {
            $qId = $q['id'];

            if ($q['type'] === 'matrix') {
                Answer::updateOrCreate(
                    ['user_id' => $this->user->id, 'question_id' => $qId],
                    [
                        'score_e' => $this->matrixAnswers[$qId]['E'] ?? 0,
                        'score_p' => $this->matrixAnswers[$qId]['P'] ?? 0,
                        'score_c' => $this->matrixAnswers[$qId]['C'] ?? 0,
                        'text_jawaban_manual' => $this->manualAnswers[$qId] ?? null
                    ]
                );
            } else {
                Answer::updateOrCreate(
                    ['user_id' => $this->user->id, 'question_id' => $qId],
                    [
                        'option_id' => $this->selectedOptions[$qId] ?? null,
                        'text_jawaban_manual' => $this->manualAnswers[$qId] ?? null
                    ]
                );
            }
        }

        // 2. Simpan Custom Hazard (Skenario Bahaya Baru)
        foreach ($this->newHazards as $hz) {
            if (!empty($hz['deskripsi'])) {
                $newQuestion = Question::create([
                    'klaster' => 'Bahaya Lapangan Baru (Custom)',
                    'sub_klaster' => 'Identifikasi Responden',
                    'text_pertanyaan' => $hz['deskripsi'],
                    'target_kelompok' => [$this->kelompok],
                    'type' => 'custom',
                    'created_by_user_id' => $this->user->id
                ]);

                Answer::create([
                    'user_id' => $this->user->id,
                    'question_id' => $newQuestion->id,
                    'score_e' => $hz['score_e'] ?? 0,
                    'score_p' => $hz['score_p'] ?? 0,
                    'score_c' => $hz['score_c'] ?? 0
                ]);
            }
        }

        // 3. Simpan Riwayat Medis / Cedera Kerja (Kondisional)
        if ($this->pernah_cedera === 'Ya') {
            foreach ($this->riwayat_kesehatan as $riwayat) {
                if (!empty($riwayat['kategori_dampak'])) {
                    ResponderHealthHistory::create([
                        'user_id' => $this->user->id,
                        'kategori_dampak' => $riwayat['kategori_dampak'],
                        'deskripsi_kronologi' => $riwayat['deskripsi_kronologi'],
                        'tahun_kejadian' => $riwayat['tahun_kejadian'],
                        'dampak_tugas' => $riwayat['dampak_tugas']
                    ]);
                }
            }
        }

        // 4. Update Status Responden
        $this->user->update(['is_completed' => true]);

        session()->flash('message', 'Seluruh jawaban kuesioner, riwayat kesehatan, dan identifikasi bahaya baru berhasil disimpan.');
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.questionnaire-wizard');
    }
}