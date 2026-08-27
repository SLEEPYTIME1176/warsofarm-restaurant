<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->string('kode_promo', 30)->nullable()->after('total');
        $table->unsignedInteger('diskon')->default(0)->after('kode_promo');
    });
}

public function down(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn(['kode_promo', 'diskon']);
    });
}
};
