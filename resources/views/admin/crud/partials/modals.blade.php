 {{-- 1. Modal Add Stock (Quick Scan/Search) --}}
    <div id="addStockModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity opacity-0" id="addStockModalBackdrop" onclick="toggleModal('addStockModal', false)"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md opacity-0 translate-y-4 sm:translate-y-0 scale-95" id="addStockModalPanel">
                    
                    <div class="bg-white px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Quick Add Stock</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Scan or search to add stock.</p>
                        </div>
                        <button type="button" onclick="toggleModal('addStockModal', false)" class="text-slate-400 hover:text-slate-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="px-6 py-5">
                        <div id="as-step1">
                            <div id="as-cameraArea" class="rounded-2xl overflow-hidden border-2 border-dashed border-slate-300 bg-slate-50 p-2">
                                <div id="as-qr-reader" class="w-full"></div>
                            </div>

                            {{-- Manual Search Area --}}
                            <div id="as-manualArea" class="hidden relative">
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Search Item</label>
                                <input type="text" id="as-manualInput" onkeyup="asSearchItem()" placeholder="Type item name..." autocomplete="off"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                                <ul id="as-searchResultList" class="w-full bg-white border border-slate-200 rounded-lg shadow-sm mt-2 max-h-60 overflow-y-auto hidden mb-3"></ul>
                            </div>

                            <div class="text-center mt-4">
                                <button type="button" onclick="asToggleManual()" id="as-btnToggle" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">
                                    Camera Issue? Search Manually
                                </button>
                            </div>
                        </div>

                        <div id="as-step2" class="hidden space-y-4">
                            <div class="p-4 bg-emerald-50 rounded-xl text-center border border-emerald-100">
                                <p class="text-xs text-emerald-600 font-semibold uppercase">Adding Stock For</p>
                                <h4 id="as-itemName" class="text-xl font-bold text-slate-800">Item Name</h4>
                                <p id="as-itemStock" class="text-sm text-slate-500">Current: 0</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Good Qty</label>
                                    <input type="number" id="as-qty" value="1" min="1" class="w-full px-4 py-2.5 text-center text-xl rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 font-bold text-emerald-700">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Reject Qty (Optional)</label>
                                    <input type="number" id="as-reject-qty" value="0" min="0" class="w-full px-4 py-2.5 text-center text-xl rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 font-bold text-rose-600">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Reference / Note</label>
                                <textarea id="as-note" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-sm resize-none" placeholder="e.g. Restock from Supplier A"></textarea>
                            </div>
                            
                            <div class="flex gap-3 pt-2">
                                <button type="button" onclick="asBackStep1()" class="w-full py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl">Back</button>
                                <button type="button" onclick="asSubmit()" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow-md">Confirm Add</button>
                            </div>
                        </div>
                    </div>

                    <form id="as-form" action="{{ route('items.transaction') ?? '#' }}" method="POST" class="hidden">
                        @csrf
                        <input type="hidden" name="type" value="add">
                        <input type="hidden" name="identifier" id="as-id">
                        <input type="hidden" name="qty" id="as-form-qty">
                        <input type="hidden" name="reject_qty" id="as-form-reject-qty">
                        <input type="hidden" name="note" id="as-form-note">
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Modal Add Item (FIXED name="units") --}}
    <div id="addItemModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity opacity-0" id="addItemModalBackdrop" onclick="toggleModal('addItemModal', false)"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg opacity-0 translate-y-4 sm:translate-y-0 scale-95" id="addItemModalPanel">
                    
                    <div class="bg-white px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Add New Item</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Enter item details to update inventory.</p>
                        </div>
                        <button type="button" onclick="toggleModal('addItemModal', false)" class="text-slate-400 hover:text-slate-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('items.store') }}" method="POST">
                        @csrf
                        <div class="px-6 py-6 space-y-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Item Name <span class="text-rose-500">*</span></label>
                                <input type="text" name="item_name" required placeholder="e.g. Macbook Pro M3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder:text-slate-400 text-sm font-medium text-slate-700">
                            </div>
                            
                            <div class="grid grid-cols-3 gap-5">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Part Number</label>
                                    <input type="text" name="part_number" placeholder="PN-2024-XXX" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder:text-slate-400 text-sm font-medium text-slate-700">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Initial Stock <span class="text-rose-500">*</span></label>
                                    <div class="relative">
                                        <input type="number" name="stock" required min="0" placeholder="0" class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder:text-slate-400 text-sm font-medium text-slate-700">
                                        <span class="absolute inset-y-0 right-4 flex items-center text-xs text-slate-400 font-medium">Qty</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Maximum Stock <span class="text-rose-500">*</span></label>
                                    <div class="relative">
                                        <input type="number" name="max_stock" required min="1" placeholder="0" class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder:text-slate-400 text-sm font-medium text-slate-700">
                                        <span class="absolute inset-y-0 right-4 flex items-center text-xs text-slate-400 font-medium">Qty</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Unit (Satuan)</label>
                                    <div class="relative">
                                        <select name="units" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm font-medium text-slate-700 appearance-none cursor-pointer">
                                            <option value="pcs">Pcs (Pieces)</option>
                                            <option value="box">Box</option>
                                            <option value="pack">Pack</option>
                                            <option value="roll">Roll</option>
                                            <option value="kg">Kg</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-500">
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Category <span class="text-rose-500">*</span></label>
                                    <div class="relative">
                                        <select name="category_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm font-medium text-slate-700 appearance-none cursor-pointer">
                                            <option value="" disabled selected>Select Category...</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-500">
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Description / Notes</label>
                                <textarea name="description" rows="3" placeholder="Add additional details..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder:text-slate-400 text-sm font-medium text-slate-700 resize-none"></textarea>
                            </div>
                        </div>
                        
                        <div class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-3 rounded-b-3xl border-t border-slate-100">
                            <button type="submit" class="inline-flex w-full sm:w-auto justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:shadow-indigo-300 transition-all">Save Item</button>
                            <button type="button" onclick="toggleModal('addItemModal', false)" class="inline-flex w-full sm:w-auto justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm border border-slate-200 hover:bg-slate-50 transition-all">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. Modal Edit Item (FIXED name="units") --}}
    <div id="editItemModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity opacity-0" id="editItemModalBackdrop" onclick="toggleModal('editItemModal', false)"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg opacity-0 translate-y-4 sm:translate-y-0 scale-95" id="editItemModalPanel">
                    
                    <div class="bg-white px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Edit Item</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Update item information and stock.</p>
                        </div>
                        <button type="button" onclick="toggleModal('editItemModal', false)" class="text-slate-400 hover:text-slate-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg> 
                        </button>
                    </div>

                    <form id="editItemForm" method="POST">
                        @csrf 
                        @method('PUT')
                        <div class="px-6 py-6 space-y-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Item Name <span class="text-rose-500">*</span></label>
                                <input type="text" id="edit_item_name" name="item_name" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm font-medium text-slate-700">
                            </div>
                            
                            <div class="grid grid-cols-3 gap-5">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Part Number</label>
                                    <input type="text" id="edit_part_number" name="part_number" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm font-medium text-slate-700">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Stock <span class="text-rose-500">*</span></label>
                                    <input type="number" id="edit_stock" name="stock" required min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm font-medium text-slate-700">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Max. Stock <span class="text-rose-500">*</span></label>
                                    <input type="number" id="edit_max_stock" name="max_stock" required min="1" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm font-medium text-slate-700">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Unit (Satuan)</label>
                                    <div class="relative">
                                        <select id="edit_units" name="units" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm font-medium text-slate-700 appearance-none cursor-pointer">
                                            <option value="pcs">Pcs (Pieces)</option>
                                            <option value="box">Box</option>
                                            <option value="pack">Pack</option>
                                            <option value="roll">Roll</option>
                                            <option value="kg">Kg</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-500">
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Category <span class="text-rose-500">*</span></label>
                                    <div class="relative">
                                        <select id="edit_category_id" name="category_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm font-medium text-slate-700 appearance-none cursor-pointer">
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-500">
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Description / Notes</label>
                                <textarea id="edit_description" name="description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm font-medium text-slate-700 resize-none"></textarea>
                            </div>
                        </div>

                        <div class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-3 rounded-b-3xl border-t border-slate-100">
                            <button type="submit" class="inline-flex w-full sm:w-auto justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:shadow-indigo-300 transition-all">Update Item</button>
                            <button type="button" onclick="toggleModal('editItemModal', false)" class="inline-flex w-full sm:w-auto justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm border border-slate-200 hover:bg-slate-50 transition-all">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- 4. Modal Delete Item --}}
    <div id="deleteItemModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity opacity-0" id="deleteItemModalBackdrop" onclick="toggleModal('deleteItemModal', false)"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md opacity-0 translate-y-4 sm:translate-y-0 scale-95" id="deleteItemModalPanel">
                    
                    <div class="bg-white px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Delete Item</h3>
                            <p class="text-xs text-slate-500 mt-0.5">This action cannot be undone.</p>
                        </div>
                        <button type="button" onclick="toggleModal('deleteItemModal', false)" class="text-slate-400 hover:text-slate-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg> 
                        </button>
                    </div>

                    <form id="deleteItemForm" method="POST">
                        @csrf 
                        @method('DELETE')
                        <div class="px-6 py-6">
                            <p class="text-sm text-slate-600">Are you sure want to delete item: <span class="font-bold text-rose-600" id="deleteItemName"></span> ?</p>
                        </div>
                        <div class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-3 rounded-b-3xl border-t border-slate-100">
                            <button type="submit" class="inline-flex w-full sm:w-auto justify-center rounded-xl bg-rose-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-rose-200 hover:bg-rose-700 hover:shadow-rose-300 transition-all">Yes, Delete</button>
                            <button type="button" onclick="toggleModal('deleteItemModal', false)" class="inline-flex w-full sm:w-auto justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm border border-slate-200 hover:bg-slate-50 transition-all">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- 5. Modal QR Code --}}
    <div id="qrItemModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity opacity-0" id="qrItemModalBackdrop" onclick="toggleModal('qrItemModal', false)"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-sm opacity-0 translate-y-4 sm:translate-y-0 scale-95" id="qrItemModalPanel">
                    
                    <div class="bg-white px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Item QR Code</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Scan to view or update stock.</p>
                        </div>
                        <button type="button" onclick="toggleModal('qrItemModal', false)" class="text-slate-400 hover:text-slate-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="px-6 py-8 flex flex-col items-center justify-center">
                        <div class="p-4 bg-white rounded-2xl shadow-sm border border-slate-100 mb-4 ring-4 ring-slate-50">
                            <img id="qrCodeImage" src="" alt="QR Code" class="w-48 h-48 object-contain">
                        </div>
                        <h4 id="qrItemName" class="text-lg font-bold text-slate-800 text-center"></h4>
                        <p id="qrItemCode" class="text-sm font-mono text-slate-500 mt-1 text-center bg-slate-100 px-3 py-1 rounded-md"></p>
                    </div>

                    <div class="bg-slate-50 px-6 py-4 flex flex-col sm:flex-row-reverse gap-3 rounded-b-3xl border-t border-slate-100">
                        <button type="button" onclick="downloadQR()" class="inline-flex w-full sm:w-auto justify-center items-center gap-2 rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:shadow-emerald-300 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg> 
                            Download QR
                        </button>
                        <button type="button" onclick="toggleModal('qrItemModal', false)" class="inline-flex w-full sm:w-auto justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm border border-slate-200 hover:bg-slate-50 transition-all">Close</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- 6. Modal Report Defect --}}
    <div id="defectModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity opacity-0" id="defectModalBackdrop" onclick="toggleModal('defectModal', false)"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div id="defectModalPanel" class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm opacity-0 translate-y-4 sm:translate-y-0 scale-95">
                    
                    <div class="bg-orange-50 px-6 py-4 border-b border-orange-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-orange-800">Report Defect Item</h3>
                            <p class="text-xs text-orange-600 mt-0.5">Move good stock to damaged/reject.</p>
                        </div>
                    </div>

                    <form action="{{ route('items.transaction') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="defect">
                        <input type="hidden" name="identifier" id="defect_item_id">

                        <div class="px-6 py-5 space-y-4">
                            <div class="text-center mb-2">
                                <p class="text-sm text-slate-500">Item Name</p>
                                <h4 class="font-bold text-lg text-slate-800" id="defect_item_name">Name</h4>
                                <p class="text-xs text-slate-500 mt-1">Available Good Stock: <span id="defect_max_stock" class="font-bold">0</span></p>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Damaged Quantity</label>
                                <input type="number" name="qty" id="defect_qty" required min="1" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 text-center text-xl font-bold text-orange-600">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Reason / Note <span class="text-rose-500">*</span></label>
                                <textarea name="note" required rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 text-sm resize-none" placeholder="e.g. Broken glass, missing parts..."></textarea>
                            </div>
                        </div>

                        <div class="bg-slate-50 px-6 py-4 flex gap-3 rounded-b-3xl border-t border-slate-100">
                            <button type="button" onclick="toggleModal('defectModal', false)" class="flex-1 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold text-sm rounded-xl hover:bg-slate-50 transition">Cancel</button>
                            <button type="submit" class="flex-1 px-4 py-2.5 bg-orange-600 text-white font-bold text-sm rounded-xl hover:bg-orange-700 transition shadow-lg shadow-orange-200">Confirm Defect</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- 7. Modal Resolve Defect --}}
    <div id="resolveModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity opacity-0" id="resolveModalBackdrop" onclick="toggleModal('resolveModal', false)"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div id="resolveModalPanel" class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm opacity-0 translate-y-4 sm:translate-y-0 scale-95">
                    
                    <div class="bg-teal-50 px-6 py-4 border-b border-teal-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-teal-800">Resolve Defect Item</h3>
                            <p class="text-xs text-teal-600 mt-0.5">Clear damaged stock (Write-off / Return).</p>
                        </div>
                    </div>

                    <form action="{{ route('items.transaction') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="resolve_defect">
                        <input type="hidden" name="identifier" id="resolve_item_id">

                        <div class="px-6 py-5 space-y-4">
                            <div class="text-center mb-2">
                                <p class="text-sm text-slate-500">Item Name</p>
                                <h4 class="font-bold text-lg text-slate-800" id="resolve_item_name">Name</h4>
                                <p class="text-xs text-slate-500 mt-1">Pending Defect Items: <span id="resolve_max_stock" class="font-bold text-rose-500">0</span></p>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Qty to Resolve</label>
                                <input type="number" name="qty" id="resolve_qty" required min="1" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-center text-xl font-bold text-teal-700">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Resolution Action <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <select name="note" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm mb-2 appearance-none cursor-pointer">
                                        <option value="Returned to Vendor/Supplier">Return to Vendor</option>
                                        <option value="Written off / Destroyed">Write-off (Dibuang)</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-4 top-0 flex items-center pointer-events-none text-slate-500 h-[42px]">
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 px-6 py-4 flex gap-3 rounded-b-3xl border-t border-slate-100">
                            <button type="button" onclick="toggleModal('resolveModal', false)" class="flex-1 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold text-sm rounded-xl hover:bg-slate-50 transition">Cancel</button>
                            <button type="submit" class="flex-1 px-4 py-2.5 bg-teal-600 text-white font-bold text-sm rounded-xl hover:bg-teal-700 transition shadow-lg shadow-teal-200">Confirm Resolve</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
