<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NutriPlan</title>
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

        .auth-right { padding: 3rem 2.5rem; }

        .brand-title { font-weight: 700; font-size: 1.8rem; }
        .brand-title span { color: #b7e4c7; }

        .feature-item {
            display: flex; align-items: center;
            gap: 0.75rem; margin-bottom: 0.85rem;
            font-size: 0.875rem; opacity: 0.85;
            text-align: left;
        }

        .form-control {
            border-radius: 10px;
            border: 1.5px solid rgba(45,106,79,0.2);
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
            background: rgba(240,250,244,0.5);
            color: #1a2e22;
        }

        .form-control:focus {
            border-color: var(--primary2);
            box-shadow: 0 0 0 3px rgba(45,106,79,0.1);
            background: white;
        }

        .form-control::placeholder { color: #aac4b2; }
        .form-label { font-weight: 500; font-size: 0.85rem; color: #3a6b4a; }

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
        <div class="col-lg-8 col-md-10">
            <div class="auth-wrapper">
                <div class="row g-0">

                    <!-- Kiri -->
                    <div class="col-md-5 auth-left d-none d-md-flex">
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
                    <div class="col-md-7 auth-right">
                        <a href="/" style="color: #6b9e7e; font-size: 0.82rem; text-decoration: none;">
                            <i class="bi bi-arrow-left me-1"></i>Kembali ke beranda
                        </a>
                        <h4 class="fw-bold mb-1 mt-3" style="color: #1a2e22">Selamat Datang! 👋</h4>
                        <p style="color: #7aaa8a; font-size: 0.85rem; margin-bottom: 1.75rem;">
                            Login untuk melanjutkan ke NutriPlan
                        </p>

                        @if(session('status'))
                            <div class="alert alert-success small">{{ session('status') }}</div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="contoh@email.com"
                                       value="{{ old('email') }}" required autofocus>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Masukkan password" required>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                    <label class="form-check-label small" for="remember"
                                           style="color: #6b9e7e">Ingat Saya</label>
                                </div>
                                @if(Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"
                                       style="color: var(--primary2); font-size: 0.82rem;">Lupa password?</a>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Login
                            </button>

                            <p class="text-center mt-3 mb-0" style="font-size: 0.85rem; color: #7aaa8a;">
                                Belum punya akun?
                                <a href="{{ route('register') }}"
                                   style="color: var(--primary); font-weight: 600;">Daftar di sini</a>
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