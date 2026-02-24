<?php

namespace App\Http\Controllers;

use App\Models\Item; // Pastikan ini mengarah ke model barang Anda
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil input periode (Y-m), default ke bulan ini jika kosong
        $period = $request->input('period', Carbon::now()->format('Y-m'));

        // Pisahkan tahun dan bulan dari input
        [$year, $month] = explode('-', $period);

        // 2. Tarik data dari database (Contoh filter berdasarkan updated_at)
        // Sesuaikan nama field 'category' dan 'status' dengan yang ada di tabel Anda
        // 2. Tarik data dari database (Gunakan Eager Loading 'with')
        $reportData = Item::with('category') // <-- TAMBAHKAN INI
            ->whereYear('updated_at', $year)
            ->whereMonth('updated_at', $month)
            ->orderBy('updated_at', 'desc')
            ->get();

        // 3. Hitung Statistik
        $totalItems = $reportData->count();
        $totalStock = $reportData->sum('stock'); // Pastikan 'stock' adalah nama kolom di database
        $lowStockItems = $reportData->where('stock', '<', 10)->where('stock', '>', 0)->count();
        $outOfStockItems = $reportData->where('stock', 0)->count();

        // 4. Kirim data ke view
        return view('admin.reports', compact(
            'reportData',
            'totalItems',
            'totalStock',
            'lowStockItems',
            'outOfStockItems',
            'period' // Kirim kembali periode untuk value input type="month"
        ));
    }
}
