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
        Schema::create('transaksi_pembayaran', function (Blueprint $table) {
            $table->id('ID_Transaksi');
            $table->string('No_Transaksi')->unique();
            $table->unsignedBigInteger('ID_Pemakaian');
            $table->unsignedBigInteger('ID_Pelanggan');
            $table->dateTime('TanggalPembayaran');
            $table->decimal('TotalTagihan', 10, 2);
            $table->enum('MetodePembayaran', ['Transfer', 'Virtual Account', 'QRIS', 'Tunai']);
            $table->enum('Status', ['Menunggu Konfirmasi', 'Lunas', 'Gagal']);
            $table->timestamps();

            $table->foreign('ID_Pemakaian')->references('ID_Pemakaian')->on('pemakaian')->onDelete('cascade');
            $table->foreign('ID_Pelanggan')->references('ID_Pelanggan')->on('pelanggan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_pembayaran');
    }
};
