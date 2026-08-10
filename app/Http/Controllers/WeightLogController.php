<?php

namespace App\Http\Controllers;

use App\Models\WeightLog;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class WeightLogController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        // Semua data untuk chart (urut tanggal)
        $logs = WeightLog::where('user_id', $user->id)
                    ->orderBy('logged_at')
                    ->get();

        $chartLabels = $logs->pluck('logged_at')
                        ->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M Y'))
                        ->toArray();
        $chartData   = $logs->pluck('weight')->toArray();

        // Data untuk tabel (paginate, urut terbaru)
        $logsPaginated = WeightLog::where('user_id', $user->id)
                            ->latest('logged_at')
                            ->paginate(10);

        $latestWeight = $logs->last()?->weight ?? $user->current_weight;

        return view('weight-logs.index', compact(
            'logsPaginated', 'chartLabels', 'chartData', 'latestWeight'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'weight'    => 'required|numeric|min:1|max:300',
            'logged_at' => 'required|date',
            'note'      => 'nullable|string|max:255',
        ]);

        WeightLog::create([
            'user_id'   => auth()->id(),
            'weight'    => $request->weight,
            'logged_at' => $request->logged_at,
            'note'      => $request->note,
        ]);

        return redirect()->route('weight-logs.index')
                ->with('success', 'Berat badan berhasil dicatat!');
    }

    public function edit(WeightLog $weightLog): View
    {
        abort_if($weightLog->user_id !== auth()->id(), 403);
        return view('weight-logs.edit', compact('weightLog'));
    }

    public function update(Request $request, WeightLog $weightLog): RedirectResponse
    {
        abort_if($weightLog->user_id !== auth()->id(), 403);

        $request->validate([
            'weight'    => 'required|numeric|min:1|max:300',
            'logged_at' => 'required|date',
            'note'      => 'nullable|string|max:255',
        ]);

        $weightLog->update($request->all());

        return redirect()->route('weight-logs.index')
                ->with('success', 'Data berhasil diubah!');
    }

    public function destroy(WeightLog $weightLog): RedirectResponse
    {
        abort_if($weightLog->user_id !== auth()->id(), 403);
        $weightLog->delete();
        return redirect()->route('weight-logs.index')
                ->with('success', 'Data berhasil dihapus!');
    }
}