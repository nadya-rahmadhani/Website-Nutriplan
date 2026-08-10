@extends('layouts.app')

@section('title', 'About')
@section('page-title', 'About NutriPlan')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">

        {{-- Header --}}
        <div class="card mb-4 text-center" style="background: linear-gradient(135deg, #f0faf4, #fff8f0); border: none;">
            <div class="card-body py-5">
                <div style="font-size: 4rem">🥗</div>
                <h2 class="fw-bold mt-3" style="color: #2d6a4f">NutriPlan</h2>
                <p class="text-muted">Personal Meal Planner & Weight Progress Tracker</p>
            </div>
        </div>

        {{-- Deskripsi --}}
        <div class="card mb-4">
            <div class="card-header fw-semibold">
                <i class="bi bi-info-circle me-2 text-success"></i>Tentang Aplikasi
            </div>
            <div class="card-body">
                <p>
                    <strong>NutriPlan</strong> merupakan sistem berbasis web yang membantu pengguna
                    merencanakan pola makan sesuai tujuan nutrisi yang ingin dicapai —
                    menurunkan berat badan (diet), menjaga berat badan (maintenance),
                    atau menambah berat badan (bulking).
                </p>
                <p class="mb-0">
                    Selain membantu menyusun jadwal makan harian dan mingguan, sistem juga
                    menyediakan fitur pencatatan perkembangan berat badan yang divisualisasikan
                    dalam bentuk grafik sehingga pengguna dapat memantau progresnya secara berkala.
                </p>
            </div>
        </div>

        {{-- Permasalahan --}}
        <div class="card mb-4">
            <div class="card-header fw-semibold">
                <i class="bi bi-exclamation-circle me-2 text-warning"></i>Permasalahan yang Diselesaikan
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">Banyak orang memiliki tujuan kesehatan tertentu, namun mengalami kesulitan dalam:</p>
                <div class="row g-3">
                    @foreach([
                        ['icon' => '📅', 'text' => 'Menyusun menu makanan yang teratur'],
                        ['icon' => '⏰', 'text' => 'Menentukan jadwal makan harian'],
                        ['icon' => '📊', 'text' => 'Memantau perkembangan berat badan'],
                        ['icon' => '🔄', 'text' => 'Menjaga konsistensi pola makan'],
                    ] as $item)
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: #f8fffe;">
                            <span style="font-size: 1.5rem">{{ $item['icon'] }}</span>
                            <span class="small">{{ $item['text'] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Fitur --}}
        <div class="card mb-4">
            <div class="card-header fw-semibold">
                <i class="bi bi-stars me-2 text-success"></i>Fitur Utama
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach([
                        ['icon' => '🍽️', 'title' => 'Meal Planning', 'desc' => 'Buat dan kelola jadwal makan harian dengan template otomatis berdasarkan tujuan nutrisi'],
                        ['icon' => '📈', 'title' => 'Weight Tracker', 'desc' => 'Catat dan pantau perkembangan berat badan melalui grafik line chart yang interaktif'],
                        ['icon' => '❤️', 'title' => 'Favorit', 'desc' => 'Simpan makanan favorit sebagai referensi dalam menyusun meal plan'],
                        ['icon' => '🔍', 'title' => 'Browse Makanan', 'desc' => 'Cari dan filter makanan berdasarkan kategori, nama, atau kandungan kalori'],
                        ['icon' => '🎯', 'title' => 'Personalized Goals', 'desc' => 'Template meal plan disesuaikan otomatis dengan tujuan nutrisi pengguna'],
                        ['icon' => '✅', 'title' => 'Progress Harian', 'desc' => 'Tandai menu yang sudah dikonsumsi dan pantau progress makan harian'],
                    ] as $f)
                    <div class="col-md-6">
                        <div class="d-flex gap-3 p-3 rounded-3" style="background: #f8fffe;">
                            <span style="font-size: 1.5rem">{{ $f['icon'] }}</span>
                            <div>
                                <div class="fw-semibold small">{{ $f['title'] }}</div>
                                <div class="text-muted" style="font-size: 0.8rem">{{ $f['desc'] }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Teknologi --}}
        <div class="card mb-4">
            <div class="card-header fw-semibold">
                <i class="bi bi-code-slash me-2 text-success"></i>Teknologi yang Digunakan
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    @foreach(['Laravel 12', 'PHP 8.2', 'MySQL', 'Bootstrap 5', 'Chart.js', 'Blade Template'] as $tech)
                    <span class="badge px-3 py-2" style="background: #e8f5e9; color: #2d6a4f; font-size: 0.85rem;">
                        {{ $tech }}
                    </span>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="text-center mt-2 mb-4">
            <a href="{{ route('dashboard') }}" class="btn btn-primary px-4">
                <i class="bi bi-speedometer2 me-2"></i>Kembali ke Dashboard
            </a>
        </div>

    </div>
</div>

@endsection