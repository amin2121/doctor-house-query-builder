<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');    
    }

    public function index()
    {
        $pasien = DB::table('pasien')->paginate(5);

        return view('pasien.index', compact('pasien'));
    }

    public function store()
    {
        $insert_data = DB::table('pasien')->insert([
            'user_id' => auth()->user()->id,
            'nama_pasien' => request('nama_pasien'),
            'alamat' => request('alamat'),
            'no_telp' => request('no_telp'),
            'jenis_kelamin' => request('jenis_kelamin'),
            'umur' => request('umur'),
            'status_umur' => request('status_umur'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if($insert_data > 0) {
            session()->flash('success', 'Pasien Berhasil Ditambahkan');

            DB::table('logging')->insert([
                'user_id' => auth()->user()->id,
                'nama_user' => auth()->user()->name,
                'keterangan' => 'Menambahkan Pasien '. request('nama_pasien'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            session()->flash('error', 'Pasien Gagal Ditambahkan');
        }

        return redirect()->to('pasien');
    }

    public function edit()
    {
        $update_data = DB::table('pasien')
                        ->where('id', request('id'))
                        ->update([
                            'user_id' => auth()->user()->id,
                            'nama_pasien' => request('nama_pasien'),
                            'alamat' => request('alamat'),
                            'no_telp' => request('no_telp'),
                            'jenis_kelamin' => request('jenis_kelamin'),
                            'umur' => request('umur'),
                            'status_umur' => request('status_umur'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

        if($update_data > 0) {
            session()->flash('success', 'Pasien Berhasil Diedit');

            DB::table('logging')->insert([
                'user_id' => auth()->user()->id,
                'nama_user' => auth()->user()->name,
                'keterangan' => 'Mengedit Pasien '. request('nama_pasien'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            session()->flash('error', 'Pasien Gagal Diedit');
        }

        return redirect()->to('pasien');
    }

    public function destroy($id)
    {
        $pasien = DB::table('pasien')->find($id);
        $delete_data = DB::table('pasien')->where('id', $id)->delete();

        if($delete_data > 0) {
            session()->flash('success', 'Pasien Berhasil Dihapus');

            DB::table('logging')->insert([
                'user_id' => auth()->user()->id,
                'nama_user' => auth()->user()->name,
                'keterangan' => 'Menghapus Pasien '. $pasien->nama_pasien,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            session()->flash('error', 'Pasien Gagal Dihapus');
        }

        return redirect()->to('pasien');
    }   
}
