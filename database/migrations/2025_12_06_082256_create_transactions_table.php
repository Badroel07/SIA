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
        // Tabel Transaksi (Header)
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict')->comment('Kasir yang memproses');
            $table->unsignedBigInteger('total_price'); // Total sebelum diskon
            $table->unsignedBigInteger('discount')->default(0);
            $table->unsignedBigInteger('final_total'); // Total akhir setelah diskon
            $table->unsignedBigInteger('amount_paid'); // Uang yang dibayarkan customer
            $table->unsignedBigInteger('change_amount'); // Kembalian
            $table->enum('status', ['paid', 'canceled'])->default('paid');
            $table->timestamps();
        });

        // Tabel Detail Transaksi
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade');
            $table->foreignId('medicine_id')->constrained('medicines')->onDelete('restrict');
            $table->string('medicine_name');
            $table->integer('quantity');
            $table->unsignedBigInteger('unit_price');
            $table->unsignedBigInteger('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
        Schema::dropIfExists('transactions');
    }
};
