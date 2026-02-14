<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category; // Jangan lupa import ini untuk dropdown modal
use Illuminate\Http\Request;
use App\Models\HistoryLog;
use Illuminate\Support\Facades\Auth;

class ItemsController extends Controller
{
    public function index()
{
    $items = Item::with('category')->latest()->get();
    $categories = Category::all();

    // Hitung Statistik
    $totalItems = $items->sum('stock');
    $lowStockCount = $items->where('stock', '<', 10)->where('stock', '>', 0)->count();
    $outOfStockCount = $items->where('stock', 0)->count();
    $inStockCount = $items->where('stock', '>', 0)->count();

    return view('admin.crud.item.itemsManage', compact(
        'items',
        'categories',
        'totalItems',
        'lowStockCount',
        'outOfStockCount',
        'inStockCount'
    ));
}

// Memuat halaman Dashboard
    public function dashboard()
    {
        $items = Item::with('category')->latest()->get();
        $totalCategories = Category::count();

        // Hitung Statistik
        $totalItems = $items->sum('stock');
        $lowStockCount = $items->where('stock', '<', 10)->where('stock', '>', 0)->count();
        $outOfStockCount = $items->where('stock', 0)->count();
        $inStockCount = $items->where('stock', '>', 0)->count();

        // Mengarah ke view dashboard-admin
        return view('admin.dashboard-admin', compact(
            'items',
            'totalCategories',
            'totalItems',
            'lowStockCount',
            'outOfStockCount',
            'inStockCount'
        ));
    }

    // Memproses form dari Scanner QR Code
    public function processTransaction(Request $request)
    {
        $request->validate([
            'identifier' => 'required',
            'type' => 'required|in:take,add',
            'qty' => 'required|integer|min:1'
        ]);

        // Cari item berdasarkan ID (atau part_number jika Anda menggunakannya)
        $item = Item::find($request->identifier);
        
        if (!$item) {
            // Jika Anda menambahkan kolom part_number di database, nyalakan baris di bawah ini:
            // $item = Item::where('part_number', $request->identifier)->first();
            
            if (!$item) {
                return redirect()->back()->with('error', 'Barang tidak ditemukan!');
            }
        }

        $qty = $request->qty;

        if ($request->type === 'take') {
            if ($item->stock < $qty) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi untuk diambil!');
            }
            $item->stock -= $qty;
            $action = 'Usage';
            $note = 'Stock taken via QR Scanner';
        } else {
            $item->stock += $qty;
            $action = 'Restock';
            $note = 'Stock added via QR Scanner';
        }

        $item->save();

        // Catat ke HistoryLog
        HistoryLog::create([
            'user_id' => Auth::id(),
            'item_id' => $item->id,
            'category_id' => $item->category_id,
            'action' => $action,
            'quantity' => ($request->type === 'take' ? -$qty : $qty), // Negatif jika diambil
            'note' => $note,
        ]);

        return redirect()->back()->with('success', "Transaksi berhasil! Stok {$item->item_name} telah diperbarui.");
    }


    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            // Validasi ID, pastikan id-nya ada di tabel categories
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
        ]);

        $item = Item::create($request->all());

        HistoryLog::create([
        'user_id' => Auth::id(),
        'item_id' => $item->id,
        'category_id' => $item->category_id,
        'action' => 'Create',
        'quantity' => $item->stock,
        'note' => 'New item created',
    ]);

        return redirect()->back()->with('success', 'Item created successfully!'); // ... (Kode store simpan data yang sudah Anda buat) ...
    }

    public function update(Request $request, $id)
{
    $item = Item::findOrFail($id);

    $oldStock = $item->stock;

    $request->validate([
        'item_name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'stock' => 'required|integer|min:0',
    ]);

    $item->update($request->all());

    $newStock = $item->stock;
    $diff = $newStock - $oldStock;

    if ($diff != 0) {
        HistoryLog::create([
            'user_id' => Auth::id(),
            'item_id' => $item->id,
            'category_id' => $item->category_id,
            'action' => $diff > 0 ? 'Restock' : 'Usage',
            'quantity' => $diff,
            'note' => 'Stock updated via edit',
        ]);
    } else {
        HistoryLog::create([
            'user_id' => Auth::id(),
            'item_id' => $item->id,
            'category_id' => $item->category_id,
            'action' => 'Update',
            'quantity' => 0,
            'note' => 'Item updated (no stock change)',
        ]);
    }

    return redirect()->back()->with('success', 'Item updated successfully!');
}

    public function destroy($id)
{
    $item = Item::findOrFail($id);

    HistoryLog::create([
        'user_id' => Auth::id(),
        'item_id' => $item->id,
        'category_id' => $item->category_id,
        'action' => 'Delete',
        'quantity' => 0,
        'note' => 'Item deleted',
    ]);

    $item->delete();

    return redirect()->back()->with('success', 'Item deleted successfully!');
}

}
