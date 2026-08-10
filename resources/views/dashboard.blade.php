@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Greeting --}}
<div class="mb-4">
    <h4 class="fw-bold mb-1" style="color: green;">
        Halo, {{ explode(' ', auth()->user()->name)[0] }}! 👋
    </h4>
    <p class="mb-0" style="color: rgba(255,255,255,0.45); font-size: 0.9rem;">
        {{ now()->locale('id')->translatedFormat('l, d F Y') }} —
        Semangat mencapai targetmu hari ini!
    </p>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-number">{{ $latestWeight }}<small style="font-size:1rem"> kg</small></div>
                    <div class="stat-label">Berat Sekarang</div>
                    <div style="color: rgba(255,255,255,0.35); font-size: 0.75rem; margin-top: 0.25rem;">
                        Target: {{ auth()->user()->target_weight }} kg
                    </div>
                </div>
                <span class="stat-icon">⚖️</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-number">{{ $totalMealPlans }}</div>
                    <div class="stat-label">Meal Plan</div>
                    <div style="color: rgba(255,255,255,0.35); font-size: 0.75rem; margin-top: 0.25rem;">
                        Total dibuat
                    </div>
                </div>
                <span class="stat-icon">🍽️</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-number">{{ $totalFavorites }}</div>
                    <div class="stat-label">Favorit</div>
                    <div style="color: rgba(255,255,255,0.35); font-size: 0.75rem; margin-top: 0.25rem;">
                        Makanan disimpan
                    </div>
                </div>
                <span class="stat-icon">❤️</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    @php $selisih = round(abs($latestWeight - auth()->user()->target_weight), 1); @endphp
                    <div class="stat-number">{{ $selisih }}<small style="font-size:1rem"> kg</small></div>
                    <div class="stat-label">Sisa Target</div>
                    <div style="color: rgba(255,255,255,0.35); font-size: 0.75rem; margin-top: 0.25rem;">
                        {{ auth()->user()->goal == 'diet' ? 'Untuk turun' : 'Untuk naik' }}
                    </div>
                </div>
                <span class="stat-icon">🎯</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">

    {{-- Progress Makan Hari Ini --}}
    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-calendar-check me-2" style="color:#52b788"></i>Menu Hari Ini</span>
                @if($activePlan)
                    <small style="color: rgba(255,255,255,0.35)">{{ $activePlan->name }}</small>
                @endif
            </div>
            <div class="card-body">
                @if($todaySchedules->isEmpty())
                    <div class="text-center py-4">
                        <div style="font-size: 3rem; opacity: 0.4;">📅</div>
                        <p class="mt-2 mb-0" style="color: rgba(255,255,255,0.4);">Tidak ada jadwal hari ini</p>
                        @if(!$activePlan)
                            <a href="{{ route('meal-plans.create') }}" class="btn btn-primary btn-sm mt-3">
                                Buat Meal Plan
                            </a>
                        @endif
                    </div>
                @else
                    {{-- Progress bar --}}
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span style="font-size:0.85rem; color:rgba(255,255,255,0.6)">Progress Hari Ini</span>
                            <span style="font-size:0.85rem; color:#52b788; font-weight:600">
                                {{ $selesaiMakan }}/{{ $totalMakan }}
                            </span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            @php $pct = $totalMakan > 0 ? ($selesaiMakan/$totalMakan)*100 : 0; @endphp
                            <div class="progress-bar bg-success" style="width: {{ $pct }}%"></div>
                        </div>
                        <div class="mt-2 text-center" style="font-size:0.78rem; color:rgba(255,255,255,0.4)">
                            {{ round($pct) }}% selesai
                        </div>
                    </div>

                    @foreach($todaySchedules as $schedule)
                    <div class="d-flex align-items-center justify-content-between py-2"
                         style="border-bottom: 1px solid rgba(82,183,136,0.08)">
                        <div class="d-flex align-items-center gap-3">
                            <span style="font-size:1.5rem">
                                @if($schedule->meal_type == 'sarapan') 🌅
                                @elseif($schedule->meal_type == 'siang') ☀️
                                @else 🌙
                                @endif
                            </span>
                            <div>
                                <div style="font-size:0.78rem; color:rgba(255,255,255,0.4)">
                                    {{ ucfirst($schedule->meal_type) }}
                                </div>
                                <div style="font-size:0.88rem; color: {{ $schedule->is_done ? '#52b788' : 'rgba(255,255,255,0.8)' }};
                                     text-decoration: {{ $schedule->is_done ? 'line-through' : 'none' }}">
                                    {{ $schedule->menu }}
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('schedules.toggle', $schedule) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit"
                                class="btn btn-sm {{ $schedule->is_done ? 'btn-success' : 'btn-outline-secondary' }}"
                                style="border-radius:8px; padding: 0.25rem 0.6rem">
                                <i class="bi {{ $schedule->is_done ? 'bi-check-circle-fill' : 'bi-circle' }}"></i>
                            </button>
                        </form>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    {{-- Weight Chart --}}
    <div class="col-md-7">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-graph-up me-2" style="color:#52b788"></i>Grafik Berat Badan</span>
                <a href="{{ route('weight-logs.index') }}"
                   class="btn btn-sm btn-outline-primary" style="font-size:0.78rem">
                    + Catat
                </a>
            </div>
            <div class="card-body">
                @if(empty($chartData))
                    <div class="text-center py-5">
                        <div style="font-size: 3rem; opacity: 0.4;">📊</div>
                        <p class="mt-3 mb-0" style="color: rgba(255,255,255,0.4);">
                            Belum ada data berat badan
                        </p>
                        <a href="{{ route('weight-logs.index') }}" class="btn btn-primary btn-sm mt-3">
                            Catat Sekarang
                        </a>
                    </div>
                @else
                    <canvas id="weightChart"></canvas>
                @endif
            </div>
        </div>
    </div>

