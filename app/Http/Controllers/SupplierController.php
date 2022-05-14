<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');    
    }
    
    public function index()
    {
        $supplier = DB::table('supplier')->latest()->paginate(5);
        return view('supplier.index', compact('supplier'));
    }

    public function store()
    {
        $insert_data = DB::table('supplier')->insert([
            'nama_supplier' => request('nama_supplier'),
            'alamat' => request('alamat'),
            'no_telp' => request('no_telp'),
            'user_id' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if($insert_data > 0) {
            session()->flash('success', 'Supplier Berhasil Ditambahkan');

            DB::table('logging')->insert([
                'user_id' => auth()->user()->id,
                'nama_user' => auth()->user()->name,
                'keterangan' => 'Menambahkan Supplier '. request('nama_supplier'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            session()->flash('error', 'Supplier Gagal Ditambahkan');
        }

        return redirect()->to('supplier');
    }

    public function edit()
    {
        $update_data = DB::table('supplier')
                        ->where('id', request('id'))
                        ->update([
                            'nama_supplier' => request('nama_supplier'),
                            'alamat' => request('alamat'),
                            'no_telp' => request('no_telp'),
                            'user_id' => auth()->user()->id,
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);

        if($update_data > 0) {
            session()->flash('success', 'Supplier Berhasil Diedit');

            DB::table('logging')->insert([
                'user_id' => auth()->user()->id,
                'nama_user' => auth()->user()->name,
                'keterangan' => 'Mengedit Supplier '. request('nama_supplier'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            session()->flash('error', 'Supplier Gagal Diedit');
        }

        return redirect()->to('supplier');
    }

    public function destroy($id)
    {
        $supplier = DB::table('supplier')->find($id);
        $delete_data = DB::table('supplier')->where('id', $id)->delete();

        if($delete_data > 0) {
            session()->flash('success', 'Supplier Berhasil Dihapus');

            DB::table('logging')->insert([
                'user_id' => auth()->user()->id,
                'nama_user' => auth()->user()->name,
                'keterangan' => 'Menghapus Supplier '. $supplier->nama_supplier,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            session()->flash('error', 'Supplier Gagal Dihapus');
        }

        return redirect()->to('supplier');
    }
}
