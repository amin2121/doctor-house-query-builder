<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ObatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');    
    }

    public function index()
    {
        $obat = DB::table('obat')
                ->join('jenis_obat', 'obat.jenis_obat_id', '=', 'jenis_obat.id')
                ->select('obat.*', 'jenis_obat.jenis_obat')
                ->paginate(5);

        $jenis_obat = DB::table('jenis_obat')->get();
        return view('obat.index', compact('obat', 'jenis_obat'));
    }

    public function store()
    {
        $insert_data = DB::table('obat')->insert([
            'jenis_obat_id' => request('jenis_obat_id'),
            'user_id' => auth()->user()->id,
            'nama_obat' => request('nama_obat'),
            'harga_awal' => request('harga_awal'),
            'harga_jual' => request('harga_jual'),
            'laba' => (int) request('harga_jual') - (int) request('harga_awal'),
            'stok' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if($insert_data > 0) {
            session()->flash('success', 'Obat Berhasil Ditambahkan');

            DB::table('logging')->insert([
                'user_id' => auth()->user()->id,
                'nama_user' => auth()->user()->name,
                'keterangan' => 'Menambahkan Obat '. request('nama_obat'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            session()->flash('error', 'Obat Gagal Ditambahkan');
        }

        return redirect()->to('obat');
    }

    public function edit()
    {
        $update_data = DB::table('obat')
                        ->where('id', request('id'))
                        ->update([
                            'jenis_obat_id' => request('jenis_obat_id'),
                            'user_id' => auth()->user()->id,
                            'nama_obat' => request('nama_obat'),
                            'harga_awal' => request('harga_awal'),
                            'harga_jual' => request('harga_jual'),
                            'laba' => (int) request('harga_jual') - (int) request('harga_awal'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

        if($update_data > 0) {
            session()->flash('success', 'Obat Berhasil Diedit');

            DB::table('logging')->insert([
                'user_id' => auth()->user()->id,
                'nama_user' => auth()->user()->name,
                'keterangan' => 'Mengedit Obat '. request('nama_obat'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            session()->flash('error', 'Obat Gagal Diedit');
        }

        return redirect()->to('obat');
    }

    public function destroy($id)
    {
        $obat = DB::table('obat')->find($id);
        $delete_data = DB::table('obat')->where('id', $id)->delete();

        if($delete_data > 0) {
            session()->flash('success', 'Obat Berhasil Dihapus');

            DB::table('logging')->insert([
                'user_id' => auth()->user()->id,
                'nama_user' => auth()->user()->name,
                'keterangan' => 'Menghapus Obat '. $obat->nama_obat,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            session()->flash('error', 'Obat Gagal Dihapus');
        }

        return redirect()->to('obat');
    }   
}
