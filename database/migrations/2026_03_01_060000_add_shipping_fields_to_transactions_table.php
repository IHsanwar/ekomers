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
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('shipping_code')->nullable()->comment('Nomor resi pengiriman');
            $table->string('shipping_status')->default('pending')->comment('Status pengiriman: pending, shipped, delivered');
            $table->timestamp('shipped_at')->nullable()->comment('Waktu barang dikirim');
            $table->timestamp('delivered_at')->nullable()->comment('Waktu barang tiba');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['shipping_code', 'shipping_status', 'shipped_at', 'delivered_at']);
        });
    }
};
