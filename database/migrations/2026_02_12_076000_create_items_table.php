<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('items', function (Blueprint $table) {
        $table->id();
        
        // 1. Item Name (Wajib)
        $table->string('item_name'); 
        
        // 2. Part Number (Opsional, tapi biasanya unik jika diisi)
        $table->string('part_number')->nullable(); 
        
        // 4. Initial Stock (Wajib, Angka)
        $table->integer('stock')->default(0); 
        
        // 5. Description / Notes (Opsional - Teks Panjang)
        $table->text('description')->nullable();
        
        // Tambahan: Status (Untuk keperluan logika tampilan 'Available/Low Stock')
        // Kita beri default 'Available' atau sesuaikan logika stok nanti
        $table->foreignId('category_id')->constrained('categories');

        $table->timestamps(); // created_at & updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
