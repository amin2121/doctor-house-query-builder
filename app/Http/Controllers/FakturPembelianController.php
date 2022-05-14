<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FakturPembelianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');    
    }

    public function index()
    {
        $faktur_pembelian = DB::table('faktur_obat')->latest()->paginate(5);
        return view('faktur_pembelian.index', compact('faktur_pembelian'));
    }

    public function show()
    {
        $id_faktur_pembelian = request('id_faktur_pembelian');
        $faktur_pembelian_detail = DB::table('faktur_obat_detail')
                                    ->join('obat', 'faktur_obat_detail.obat_id', 'obat.id')
                                    ->join('jenis_obat', 'obat.jenis_obat_id', 'jenis_obat.id')
                                    ->select('faktur_obat_detail.*', 'jenis_obat.jenis_obat')
                                    ->where('faktur_id', $id_faktur_pembelian)->get();

        return response()->json($faktur_pembelian_detail);
    }

    public function create()
    {
        $supplier = DB::table('supplier')->get();
        $obat = DB::table('obat')->get();
        return view('faktur_pembelian.create', compact('supplier', 'obat'));
    }

    public function store()
    {
        $supplier = DB::table('supplier')->find(request('supplier'));

        $id_faktur_pembelian = DB::table('faktur_obat')->insertGetId([
            'supplier_id' => request('supplier'),
            'no_faktur' => request('no_faktur'),
            'tanggal_faktur' => request('tanggal_faktur'),
            'nama_supplier' => $supplier->nama_supplier,
            'total_harga' => request('total_harga_akhir'),
            'total_laba' => request('total_laba_akhir'),
            'user_id' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $data_faktur_detail = [];
        foreach (request('obat') as $key => $obat) {
            $data_obat = DB::table('obat')->find($obat);

            $data_faktur_detail[] = array(
                'obat_id' => $obat,
                'user_id' => auth()->user()->id,
                'faktur_id' => $id_faktur_pembelian,
                'nama_obat' => $data_obat->nama_obat,
                'harga_jual' => request('harga_jual')[$key],
                'harga_awal' => request('harga_awal')[$key],
                'jumlah_beli' => request('jumlah_beli')[$key],
                'laba' => request('laba')[$key],
                'total_harga' => request('total_harga')[$key],
                'total_laba' => request('total_laba')[$key],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            DB::table('obat')->where('id', $obat)->increment('stok', request('jumlah_beli')[$key]);
        }

        $insert_faktur_detail = DB::table('faktur_obat_detail')->insert($data_faktur_detail);

        if($insert_faktur_detail > 0) {
            session()->flash('success', 'Faktur Pembelian Berhasil Ditambahkan');

            DB::table('logging')->insert([
                'user_id' => auth()->user()->id,
                'nama_user' => auth()->user()->name,
                'keterangan' => 'Menambahkan Faktur Pembelian '. request('no_faktur'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            session()->flash('error', 'Faktur Pembelian Gagal Ditambahkan');
        }

        return redirect()->to('faktur-pembelian');
    }
}
