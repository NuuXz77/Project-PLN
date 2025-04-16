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
            $table->unsignedBigInteger('No_Pemakaian');
            $table->unsignedBigInteger('No_Kontrol');
            $table->dateTime('TanggalPembayaran');
            $table->decimal('TotalTagihan', 10, 2);
            $table->enum('MetodePembayaran', ['Transfer', 'Virtual Account', 'QRIS', 'Tunai']);
            $table->enum('Status', ['Menunggu Konfirmasi', 'Lunas', 'Gagal']);
            $table->timestamps();

            $table->foreign('No_Pemakaian')->references('No_Pemakaian')->on('pemakaian')->onDelete('cascade');
            $table->foreign('No_Kontrol')->references('No_Kontrol')->on('pelanggan')->onDelete('cascade');
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
