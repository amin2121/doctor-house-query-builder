<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DokterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');    
    }

    public function index()
    {
        $dokter = DB::table('dokter')->latest()->paginate(5);
        return view('dokter.index', compact('dokter'));
    }

    public function store()
    {
        $insert_data = DB::table('dokter')->insert([
            'nama_dokter' => request('nama_dokter'),
            'alamat' => request('alamat'),
            'no_telp' => request('no_telp'),
            'spesialis' => request('spesialis'),
            'user_id' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if($insert_data > 0) {
            session()->flash('success', 'Dokter Berhasil Ditambahkan');

            DB::table('logging')->insert([
                'user_id' => auth()->user()->id,
                'nama_user' => auth()->user()->name,
                'keterangan' => 'Menambahkan Dokter '. request('nama_dokter'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            session()->flash('error', 'Dokter Gagal Ditambahkan');
        }

        return redirect()->to('dokter');
    }

    public function edit()
    {
        $update_data = DB::table('dokter')
                        ->where('id', request('id'))
                        ->update([
                            'nama_dokter' => request('nama_dokter'),
                            'alamat' => request('alamat'),
                            'no_telp' => request('no_telp'),
                            'spesialis' => request('spesialis'),
                            'user_id' => auth()->user()->id,
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);

        if($update_data > 0) {
            session()->flash('success', 'Dokter Berhasil Diedit');

            DB::table('logging')->insert([
                'user_id' => auth()->user()->id,
                'nama_user' => auth()->user()->name,
                'keterangan' => 'Mengedit Dokter '. request('nama_dokter'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            session()->flash('error', 'Dokter Gagal Diedit');
        }

        return redirect()->to('dokter');
    }

    public function destroy($id)
    {
        $dokter = DB::table('dokter')->find($id);
        $delete_data = DB::table('dokter')->where('id', $id)->delete();

        if($delete_data > 0) {
            session()->flash('success', 'Dokter Berhasil Dihapus');

            DB::table('logging')->insert([
                'user_id' => auth()->user()->id,
                'nama_user' => auth()->user()->name,
                'keterangan' => 'Menghapus Dokter '. $dokter->nama_dokter,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            session()->flash('error', 'Dokter Gagal Dihapus');
        }

        return redirect()->to('dokter');
    }   
}
