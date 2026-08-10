@extends('layouts.app')

@section('title', 'Weight Tracker')
@section('page-title', 'Weight Progress Tracker')

@section('content')

<div class="row g-3 mb-4">
    {{-- Card Berat Sekarang --}}
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body py-4">
                <div class="fs-1 fw-bold text-success">{{ $latestWeight }} <small class="fs-5">kg</small></div>
                <div class="text-muted">Berat Terkini</div>
            </div>
        </div>
    </div>
    {{-- Card Target --}}
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body py-4">
                <div class="fs-1 fw-bold text-primary">{{ auth()->user()->target_weight }} <small class="fs-5">kg</small></div>
                <div class="text-muted">Target Berat</div>
            </div>
        </div>
    </div>
    {{-- Card Selisih --}}
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body py-4">
                @php
                    $selisih = round($latestWeight - auth()->user()->target_weight, 1);
                @endphp
                <div class="fs-1 fw-bold {{ $selisih > 0 ? 'text-warning' : 'text-success' }}">
                    {{ abs($selisih) }} <small class="fs-5">kg</small>
                </div>
                <div class="text-muted">
                    {{ $selisih > 0 ? 'Lagi untuk mencapai target' : 'Sudah melewati target! 🎉' }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">

    {{-- Form Tambah + Tabel --}}
    <div class="col-md-5">

        {{-- Form Catat Berat --}}
        <div class="card mb-3">
            <div class="card-header">
                <i class="bi bi-plus-circle me-2 text-success"></i>Catat Berat Badan
            </div>
            <div class="card-body">
                <form action="{{ route('weight-logs.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Berat Badan (kg)</label>
                        <input type="number" step="0.1" name="weight"
                               class="form-control @error('weight') is-invalid @enderror"
                               placeholder="Contoh: 63.5"
                               value="{{ old('weight') }}" required>
                        @error('weight')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal</label>
                        <input type="date" name="logged_at"
                               class="form-control @error('logged_at') is-invalid @enderror"
                               value="{{ old('logged_at', date('Y-m-d')) }}" required>
                        @error('logged_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Catatan (opsional)</label>
                        <input type="text" name="note"
                               class="form-control"
                               placeholder="Contoh: Setelah olahraga"
                               value="{{ old('note') }}">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-save me-1"></i>Simpan
                    </button>
                </form>
            </div>
        </div>

        {{-- Tabel Riwayat --}}
        <div class="card">
            <div class="card-header">
                <i class="bi bi-clock-history me-2 text-success"></i>Riwayat
            </div>
            <div class="card-body p-0">
                @if($logsPaginated->isEmpty())
                    <div class="text-center text-muted py-4">
                        Belum ada data
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Berat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logsPaginated as $log)
                                <tr>
                                    <td>
                                        <div>{{ \Carbon\Carbon::parse($log->logged_at)->format('d M Y') }}</div>
                                        @if($log->note)
                                            <small class="text-muted">{{ $log->note }}</small>
                                        @endif
                                    </td>
                                    <td class="fw-semibold">{{ $log->weight }} kg</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('weight-logs.edit', $log) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('weight-logs.destroy', $log) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Hapus data ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3">
                        {{ $logsPaginated->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Chart --}}
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-graph-up me-2 text-success"></i>Grafik Perkembangan Berat Badan
            </div>
            <div class="card-body">
                @if(empty($chartData))
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-bar-chart fs-1"></i>
                        <p class="mt-3">Belum ada data untuk ditampilkan.<br>Mulai catat berat badanmu!</p>
                    </div>
                @else
                    <canvas id="weightChart"></canvas>
                    {{-- Garis target --}}
                    <div class="mt-3 text-center">
                        <span class="badge" style="background:#e9ecef; color:#555;">
                            <span style="color:#f4a261;">━━</span> Target: {{ auth()->user()->target_weight }} kg
                        </span>
                        <span class="badge ms-2" style="background:#e9ecef; color:#555;">
                            <span style="color:#2d6a4f;">━━</span> Berat Aktual
                        </span>
                    </div>
                @endif
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
                    label: 'Berat Badan (kg)',
                    data: {!! json_encode($chartData) !!},
                    borderColor: '#2d6a4f',
                    backgroundColor: 'rgba(45,106,79,0.1)',
                    borderWidth: 2,
                    pointBackgroundColor: '#2d6a4f',
                    pointRadius: 5,
                    tension: 0.4,
                    fill: true,
                },
                {
                    label: 'Target',
                    data: Array({!! count($chartData) !!}).fill({{ auth()->user()->target_weight }}),
                    borderColor: '#f4a261',
                    borderWidth: 2,
                    borderDash: [6, 4],
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
                    callbacks: {
                        label: ctx => ctx.dataset.label + ': ' + ctx.parsed.y + ' kg'
                    }
                }
            },
            scales: {
                y: {
                    ticks: { callback: val => val + ' kg' }
                }
            }
        }
    });
</script>
@endif
@endpush