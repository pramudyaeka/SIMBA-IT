<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil periode dari input, jika kosong gunakan bulan ini
        $period = $request->input('period', Carbon::now()->format('Y-m'));
        $parsedDate = Carbon::createFromFormat('Y-m', $period);
        $formattedMonth = $parsedDate->format('F Y');

        $user = Auth::user();
        $isAdmin = $user->access_level === 'admin';

        // 2. Base Query: Ambil data history dan filter berdasarkan BULAN & TAHUN
        $query = HistoryLog::with(['user', 'item', 'category'])
            ->whereYear('created_at', $parsedDate->year)
            ->whereMonth('created_at', $parsedDate->month)
            ->latest();

        // 3. Terapkan Filter Hak Akses (RBAC)
        if (!$isAdmin) {
            $query->where('user_id', $user->id);
        }

        // 4. Eksekusi data untuk tabel
        $historyData = $query->get();

        // 5. Kalkulasi Statistik berdasarkan bulan yang dipilih (Bukan cuma hari ini)
        $transactionsCount = (clone $query)->count();

        $itemsInCount = (clone $query)
            ->where('quantity', '>', 0)
            ->sum('quantity');

        $itemsOutCount = abs((clone $query)
            ->where('quantity', '<', 0)
            ->sum('quantity'));

        return view('admin.history', compact(
            'historyData',
            'transactionsCount',
            'itemsInCount',
            'itemsOutCount',
            'period',
            'formattedMonth'
        ));
    }
}