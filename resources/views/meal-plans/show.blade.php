@extends('layouts.app')

@section('title', $mealPlan->name)
@section('page-title', $mealPlan->name)

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">{{ $mealPlan->name }}</h5>
        <small class="text-muted">Dibuat {{ $mealPlan->created_at->format('d M Y') }}</small>
    </div>
    <a href="{{ route('meal-plans.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

{{-- Form Tambah Menu --}}
<div class="card mb-4">
    <div class="card-header">
        <i class="bi bi-plus-circle me-2 text-success"></i>Tambah Menu
    </div>
    <div class="card-body">
        <form action="{{ route('meal-plans.schedules.store', $mealPlan) }}" method="POST">
            @csrf
            <input type="hidden" name="meal_plan_id" value="{{ $mealPlan->id }}">
            <div class="row g-2">
                <div class="col-md-3">
                    <select name="day" class="form-select" required>
                        <option value="">Pilih Hari</option>
                        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $day)
                            <option value="{{ $day }}" {{ old('day') == $day ? 'selected' : '' }}>{{ $day }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="meal_type" class="form-select" required>
                        <option value="">Waktu Makan</option>
                        <option value="sarapan">🌅 Sarapan</option>
                        <option value="siang">☀️ Makan Siang</option>
                        <option value="malam">🌙 Makan Malam</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" name="menu" class="form-control"
                           placeholder="Nama menu makanan"
                           value="{{ old('menu') }}" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-plus"></i> Tambah
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Jadwal per Hari --}}
@if($schedules->isEmpty())
    <div class="card">
        <div class="card-body text-center py-4 text-muted">
            <i class="bi bi-calendar-x fs-3"></i>
            <p class="mt-2">Belum ada jadwal. Tambahkan menu di atas!</p>
        </div>
    </div>
@else
    @foreach($schedules as $day => $items)
    <div class="card mb-3">
        <div class="card-header fw-semibold">
            <i class="bi bi-calendar-day me-2 text-success"></i>{{ $day }}
            <span class="badge bg-success-subtle text-success ms-2">{{ $items->count() }} menu</span>
        </div>
        <div class="card-body p-0">
            @foreach($items as $schedule)
            <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">

                {{-- Waktu & Menu --}}
                <div class="d-flex align-items-center gap-3">
                    <span class="fs-5">
                        @if($schedule->meal_type == 'sarapan') 🌅
                        @elseif($schedule->meal_type == 'siang') ☀️
                        @else 🌙
                        @endif
                    </span>
                    <div>
                        <div class="small text-muted">{{ ucfirst($schedule->meal_type) }}</div>
                        <div class="fw-semibold">{{ $schedule->menu }}</div>
                    </div>
                </div>

                {{-- Aksi --}}
                <div class="d-flex align-items-center gap-2">

                    {{-- Toggle Status --}}
                    <form action="{{ route('schedules.toggle', $schedule) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit"
                            class="btn btn-sm {{ $schedule->is_done ? 'btn-success' : 'btn-outline-secondary' }}">
                            <i class="bi {{ $schedule->is_done ? 'bi-check-circle-fill' : 'bi-circle' }} me-1"></i>
                            {{ $schedule->is_done ? 'Selesai' : 'Belum' }}
                        </button>
                    </form>

                    {{-- Tombol Edit --}}
                    <button type="button" class="btn btn-sm btn-outline-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#editModal"
                        data-id="{{ $schedule->id }}"
                        data-day="{{ $schedule->day }}"
                        data-meal_type="{{ $schedule->meal_type }}"
                        data-menu="{{ $schedule->menu }}">
                        <i class="bi bi-pencil"></i>
                    </button>

                    {{-- Hapus --}}
                    <form action="{{ route('schedules.destroy', $schedule) }}" method="POST"
                          id="deleteForm{{ $schedule->id }}">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-sm btn-outline-danger"
                                onclick="showDeleteModal({{ $schedule->id }}, '{{ $schedule->menu }}')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>

                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
@endif

{{-- Modal Konfirmasi Hapus --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 380px;">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-body text-center p-4">
                <div style="font-size: 3rem; margin-bottom: 0.75rem;">🗑️</div>
                <h5 class="fw-bold mb-2">Hapus Menu?</h5>
                <p class="text-muted mb-0" id="deleteMenuName" style="font-size: 0.9rem;"></p>
                <p class="text-muted" style="font-size: 0.85rem;">Tindakan ini tidak bisa dibatalkan.</p>
                <div class="d-flex gap-2 justify-content-center mt-3">
                    <button type="button" class="btn btn-outline-secondary px-4"
                            data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger px-4"
                            id="confirmDeleteBtn">Ya, Hapus!</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Hari</label>
                        <select name="day" id="editDay" class="form-select" required>
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $d)
                                <option value="{{ $d }}">{{ $d }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Waktu Makan</label>
                        <select name="meal_type" id="editMealType" class="form-select" required>
                            <option value="sarapan">🌅 Sarapan</option>
                            <option value="siang">☀️ Makan Siang</option>
                            <option value="malam">🌙 Makan Malam</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Menu</label>
                        <input type="text" name="menu" id="editMenu" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let deleteFormId = null;

    function showDeleteModal(id, menuName) {
        deleteFormId = id;
        document.getElementById('deleteMenuName').textContent = '"' + menuName + '"';
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (deleteFormId) {
            document.getElementById('deleteForm' + deleteFormId).submit();
        }
    });

    // Isi modal edit dengan data schedule
    document.getElementById('editModal').addEventListener('show.bs.modal', function(e) {
        const btn      = e.relatedTarget;
        const id       = btn.getAttribute('data-id');
        const day      = btn.getAttribute('data-day');
        const mealType = btn.getAttribute('data-meal_type');
        const menu     = btn.getAttribute('data-menu');

        document.getElementById('editForm').action = '/schedules/' + id;
        document.getElementById('editDay').value      = day;
        document.getElementById('editMealType').value = mealType;
        document.getElementById('editMenu').value     = menu;
    });
</script>
@endpush