</div>

{{-- Quick Actions --}}
<div class="row g-3 mt-1">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-lightning me-2" style="color:#52b788"></i>Aksi Cepat
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-6 col-md-3">
                        <a href="{{ route('meal-plans.create') }}"
                           class="btn btn-outline-primary w-100 d-flex flex-column align-items-center py-3">
                            <span style="font-size:1.5rem">🍽️</span>
                            <span style="font-size:0.8rem; margin-top:0.25rem">Buat Meal Plan</span>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('weight-logs.index') }}"
                           class="btn btn-outline-primary w-100 d-flex flex-column align-items-center py-3">
                            <span style="font-size:1.5rem">⚖️</span>
                            <span style="font-size:0.8rem; margin-top:0.25rem">Catat Berat</span>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('foods.index') }}"
                           class="btn btn-outline-primary w-100 d-flex flex-column align-items-center py-3">
                            <span style="font-size:1.5rem">🔍</span>
                            <span style="font-size:0.8rem; margin-top:0.25rem">Browse Makanan</span>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('favorites.index') }}"
                           class="btn btn-outline-primary w-100 d-flex flex-column align-items-center py-3">
                            <span style="font-size:1.5rem">❤️</span>
                            <span style="font-size:0.8rem; margin-top:0.25rem">Favorit Saya</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
@if(!empty($chartData))
<script>
    const ctx = document.getElementById('weightChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [
                {
                    label: 'Berat Badan',
                    data: {!! json_encode($chartData) !!},
                    borderColor: '#52b788',
                    backgroundColor: 'rgba(82,183,136,0.08)',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#52b788',
                    pointBorderColor: '#0a1628',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    tension: 0.4,
                    fill: true,
                },
                {
                    label: 'Target',
                    data: Array({!! count($chartData) !!}).fill({{ auth()->user()->target_weight }}),
                    borderColor: 'rgba(244,162,97,0.6)',
                    borderWidth: 1.5,
                    borderDash: [6,4],
                    pointRadius: 0,
                    fill: false,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(10,25,15,0.9)',
                    borderColor: 'rgba(82,183,136,0.3)',
                    borderWidth: 1,
                    titleColor: '#52b788',
                    bodyColor: '#cce8d4',
                    callbacks: {
                        label: ctx => ctx.dataset.label + ': ' + ctx.parsed.y + ' kg'
                    }
                }
            },
            scales: {
                x: {
                    grid: { color: 'rgba(82,183,136,0.05)' },
                    ticks: { color: 'rgba(255,255,255,0.4)', font: { size: 11 } }
                },
                y: {
                    grid: { color: 'rgba(82,183,136,0.05)' },
                    ticks: {
                        color: 'rgba(255,255,255,0.4)',
                        font: { size: 11 },
                        callback: val => val + ' kg'
                    }
                }
            }
        }
    });
</script>
@endif
@endpush