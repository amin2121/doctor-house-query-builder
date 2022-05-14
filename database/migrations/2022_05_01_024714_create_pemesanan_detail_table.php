<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemesananDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemesanan_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obat_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('pemesanan_id')->nullable();
            $table->string('nama_obat', 191);
            $table->integer('jumlah_beli');
            $table->bigInteger('harga_jual');
            $table->bigInteger('harga_awal');
            $table->bigInteger('laba');
            $table->bigInteger('total_harga');
            $table->bigInteger('total_laba');
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
        Schema::dropIfExists('pemesanan_detail');
    }
}
