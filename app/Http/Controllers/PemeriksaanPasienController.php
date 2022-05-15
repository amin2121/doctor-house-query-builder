<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemeriksaanPasienController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');    
    }

    public function create()
    {
        $pasien = DB::table('pasien')->latest()->get();
        $dokter = DB::table('dokter')->latest()->get();
        $obat = DB::table('obat')->latest()->get();

        return view('pemeriksaan_pasien.create', compact('pasien', 'dokter', 'obat'));
    }

    public function store()
    {
        $pasien = DB::table('pasien')->find(request('pasien'));
        $dokter = DB::table('dokter')->find(request('dokter'));

        $id_pemeriksaan_pasien = DB::table('pemesanan')->insertGetId([
            'pasien_id' => request('pasien'),
            'dokter_id' => request('dokter'),
            'user_id' => auth()->user()->id,
            'pasien' => $pasien->nama_pasien,
            'dokter' => $dokter->nama_dokter,
            'diagnosa' => request('diagnosa'),
            'total_nominal' => request('total_nominal'),
            'pembayaran' => request('pembayaran'),
            'kembalian' => request('kembalian'),
            'diskon' => request('diskon'),
            'tanggal_pemesanan' => date('Y-m-d H:i:s'),
            'total_laba' => request('total_laba_akhir'),
            'kode_pemesanan' => 'PMP0001',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $data_pemeriksaan_pasien_detail = [];
        foreach (request('obat') as $key => $obat) {
            $data_obat = DB::table('obat')->find($obat);

            $data_pemeriksaan_pasien_detail[] = array(
                'obat_id' => $obat,
                'user_id' => auth()->user()->id,
                'pemesanan_id' => $id_pemeriksaan_pasien,
                'nama_obat' => $data_obat->nama_obat,
                'harga_jual' => request('harga')[$key],
                'harga_awal' => request('harga_awal')[$key],
                'jumlah_beli' => request('jumlah_beli')[$key],
                'laba' => request('laba')[$key],
                'total_harga' => request('total_harga')[$key],
                'total_laba' => request('total_laba')[$key],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            DB::table('obat')->where('id', $obat)->decrement('stok', request('jumlah_beli')[$key]);
        }

        $insert_pemeriksaan_pasien_detail = DB::table('pemesanan_detail')->insert($data_pemeriksaan_pasien_detail);

        if($insert_pemeriksaan_pasien_detail > 0) {
            session()->flash('success', 'Pemeriksaan Pasien Berhasil Ditambahkan');

            DB::table('logging')->insert([
                'user_id' => auth()->user()->id,
                'nama_user' => auth()->user()->name,
                'keterangan' => 'Menambahkan Pemeriksaan Pasien '. $pasien->nama_pasien,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            session()->flash('error', 'Pemeriksaan Pasien Gagal Ditambahkan');
        }

        return redirect()->to('pemeriksaan-pasien');
    }
}
