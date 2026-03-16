<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\HistoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemsController extends Controller
{
    /**
     * FUNGSI BANTUAN (HELPER)
     * Untuk mencegah penulisan kode berulang di index() dan dashboard()
     */
    private function getInventoryStats($items)
    {
        return [
            'totalItems'      => $items->sum('stock'),
            'outOfStockCount' => $items->where('stock', 0)->count(),
            'lowStockCount'   => $items->filter(fn($item) => $item->stock > 0 && $item->stock <= ($item->max_stock * 0.5))->count(),
            'inStockCount'    => $items->filter(fn($item) => $item->stock > ($item->max_stock * 0.5))->count(),
        ];
    }

    public function index()
    {
        $items = Item::with('category')->latest()->get();
        $categories = Category::all();
        $stats = $this->getInventoryStats($items); 

        return view('admin.crud.item.itemsManage', array_merge(compact('items', 'categories'), $stats));
    }

    public function dashboard()
    {
        $items = Item::with('category')->latest()->get();
        $totalCategories = Category::count();
        $stats = $this->getInventoryStats($items); 

        return view('admin.dashboard-admin', array_merge(compact('items', 'totalCategories'), $stats));
    }

    public function processTransaction(Request $request)
    {
        $request->validate([
            'identifier' => 'required',
            'type'       => 'required|in:take,add,defect,resolve_defect',
            'qty'        => 'required|integer|min:1',
            'reject_qty' => 'nullable|integer|min:0',
            'note'       => 'nullable|string|max:255'
        ]);

        $item = Item::find($request->identifier);

        if (!$item) {
            return redirect()->back()->with('error', 'Barang tidak ditemukan!');
        }

        $qty = $request->qty;
        $rejectQty = $request->reject_qty ?? 0;
        $userNote = $request->note;
        $itemName = $item->item_name; // Snapshot nama barang

        $logData = [
            'user_id'     => Auth::id(),
            'item_id'     => $item->id,
            'category_id' => $item->category_id,
            'units'       => $item->units, 
        ];

        if ($request->type === 'take') {
            if ($item->stock < $qty) return redirect()->back()->with('error', 'Stok tidak mencukupi!');
            
            $item->decrement('stock', $qty); 
            
            HistoryLog::create(array_merge($logData, [
                'action'   => 'Usage',
                'quantity' => -$qty,
                'note'     => $userNote ?: "Penggunaan stok: {$itemName}",
            ]));

        } elseif ($request->type === 'add') {
            $item->increment('stock', $qty);
            $item->increment('damaged_stock', $rejectQty);

            HistoryLog::create(array_merge($logData, [
                'action'   => 'Restock',
                'quantity' => $qty,
                'note'     => $userNote ?: "Penambahan stok: {$itemName}",
            ]));

            if ($rejectQty > 0) {
                HistoryLog::create(array_merge($logData, [
                    'action'   => 'Rejected (QC)',
                    'quantity' => $rejectQty,
                    'note'     => $userNote ? "Rejected QC ({$userNote})" : "Barang cacat ditemukan saat restock: {$itemName}",
                ]));
            }

        } elseif ($request->type === 'defect') {
            if ($item->stock < $qty) return redirect()->back()->with('error', 'Stok bagus tidak mencukupi!');
            
            $item->decrement('stock', $qty);
            $item->increment('damaged_stock', $qty);

            HistoryLog::create(array_merge($logData, [
                'action'   => 'Mark Defect',
                'quantity' => -$qty,
                'note'     => $userNote ?: "Dipindahkan ke stok rusak: {$itemName}",
            ]));

        } elseif ($request->type === 'resolve_defect') {
            if ($item->damaged_stock < $qty) return redirect()->back()->with('error', 'Stok rusak tidak mencukupi!');
            
            $item->decrement('damaged_stock', $qty);

            HistoryLog::create(array_merge($logData, [
                'action'   => 'Resolve Defect',
                'quantity' => -$qty,
                'note'     => $userNote ?: "Stok rusak diselesaikan/dibuang: {$itemName}",
            ]));
        }

        return redirect()->back()->with('success', "Transaksi berhasil diproses!");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name'   => 'required|string|max:255',
            'part_number' => 'nullable|string|max:255|unique:items,part_number',
            'category_id' => 'required|exists:categories,id',
            'stock'       => 'required|integer|min:0',
            'units'       => 'required|string|max:50',
            'max_stock'   => 'required|integer|min:0',
        ]);

        $item = Item::create($validated); 

        HistoryLog::create([
            'user_id'     => Auth::id(),
            'item_id'     => $item->id,
            'category_id' => $item->category_id,
            'action'      => 'Create',
            'units'       => $item->units,
            'quantity'    => $item->stock,
            'note'        => "Registrasi barang baru: {$item->item_name}",
        ]);

        return redirect()->back()->with('success', 'Item created successfully!');
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        $oldStock = $item->stock;

        $validated = $request->validate([
            'item_name'   => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock'       => 'required|integer|min:0',
            'max_stock'   => 'required|integer|min:0',
            'units'       => 'required|string|max:50',
            'part_number' => 'nullable|string|max:255|unique:items,part_number,' . $id,
            'description' => 'nullable|string'
        ]);

        $item->update($validated); 

        $diff = $item->stock - $oldStock;

        $logData = [
            'user_id'     => Auth::id(),
            'item_id'     => $item->id,
            'category_id' => $item->category_id,
            'units'       => $item->units,
        ];

        if ($diff != 0) {
            HistoryLog::create(array_merge($logData, [
                'action'   => $diff > 0 ? 'Restock' : 'Usage',
                'quantity' => $diff,
                'note'     => "Update stok via Edit Data: {$item->item_name}",
            ]));
        } else {
            HistoryLog::create(array_merge($logData, [
                'action'   => 'Update',
                'quantity' => 0,
                'note'     => "Memperbarui rincian barang: {$item->item_name}",
            ]));
        }

        return redirect()->back()->with('success', 'Item updated successfully!');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        
        $itemName = $item->item_name;
        $partNumber = $item->part_number ?? 'Tidak ada PN';

        HistoryLog::create([
            'user_id' => Auth::id(),
            'item_id' => null, 
            'action'  => 'Delete Item',
            'quantity'=> 0,
            'note'    => "Item Deleted Permanent: {$itemName} ({$partNumber})"
        ]);

        $item->delete();

        return redirect()->back()->with('success', 'Item deleted successfully!');
    }
}