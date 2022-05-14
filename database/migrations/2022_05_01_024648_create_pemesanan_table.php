<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemesananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('dokter_id')->nullable();
            $table->string('pasien', 191);
            $table->string('dokter', 191);
            $table->string('diagnosa', 191);
            $table->bigInteger('total_nominal');
            $table->bigInteger('pembayaran');
            $table->bigInteger('kembalian');
            $table->bigInteger('diskon');
            $table->string('status_diskon', 191);
            $table->timestamp('tanggal_pemesanan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemesanan');
    }
}
