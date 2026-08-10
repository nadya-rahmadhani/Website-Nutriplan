@extends('layouts.app')

@section('title', 'Makanan Favorit')
@section('page-title', 'Makanan Favorit')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Makanan Favorit</h5>
        <p class="text-muted small mb-0">Makanan yang kamu simpan</p>
    </div>
    <a href="{{ route('foods.index') }}" class="btn btn-outline-primary btn-sm">
        <i class="bi bi-egg-fried me-1"></i>Browse Makanan
    </a>
</div>

@if($favorites->isEmpty())
    <div class="card">
        <div class="card-body text-center py-5 text-muted">
            <i class="bi bi-heart fs-1"></i>
            <p class="mt-3">Belum ada makanan favorit</p>
            <a href="{{ route('foods.index') }}" class="btn btn-primary">
                Browse Makanan
            </a>
        </div>
    </div>
@else
    <div class="row g-3">
        @foreach($favorites as $fav)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card h-100">
                <div style="height: 140px; overflow: hidden; border-radius: 12px 12px 0 0; background: #f0faf4;">
                    @if($fav->food->image)
                        <img src="{{ asset('images/foods/' . $fav->food->image) }}"
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
                            <h6 class="fw-semibold mb-1 small">{{ $fav->food->name }}</h6>
                            <span class="badge bg-light text-dark border small">
                                {{ $fav->food->category->name }}
                            </span>
                        </div>
                        <form action="{{ route('favorites.toggle', $fav->food->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm border-0 p-0" title="Hapus dari favorit">
                                <i class="bi bi-heart-fill text-danger fs-5"></i>
                            </button>
                        </form>
                    </div>
                    <div class="mt-2">
                        <span class="badge bg-success-subtle text-success">
                            <i class="bi bi-fire me-1"></i>{{ $fav->food->calories }} kal
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $favorites->links() }}
    </div>
@endif

@endsection