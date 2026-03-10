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
        Schema::table('history_logs', function (Blueprint $table) {
            // Ubah kolom ini agar boleh kosong (null)
            $table->unsignedBigInteger('item_id')->nullable()->change();
            $table->unsignedBigInteger('category_id')->nullable()->change();
            $table->integer('quantity')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Kembalikan ke pengaturan awal (jika perlu rollback)
        Schema::table('history_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('item_id')->nullable(false)->change();
            $table->unsignedBigInteger('category_id')->nullable(false)->change();
            $table->integer('quantity')->nullable(false)->change();
        });
    }
};
