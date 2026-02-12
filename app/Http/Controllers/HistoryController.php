<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // ambil semua history log terbaru
        $historyData = HistoryLog::with(['user', 'item', 'category'])
            ->latest()
            ->get();

        // statistik hari ini
        $transactionsToday = HistoryLog::whereDate('created_at', $today)->count();

        $itemsInToday = HistoryLog::whereDate('created_at', $today)
            ->where('quantity', '>', 0)
            ->sum('quantity');

        $itemsOutToday = HistoryLog::whereDate('created_at', $today)
            ->where('quantity', '<', 0)
            ->sum('quantity');

        $itemsOutToday = abs($itemsOutToday);

        return view('admin.history', compact(
            'historyData',
            'transactionsToday',
            'itemsInToday',
            'itemsOutToday'
        ));
    }
}
