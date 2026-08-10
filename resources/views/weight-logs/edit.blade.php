@extends('layouts.app')

@section('title', 'Edit Data Berat')
@section('page-title', 'Edit Data Berat Badan')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-pencil me-2 text-warning"></i>Edit Data Berat Badan
            </div>
            <div class="card-body">
                <form action="{{ route('weight-logs.update', $weightLog) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Berat Badan (kg)</label>
                        <input type="number" step="0.1" name="weight"
                               class="form-control @error('weight') is-invalid @enderror"
                               value="{{ old('weight', $weightLog->weight) }}" required>
                        @error('weight')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal</label>
                        <input type="date" name="logged_at"
                               class="form-control @error('logged_at') is-invalid @enderror"
                               value="{{ old('logged_at', \Carbon\Carbon::parse($weightLog->logged_at)->format('Y-m-d')) }}"
                               required>
                        @error('logged_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Catatan (opsional)</label>
                        <input type="text" name="note"
                               class="form-control"
                               value="{{ old('note', $weightLog->note) }}">
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Simpan
                        </button>
                        <a href="{{ route('weight-logs.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection