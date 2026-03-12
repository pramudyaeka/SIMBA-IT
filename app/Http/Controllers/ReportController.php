<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Exports\InventoryExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil periode dari input, jika kosong gunakan bulan ini
        $period = $request->input('period', Carbon::now()->format('Y-m'));
        
        // Pecah periode (contoh: '2024-05') menjadi Tahun dan Bulan
        $parsedDate = Carbon::createFromFormat('Y-m', $period);

        // 2. Ambil data barang yang HANYA di-update pada bulan & tahun yang dipilih
        $reportData = Item::with('category')
            ->whereYear('updated_at', $parsedDate->year)
            ->whereMonth('updated_at', $parsedDate->month)
            ->orderBy('item_name', 'asc')
            ->get();

        // 3. Kalkulasi Statistik berdasarkan data yang difilter
        $totalStock      = $reportData->sum('stock');
        $totalItems      = $reportData->count();
        $outOfStockItems = $reportData->where('stock', '<=', 0)->count();
        $lowStockItems   = $reportData->where('stock', '>', 0)->where('stock', '<', 10)->count();

        // Ganti 'admin.reports' dengan path file view Anda (misal: 'admin.reports.index' jika di dalam folder)
        return view('admin.reports', compact(
            'period', 'reportData', 'totalStock', 'totalItems', 'lowStockItems', 'outOfStockItems'
        ));
    }

    public function exportExcel(Request $request)
    {
        $period = $request->input('period', Carbon::now()->format('Y-m'));
        $fileName = 'Inventory_Report_' . $period . '.xlsx';

        return Excel::download(new InventoryExport($period), $fileName);
    }

    public function exportPdf(Request $request)
    {
        $period = $request->input('period', Carbon::now()->format('Y-m'));
        $parsedDate = Carbon::createFromFormat('Y-m', $period);
        $formattedMonth = $parsedDate->format('F Y');

        // Filter data untuk PDF sama seperti di view
        $items = Item::with('category')
            ->whereYear('updated_at', $parsedDate->year)
            ->whereMonth('updated_at', $parsedDate->month)
            ->orderBy('item_name', 'asc')
            ->get();

        // Render view PDF
        $pdf = Pdf::loadView('admin.pdf-report', compact('items', 'formattedMonth'));
        
        return $pdf->download('Inventory_Report_' . $period . '.pdf');
    }
}