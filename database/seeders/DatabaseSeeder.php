<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Option;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User Admin Default untuk Command Center Monitoring
        User::create([
            'name' => 'Admin Balitbangda Bekasi',
            'email' => 'admin.damkar@bekasikab.go.id',
            'password' => Hash::make('DamkarBekasi2026!'),
            'role' => 'admin',
        ]);

        // 2. Suntik Parameter Global Fine & Kinney (Opsi Global: question_id = null)
        $this->seedGlobalFineKinneyParameters();

        // 3. KLASTER I: OPERASI PEMADAM KEBAKARAN (Target: A = Pemadam, C = Danru, E = Gabungan)
        // Berdasarkan data "Tabel Identifikasi Hazard Operasi Pemadaman"
        $qPemadaman = [
            [
                'sub_klaster' => 'B3 & Kimia',
                'text_pertanyaan' => 'Skenario: Menghirup asap beracun (seperti karbon monoksida atau hidrogen sianida) saat memadamkan kebakaran gudang/pabrik limbah (seperti kasus di Rawajulang/Gandamekar Cikarang Barat) yang menyala berjam-jam.',
                'target' => ['A', 'C', 'E']
            ],
            [
                'sub_klaster' => 'Fisik & Termal',
                'text_pertanyaan' => 'Skenario: Menghadapi hawa panas ekstrem (radiasi panas) atau bara api tersembunyi di bawah tumpukan material yang tiba-tiba menyala kembali saat proses pendinginan gudang limbah atau pabrik kayu.',
                'target' => ['A', 'C', 'E']
            ],
            [
                'sub_klaster' => 'Akses & Medan',
                'text_pertanyaan' => 'Skenario: Masuk ke lokasi kebakaran di pemukiman padat atau gang sempit (seperti di Tambun) yang terhalang portal terkunci atau kabel listrik berantakan, sehingga ruang gerak regu sangat terbatas jika api membesar.',
                'target' => ['A', 'C', 'E']
            ],
            [
                'sub_klaster' => 'Mekanik & Tekanan',
                'text_pertanyaan' => 'Skenario: Menahan hentakan keras selang air bertekanan tinggi (Nozzle Reaction) yang bisa membuat terpelanting, atau harus menarik selang berat sejauh ratusan meter secara manual melewati sudut gang yang berliku.',
                'target' => ['A', 'C', 'E']
            ],
            [
                'sub_klaster' => 'Kelistrikan',
                'text_pertanyaan' => 'Skenario: Tersengat aliran listrik dari kabel PLN aktif yang putus akibat terbakar dan jatuh ke genangan air sisa pemadaman di area ruko atau pemukiman padat.',
                'target' => ['A', 'C', 'E']
            ],
            [
                'sub_klaster' => 'Utilitas Massa',
                'text_pertanyaan' => 'Skenario: Menghadapi ledakan berantai dari tabung gas LPG (ukuran melon 3 kg atau tabung industri) yang meledak dan terpental saat memadamkan kebakaran deretan warung, kios, atau pasar padat.',
                'target' => ['A', 'C', 'E']
            ],
            [
                'sub_klaster' => 'Lingkungan/Massa',
                'text_pertanyaan' => 'Skenario: Menghadapi kemarahan warga yang panik, diintimidasi karena dianggap terlambat tiba akibat jalanan macet (seperti di jalur Cikarang/Cibitung), hingga selang air direbut paksa oleh massa.',
                'target' => ['A', 'C', 'E']
            ]
        ];

        foreach ($qPemadaman as $qp) {
            Question::create([
                'klaster' => 'Operasi Pemadaman',
                'sub_klaster' => $qp['sub_klaster'],
                'text_pertanyaan' => $qp['text_pertanyaan'],
                'target_kelompok' => $qp['target'],
                'type' => 'matrix'
            ]);
        }

        // 4. KLASTER II: OPERASI PENYELAMATAN (RESCUE) (Target: B = Rescue, C = Danru, E = Gabungan)
        // Berdasarkan data "Tabel Identifikasi Hazard Operasi Penyelamatan"
        $qRescue = [
            [
                'sub_klaster' => 'Evakuasi Tawon',
                'text_pertanyaan' => 'Skenario: Diserang atau disengat gerombolan tawon Vespa saat memanjat dan merayap di atas plafon rumah warga (seperti di Babelan) yang sempit, gelap, dan rapuh.',
                'target' => ['B', 'C', 'E']
            ],
            [
                'sub_klaster' => 'Evakuasi Ular',
                'text_pertanyaan' => 'Skenario: Terkena semburan bisa ular Kobra dewasa (berisiko merusak mata/kebutaan) atau risiko digigit ular berbisa tinggi saat mengevakuasi ular di bawah meja warung atau dapur warga.',
                'target' => ['B', 'C', 'E']
            ],
            [
                'sub_klaster' => 'Evakuasi Hewan Terperosok',
                'text_pertanyaan' => 'Skenario: Diseruduk atau ditendang hewan besar (seperti sapi kurban seberat 500 kg) yang mengamuk dan memberontak saat dievakuasi dari parit pemukiman yang sempit dan licin.',
                'target' => ['B', 'C', 'E']
            ],
            [
                'sub_klaster' => 'Pelepasan Cincin / Jari',
                'text_pertanyaan' => 'Skenario: Terkena pecahan mata gerinda mini atau panas gesekan logam saat menggunakan gerinda mini untuk memotong cincin yang menjepit jari korban dengan jarak potong milimeter dari kulit.',
                'target' => ['B', 'C', 'E']
            ],
            [
                'sub_klaster' => 'Korban Terkunci',
                'text_pertanyaan' => 'Skenario: Terluka oleh pecahan kaca mobil, serpihan tajam, atau kelelahan fisik akibat ruang sempit saat membuka paksa pintu kendaraan/lift macet (misal kasus di SPBU Cikarang).',
                'target' => ['B', 'C', 'E']
            ],
            [
                'sub_klaster' => 'Penyelamatan Banjir / Air',
                'text_pertanyaan' => 'Skenario: Terbawa arus pusaran air atau terpapar air banjir yang tercampur limbah industri B3 beracun saat mengevakuasi warga di area dataran rendah Bekasi.',
                'target' => ['B', 'C', 'E']
            ],
            [
                'sub_klaster' => 'Pohon Tumbang',
                'text_pertanyaan' => 'Skenario: Tersengat listrik dari kabel PLN aktif yang terlilit pohon tumbang, atau terkena pantulan balik gergaji mesin (kickback) saat memotong batang pohon besar di pinggir jalan raya.',
                'target' => ['B', 'C', 'E']
            ]
        ];

        foreach ($qRescue as $qr) {
            Question::create([
                'klaster' => 'Operasi Penyelamatan (Rescue)',
                'sub_klaster' => $qr['sub_klaster'],
                'text_pertanyaan' => $qr['text_pertanyaan'],
                'target_kelompok' => $qr['target'],
                'type' => 'matrix'
            ]);
        }

        // 5. KLASTER III: BEBAN DAN TANGGUNG JAWAB KHUSUS KOMANDAN REGU (Target: C = Danru)
        // Berdasarkan data "Tabel Identifikasi Hazard Khusus Komandan Regu (Danru)"
        $qDanru = [
            [
                'sub_klaster' => 'Pengambilan Keputusan',
                'text_pertanyaan' => 'Skenario (Danru): Mengambil keputusan taktis dengan informasi awal yang tidak akurat (misal dilaporkan kebakaran sampah, ternyata gudang limbah plastik B3 di Cikarang), sehingga berisiko salah strategi formasi awal atau kekurangan armada.',
                'target' => ['C']
            ],
            [
                'sub_klaster' => 'Komunikasi & Kontrol',
                'text_pertanyaan' => 'Skenario (Danru): Kehilangan kontak radio/sinyal komunikasi (blind spot) akibat asap pekat atau sekat beton tebal (seperti di basemen ruko MM2100), sehingga tidak bisa memantau posisi regu yang terjebak di dalam.',
                'target' => ['C']
            ],
            [
                'sub_klaster' => 'Psikologis & Tekanan',
                'text_pertanyaan' => 'Skenario (Danru): Menghadapi tekanan mental masif dari warga yang histeris dan menghujat petugas di gang sempit Tambun, sementara pemilik aset menuntut Anda memprioritaskan area kantornya.',
                'target' => ['C']
            ],
            [
                'sub_klaster' => 'Hukum & Akuntabilitas',
                'text_pertanyaan' => 'Skenario (Danru): Menghadapi tuntutan hukum pidana atau sanksi disiplin berat apabila salah menilai kekuatan struktur ruko rapuh (akibat sekat ilegal) sehingga runtuh dan mencederai regu pemadam.',
                'target' => ['C']
            ],
            [
                'sub_klaster' => 'Manajemen Sumber Daya',
                'text_pertanyaan' => 'Skenario (Danru): Mengatur pembagian fokus regu untuk mengamankan jalur tangki suplai air (shuttle system) karena hidran sekitar Bekasi mati, sementara api terancam melompati batas lokalisasi.',
                'target' => ['C']
            ],
            [
                'sub_klaster' => 'Fisik & Taktis',
                'text_pertanyaan' => 'Skenario (Danru): Melakukan survei medan (reconnaissance) sendirian tanpa pengawalan di pintu belakang gudang kimia untuk mencari titik masuk terbaik, namun berisiko terjebak ledakan balik (backdraft) atau terperosok.',
                'target' => ['C']
            ]
        ];

        foreach ($qDanru as $qd) {
            Question::create([
                'klaster' => 'Tanggung Jawab Danru',
                'sub_klaster' => $qd['sub_klaster'],
                'text_pertanyaan' => $qd['text_pertanyaan'],
                'target_kelompok' => $qd['target'],
                'type' => 'matrix'
            ]);
        }

        // 6. KLASTER IV: PEGAWAI KANTOR DAMKAR (Target: D = Staf Kantor)
        // Berdasarkan data "Tabel Identifikasi Hazard Pegawai Kantor Damkar"
        $qKantor = [
            [
                'sub_klaster' => 'Psikologis & Komunikasi',
                'text_pertanyaan' => 'Skenario (Staf/Pusdalops): Menerima telepon darurat dari warga Tambun yang histeris karena api membesar di gang sempit atau laporan penemuan kobra, dan dituntut mengolah data dalam hitungan detik.',
                'target' => ['D']
            ],
            [
                'sub_klaster' => 'Fisik & Jam Kerja',
                'text_pertanyaan' => 'Skenario (Staf/Pusdalops): Menjaga ritme kerja shift malam 24 jam penuh yang mengacaukan jam tidur biologis tubuh demi tetap siaga memantau pergerakan armada sepanjang malam.',
                'target' => ['D']
            ],
            [
                'sub_klaster' => 'Ergonomi',
                'text_pertanyaan' => 'Skenario (Staf): Duduk mengetik laporan keuangan, administrasi kepegawaian, atau laporan kejadian evakuasi reptil/tawon berjam-jam secara statis di depan layar komputer ganda.',
                'target' => ['D']
            ],
            [
                'sub_klaster' => 'Biologis & Lingkungan',
                'text_pertanyaan' => 'Skenario (Staf Logistik): Mendata dan menata tumpukan dokumen fisik, arsip lama, atau memeriksa gudang penyimpanan APD bekas pakai di Mako yang berdebu pekat dan berjamur.',
                'target' => ['D']
            ],
            [
                'sub_klaster' => 'Kelistrikan',
                'text_pertanyaan' => 'Skenario (Staf/Pusdalops): Mengoperasikan perangkat komunikasi radio, komputer pemantau, dan AC non-stop di ruang Pusdalops yang rentan korsleting akibat tumpukan stopkontak dan jaringan kabel server yang rumit.',
                'target' => ['D']
            ],
            [
                'sub_klaster' => 'Mekanik',
                'text_pertanyaan' => 'Skenario (Staf): Beraktivitas di ruang administrasi sektor yang sempit (poor layout) karena dipadati tumpukan dokumen fisik perkara sehingga berisiko tersandung kabel atau tersayat kertas.',
                'target' => ['D']
            ]
        ];

        foreach ($qKantor as $qk) {
            Question::create([
                'klaster' => 'Pegawai Kantor Damkar',
                'sub_klaster' => $qk['sub_klaster'],
                'text_pertanyaan' => $qk['text_pertanyaan'],
                'target_kelompok' => $qk['target'],
                'type' => 'matrix'
            ]);
        }

        // 7. KLASTER V: PERTANYAAN KHUSUS VALIDASI ANGGARAN (Target: Semua Kelompok Responden)
        $qAnggaran1 = Question::create([
            'klaster' => 'Validasi Anggaran',
            'sub_klaster' => 'Asuransi Tambahan',
            'text_pertanyaan' => 'Apakah asuransi standar pemerintah daerah (BPJS Ketenagakerjaan/Kesehatan) yang Anda miliki saat ini dirasa sudah cukup untuk menjamin masa depan keluarga Anda jika terjadi kecelakaan fatal/gugur di medan tugas operasional?',
            'target_kelompok' => ['A', 'B', 'C', 'D', 'E'],
            'type' => 'normal'
        ]);
        $this->createNormalOptions($qAnggaran1->id, [
            ['Sangat tidak cukup. Santunan kematian standar tidak sepadan dengan risiko fatalitas ekstrem harian yang kami hadapi di lapangan.', 0.0],
            ['Kurang cukup. Proses birokrasi pencairan BPJS dinilai lambat dan nilai pertanggungannya terbatas.', 0.0],
            ['Cukup. Jaminan yang ada saat ini dirasa sudah memadai.', 0.0]
        ]);

        $qAnggaran2 = Question::create([
            'klaster' => 'Validasi Anggaran',
            'sub_klaster' => 'Asuransi Tambahan',
            'text_pertanyaan' => 'Seberapa mendesak pengadaan asuransi kecelakaan kerja swasta komersial tambahan (double cover) yang dibayarkan oleh APBD secara kolektif untuk seluruh personel operasional?',
            'target_kelompok' => ['A', 'B', 'C', 'D', 'E'],
            'type' => 'normal'
        ]);
        $this->createNormalOptions($qAnggaran2->id, [
            ['Sangat mendesak (Mutlak diperlukan segera guna memberi rasa aman saat bertempur di lapangan).', 0.0],
            ['Cukup mendesak (Dapat ditunda namun harus direncanakan dalam tahun anggaran berjalan).', 0.0],
            ['Tidak mendesak.', 0.0]
        ]);

        $qAnggaran3 = Question::create([
            'klaster' => 'Validasi Anggaran',
            'sub_klaster' => 'Medical Check-Up',
            'text_pertanyaan' => 'Seberapa sering Anda mengalami gangguan pernapasan, batuk kronis, sesak napas, atau pusing setelah melakukan operasi pemadaman kebakaran (khususnya pemadaman pabrik kimia/industri/gudang plastik)?',
            'target_kelompok' => ['A', 'B', 'C', 'D', 'E'],
            'type' => 'normal'
        ]);
        $this->createNormalOptions($qAnggaran3->id, [
            ['Setiap kali setelah penanganan kebakaran industri (mengalami sesak/batuk hitam berhari-hari).', 0.0],
            ['Sering (Beberapa kali dalam setahun).', 0.0],
            ['Jarang/Hampir tidak pernah.', 0.0]
        ]);

        $qAnggaran4 = Question::create([
            'klaster' => 'Validasi Anggaran',
            'sub_klaster' => 'Medical Check-Up',
            'text_pertanyaan' => 'Apakah instansi Anda saat ini memfasilitasi pemeriksaan kesehatan (Medical Check-Up) mendalam yang mendeteksi kadar racun gas kimia dalam paru-paru dan darah Anda secara rutin?',
            'target_kelompok' => ['A', 'B', 'C', 'D', 'E'],
            'type' => 'normal'
        ]);
        $this->createNormalOptions($qAnggaran4->id, [
            ['Tidak pernah ada sama sekali. Kami hanya diperiksa jika sudah sakit parah/tumbang.', 0.0],
            ['Pernah dilakukan, namun hanya pemeriksaan fisik standar/dasar (tensi darah dan berat badan).', 0.0],
            ['Rutin dilakukan minimal satu kali dalam setahun dengan pemeriksaan paru dan darah lengkap.', 0.0]
        ]);

        $qAnggaran5 = Question::create([
            'klaster' => 'Validasi Anggaran',
            'sub_klaster' => 'Extra Fooding',
            'text_pertanyaan' => 'Apakah Anda merasa asupan makanan standar harian Anda saat ini mampu memulihkan energi fisik dan mendetoksifikasi racun gas yang terhirup secara optimal pasca-pemadaman besar yang memakan waktu di atas 6 hingga 12 jam?',
            'target_kelompok' => ['A', 'B', 'C', 'D', 'E'],
            'type' => 'normal'
        ]);
        $this->createNormalOptions($qAnggaran5->id, [
            ['Sangat tidak mampu. Kami sering kali kelelahan ekstrem berhari-hari karena tidak ada asupan khusus pemulihan pasca-tugas.', 0.0],
            ['Kurang mampu. Kami harus membeli suplemen/susu sendiri dengan uang pribadi yang terbatas.', 0.0],
            ['Cukup mampu dengan asupan makanan harian biasa.', 0.0]
        ]);

        // 8. KLASTER VI: PERTANYAAN KHUSUS EVALUASI ANJAB-ABK (Target Spesifik Kelompok)
        // Pertanyaan ABK 1: Kecukupan Kuantitas Anggota Regu Lapangan
        $qAbk1 = Question::create([
            'klaster' => 'Evaluasi ANJAB-ABK',
            'sub_klaster' => 'Kecukupan Personel Regu (ABK)',
            'text_pertanyaan' => 'Apakah jumlah anggota (personel) dalam regu piket Anda saat ini sudah cukup dan aman saat bertempur memadamkan api atau mengevakuasi korban, atau seringkali terpaksa bekerja ekstra keras karena kekurangan orang?',
            'target_kelompok' => ['A', 'B', 'C', 'E'],
            'type' => 'normal'
        ]);
        $this->createNormalOptions($qAbk1->id, [
            ['Sangat Kurang (Seringkali harus memegang peran ganda, misal pemadam merangkap rescue, karena jumlah personel per shift sangat minim).', 0.0],
            ['Kurang Ideal (Cukup untuk kejadian skala kecil, tetapi kewalahan setengah mati jika ada kejadian besar bersamaan).', 0.0],
            ['Sudah Cukup & Aman (Jumlah personel per shift sudah sesuai dengan beban kerja tugas harian regu).', 0.0]
        ]);

        // Pertanyaan ABK 2: Perangkapan Beban Kerja Danru (ABK Danru)
        $qAbk2 = Question::create([
            'klaster' => 'Evaluasi ANJAB-ABK',
            'sub_klaster' => 'Beban Kerja Danru (ABK)',
            'text_pertanyaan' => 'Sebagai Komandan, apakah Anda seringkali merasa kewalahan mengatur pembagian anggota karena jumlah personel riil yang piket dan berangkat bertugas jauh di bawah standar ideal regu?',
            'target_kelompok' => ['C'],
            'type' => 'normal'
        ]);
        $this->createNormalOptions($qAbk2->id, [
            ['Sangat Sering (Saya sering terpaksa turun langsung menarik selang atau memegang nozzle karena kekurangan anggota regu di lapangan).', 0.0],
            ['Kadang-kadang (Tergantung tingkat kehadiran piket, namun beban tanggung jawab komando dan fisik seringkali tumpang tindih).', 0.0],
            ['Jarang / Tidak Pernah (Anggota regu saya selalu lengkap dan saya bisa fokus penuh pada koordinasi komando taktis keselamatan regu).', 0.0]
        ]);

        // Pertanyaan ANJAB 3: Kesesuaian Tugas dan Fungsi Staf Kantor (ANJAB)
        $qAnjab3 = Question::create([
            'klaster' => 'Evaluasi ANJAB-ABK',
            'sub_klaster' => 'Kesesuaian Jobdesk (ANJAB)',
            'text_pertanyaan' => 'Apakah Anda sering ditugaskan menyelesaikan pekerjaan administrasi, laporan keuangan/kepegawaian, atau urusan dinas lain yang sebenarnya di luar tugas pokok (jobdesk) jabatan asli Anda karena kekurangan staf di kantor?',
            'target_kelompok' => ['D'],
            'type' => 'normal'
        ]);
        $this->createNormalOptions($qAnjab3->id, [
            ['Sangat Sering (Seringkali mengerjakan tugas-tugas dadakan di luar deskripsi kerja utama saya sehingga pekerjaan pokok saya terbengkalai).', 0.0],
            ['Kadang-kadang (Pekerjaan tumpang tindih hanya terjadi saat ada dokumen laporan penting akhir tahun anggaran).', 0.0],
            ['Tidak Pernah (Tugas yang didelegasikan pimpinan kepada saya selalu sesuai dengan formasi jabatan dan uraian tugas kompetensi saya).', 0.0]
        ]);

        // Pertanyaan ABK 4: Waktu Pemulihan Stamina / Jam Kerja (ABK Umum)
        $qAbk4 = Question::create([
            'klaster' => 'Evaluasi ANJAB-ABK',
            'sub_klaster' => 'Waktu Pemulihan Stamina (ABK)',
            'text_pertanyaan' => 'Apakah pembagian shift kerja piket dan siaga 24 jam saat ini dirasa sudah memberikan waktu istirahat yang cukup untuk memulihkan stamina fisik Anda sebelum masuk shift piket berikutnya?',
            'target_kelompok' => ['A', 'B', 'C', 'D', 'E'],
            'type' => 'normal'
        ]);
        $this->createNormalOptions($qAbk4->id, [
            ['Sangat Tidak Cukup (Seringkali masuk piket berikutnya dalam kondisi masih lelah ekstrem atau kurang tidur akibat kejadian kebakaran panjang beruntun).', 0.0],
            ['Cukup (Waktu istirahat di rumah dinilai pas-pasan untuk memulihkan kebugaran otot dan pernapasan sebelum kembali siaga).', 0.0],
            ['Sangat Cukup (Sistem rotasi shift berjalan sangat ideal sehingga stamina fisik saya selalu berada di kondisi prima saat kembali piket).', 0.0]
        ]);
    }

    private function seedGlobalFineKinneyParameters(): void
    {
        // Parameter Exposure (E) - Skala Asli dari Gambar Lampiran Anda (image_ad9e63.png)
        $exposures = [
            ['Terus-menerus', 'E', 10.0, 'Terjadi berkali-kali setiap hari saat bekerja atau bertugas.'],
            ['Sering', 'E', 6.0, 'Terjadi minimal sekali sehari (hampir setiap giliran piket).'],
            ['Kadang-kadang', 'E', 3.0, 'Terjadi antara sekali seminggu sampai sekali sebulan.'],
            ['Jarang', 'E', 2.0, 'Terjadi beberapa bulan sekali sampai setahun sekali.'],
            ['Sangat Jarang', 'E', 1.0, 'Hanya terjadi beberapa kali saja dalam satu tahun.'],
            ['Sangat Mustahil', 'E', 0.5, 'Hampir tidak pernah, hanya sekali setahun atau bahkan kurang.']
        ];

        // Parameter Probability (P) - Skala Asli dari Gambar Lampiran Anda (image_ad9e63.png)
        $probabilities = [
            ['Sangat Mungkin', 'P', 10.0, 'Pasti akan terjadi jika ada situasi bahaya yang muncul.'],
            ['Mungkin Terjadi', 'P', 6.0, 'Memiliki peluang seimbang (50:50) untuk terjadi.'],
            ['Pernah Terjadi di Tempat Lain', 'P', 3.0, 'Belum pernah terjadi di sini, tapi pernah terjadi di instansi/wilayah lain.'],
            ['Kecil Kemungkinannya', 'P', 1.0, 'Belum pernah terjadi sama sekali, tapi secara logika masih bisa terjadi.'],
            ['Sangat Sulit Terjadi', 'P', 0.5, 'Sangat jarang terjadi dan hampir tidak masuk akal dalam kondisi normal.'],
            ['Mustahil Terjadi', 'P', 0.1, 'Peluangnya satu banding sejuta (tidak realistis untuk terjadi).']
        ];

        // Parameter Consequence (C) - Skala Asli dari Gambar Lampiran Anda (image_ad9e63.png)
        $consequences = [
            ['Malapetaka Besar', 'C', 100.0, 'Mengakibatkan banyak korban jiwa gugur atau kerusakan total seluruh armada.'],
            ['Sangat Serius', 'C', 40.0, 'Mengakibatkan beberapa korban jiwa sekaligus atau regu kerja lumpuh total.'],
            ['Sangat Buruk', 'C', 15.0, 'Mengakibatkan satu korban jiwa (gugur) atau cacat fisik seumur hidup.'],
            ['Parah / Rawat Inap', 'C', 7.0, 'Luka berat atau luka bakar serius yang wajib opname (rawat inap) lama di RS.'],
            ['Sedang / IGD', 'C', 3.0, 'Luka sedang, butuh penanganan darurat di IGD rumah sakit tanpa perlu rawat inap.'],
            ['Ringan / P3K', 'C', 1.0, 'Luka ringan (lecet/memar) yang bisa sembuh sendiri atau cukup diobati dengan P3K.']
        ];

        foreach (array_merge($exposures, $probabilities, $consequences) as $p) {
            Option::create([
                'question_id' => null, // null menandakan opsi parameter global
                'text_pilihan' => $p[0],
                'parameter_type' => $p[1],
                'score_value' => $p[2],
                'deskripsi_kriteria' => $p[3]
            ]);
        }
    }

    private function createNormalOptions(int $questionId, array $options): void
    {
        foreach ($options as $opt) {
            Option::create([
                'question_id' => $questionId,
                'text_pilihan' => $opt[0],
                'parameter_type' => 'N/A',
                'score_value' => $opt[1],
            ]);
        }
    }
}