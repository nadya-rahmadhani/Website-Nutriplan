@extends('layouts.app')

@section('title', 'Meal Plan')
@section('page-title', 'Meal Plan Saya')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Meal Plan Saya</h5>
        <p class="text-muted small mb-0">Kelola jadwal makan harianmu</p>
    </div>
    <a href="{{ route('meal-plans.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Buat Meal Plan
    </a>
</div>

@if($mealPlans->isEmpty())
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-calendar-x fs-1 text-muted"></i>
            <h5 class="mt-3 text-muted">Belum ada meal plan</h5>
            <p class="text-muted">Buat meal plan pertamamu sekarang!</p>
            <a href="{{ route('meal-plans.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Buat Sekarang
            </a>
        </div>
    </div>
@else
    <div class="row g-3">
        @foreach($mealPlans as $plan)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="fw-bold mb-1">{{ $plan->name }}</h6>
                            <small class="text-muted">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $plan->created_at->format('d M Y') }}
                            </small>
                        </div>
                        <span class="badge bg-success-subtle text-success">
                            {{ $plan->schedules->count() }} menu
                        </span>
                    </div>

                    {{-- Preview hari --}}
                    @php
                        $days = $plan->schedules->pluck('day')->unique()->count();
                    @endphp
                    <p class="text-muted small mb-3">
                        <i class="bi bi-sun me-1"></i>{{ $days }} hari terjadwal
                    </p>

                    <div class="d-flex gap-2">
                        <a href="{{ route('meal-plans.show', $plan) }}"
                           class="btn btn-sm btn-primary flex-fill">
                            <i class="bi bi-eye me-1"></i>Lihat
                        </a>
                        <a href="{{ route('meal-plans.edit', $plan) }}"
                           class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('meal-plans.destroy', $plan) }}" method="POST"
                              onsubmit="return confirm('Hapus meal plan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $mealPlans->links() }}
    </div>
@endif

@endsection