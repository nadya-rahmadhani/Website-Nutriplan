<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriPlan - Personal Meal Planner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Poppins', sans-serif; }

        :root {
            --primary: #2d6a4f;
            --primary2: #40916c;
            --primary3: #52b788;
            --soft: #95d5b2;
            --accent: #f4a261;
        }

        body {
            background: linear-gradient(135deg, #f0faf4 0%, #ffffff 60%, #e8f5f0 100%);
            color: #1a2e22;
        }

        /* Navbar */
        .navbar {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(45,106,79,0.1);
            padding: 1rem 0;
        }

        .navbar-brand { font-weight: 700; font-size: 1.4rem; color: var(--primary) !important; }
        .navbar-brand span { color: var(--accent); }
        .nav-link { color: #4a7c59 !important; font-size: 0.9rem; }
        .nav-link:hover { color: var(--primary) !important; }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary2));
            border: none; border-radius: 10px; font-weight: 500;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1b4332, var(--primary));
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(45,106,79,0.3);
        }

        .btn-outline-primary {
            color: var(--primary);
            border-color: rgba(45,106,79,0.35);
            border-radius: 10px;
        }

        .btn-outline-primary:hover {
            background: rgba(45,106,79,0.08);
            color: var(--primary);
            border-color: var(--primary);
        }

        /* Hero */
        .hero-section {
            padding: 110px 0 90px;
            min-height: 92vh;
            display: flex; align-items: center;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(45,106,79,0.08);
            color: var(--primary2);
            border: 1px solid rgba(45,106,79,0.18);
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.82rem; font-weight: 500;
            margin-bottom: 1.25rem;
        }

        .hero-title { font-size: 3rem; font-weight: 800; line-height: 1.15; color: #1a2e22; }
        .hero-title span { color: var(--primary); }
        .hero-subtitle { font-size: 1rem; color: #6b9e7e; line-height: 1.75; }

        .floating-card {
            position: absolute;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(45,106,79,0.15);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 0.82rem;
            color: var(--primary);
            white-space: nowrap;
            box-shadow: 0 4px 20px rgba(45,106,79,0.1);
        }

        .float-1 { top: 10%; left: -5%; animation: float 3s ease-in-out infinite; }
        .float-2 { bottom: 15%; right: -5%; animation: float 3s ease-in-out infinite 1.5s; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Stat pill */
        .stat-pill {
            background: rgba(255,255,255,0.8);
            border: 1px solid rgba(45,106,79,0.15);
            border-radius: 12px;
            padding: 0.75rem 1.25rem;
            text-align: center;
            box-shadow: 0 2px 12px rgba(45,106,79,0.06);
        }

        .stat-pill .num { font-size: 1.5rem; font-weight: 700; color: var(--primary); }
        .stat-pill .lbl { font-size: 0.75rem; color: #7aaa8a; }

        /* Glass card */
        .glass-card {
            background: rgba(255,255,255,0.75);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(45,106,79,0.1);
            border-radius: 16px;
            padding: 2rem;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 2px 16px rgba(45,106,79,0.06);
        }

        .glass-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 35px rgba(45,106,79,0.12);
        }

        .feature-icon {
            width: 58px; height: 58px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.25rem;
            background: rgba(45,106,79,0.08);
            border: 1px solid rgba(45,106,79,0.12);
        }

        /* Section */
        section { padding: 80px 0; }
        .section-label { color: var(--primary3); font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 0.5rem; }
        .section-title { font-size: 2rem; font-weight: 700; color: #1a2e22; }
        .section-title span { color: var(--primary); }
        .section-divider { border-color: rgba(45,106,79,0.1); }

        /* CTA */
        .cta-section {
            background: linear-gradient(135deg, var(--primary), var(--primary2));
            color: white;
        }

        .cta-section .btn-light {
            color: var(--primary);
            font-weight: 600;
            border-radius: 10px;
        }

        /* Footer */
        footer {
            background: rgba(240,250,244,0.8);
            border-top: 1px solid rgba(45,106,79,0.1);
            color: #6b9e7e;
            padding: 2rem 0;
        }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(45,106,79,0.2); border-radius: 3px; }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#">🥗 Nutri<span>Plan</span></a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <i class="bi bi-list fs-4" style="color: var(--primary)"></i>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="#features">Fitur</a></li>
                <li class="nav-item"><a class="nav-link" href="#goals">Tujuan</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">Tentang</a></li>
            </ul>
            <div class="d-flex gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        <i class="bi bi-speedometer2 me-1"></i>Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Daftar Gratis</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Hero -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="hero-badge">✨ Personal Meal Planner & Weight Tracker</div>
                <h1 class="hero-title">
                    Rencanakan <span>Pola Makanmu</span><br>dengan Lebih Mudah
                </h1>
                <p class="hero-subtitle mt-3">
                    NutriPlan membantu kamu menyusun jadwal makan harian,
                    memantau perkembangan berat badan, dan mencapai tujuan nutrisimu.
                </p>
                <div class="d-flex gap-3 mt-4 flex-wrap">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-4">
                            <i class="bi bi-speedometer2 me-2"></i>Buka Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4">
                            <i class="bi bi-rocket me-2"></i>Mulai Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg px-4">Login</a>
                    @endauth
                </div>
                <div class="d-flex gap-3 mt-4 flex-wrap">
                    <div class="stat-pill"><div class="num">3</div><div class="lbl">Tujuan Nutrisi</div></div>
                    <div class="stat-pill"><div class="num">7</div><div class="lbl">Hari Dijadwal</div></div>
                    <div class="stat-pill"><div class="num">📊</div><div class="lbl">Grafik Progress</div></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative text-center">
                    <div style="font-size: 11rem; line-height: 1; filter: drop-shadow(0 20px 40px rgba(45,106,79,0.15))">
                        🥗
                    </div>
                    <div class="floating-card float-1">✅ Sarapan selesai!</div>
                    <div class="floating-card float-2">📉 -2 kg minggu ini</div>
                </div>
            </div>
        </div>
    </div>
</section>

<hr class="section-divider m-0">

<!-- Features -->
<section id="features" style="background: rgba(255,255,255,0.5);">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-label">Fitur</div>
            <h2 class="section-title">Semua yang Kamu <span>Butuhkan</span></h2>
            <p style="color: #7aaa8a; font-size: 0.9rem;">Dirancang untuk perjalanan hidupmu yang lebih sehat</p>
        </div>
        <div class="row g-4">
            @foreach([
                ['icon'=>'🍽️','title'=>'Meal Planning','desc'=>'Susun jadwal makan harian dan mingguan dengan template otomatis sesuai tujuan nutrisimu.'],
                ['icon'=>'📈','title'=>'Weight Tracker','desc'=>'Pantau perkembangan berat badan melalui grafik interaktif dari waktu ke waktu.'],
                ['icon'=>'❤️','title'=>'Favorit','desc'=>'Simpan makanan favoritmu sebagai referensi cepat saat menyusun meal plan.'],
                ['icon'=>'🎯','title'=>'Personalized','desc'=>'Template meal plan disesuaikan otomatis berdasarkan tujuan nutrisimu.'],
            ] as $f)
            <div class="col-md-6 col-lg-3">
                <div class="glass-card h-100">
                    <div class="feature-icon">{{ $f['icon'] }}</div>
                    <h6 class="fw-bold mb-2" style="color: #1a2e22">{{ $f['title'] }}</h6>
                    <p style="color: #7aaa8a; font-size: 0.85rem; margin: 0;">{{ $f['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<hr class="section-divider m-0">

<!-- Goals -->
<section id="goals">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-label">Tujuan</div>
            <h2 class="section-title">Pilih <span>Tujuanmu</span></h2>
            <p style="color: #7aaa8a; font-size: 0.9rem;">NutriPlan mendukung 3 tujuan nutrisi utama</p>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach([
                ['icon'=>'🥗','title'=>'Diet','desc'=>'Menu rendah kalori untuk menurunkan berat badan secara sehat.','badge'=>'Turun Berat Badan','bg'=>'rgba(45,106,79,0.1)','color'=>'#2d6a4f'],
                ['icon'=>'⚖️','title'=>'Maintenance','desc'=>'Menu seimbang untuk menjaga berat badan ideal.','badge'=>'Jaga Berat Badan','bg'=>'rgba(59,130,246,0.08)','color'=>'#1d4ed8'],
                ['icon'=>'💪','title'=>'Bulking','desc'=>'Menu tinggi protein dan kalori untuk membangun massa otot.','badge'=>'Tambah Massa Otot','bg'=>'rgba(245,158,11,0.1)','color'=>'#b45309'],
            ] as $g)
            <div class="col-md-4">
                <div class="glass-card text-center h-100">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">{{ $g['icon'] }}</div>
                    <h5 class="fw-bold mb-2" style="color: #1a2e22">{{ $g['title'] }}</h5>
                    <p style="color: #7aaa8a; font-size: 0.85rem;">{{ $g['desc'] }}</p>
                    <span class="badge px-3 py-2"
                          style="background: {{ $g['bg'] }}; color: {{ $g['color'] }}; border-radius: 20px; font-size: 0.8rem;">
                        {{ $g['badge'] }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<hr class="section-divider m-0">

<!-- About -->
<section id="about" style="background: rgba(255,255,255,0.5);">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5 text-center">
                <div style="font-size: 8rem; filter: drop-shadow(0 10px 30px rgba(45,106,79,0.15))">🌱</div>
            </div>
            <div class="col-lg-7">
                <div class="section-label">Tentang</div>
                <h2 class="section-title">Tentang <span>NutriPlan</span></h2>
                <p style="color: #6b9e7e; line-height: 1.8; margin-top: 1rem;">
                    NutriPlan adalah sistem berbasis web yang dirancang untuk membantu
                    siapa saja merencanakan pola makan secara lebih terstruktur dan konsisten.
                    Dengan fitur meal planning, weight tracking, dan personalisasi berdasarkan
                    tujuan nutrisi, NutriPlan menjadi teman terbaikmu menuju hidup lebih sehat.
                </p>
                <a href="{{ route('about') }}" class="btn btn-outline-primary mt-2">
                    <i class="bi bi-info-circle me-2"></i>Selengkapnya
                </a>
            </div>
        </div>
    </div>
</section>

<hr class="section-divider m-0">

<!-- CTA -->
<section class="cta-section">
    <div class="container text-center py-2">
        <h2 class="fw-bold mb-3">Mulai Perjalanan Sehatmu! 🚀</h2>
        <p style="opacity: 0.8; margin-bottom: 2rem;">Bergabung dan buat meal plan pertamamu hari ini. Gratis!</p>
        @auth
            <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg px-5">Buka Dashboard</a>
        @else
            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5">Daftar Sekarang — Gratis!</a>
        @endauth
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="container text-center">
        <div style="color: var(--primary); font-weight: 600; margin-bottom: 0.5rem;">🥗 NutriPlan</div>
        <p style="font-size: 0.8rem; margin: 0;">© 2026 NutriPlan. Personal Meal Planner & Weight Tracker.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>