<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->string('tipe_pesanan')->default('takeaway')->after('status'); // dine_in / takeaway
        $table->string('nomor_meja')->nullable()->after('tipe_pesanan');
        $table->string('metode_pembayaran')->default('tunai')->after('nomor_meja'); // tunai / transfer / qris
    });
}

public function down(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn(['tipe_pesanan', 'nomor_meja', 'metode_pembayaran']);
    });
}
};
