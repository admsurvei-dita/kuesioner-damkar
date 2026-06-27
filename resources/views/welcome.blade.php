<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Survei Analisis Risiko - Disdamkar Kabupaten Bekasi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-slate-950 text-white min-h-screen flex flex-col selection:bg-orange-600 selection:text-white">

    <!-- Navbar Sederhana -->
    <header class="border-b border-slate-900 bg-slate-950/80 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <span class="text-orange-600 text-2xl"><i class="fa-solid fa-fire-extinguisher"></i></span>
                <span class="font-extrabold tracking-wider uppercase text-sm md:text-base text-white">DISDAMKAR <span
                        class="text-orange-500">BEKASI</span></span>
            </div>
            <div class="flex gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="text-xs md:text-sm font-bold bg-orange-600 hover:bg-orange-500 px-4 py-2 rounded-xl transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-xs md:text-sm font-bold text-gray-300 hover:text-white transition py-2 px-3">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="text-xs md:text-sm font-bold bg-orange-600 hover:bg-orange-500 px-4 py-2 rounded-xl transition">Daftar</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <main class="flex-grow max-w-7xl mx-auto px-6 py-12 md:py-20 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <!-- Teks Informasi -->
        <div class="lg:col-span-7 space-y-6">
            <span
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-orange-500/10 text-orange-400 border border-orange-500/20">
                <i class="fa-solid fa-scale-balanced text-xs"></i> Amanat Permendagri No. 15 Tahun 2024
            </span>
            <h1 class="text-4xl md:text-6xl font-black leading-tight text-white uppercase tracking-tight">
                Suarakan Risiko Nyata, Perjuangkan <span
                    class="text-orange-500 underline decoration-orange-600 decoration-wavy">Kesejahteraan</span>
            </h1>
            <p class="text-slate-400 text-sm md:text-base leading-relaxed">
                Selamat datang di portal mandiri <strong>Survei Kajian Formulasi Tunjangan Risiko Tinggi</strong>. Kami
                mengundang
                seluruh jajaran pimpinan, staf, dan seluruh pasukan pemadam di lapangan untuk bersama-sama menyusun
                basis data ilmiah penilaian bahaya K3 menggunakan metode <strong>Fine-Kinney</strong>. Data Anda adalah
                senjata hukum
                kita di hadapan TAPD Pemkab Bekasi.
            </p>
            <div class="flex flex-wrap gap-4 pt-4">
                <a href="{{ route('register') }}"
                    class="bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-500 hover:to-red-500 text-white font-bold px-8 py-3.5 rounded-2xl text-sm transition shadow-lg shadow-orange-600/30 flex items-center gap-2">
                    <i class="fa-solid fa-id-card-clip"></i> Daftar Akun Baru
                </a>
                <a href="{{ route('login') }}"
                    class="bg-slate-900 hover:bg-slate-800 text-slate-300 font-bold px-6 py-3.5 rounded-2xl text-sm transition border border-slate-800 flex items-center gap-2">
                    Sudah Punya Akun <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

        <!-- Gambar Visual Representatif -->
        <div class="lg:col-span-5 relative">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent z-10"></div>
            <div class="absolute -inset-1 rounded-3xl bg-gradient-to-r from-orange-600 to-red-600 opacity-20 blur-xl">
            </div>
            <!-- Gambar representasi damkar -->
            <img class="relative z-0 rounded-3xl w-full h-[350px] md:h-[450px] object-fit object-cover shadow-2xl border border-slate-800"
                src="https://cms.westjavatoday.com/uploads/images/2023/01/image_750x_63c2024676bb5.jpg?auto=format&fit=crop&w=600&q=80"
                alt="Aparatur Pemadam Kebakaran Bekasi">
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-900 py-6 text-center text-xs text-slate-600">
        &copy; 2026 Dinas Pemadam Kebakaran Kabupaten Bekasi. Seluruh Hak Cipta Dilindungi.
    </footer>

</body>

</html>