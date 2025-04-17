<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_pembayaran_table.php

    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('ID_Pembayaran');
            $table->string('No_Pembayaran')->unique();
            $table->string('No_Kontrol'); // FK ke pelanggan
            $table->string('Nama');
            $table->string('No_Tarif'); // dari Tarif
            $table->string('StandMeter'); // gabungan Awal - Akhir
            $table->decimal('TotalHarga', 10, 2)->nullable();
            $table->unsignedBigInteger('Admin')->nullable(); // FK ke Admin
            $table->decimal('TotalBayar', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('No_Kontrol')->references('No_Kontrol')->on('pelanggan');
            $table->foreign('No_Tarif')->references('No_Tarif')->on('tarif');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
