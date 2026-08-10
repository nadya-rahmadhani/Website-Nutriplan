<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - NutriPlan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        :root { --primary: #2d6a4f; --primary2: #40916c; --primary3: #52b788; }

        body {
            background: linear-gradient(135deg, #f0faf4 0%, #ffffff 50%, #e8f5f0 100%);
            min-height: 100vh;
            display: flex; align-items: center;
            padding: 2rem 0;
        }

        .auth-wrapper {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(45,106,79,0.12);
            border-radius: 24px;
            box-shadow: 0 8px 40px rgba(45,106,79,0.1);
            overflow: hidden;
        }

        .auth-left {
            background: linear-gradient(135deg, var(--primary), var(--primary2));
            padding: 3rem 2rem;
            display: flex; flex-direction: column;
            justify-content: center; align-items: center;
            text-align: center; color: white;
        }

        .auth-right { padding: 2.5rem; }

        .brand-title { font-weight: 700; font-size: 1.8rem; }
        .brand-title span { color: #b7e4c7; }

        .feature-item {
            display: flex; align-items: center;
            gap: 0.75rem; margin-bottom: 0.85rem;
            font-size: 0.875rem; opacity: 0.85;
            text-align: left;
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 1.5px solid rgba(45,106,79,0.2);
            padding: 0.6rem 1rem;
            font-size: 0.88rem;
            background: rgba(240,250,244,0.5);
            color: #1a2e22;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary2);
            box-shadow: 0 0 0 3px rgba(45,106,79,0.1);
            background: white;
            color: #1a2e22;
        }

        .form-control::placeholder { color: #aac4b2; }
        .form-select option { background: white; color: #1a2e22; }
        .form-label { font-weight: 500; font-size: 0.82rem; color: #3a6b4a; }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary2));
            border: none; border-radius: 10px;
            padding: 0.65rem; font-weight: 600;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1b4332, var(--primary));
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(45,106,79,0.3);
        }

        .divider { border-color: rgba(45,106,79,0.1); }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-md-11">
            <div class="auth-wrapper">
                <div class="row g-0">

                    <!-- Kiri -->
                    <div class="col-md-4 auth-left d-none d-md-flex">
                        <div>
                            <div style="font-size: 3.5rem">🥗</div>
                            <h3 class="brand-title mt-3">Nutri<span>Plan</span></h3>
                            <p style="opacity:0.65; font-size:0.82rem; margin-top:0.5rem">
                                Personal Meal Planner & Weight Tracker
                            </p>
                            <hr class="divider my-3">
                            <div class="mt-2">
                                <div class="feature-item"><span>🍽️</span> Meal Planning Otomatis</div>
                                <div class="feature-item"><span>📈</span> Weight Progress Tracker</div>
                                <div class="feature-item"><span>❤️</span> Simpan Makanan Favorit</div>
                                <div class="feature-item"><span>🎯</span> Personalized Goal</div>
                            </div>
                        </div>
                    </div>

                    <!-- Kanan -->
                    <div class="col-md-8 auth-right">
                        <a href="/" style="color: #6b9e7e; font-size: 0.82rem; text-decoration: none;">
                            <i class="bi bi-arrow-left me-1"></i>Kembali ke beranda
                        </a>
                        <h4 class="fw-bold mb-1 mt-3" style="color: #1a2e22">Buat Akun Baru</h4>
                        <p style="color: #7aaa8a; font-size: 0.85rem; margin-bottom: 1.5rem;">
                            Mulai perjalanan sehatmu bersama NutriPlan
                        </p>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row g-2 mb-2">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           placeholder="Nama lengkap"
                                           value="{{ old('name') }}" required autofocus>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           placeholder="contoh@email.com"
                                           value="{{ old('email') }}" required>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row g-2 mb-2">
                                <div class="col-md-6">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Min. 8 karakter" required>
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation"
                                           class="form-control" placeholder="Ulangi password" required>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Tujuan Nutrisi</label>
                                <select name="goal" class="form-select @error('goal') is-invalid @enderror" required>
                                    <option value="">-- Pilih Tujuan --</option>
                                    <option value="diet" {{ old('goal')=='diet'?'selected':'' }}>🥗 Diet — Turunkan Berat Badan</option>
                                    <option value="maintenance" {{ old('goal')=='maintenance'?'selected':'' }}>⚖️ Maintenance — Jaga Berat Badan</option>
                                    <option value="bulking" {{ old('goal')=='bulking'?'selected':'' }}>💪 Bulking — Tambah Massa Otot</option>
                                </select>
                                @error('goal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Berat Saat Ini (kg)</label>
                                    <input type="number" step="0.1" name="current_weight"
                                           class="form-control @error('current_weight') is-invalid @enderror"
                                           placeholder="Contoh: 65"
                                           value="{{ old('current_weight') }}" required>
                                    @error('current_weight')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Target Berat (kg)</label>
                                    <input type="number" step="0.1" name="target_weight"
                                           class="form-control @error('target_weight') is-invalid @enderror"
                                           placeholder="Contoh: 55"
                                           value="{{ old('target_weight') }}" required>
                                    @error('target_weight')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-rocket me-2"></i>Daftar Sekarang
                            </button>

                            <p class="text-center mt-3 mb-0" style="font-size: 0.85rem; color: #7aaa8a;">
                                Sudah punya akun?
                                <a href="{{ route('login') }}"
                                   style="color: var(--primary); font-weight: 600;">Login di sini</a>
                            </p>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>