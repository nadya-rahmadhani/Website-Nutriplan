@extends('layouts.app')

@section('title', 'Buat Meal Plan')
@section('page-title', 'Buat Meal Plan Baru')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-plus-circle me-2 text-success"></i>Buat Meal Plan Baru
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Sistem akan otomatis membuat template jadwal makan berdasarkan tujuan nutrisimu
                    <strong>({{ ucfirst(auth()->user()->goal ?? 'maintenance') }})</strong>.
                    Kamu bisa mengubahnya setelah dibuat.
                </div>

                <form action="{{ route('meal-plans.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Meal Plan</label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Contoh: Diet Minggu 1"
                               value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Minimal 3 karakter</small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Buat Meal Plan
                        </button>
                        <a href="{{ route('meal-plans.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection