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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nama_pemesan');
            $table->string('alamat');
            $table->integer('total_harga');
            // Status: Dibuat, Menunggu Pembayaran, Dikonfirmasi, Dalam Pengiriman, Selesai, Hold
            $table->string('status')->default('pending');
            $table->json('items'); // daftar makanan yang dipesan
            $table->string('tracking_number')->nullable();
            $table->timestamp('estimated_delivery')->nullable();
            $table->string('payment_method')->nullable(); // cash/online
            $table->string('payment_status')->default('unpaid'); // unpaid/paid/failed
            $table->integer('payment_attempts')->default(0); // retry pembayaran online
            $table->timestamp('confirmed_at')->nullable(); // waktu pesanan dikonfirmasi admin
            $table->timestamp('delivered_at')->nullable(); // waktu pesanan selesai dikirim
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
