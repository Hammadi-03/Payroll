<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PayRoll</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }

        /* Cloud drift animations */
        @keyframes cloudDrift1 {
            0%   { transform: translateX(0px) translateY(0px); }
            50%  { transform: translateX(30px) translateY(-8px); }
            100% { transform: translateX(0px) translateY(0px); }
        }
        @keyframes cloudDrift2 {
            0%   { transform: translateX(0px) translateY(0px); }
            50%  { transform: translateX(-25px) translateY(6px); }
            100% { transform: translateX(0px) translateY(0px); }
        }
        @keyframes cloudDrift3 {
            0%   { transform: translateX(0px) translateY(0px); }
            50%  { transform: translateX(20px) translateY(10px); }
            100% { transform: translateX(0px) translateY(0px); }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-12px); }
        }
        @keyframes shimmer {
            0%   { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(99,102,241,0.3); }
            50%       { box-shadow: 0 0 40px rgba(99,102,241,0.6); }
        }

        .cloud-1 { animation: cloudDrift1 12s ease-in-out infinite; }
        .cloud-2 { animation: cloudDrift2 16s ease-in-out infinite; }
        .cloud-3 { animation: cloudDrift3 10s ease-in-out infinite; }

        .fade-up-1 { animation: fadeUp 0.8s ease forwards; opacity: 0; }
        .fade-up-2 { animation: fadeUp 0.8s ease 0.2s forwards; opacity: 0; }
        .fade-up-3 { animation: fadeUp 0.8s ease 0.4s forwards; opacity: 0; }
        .fade-up-4 { animation: fadeUp 0.8s ease 0.6s forwards; opacity: 0; }

        .float-card { animation: float 4s ease-in-out infinite; }
        .float-card-2 { animation: float 5s ease-in-out 1s infinite; }

        .hero-bg {
            /* Removing background image to use video instead */
        }

        .shimmer-text {
            background: linear-gradient(90deg, #fff 0%, #a5b4fc 40%, #fff 60%, #a5b4fc 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 3s linear infinite;
        }

        .glass-card {
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.25);
        }

        .glass-card-dark {
            background: rgba(15,15,40,0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .btn-glow { animation: pulse-glow 2s ease-in-out infinite; }

        .feature-card:hover { transform: translateY(-4px) scale(1.02); }
        .feature-card { transition: all 0.3s ease; }

        nav a { transition: all 0.2s ease; }
    </style>
</head>
<body class="antialiased overflow-x-hidden bg-yellow-50">

    <!-- ═══════════════ HERO SECTION ═══════════════ -->
    <section class="relative min-h-screen flex flex-col overflow-hidden bg-black rounded-b-[60px] md:rounded-b-[100px]">
        
        <!-- Video Background Zoomed In -->
        <video autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover z-0 scale-[1.35]">
            <source src="{{ asset('Nature vidio.mp4') }}" type="video/mp4">
        </video>

        <!-- Dark overlay gradient -->
        <div class="absolute inset-0 bg-gradient-to-b from-[#0a0a2e]/60 via-[#0a0a2e]/30 to-[#0a0a2e]/80 z-10"></div>

        <!-- ── NAVBAR ── -->
        <nav class="relative z-20 w-full px-6 lg:px-16 py-6 flex items-center justify-between">
            <!-- Left: Logo -->
            <div class="flex items-center gap-3 min-w-[200px]">
                <img src="{{ asset('images/logo-star.jpg') }}" alt="PayRoll Logo" class="w-10 h-10 rounded-full shadow-md">
                <div class="flex flex-col">
                    <span class="text-white font-extrabold text-xl tracking-tight leading-none">PayRoll.exe</span>
                    <span class="text-white/60 text-[10px] font-medium tracking-wide mt-1">Parent of MurjanLab</span>
                </div>
            </div>

            <!-- Center: Links (Perfectly Centered) -->
            <div class="hidden md:flex absolute left-1/2 -translate-x-1/2 items-center gap-8 text-white/80 text-sm font-medium">
                <a href="#features" class="hover:text-white transition-colors">Fitur</a>
                <a href="#how" class="hover:text-white transition-colors">Cara Kerja</a>
                <a href="#pricing" class="hover:text-white transition-colors">Harga</a>
            </div>

            <!-- Right: Auth Buttons -->
            <div class="flex items-center justify-end gap-3 min-w-[200px]">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="text-sm font-semibold text-white/80 hover:text-white transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                           class="text-sm font-semibold text-white/80 hover:text-white transition">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="px-4 py-2 text-sm font-bold text-white rounded-full transition hover:opacity-90 btn-glow"
                               style="background-color:#282939;">
                                Daftar Gratis
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>

        <!-- ── HERO CONTENT ── -->
        <div class="relative z-10 flex-1 flex flex-col items-center justify-center text-center px-6 pb-20 pt-10">

            <div class="fade-up-1 inline-flex items-center gap-2 px-4 py-1.5 rounded-full glass-card text-white/90 text-xs font-semibold mb-6 tracking-widest uppercase">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                Dipercaya 35.000+ Perusahaan
            </div>

            <h1 class="fade-up-2 text-5xl md:text-7xl lg:text-8xl font-black text-white leading-none tracking-tighter mb-6 max-w-5xl">
                BAYAR GAJI
                <br>
                <span class="shimmer-text">MUDAH, CEPAT</span>
                <br>
                <span class="text-white">&amp; AMAN</span>
            </h1>

            <p class="fade-up-3 text-white/70 text-lg md:text-xl max-w-2xl leading-relaxed mb-10">
                Kelola penggajian karyawan, absensi, dan slip gaji otomatis dalam satu platform yang terintegrasi dan mudah digunakan.
            </p>

            <div class="fade-up-4 flex flex-col sm:flex-row items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="px-8 py-4 text-base font-bold text-white rounded-full shadow-2xl transition-all hover:-translate-y-1 hover:opacity-90 btn-glow"
                           style="background-color:#282939;">
                            <i class="fa-solid fa-rocket mr-2"></i>Request Demo
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-8 py-4 text-base font-semibold text-white rounded-full glass-card transition-all hover:-translate-y-1 hover:bg-white/20">
                            Request Demo <i class="fa-solid fa-arrow-right ml-2"></i>
                        </a>
                    @endauth
                @endif
            </div>

            <!-- Stats row -->
            <div class="fade-up-4 mt-14 flex flex-wrap items-center justify-center gap-8">
                <div class="flex items-center gap-2 text-white/70 text-sm">
                    <i class="fa-solid fa-shield-halved text-green-400"></i>
                    <span>Data terenkripsi</span>
                </div>
                <div class="w-px h-4 bg-white/20 hidden sm:block"></div>
                <div class="flex items-center gap-2 text-white/70 text-sm">
                    <i class="fa-solid fa-star text-yellow-400"></i>
                    <span>7.000+ Ulasan positif</span>
                </div>
                <div class="w-px h-4 bg-white/20 hidden sm:block"></div>
                <div class="flex items-center gap-2 text-white/70 text-sm">
                    <i class="fa-solid fa-bolt text-indigo-400"></i>
                    <span>Proses instan</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════ FEATURE CARDS ═══════════════ -->
    <section id="features" class="py-24 px-6 mx-4 mt-12 lg:px-16 relative overflow-hidden rounded-[60px] md:rounded-[100px]">
        <!-- Cloud sky background image -->
        <img src="{{ asset('images/cloud-bg.png') }}" alt="img Awan" class="absolute inset-0 w-full h-full object-cover " >

        <div class="relative z-10 max-w-6xl mx-auto">

            <div class="text-center mb-16" data-aos="fade-up">
                <p class="text-white font-bold text-sm uppercase tracking-widest mb-3">Platform Lengkap</p>
                <h2 class="text-4xl md:text-5xl font-black text-white tracking-tight drop-shadow-lg">DAPATKAN LEBIH BANYAK<br>DENGAN PAYROLL</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <div class="feature-card glass-card-dark rounded-2xl p-6 text-white float-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 bg-orange-500/80 rounded-full flex items-center justify-center mb-5 shadow-lg">
                        <i class="fa-solid fa-bolt text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Pembayaran Instan</h3>
                    <p class="text-white/70 text-sm leading-relaxed">Transfer gaji ke seluruh rekening bank secara otomatis dan real-time setiap periode.</p>
                </div>
                <!-- Card 2 -->
                <div class="feature-card glass-card-dark rounded-2xl p-6 text-white float-card-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 bg-yellow-500/80 rounded-full flex items-center justify-center mb-5 shadow-lg">
                        <i class="fa-solid fa-users text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Untuk Semua Orang</h3>
                    <p class="text-white/70 text-sm leading-relaxed">Dari UKM hingga perusahaan besar, platform kami scalable sesuai kebutuhan bisnis Anda.</p>
                </div>
                <!-- Card 3 -->
                <div class="feature-card glass-card-dark rounded-2xl p-6 text-white float-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-14 h-14 bg-indigo-500/80 rounded-full flex items-center justify-center mb-5 shadow-lg">
                        <i class="fa-solid fa-globe text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Cakupan Global</h3>
                    <p class="text-white/70 text-sm leading-relaxed">Kelola karyawan dari 190+ negara dengan dukungan multi-mata uang dan regulasi lokal.</p>
                </div>
                <!-- Card 4 -->
                <div class="feature-card glass-card-dark rounded-2xl p-6 text-white float-card-2" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-14 h-14 bg-green-500/80 rounded-full flex items-center justify-center mb-5 shadow-lg">
                        <i class="fa-solid fa-shield-halved text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Aman & Terenkripsi</h3>
                    <p class="text-white/70 text-sm leading-relaxed">Data keuangan dan karyawan Anda dijaga dengan enkripsi tingkat militer 256-bit AES.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════ HOW IT WORKS ═══════════════ -->
    <section id="how" class="bg-yellow-50 py-24 px-6 lg:px-16">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16" data-aos="fade-up">
                <p class="text-black-black font-bold text-sm uppercase tracking-widest mb-3">Sangat Mudah</p>
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tight">SATU APLIKASI UNTUK<br>SEMUA KEBUTUHAN GAJI</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white font-black text-2xl mx-auto mb-5 shadow-lg" style="background-color:#282939;">1</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Daftarkan Karyawan</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Tambahkan data karyawan lengkap termasuk jabatan, departemen, dan informasi rekening bank.</p>
                </div>
                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white font-black text-2xl mx-auto mb-5 shadow-lg" style="background-color:#f97316;">2</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Hitung Otomatis</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Sistem menghitung gaji pokok, tunjangan, potongan, dan pajak secara otomatis setiap bulan.</p>
                </div>
                <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white font-black text-2xl mx-auto mb-5 shadow-lg" style="background-color:#22c55e;">3</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Slip Gaji Digital</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Karyawan menerima slip gaji PDF langsung di portal mereka, kapan saja dan di mana saja.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════ CTA BANNER ═══════════════ -->
    <section class="py-24 px-6 relative overflow-hidden" style="background-color:#282939;">
        <div class="absolute inset-0 opacity-10 rounded-5">
            <div class="cloud-1 absolute left-0 top-0 w-1/2 h-full " style="background: radial-gradient(ellipse at left, #6366f1 0%, transparent 60%);"></div>
            <div class="cloud-2 absolute right-0 bottom-0 w-1/2 h-full" style="background: radial-gradient(ellipse at right, #a855f7 0%, transparent 60%);"></div>
        </div>
        <div class="relative z-10 max-w-3xl mx-auto text-center" data-aos="zoom-in">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6 tracking-tight">
                PEMBAYARAN SEAMLESS,<br>
                <span class="text-white">REWARD INSTAN</span>
            </h2>
            <p class="text-white/60 text-lg mb-10">Bergabunglah dengan ribuan perusahaan yang sudah mempercayakan pengelolaan payroll mereka kepada kami.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="px-8 py-4 bg-indigo-500 hover:bg-indigo-400 text-white font-bold rounded-full transition-all hover:-translate-y-1 shadow-xl">
                            <i class="fa-solid fa-gauge mr-2"></i> Ke Dashboard
                        </a>
                    @else
                    
                        <a href="{{ route('login') }}"
                           class="px-8 py-4 border border-white/20 text-white font-semibold rounded-full transition-all hover:bg-white/10 hover:-translate-y-1">
                            Get Accsess
                            Masuk akun
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </section>

    <!-- ═══════════════ FOOTER ═══════════════ -->
    <footer class="bg-gray-900 py-10 px-6 text-center text-gray-500 text-sm">
        <div class="flex items-center justify-center gap-2 mb-3">
            <img src="{{ asset('images/logo-star.jpg') }}" alt="PayRoll Logo" class="w-7 h-7 rounded-full shadow-sm">
            <span class="text-white font-bold">Pay<span class="text-indigo-400">Roll</span></span>
        </div>
        <p>&copy; {{ date('Y') }} PayRoll. Abdulaziz Hammadi. &nbsp;·&nbsp; Laravel v{{ Illuminate\Foundation\Application::VERSION }}</p>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
        });
    </script>
</body>
</html>
