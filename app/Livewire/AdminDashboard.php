<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Question;
use App\Models\Option;
use App\Models\Answer;
use Illuminate\Support\Facades\Gate;

class AdminDashboard extends Component
{
    // State Navigasi Dashboard
    public $viewMode = 'progress'; // Opsi: 'progress' atau 'questions'

    // Form Binding untuk CRUD Pertanyaan (Tanpa loose properties)
    public $isEditMode = false;
    public $editingQuestionId = null;

    public $form = [
        'klaster' => '',
        'sub_klaster' => '',
        'text_pertanyaan' => '',
        'target_kelompok' => []
    ];

    // Array Opsi Jawaban Dinamis dalam Form Soal
    public $formOptions = [];

    // Daftar 10 Pos Sektor resmi untuk tracking
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

    public function rules()
    {
        return [
            'form.klaster' => 'required|string|max:100',
            'form.sub_klaster' => 'nullable|string|max:100',
            'form.text_pertanyaan' => 'required|string',
            'form.target_kelompok' => 'required|array|min:1',
            'formOptions' => 'required|array|min:1',
            'formOptions.*.text_pilihan' => 'required|string',
            'formOptions.*.parameter_type' => 'required|in:C,E,P,N/A',
            'formOptions.*.score_value' => 'required|numeric|min:0',
        ];
    }

    protected $validationAttributes = [
        'form.klaster' => 'Klaster',
        'form.text_pertanyaan' => 'Kalimat Pertanyaan',
        'form.target_kelompok' => 'Target Responden',
        'formOptions.*.text_pilihan' => 'Teks Pilihan',
        'formOptions.*.parameter_type' => 'Parameter',
        'formOptions.*.score_value' => 'Bobot Skor',
    ];

    public function mount()
    {
        if (!Gate::allows('admin-access')) {
            abort(403, 'Akses Command Center Ditolak.');
        }
        $this->resetOptionForm();
    }

    public function resetOptionForm()
    {
        $this->formOptions = [
            ['text_pilihan' => '', 'parameter_type' => 'N/A', 'score_value' => 0.0]
        ];
    }

    public function addOptionField()
    {
        $this->formOptions[] = ['text_pilihan' => '', 'parameter_type' => 'N/A', 'score_value' => 0.0];
    }

    public function removeOptionField($index)
    {
        unset($this->formOptions[$index]);
        $this->formOptions = array_values($this->formOptions);
    }

    public function storeQuestion()
    {
        $this->validate();

        $question = Question::create([
            'klaster' => $this->form['klaster'],
            'sub_klaster' => $this->form['sub_klaster'],
            'text_pertanyaan' => $this->form['text_pertanyaan'],
            'target_kelompok' => $this->form['target_kelompok'],
        ]);

        foreach ($this->formOptions as $opt) {
            Option::create([
                'question_id' => $question->id,
                'text_pilihan' => $opt['text_pilihan'],
                'parameter_type' => $opt['parameter_type'],
                'score_value' => $opt['score_value'],
            ]);
        }

        $this->resetForm();
        session()->flash('message', 'Pertanyaan baru berhasil ditambahkan.');
    }

    public function editQuestion($id)
    {
        $this->isEditMode = true;
        $this->editingQuestionId = $id;

        $question = Question::with('options')->findOrFail($id);

        $this->form = [
            'klaster' => $question->klaster,
            'sub_klaster' => $question->sub_klaster,
            'text_pertanyaan' => $question->text_pertanyaan,
            'target_kelompok' => $question->target_kelompok,
        ];

        $this->formOptions = [];
        foreach ($question->options as $opt) {
            $this->formOptions[] = [
                'text_pilihan' => $opt->text_pilihan,
                'parameter_type' => $opt->parameter_type,
                'score_value' => $opt->score_value,
            ];
        }
    }

