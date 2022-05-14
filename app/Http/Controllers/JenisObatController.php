<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JenisObatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');    
    }
    
    public function index()
    {
        $jenis_obat = DB::table('jenis_obat')->latest()->paginate(5);
        return view('jenis_obat.index', compact('jenis_obat'));
    }

    public function store()
    {
        $insert_data = DB::table('jenis_obat')->insert([
            'jenis_obat' => request('jenis_obat'), 
            'user_id' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if($insert_data > 0) {
            session()->flash('success', 'Jenis Obat Berhasil Ditambahkan');

            DB::table('logging')->insert([
                'user_id' => auth()->user()->id,
                'nama_user' => auth()->user()->name,
                'keterangan' => 'Menambahkan Jenis Obat '. request('jenis_obat'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            session()->flash('error', 'Jenis Obat Gagal Ditambahkan');
        }

        return redirect()->to('jenis_obat');
    }

    public function edit()
    {
        $update_data = DB::table('jenis_obat')
                        ->where('id', request('id'))
                        ->update([
                            'jenis_obat' => request('jenis_obat'),
                            'user_id' => auth()->user()->id,
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);

        if($update_data > 0) {
            session()->flash('success', 'Jenis Obat Berhasil Diedit');

            DB::table('logging')->insert([
                'user_id' => auth()->user()->id,
                'nama_user' => auth()->user()->name,
                'keterangan' => 'Mengedit Jenis Obat '. request('jenis_obat'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            session()->flash('error', 'Jenis Obat Gagal Diedit');
        }

        return redirect()->to('jenis_obat');
    }

    public function destroy($id)
    {
        $j_obat = DB::table('jenis_obat')->find($id);
        $delete_data = DB::table('jenis_obat')->where('id', $id)->delete();

        if($delete_data > 0) {
            session()->flash('success', 'Jenis Obat Berhasil Dihapus');

            DB::table('logging')->insert([
                'user_id' => auth()->user()->id,
                'nama_user' => auth()->user()->name,
                'keterangan' => 'Menghapus Jenis Obat '. $j_obat->jenis_obat,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            session()->flash('error', 'Jenis Obat Gagal Dihapus');
        }

        return redirect()->to('jenis_obat');
    }   
}
