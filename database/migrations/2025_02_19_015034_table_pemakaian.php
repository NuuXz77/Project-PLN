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
        Schema::create('pemakaian', function (Blueprint $table) {
            $table->id('ID_Pemakaian');
            $table->unsignedBigInteger('ID_Pelanggan');
            $table->date('TanggalCatat');
            $table->integer('MeterAwal');
            $table->integer('MeterAkhir');
            $table->integer('JumlahPakai');
            $table->decimal('BiayaBebanPemakai', 10, 2);
            $table->decimal('BiayaPemakaian', 10, 2);
            $table->enum('StatusPembayaran', ['Belum Lunas', 'Lunas']);
            $table->timestamps();

            $table->foreign('ID_Pelanggan')->references('ID_Pelanggan')->on('pelanggan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemakaian');
    }
};