    public function updateQuestion()
    {
        $this->validate();

        $question = Question::findOrFail($this->editingQuestionId);

        $question->update([
            'klaster' => $this->form['klaster'],
            'sub_klaster' => $this->form['sub_klaster'],
            'text_pertanyaan' => $this->form['text_pertanyaan'],
            'target_kelompok' => $this->form['target_kelompok'],
        ]);

        // Hapus opsi lama, ganti dengan yang baru (Mencegah konflik ID)
        Option::where('question_id', $question->id)->delete();
        foreach ($this->formOptions as $opt) {
            Option::create([
                'question_id' => $question->id,
                'text_pilihan' => $opt['text_pilihan'],
                'parameter_type' => $opt['parameter_type'],
                'score_value' => $opt['score_value'],
            ]);
        }

        $this->resetForm();
        session()->flash('message', 'Pertanyaan berhasil diperbarui.');
    }

    public function deleteQuestion($id)
    {
        Question::destroy($id);
        session()->flash('message', 'Pertanyaan berhasil dihapus.');
    }

    public function resetForm()
    {
        $this->isEditMode = false;
        $this->editingQuestionId = null;
        $this->form = [
            'klaster' => '',
            'sub_klaster' => '',
            'text_pertanyaan' => '',
            'target_kelompok' => []
        ];
        $this->resetOptionForm();
    }

    private function getProgressMetrics()
    {
        return [
            // Menjumlahkan kelompok A, B, dan E sebagai "Pasukan Lapangan" (Target: 65)
            'lapangan_completed' => User::whereIn('kelompok_responden', ['A', 'B', 'E'])
                ->where('is_completed', true)
                ->count(),

            // Target Danru (C) = 10
            'danru_completed' => User::where('kelompok_responden', 'C')
                ->where('is_completed', true)
                ->count(),

            // Target Staf Adm (D) = 5
            'adm_completed' => User::where('kelompok_responden', 'D')
                ->where('is_completed', true)
                ->count(),
        ];
    }

    // Melacak jumlah pengisi kuesioner berdasarkan masing-masing Pos Sektor
    private function getPosSektorMetrics()
    {
        $dataSektor = [];
        foreach ($this->posSektorList as $pos) {
            $dataSektor[$pos] = [
                'total' => User::where('unit_kerja', $pos)->count(),
                'completed' => User::where('unit_kerja', $pos)->where('is_completed', true)->count()
            ];
        }
        return $dataSektor;
    }

    public function render()
    {
        $metrics = $this->getProgressMetrics();
        $sektorMetrics = $this->getPosSektorMetrics();

        // ANALISA FINE KINNEY: Agregasi skor rata-rata per pertanyaan matriks
        $riskAnalysis = Question::whereIn('type', ['matrix', 'custom'])
            ->with(['answers'])
            ->get()
            ->map(function ($question) {
                $avgE = $question->answers->avg('score_e') ?? 0;
                $avgP = $question->answers->avg('score_p') ?? 0;
                $avgC = $question->answers->avg('score_c') ?? 0;
                $rs = $avgE * $avgP * $avgC;

                // Tentukan Level Risiko
                $level = 'Low';
                $color = 'text-green-500';
                if ($rs > 350) {
                    $level = 'EXTREME';
                    $color = 'text-red-500';
                } elseif ($rs > 180) {
                    $level = 'HIGH';
                    $color = 'text-orange-500';
                } elseif ($rs > 70) {
                    $level = 'SUBSTANTIAL';
                    $color = 'text-yellow-500';
                } elseif ($rs > 20) {
                    $level = 'POSSIBLE';
                    $color = 'text-blue-500';
                }

                return [
                    'id' => $question->id,
                    'text' => $question->text_pertanyaan,
                    'klaster' => $question->klaster,
                    'avg_e' => round($avgE, 2),
                    'avg_p' => round($avgP, 2),
                    'avg_c' => round($avgC, 2),
                    'rs' => round($rs, 2),
                    'level' => $level,
                    'color' => $color,
                    'type' => $question->type
                ];
            });

        return view('livewire.admin-dashboard', [
            'lapanganCompleted' => $metrics['lapangan_completed'],
            'danruCompleted' => $metrics['danru_completed'],
            'admCompleted' => $metrics['adm_completed'],
            'sektorMetrics' => $sektorMetrics,
            'riskAnalysis' => $riskAnalysis, // Data untuk tabel analisa risiko
            'questionsList' => Question::with('options')->where('type', '!=', 'custom')->latest()->get()
        ])->layout('layouts.app');
    }
}