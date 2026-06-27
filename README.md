# 🚒 Kuesioner Damkar Bekasi

**Aplikasi Kuesioner Evaluasi Risiko & Hazard Assessment untuk Personel Damkar (Dinas Pemadam Kebakaran) Bekasi**

Sistem berbasis web untuk mengidentifikasi, mengevaluasi, dan mendokumentasikan risiko operasional, beban kerja, riwayat kesehatan, dan bahaya khas lapangan bagi personel penangulangan bencana.

---

## 📋 Daftar Isi

- [Tentang Aplikasi](#tentang-aplikasi)
- [Fitur Utama](#fitur-utama)
- [Stack Teknologi](#stack-teknologi)
- [Requirement Sistem](#requirement-sistem)
- [Instalasi](#instalasi)
- [Konfigurasi](#konfigurasi)
- [Penggunaan](#penggunaan)
- [Struktur Aplikasi](#struktur-aplikasi)
- [Model & Database](#model--database)
- [Troubleshooting](#troubleshooting)

---

## 📌 Tentang Aplikasi

**Kuesioner Damkar** adalah aplikasi web yang dirancang khusus untuk **Dinas Pemadam Kebakaran Bekasi** guna:

1. **Mengumpulkan Data Risiko Operasional** - Evaluasi beban kerja dan hazard assessment menggunakan metode **Fine & Kinney Risk Matrix**
2. **Mendokumentasikan Riwayat Kesehatan** - Melacak riwayat cedera kerja, penyakit akibat kerja, dan dampak kesehatan jangka panjang
3. **Identifikasi Bahaya Baru** - Memungkinkan personel menginput skenario bahaya lapangan baru yang mereka hadapi
4. **Analisis Dashboard** - Admin dapat melihat dashboard komprehensif dengan insights risiko per klaster operasi

Aplikasi ini mendukung responden dengan berbagai **kelompok kategori** (A, B, C, D, E) dengan pertanyaan yang disesuaikan berdasarkan jenis pekerjaan dan tanggung jawab.

---

## ✨ Fitur Utama

### 1. **Wizard Kuesioner Multi-Step**

- Tampilan step-by-step yang user-friendly dengan progress indicator
- Soal terbagi dalam 3 tahap utama:
    - **Tahap 1**: Pertanyaan Standar (Matrix Fine & Kinney + Pilihan Ganda Normal)
    - **Tahap 2**: Riwayat Kesehatan & Cedera Kerja
    - **Tahap 3**: Identifikasi Bahaya Baru Lapangan

### 2. **Matriks Penilaian Fine & Kinney**

- Evaluasi kuantitatif menggunakan 3 parameter:
    - **E (Exposure)** - Tingkat Paparan/Frekuensi
    - **P (Probability)** - Peluang Terjadinya
    - **C (Consequence)** - Tingkat Keparahan/Akibat
- Risk Score = E × P × C untuk kategorisasi risiko

### 3. **Dynamic Form Entry**

- Pengguna dapat menambah/menghapus multiple entries untuk:
    - Riwayat kesehatan & cedera kerja
    - Temuan bahaya baru lapangan

### 4. **Admin Dashboard Command Center**

- Visualisasi statistik real-time:
    - Total responden yang telah selesai
    - Risk level distribution per klaster
    - Health history trends
    - Custom hazard submissions
- Export dan reporting capabilities

### 5. **Role-Based Access Control**

- **Admin** - Akses dashboard analitik dan manajemen data
- **Responden** - Akses form kuesioner dan lihat submission history

---

## 🛠️ Stack Teknologi

| Komponen               | Teknologi      | Versi  |
| ---------------------- | -------------- | ------ |
| **Backend**            | Laravel        | ^13.8  |
| **Frontend Framework** | Livewire Volt  | ^1.7.0 |
| **Styling**            | Tailwind CSS   | Latest |
| **Build Tool**         | Vite           | Latest |
| **Database**           | MySQL/SQLite   | -      |
| **PHP**                | PHP            | ^8.3   |
| **Authentication**     | Laravel Breeze | ^2.4   |

### Package Dependencies:

```json
{
    "livewire/livewire": "^3.6.4",
    "livewire/volt": "^1.7.0",
    "laravel/tinker": "^3.0"
}
```

---

## 🖥️ Requirement Sistem

### Minimum Requirements:

- **PHP**: 8.3 atau lebih tinggi
- **Composer**: ^2.0
- **Node.js**: 18+ (untuk npm)
- **Database**: MySQL 8.0+ atau SQLite
- **Memory**: 2GB RAM minimum
- **Disk Space**: 500MB untuk instalasi lengkap

### Recommended:

- **PHP**: 8.3+
- **MySQL**: 8.0+
- **Node.js**: 20 LTS
- **RAM**: 4GB+

---

## 📦 Instalasi

### 1. Clone Repository

```bash
git clone <repository-url>
cd kuesioner-damkar
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Configuration

Edit `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kuesioner_damkar
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Database Migration

```bash
php artisan migrate
```

### 6. Build Assets

```bash
npm run build
```

### 7. Serve Application

```bash
php artisan serve
```

Akses aplikasi di: **http://localhost:8000**

---

## ⚙️ Konfigurasi

### Authentication

Aplikasi menggunakan **Laravel Breeze** untuk auth. Routes:

- `/login` - Login page
- `/register` - Registrasi responden baru
- `/dashboard` - Dashboard responden
- `/admin/command-center` - Admin dashboard (memerlukan role admin)

### Database Seeds (Optional)

Jalankan seeders untuk dummy data:

```bash
php artisan db:seed
```

### Configuration Files:

- `config/app.php` - Konfigurasi aplikasi utama
- `config/database.php` - Database configuration
- `.env` - Environment variables

---

## 🎯 Penggunaan

### Untuk Responden:

1. **Register/Login**
    - Buat akun atau login dengan credentials
    - Pilih kelompok kategori (A-E) saat registrasi
    - Pilih unit kerja dari dropdown

2. **Isi Kuesioner**
    - Klik "Mulai Kuesioner" di dashboard
    - Ikuti wizard step-by-step:
        - **Step 1-N**: Jawab pertanyaan dengan matrix evaluation atau pilihan ganda
        - **Step N+1**: Isi riwayat kesehatan (jika ada)
        - **Step N+2**: Input bahaya lapangan baru (opsional)
    - Setiap field support bukti/evidence tekstual

3. **Submit**
    - Klik "Kirim Seluruh Jawaban" di akhir wizard
    - Status berubah menjadi "Completed"

### Untuk Admin:

1. **Login dengan akun admin**
    - Akses `/admin/command-center`

2. **Monitor Responden**
    - Lihat statistik completion rate
    - Filter by kelompok kategori
    - Lihat risk distribution per klaster

3. **Analisis Data**
    - Review hazard submissions
    - Monitor health history trends
    - Export reports

---

## 🗂️ Struktur Aplikasi

### Directory Layout:

```
kuesioner-damkar/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   ├── Livewire/
│   │   ├── AdminDashboard.php         # Admin dashboard component
│   │   └── QuestionnaireWizard.php    # Main questionnaire form
│   ├── Models/
│   │   ├── Question.php               # Question model + relationships
│   │   ├── Option.php                 # Answer options
│   │   ├── Answer.php                 # Responden answers
│   │   ├── ResponderHealthHistory.php # Health/injury records
│   │   ├── CustomHazard.php          # Custom field hazards
│   │   └── User.php                  # User with roles
│   └── View/Components/
├── database/
│   ├── migrations/
│   │   ├── 2026_04_22_000001_create_kuesioner_tables.php
│   │   └── (auth migrations)
│   ├── factories/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── livewire/
│   │   │   ├── questionnaire-wizard.blade.php
│   │   │   └── admin-dashboard.blade.php
│   │   ├── layouts/
│   │   └── auth/
│   ├── css/
│   │   └── app.css
│   └── js/
│       └── app.js
├── routes/
│   ├── web.php                       # Web routes
│   ├── auth.php                      # Auth routes (Breeze)
│   └── console.php
├── config/
│   ├── app.php
│   ├── database.php
│   └── (other configs)
├── .env.example
├── composer.json
├── package.json
└── README.md
```

---

## 📊 Model & Database

### ER Diagram:

```
users (1) ──── (N) answers
  │              │
  └─ (1)        └─ belongsTo
     │
     ├── (N) responder_health_histories
     └── (N) custom_hazards (deprecated - merged into questions)

questions (1) ──── (N) options
    │                   │
    └─ (N) answers ─────┘

options (1) ──── (N) answers
```

### Main Tables:

#### **users**

```sql
id, name, email, password, role (admin/responden),
kelompok_responden (A-E), unit_kerja, is_completed,
status_kepegawaian, timestamps
```

#### **questions**

```sql
id, klaster, sub_klaster, text_pertanyaan,
target_kelompok (JSON array), type (matrix/normal/custom),
created_by_user_id, timestamps
```

#### **options**

```sql
id, question_id, text_pilihan, parameter_type (E/P/C/N/A),
score_value, deskripsi_kriteria, timestamps
```

#### **answers**

```sql
id, user_id, question_id, option_id,
score_e, score_p, score_c (untuk matrix),
text_jawaban_manual, timestamps
```

#### **responder_health_histories**

```sql
id, user_id, kategori_dampak, deskripsi_kronologi,
tahun_kejadian, dampak_tugas, timestamps
```

---

## 🔧 Troubleshooting

### Error: "Undefined array key 'options'"

**Solusi**: Pastikan Query Question menggunakan `.with('options')` untuk eager load relationships.

### Form Input Menampilkan Data Lama

**Solusi**: Template menggunakan `wire:key` untuk memastikan form direset saat step berubah.

### Database Connection Error

**Solusi**:

1. Verifikasi `.env` DB\_\* variables
2. Pastikan MySQL/SQLite running
3. Run `php artisan migrate`

### Admin Dashboard Showing 0 Responden

**Solusi**: Query menggunakan `where('role', '!=', 'admin')` untuk exclude admin users.

### Livewire Component Not Updating

**Solusi**:

1. Pastikan npm assets ter-build: `npm run build`
2. Clear cache: `php artisan cache:clear`
3. Jalankan dev server dalam mode watch: `npm run dev`

---

## 📝 Development Tips

### Local Development:

```bash
# Jalankan dev server dengan hot reload
npm run dev

# Jalankan Laravel server
php artisan serve

# Run tests
php artisan test

# Linting & formatting
php artisan pint
```

### Debugging:

```bash
# Tail logs realtime
php artisan pail

# Tinker shell
php artisan tinker

# Check queue (jika menggunakan)
php artisan queue:listen
```

---

## 📄 License

MIT License - Lihat LICENSE file untuk detail.

---

## 👥 Support

Untuk bantuan dan pertanyaan, hubungi tim development atau buka issue di repository.

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

# The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# kuesioner-damkar

> > > > > > > 60fb4d3b252296a026239ae2ba6a3a1bc2bbe20c
