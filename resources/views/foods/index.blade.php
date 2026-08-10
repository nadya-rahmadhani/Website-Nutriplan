@extends('layouts.app')

@section('title', 'Browse Makanan')
@section('page-title', 'Browse Makanan')

@section('content')

{{-- Search & Filter --}}
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('foods.index') }}">
            <div class="row g-2">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control"
                               placeholder="Cari makanan..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="category_id" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="sort" class="form-select">
                        <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="name_asc" {{ $sort == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="calories_asc" {{ $sort == 'calories_asc' ? 'selected' : '' }}>Kalori Terendah</option>
                        <option value="calories_desc" {{ $sort == 'calories_desc' ? 'selected' : '' }}>Kalori Tertinggi</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Reset filter --}}
@if(request('search') || request('category_id'))
    <div class="mb-3">
        <a href="{{ route('foods.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-x-circle me-1"></i>Reset Filter
        </a>
        <span class="text-muted small ms-2">{{ $foods->total() }} hasil ditemukan</span>
    </div>
@endif

{{-- Grid Makanan --}}
@if($foods->isEmpty())
    <div class="card">
        <div class="card-body text-center py-5 text-muted">
            <i class="bi bi-search fs-1"></i>
            <p class="mt-3">Makanan tidak ditemukan</p>
        </div>
    </div>
@else
    <div class="row g-3">
        @foreach($foods as $food)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card h-100">
                {{-- Gambar --}}
                <div style="height: 140px; overflow: hidden; border-radius: 12px 12px 0 0; background: #f0faf4;">
                    @if($food->image)
                        <img src="{{ asset('images/foods/' . $food->image) }}"
                             class="w-100 h-100" style="object-fit: cover;">
                    @else
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                            <i class="bi bi-egg-fried fs-1 text-muted"></i>
                        </div>
                    @endif
                </div>

                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="fw-semibold mb-1 small">{{ $food->name }}</h6>
                            <span class="badge bg-light text-dark border small">
                                {{ $food->category->name }}
                            </span>
                        </div>
                        {{-- Tombol Favorit --}}
                        <form action="{{ route('favorites.toggle', $food->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="btn btn-sm border-0 p-0"
                                title="{{ in_array($food->id, $favoriteIds) ? 'Hapus dari favorit' : 'Tambah ke favorit' }}">
                                <i class="bi {{ in_array($food->id, $favoriteIds) ? 'bi-heart-fill text-danger' : 'bi-heart' }} fs-5"></i>
                            </button>
                        </form>
                    </div>
                    <div class="mt-2">
                        <span class="badge bg-success-subtle text-success">
                            <i class="bi bi-fire me-1"></i>{{ $food->calories }} kal
                        </span>
                    </div>
                    @if($food->description)
                        <p class="text-muted small mt-2 mb-0" style="font-size: 0.75rem;">
                            {{ Str::limit($food->description, 50) }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $foods->links() }}
    </div>
@endif

@endsection