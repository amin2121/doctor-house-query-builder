<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiwayatPemeriksaanPasienController extends Controller
{
    public function index()
    {
        $riwayatPemeriksaanPasien = DB::table('pemesanan')
                                    ->join('pasien', 'pemesanan.pasien_id', '=', 'pasien.id')
                                    ->select('pemesanan.*', 'pasien.nama_pasien', 'pasien.alamat', 'pasien.no_telp', 'pasien.jenis_kelamin', 'pasien.umur', 'pasien.status_umur')
                                    ->paginate(5);

        return view('riwayat-pemeriksaan.index', compact('riwayatPemeriksaanPasien'));
    }

    public function detail_obat()
    {
        $id = request('id');
        $obat = DB::table('pemesanan_detail')
                    ->where('pemesanan_id', $id)
                    ->select('pemesanan_detail.*')
                    ->latest()
                    ->get();

        echo json_encode($obat);
    }
}
